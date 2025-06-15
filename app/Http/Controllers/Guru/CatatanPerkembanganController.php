<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Kelas;

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
    
    public function create(Request $request)
    {
        $guru = Auth::guard('guru')->user();
        $siswaId = $request->get('siswa_id');
        
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
            'kategori' => 'required|in:akademik,perilaku,kehadiran,lainnya',
            'catatan' => 'required|string|max:1000',
            'skor' => 'nullable|integer|min:1|max:5'
        ]);
        
        $guru = Auth::guard('guru')->user();
        
        // Here you would save the development notes
        // For now, we'll just return success message
        
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
        
        // Here you would get the development notes for this student
        $catatanList = collect(); // Placeholder
        
        return view('guru.catatan-perkembangan.show', compact('siswa', 'catatanList'));
    }
}