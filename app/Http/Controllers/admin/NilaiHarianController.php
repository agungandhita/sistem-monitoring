<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiHarian;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NilaiHarianController extends Controller
{
    public function index(Request $request)
    {
        // Get all classes
        $kelasOptions = Kelas::with('kurikulum')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();
            
        // Get filter parameters
        $kelasId = $request->get('kelas_id');
        $mapelId = $request->get('mapel_id');
        $bulan = $request->get('bulan', date('Y-m'));
        
        $mapelOptions = collect();
        $nilaiHarian = collect();
        $statistics = [];
        
        if ($kelasId) {
            // Get subjects taught in this class
            $mapelOptions = Mapel::whereHas('gurus', function($query) use ($kelasId) {
                $query->whereHas('jadwals', function($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId)
                      ->where('status', 'aktif');
                });
            })->get();
            
            // Build query for grades
            $nilaiQuery = NilaiHarian::with(['siswa', 'guru', 'mapel'])
                ->where('kelas_id', $kelasId)
                ->whereYear('tanggal', Carbon::parse($bulan)->year)
                ->whereMonth('tanggal', Carbon::parse($bulan)->month)
                ->orderBy('tanggal', 'desc');
                
            if ($mapelId) {
                $nilaiQuery->where('mapel_id', $mapelId);
            }
            
            $nilaiHarian = $nilaiQuery->get();
            
            // Calculate statistics
            if ($nilaiHarian->count() > 0) {
                $statistics = [
                    'total_nilai' => $nilaiHarian->count(),
                    'total_siswa' => $nilaiHarian->pluck('siswa_id')->unique()->count(),
                    'rata_rata_kelas' => round($nilaiHarian->avg('nilai'), 2),
                    'nilai_tertinggi' => $nilaiHarian->max('nilai'),
                    'nilai_terendah' => $nilaiHarian->min('nilai')
                ];
                
                // Statistics per student
                $statisticsPerSiswa = $nilaiHarian->groupBy('siswa_id')->map(function($nilai, $siswaId) {
                    return [
                        'siswa' => $nilai->first()->siswa,
                        'total_nilai' => $nilai->count(),
                        'rata_rata' => round($nilai->avg('nilai'), 2),
                        'tertinggi' => $nilai->max('nilai'),
                        'terendah' => $nilai->min('nilai')
                    ];
                })->sortBy('siswa.nama');
                
                $statistics['per_siswa'] = $statisticsPerSiswa;
            }
        }
        
        return view('admin.nilai-harian.index', compact(
            'kelasOptions',
            'mapelOptions',
            'nilaiHarian',
            'statistics',
            'kelasId',
            'mapelId',
            'bulan'
        ))->with('kelas', $kelasOptions)->with('mapels', $mapelOptions);
    }
    
    public function laporan(Request $request)
    {
        // Get all classes
        $kelasOptions = Kelas::with('kurikulum')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();
            
        // Get filter parameters
        $kelasId = $request->get('kelas_id');
        $semester = $request->get('semester');
        $tahunAjaran = $request->get('tahun_ajaran');
        
        // Get available academic years and semesters
        $tahunAjaranOptions = NilaiHarian::distinct()
            ->pluck('tahun_ajaran')
            ->sort()
            ->values();
            
        $semesterOptions = ['Ganjil', 'Genap'];
        
        $laporanData = [];
        
        if ($kelasId) {
            // Get students in the class
            $siswaList = Siswa::where('kelas_id', $kelasId)
                ->orderBy('nama')
                ->get();
                
            // Get subjects taught in this class
            $mapelList = Mapel::whereHas('gurus', function($query) use ($kelasId) {
                $query->whereHas('jadwals', function($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId)
                      ->where('status', 'aktif');
                });
            })->get();
            
            // Build report data
            foreach ($siswaList as $siswa) {
                $siswaData = [
                    'siswa' => $siswa,
                    'mapel' => []
                ];
                
                foreach ($mapelList as $mapel) {
                    $nilaiQuery = NilaiHarian::where('siswa_id', $siswa->siswa_id)
                        ->where('mapel_id', $mapel->mapel_id)
                        ->where('kelas_id', $kelasId);
                        
                    if ($semester) {
                        $nilaiQuery->where('semester', $semester);
                    }
                    
                    if ($tahunAjaran) {
                        $nilaiQuery->where('tahun_ajaran', $tahunAjaran);
                    }
                    
                    $nilaiList = $nilaiQuery->orderBy('tanggal', 'desc')->get();
                    
                    $siswaData['mapel'][$mapel->mapel] = [
                        'mapel_info' => $mapel,
                        'nilai_list' => $nilaiList,
                        'rata_rata' => $nilaiList->count() > 0 ? round($nilaiList->avg('nilai'), 2) : null,
                        'total_nilai' => $nilaiList->count()
                    ];
                }
                
                $laporanData[] = $siswaData;
            }
        }
        
        return view('admin.nilai-harian.laporan', compact(
            'kelasOptions',
            'tahunAjaranOptions',
            'semesterOptions',
            'laporanData',
            'kelasId',
            'semester',
            'tahunAjaran'
        ));
    }
    
    public function export(Request $request)
    {
        // This method can be implemented later for Excel/PDF export
        // For now, return JSON data
        
        $kelasId = $request->get('kelas_id');
        $semester = $request->get('semester');
        $tahunAjaran = $request->get('tahun_ajaran');
        
        if (!$kelasId) {
            return response()->json(['error' => 'Kelas harus dipilih'], 400);
        }
        
        $kelas = Kelas::findOrFail($kelasId);
        
        $data = NilaiHarian::with(['siswa', 'guru', 'mapel'])
            ->where('kelas_id', $kelasId)
            ->when($semester, function($q) use ($semester) {
                return $q->where('semester', $semester);
            })
            ->when($tahunAjaran, function($q) use ($tahunAjaran) {
                return $q->where('tahun_ajaran', $tahunAjaran);
            })
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return response()->json([
            'kelas' => $kelas,
            'data' => $data,
            'total' => $data->count(),
            'filters' => [
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran
            ]
        ]);
    }
}