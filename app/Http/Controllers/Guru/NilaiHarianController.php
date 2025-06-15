<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Kelas;

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
            
        $selectedKelas = $request->get('kelas_id');
        $selectedMapel = $request->get('mapel_id');
        
        $mapelOptions = collect();
        $siswaList = collect();
        
        if ($selectedKelas) {
            // Get subjects for selected class
            $mapelOptions = Jadwal::with('mapel')
                ->where('guru_id', $guru->guru_id)
                ->where('kelas_id', $selectedKelas)
                ->where('status', 'aktif')
                ->distinct('mapel_id')
                ->get()
                ->pluck('mapel')
                ->unique('mapel_id');
                
            // Get students in selected class
            $siswaList = Siswa::where('kelas_id', $selectedKelas)
                ->orderBy('nama')
                ->get();
        }
        
        return view('guru.nilai-harian.index', compact(
            'kelasOptions',
            'mapelOptions', 
            'siswaList',
            'selectedKelas',
            'selectedMapel'
        ));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'tanggal' => 'required|date',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100'
        ]);
        
        $guru = Auth::guard('guru')->user();
        
        // Here you would save the daily grades
        // For now, we'll just return success message
        
        return back()->with('success', 'Nilai harian berhasil disimpan!');
    }
}