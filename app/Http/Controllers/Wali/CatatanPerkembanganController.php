<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\CatatanPerkembangan;

class CatatanPerkembanganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wali = $user->wali;
        $siswas = $wali->siswas()->with('kelas')->get();
        
        return view('wali.catatan-perkembangan.index', compact('siswas'));
    }

    public function show($siswa_id)
    {
        $user = Auth::user();
        $wali = $user->wali;
        
        // Verify that the student is related to this wali
        $siswa = $wali->siswas()->with('kelas')->findOrFail($siswa_id);
        
        // Get development notes for this student
        $catatanPerkembangan = CatatanPerkembangan::where('siswa_id', $siswa_id)
            ->with('guru')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('wali.catatan-perkembangan.show', compact('siswa', 'catatanPerkembangan'));
    }
}