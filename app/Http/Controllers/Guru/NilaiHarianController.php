<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\NilaiHarian;
use Carbon\Carbon;

class NilaiHarianController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::guard('guru')->user();
        
        // Get classes taught by this teacher
        $kelasOptions = Jadwal::with('kelas')
            ->where('guru_id', $guru->guru_id)
            ->where('status', 'aktif')
            ->distinct('kelas_id')
            ->get()
            ->pluck('kelas')
            ->unique('kelas_id');
            
        $selectedKelasId = $request->get('kelas_id');
        $selectedMapelId = $request->get('mapel_id');
        
        // Get selected kelas and mapel objects
        $selectedKelas = null;
        $selectedMapel = null;
        
        if ($selectedKelasId) {
            $selectedKelas = Kelas::find($selectedKelasId);
        }
        
        if ($selectedMapelId) {
            $selectedMapel = \App\Models\Mapel::find($selectedMapelId);
        }
        
        $mapelOptions = collect();
        $siswaList = collect();
        
        if ($selectedKelasId) {
            // Get subjects for selected class
            $mapelOptions = Jadwal::with('mapel')
                ->where('guru_id', $guru->guru_id)
                ->where('kelas_id', $selectedKelasId)
                ->where('status', 'aktif')
                ->distinct('mapel_id')
                ->get()
                ->pluck('mapel')
                ->unique('mapel_id');
                
            // Get students in selected class
            $siswaList = Siswa::where('kelas_id', $selectedKelasId)
                ->orderBy('nama')
                ->get();
        }
        
        return view('guru.nilai-harian.index', compact(
            'kelasOptions',
            'mapelOptions', 
            'siswaList',
            'selectedKelas',
            'selectedMapel',
            'selectedKelasId',
            'selectedMapelId'
        ));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'tanggal' => 'required|date',
            'jenis_penilaian' => 'required|in:Tugas,Kuis,Ulangan Harian,Praktik,Lainnya',
            'keterangan' => 'nullable|string|max:255',
            'nilai' => 'required|array',
            'nilai.*.siswa_id' => 'required|exists:siswas,siswa_id',
            'nilai.*.nilai' => 'nullable|numeric|min:0|max:100'
        ]);
        
        $guru = Auth::guard('guru')->user();
        
        // Verify teacher teaches this class and subject
        $jadwal = Jadwal::where('guru_id', $guru->guru_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->where('status', 'aktif')
            ->first();
            
        if (!$jadwal) {
            return back()->with('error', 'Anda tidak mengajar mata pelajaran ini di kelas tersebut.');
        }
        
        // Get current semester and academic year
        $currentDate = Carbon::parse($request->tanggal);
        $tahunAjaran = $currentDate->year . '/' . ($currentDate->year + 1);
        $semester = $currentDate->month >= 7 ? 'Ganjil' : 'Genap';
        
        $savedCount = 0;
        
        foreach ($request->nilai as $nilaiData) {
            if (!empty($nilaiData['nilai'])) {
                // Check if grade already exists for this date
                $existingNilai = NilaiHarian::where('siswa_id', $nilaiData['siswa_id'])
                    ->where('guru_id', $guru->guru_id)
                    ->where('mapel_id', $request->mapel_id)
                    ->where('kelas_id', $request->kelas_id)
                    ->where('tanggal', $request->tanggal)
                    ->where('jenis_penilaian', $request->jenis_penilaian)
                    ->first();
                    
                if ($existingNilai) {
                    // Update existing grade
                    $existingNilai->update([
                        'nilai' => $nilaiData['nilai'],
                        'keterangan' => $request->keterangan
                    ]);
                } else {
                    // Create new grade
                    NilaiHarian::create([
                        'siswa_id' => $nilaiData['siswa_id'],
                        'guru_id' => $guru->guru_id,
                        'mapel_id' => $request->mapel_id,
                        'kelas_id' => $request->kelas_id,
                        'tanggal' => $request->tanggal,
                        'nilai' => $nilaiData['nilai'],
                        'jenis_penilaian' => $request->jenis_penilaian,
                        'keterangan' => $request->keterangan,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran
                    ]);
                }
                $savedCount++;
            }
        }
        
        return back()->with('success', "Berhasil menyimpan {$savedCount} nilai harian siswa!");
    }
}