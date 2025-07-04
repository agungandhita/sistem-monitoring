<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\NilaiHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        
        $nilaiHarian = collect();
        $statistics = [];
        
        if ($kelasId) {
            // Get subjects taught in this class
            $mapelOptions = Mapel::whereHas('gurus', function($query) use ($kelasId) {
                $query->whereHas('jadwals', function($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId)
                      ->where('status', 'aktif');
                });
            })->orderBy('mapel')->get();
            
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
        } else {
            // Jika belum ada kelas yang dipilih, tampilkan semua mata pelajaran
            $mapelOptions = Mapel::orderBy('mapel')->get();
        }
        
        return view('admin.nilai-harian.index', compact(
            'kelasOptions',
            'mapelOptions', 
            'nilaiHarian',
            'statistics',
            'kelasId',
            'mapelId',
            'bulan'
        ));
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
        try {
            // Validasi parameter
            $kelasId = $request->get('kelas_id');
            $mapelId = $request->get('mapel_id');
            $bulan = $request->get('bulan', date('Y-m'));
            $semester = $request->get('semester');
            $tahunAjaran = $request->get('tahun_ajaran');
            
            if (!$kelasId) {
                return redirect()->back()->with('error', 'Parameter kelas harus dipilih');
            }
            
            // Ambil data kelas
            $kelas = Kelas::find($kelasId);
            if (!$kelas) {
                return redirect()->back()->with('error', 'Kelas tidak ditemukan');
            }
            
            // Ambil data siswa dalam kelas
            $siswaList = Siswa::where('kelas_id', $kelasId)
                ->orderBy('nama')
                ->get();
            
            // Ambil mata pelajaran yang diajarkan di kelas ini
            $mapelList = Mapel::whereHas('gurus', function($query) use ($kelasId) {
                $query->whereHas('jadwals', function($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId)
                      ->where('status', 'aktif');
                });
            })->orderBy('mapel')->get();
            
            // Jika ada filter mapel tertentu
            if ($mapelId) {
                $mapelList = $mapelList->where('mapel_id', $mapelId);
            }
            
            // Buat spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul
            $sheet->setCellValue('A1', 'LAPORAN NILAI HARIAN');
            $sheet->setCellValue('A2', 'Kelas: ' . $kelas->nama_kelas);
            $sheet->setCellValue('A3', 'Periode: ' . \Carbon\Carbon::parse($bulan)->format('F Y'));
            if ($semester) {
                $sheet->setCellValue('A4', 'Semester: ' . $semester);
            }
            if ($tahunAjaran) {
                $sheet->setCellValue('A5', 'Tahun Ajaran: ' . $tahunAjaran);
            }
            
            // Header tabel
            $row = $semester || $tahunAjaran ? 7 : 5;
            $sheet->setCellValue('A' . $row, 'No');
            $sheet->setCellValue('B' . $row, 'Nama Siswa');
            
            $col = 'C';
            foreach ($mapelList as $mapel) {
                $sheet->setCellValue($col . $row, $mapel->mapel);
                $col++;
            }
            $sheet->setCellValue($col . $row, 'Rata-rata');
            
            // Data siswa
            $row++;
            $no = 1;
            foreach ($siswaList as $siswa) {
                $sheet->setCellValue('A' . $row, $no++);
                $sheet->setCellValue('B' . $row, $siswa->nama);
                
                $totalNilai = 0;
                $jumlahMapel = 0;
                $col = 'C';
                
                foreach ($mapelList as $mapel) {
                    // Query nilai berdasarkan parameter yang tersedia
                    $nilaiQuery = NilaiHarian::where('siswa_id', $siswa->siswa_id)
                        ->where('mapel_id', $mapel->mapel_id)
                        ->where('kelas_id', $kelasId);
                    
                    // Filter berdasarkan bulan jika ada
                    if ($bulan) {
                        $nilaiQuery->whereYear('tanggal', \Carbon\Carbon::parse($bulan)->year)
                                  ->whereMonth('tanggal', \Carbon\Carbon::parse($bulan)->month);
                    }
                    
                    // Filter berdasarkan semester jika ada
                    if ($semester) {
                        $nilaiQuery->where('semester', $semester);
                    }
                    
                    // Filter berdasarkan tahun ajaran jika ada
                    if ($tahunAjaran) {
                        $nilaiQuery->where('tahun_ajaran', $tahunAjaran);
                    }
                    
                    $rataRata = $nilaiQuery->avg('nilai');
                    
                    if ($rataRata) {
                        $sheet->setCellValue($col . $row, number_format($rataRata, 1));
                        $totalNilai += $rataRata;
                        $jumlahMapel++;
                    } else {
                        $sheet->setCellValue($col . $row, '-');
                    }
                    $col++;
                }
                
                // Rata-rata keseluruhan
                $rataKeseluruhan = $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
                $sheet->setCellValue($col . $row, number_format($rataKeseluruhan, 1));
                
                $row++;
            }
            
            // Style header
            $headerRow = $semester || $tahunAjaran ? 7 : 5;
            $headerRange = 'A' . $headerRow . ':' . $col . $headerRow;
            $sheet->getStyle($headerRange)->getFont()->setBold(true);
            $sheet->getStyle($headerRange)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CCCCCC');
            
            // Auto width
            foreach (range('A', $col) as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
            
            // Download file
            $filename = 'Laporan_Nilai_Harian_' . $kelas->nama_kelas . '_' . \Carbon\Carbon::parse($bulan)->format('Y_m') . '.xlsx';
            
            $writer = new Xlsx($spreadsheet);
            
            return Response::streamDownload(function() use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor data: ' . $e->getMessage());
        }
    }
}