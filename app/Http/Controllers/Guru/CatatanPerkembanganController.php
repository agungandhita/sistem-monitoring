<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\CatatanPerkembangan;

class CatatanPerkembanganController extends Controller
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
            
        $selectedKelas = $request->get('kelas_id');
        $siswaList = collect();
        
        if ($selectedKelas) {
            // Get students in selected class
            $siswaList = Siswa::where('kelas_id', $selectedKelas)
                ->orderBy('nama')
                ->get();
        }
        
        return view('guru.catatan-perkembangan.index', compact(
            'kelasOptions',
            'siswaList',
            'selectedKelas'
        ));
    }
    
    public function create($siswa)
    {
        $guru = Auth::guard('guru')->user();
        
        // $siswa sudah berisi siswa_id dari route parameter
        $siswaId = $siswa;
        
        if (!$siswaId) {
            return redirect()->route('guru.catatan-perkembangan.index')
                ->with('error', 'Pilih siswa terlebih dahulu.');
        }
        
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        
        // Verify teacher teaches this student's class
        $teachesClass = Jadwal::where('guru_id', $guru->guru_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('status', 'aktif')
            ->exists();
            
        if (!$teachesClass) {
            return redirect()->route('guru.catatan-perkembangan.index')
                ->with('error', 'Anda tidak mengajar di kelas siswa ini.');
        }
        
        return view('guru.catatan-perkembangan.create', compact('siswa'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,siswa_id',
            'tanggal' => 'required|date',
            'jenis_catatan' => 'required|in:akademik,perilaku,kehadiran,sosial,lainnya',
            'catatan' => 'required|string|max:1000'
        ]);
        
        $guru = Auth::guard('guru')->user();
        
        // Create catatan perkembangan
        CatatanPerkembangan::create([
            'siswa_id' => $request->siswa_id,
            'guru_id' => $guru->guru_id,
            'tanggal' => $request->tanggal,
            'jenis_catatan' => $request->jenis_catatan,
            'catatan' => $request->catatan,
            'semester' => $this->getCurrentSemester(),
            'tahun_ajaran' => $this->getCurrentTahunAjaran()
        ]);
        
        return redirect()->route('guru.catatan-perkembangan.index')
            ->with('success', 'Catatan perkembangan berhasil disimpan!');
    }
    
    public function show($siswaId)
    {
        $guru = Auth::guard('guru')->user();
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        
        // Verify teacher teaches this student's class
        $teachesClass = Jadwal::where('guru_id', $guru->guru_id)
            ->where('kelas_id', $siswa->kelas_id)
            ->where('status', 'aktif')
            ->exists();
            
        if (!$teachesClass) {
            return redirect()->route('guru.catatan-perkembangan.index')
                ->with('error', 'Anda tidak mengajar di kelas siswa ini.');
        }
        
        // Get development notes for this student
        $catatanList = CatatanPerkembangan::with('guru')
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('guru.catatan-perkembangan.show', compact('siswa', 'catatanList'));
    }
    
    private function getCurrentSemester()
    {
        $month = date('n');
        return ($month >= 7 && $month <= 12) ? 1 : 2;
    }
    
    private function getCurrentTahunAjaran()
    {
        $year = date('Y');
        $month = date('n');
        
        if ($month >= 7) {
            return $year . '/' . ($year + 1);
        } else {
            return ($year - 1) . '/' . $year;
        }
    }
}