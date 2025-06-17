<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\NilaiHarian;
use App\Models\Mapel;
use Carbon\Carbon;

class NilaiHarianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wali = $user->wali;
        $siswas = $wali->siswas()->with('kelas')->get();
        
        return view('wali.nilai-harian.index', compact('siswas'));
    }
    
    public function show(Request $request, $siswa_id)
    {
        $user = Auth::user();
        $wali = $user->wali;
        
        // Verify that the student is related to this wali
        $siswa = $wali->siswas()->with('kelas')->findOrFail($siswa_id);
        
        // Get filter parameters
        $mapelId = $request->get('mapel_id');
        $bulan = $request->get('bulan', date('Y-m'));
        
        // Get available subjects for this student
        $mapels = Mapel::whereHas('gurus', function($query) use ($siswa) {
            $query->whereHas('jadwals', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id)
                  ->where('status', 'aktif');
            });
        })->get();
        
        // Build query for grades
        $nilaiQuery = NilaiHarian::where('siswa_id', $siswa_id)
            ->with(['guru', 'mapel'])
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->orderBy('tanggal', 'desc');
            
        if ($mapelId) {
            $nilaiQuery->where('mapel_id', $mapelId);
        }
        
        $nilaiHarian = $nilaiQuery->get();
        
        // Calculate statistics
        $statistics = [];
        if ($nilaiHarian->count() > 0) {
            $statistics = [
                'total_nilai' => $nilaiHarian->count(),
                'rata_rata' => round($nilaiHarian->avg('nilai'), 2),
                'nilai_tertinggi' => $nilaiHarian->max('nilai'),
                'nilai_terendah' => $nilaiHarian->min('nilai')
            ];
        }
        
        // Group by subject for better display
        $nilaiByMapel = $nilaiHarian->groupBy('mapel.mapel');
        
        return view('wali.nilai-harian.show', compact(
            'siswa', 
            'nilaiHarian', 
            'nilaiByMapel',
            'mapels', 
            'statistics',
            'mapelId',
            'bulan'
        ));
    }
    
    public function riwayat(Request $request, $siswa_id)
    {
        $user = Auth::user();
        $wali = $user->wali;
        
        // Verify that the student is related to this wali
        $siswa = $wali->siswas()->with('kelas')->findOrFail($siswa_id);
        
        // Get filter parameters
        $mapelId = $request->get('mapel_id');
        $semester = $request->get('semester');
        $tahunAjaran = $request->get('tahun_ajaran');
        
        // Get available subjects
        $mapels = Mapel::whereHas('gurus', function($query) use ($siswa) {
            $query->whereHas('jadwals', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            });
        })->get();
        
        // Get available academic years and semesters
        $tahunAjaranOptions = NilaiHarian::where('siswa_id', $siswa_id)
            ->distinct()
            ->pluck('tahun_ajaran')
            ->sort()
            ->values();
            
        $semesterOptions = ['Ganjil', 'Genap'];
        
        // Build query for grades history
        $nilaiQuery = NilaiHarian::where('siswa_id', $siswa_id)
            ->with(['guru', 'mapel'])
            ->orderBy('tanggal', 'desc');
            
        if ($mapelId) {
            $nilaiQuery->where('mapel_id', $mapelId);
        }
        
        if ($semester) {
            $nilaiQuery->where('semester', $semester);
        }
        
        if ($tahunAjaran) {
            $nilaiQuery->where('tahun_ajaran', $tahunAjaran);
        }
        
        $nilaiHarian = $nilaiQuery->paginate(20);
        
        // Calculate statistics
        $statistik = null;
        $allNilai = NilaiHarian::where('siswa_id', $siswa_id)
            ->when($mapelId, function($q) use ($mapelId) {
                return $q->where('mapel_id', $mapelId);
            })
            ->when($semester, function($q) use ($semester) {
                return $q->where('semester', $semester);
            })
            ->when($tahunAjaran, function($q) use ($tahunAjaran) {
                return $q->where('tahun_ajaran', $tahunAjaran);
            })
            ->get();
            
        if ($allNilai->count() > 0) {
            $statistik = [
                'total_nilai' => $allNilai->count(),
                'rata_rata' => $allNilai->avg('nilai'),
                'nilai_tertinggi' => $allNilai->max('nilai'),
                'nilai_terendah' => $allNilai->min('nilai')
            ];
        }
        
        // Calculate average per subject
        $rataRataPerMapel = [];
        if ($mapelId || (!$mapelId && $nilaiHarian->count() > 0)) {
            $mapelList = $mapelId ? [$mapelId] : $mapels->pluck('mapel_id')->toArray();
            
            foreach ($mapelList as $mId) {
                $mapel = $mapels->firstWhere('mapel_id', $mId);
                if ($mapel) {
                    $avg = NilaiHarian::where('siswa_id', $siswa_id)
                        ->where('mapel_id', $mId)
                        ->when($semester, function($q) use ($semester) {
                            return $q->where('semester', $semester);
                        })
                        ->when($tahunAjaran, function($q) use ($tahunAjaran) {
                            return $q->where('tahun_ajaran', $tahunAjaran);
                        })
                        ->avg('nilai');
                        
                    $count = NilaiHarian::where('siswa_id', $siswa_id)
                        ->where('mapel_id', $mId)
                        ->when($semester, function($q) use ($semester) {
                            return $q->where('semester', $semester);
                        })
                        ->when($tahunAjaran, function($q) use ($tahunAjaran) {
                            return $q->where('tahun_ajaran', $tahunAjaran);
                        })
                        ->count();
                        
                    $rataRataPerMapel[$mId] = [
                        'nama_mapel' => $mapel->mapel,
                        'rata_rata' => round($avg, 2),
                        'jumlah_nilai' => $count
                    ];
                }
            }
        }
        
        return view('wali.nilai-harian.riwayat', compact(
            'siswa',
            'nilaiHarian',
            'mapels',
            'tahunAjaranOptions',
            'semesterOptions',
            'rataRataPerMapel',
            'statistik',
            'mapelId',
            'semester',
            'tahunAjaran'
        ));
    }
}