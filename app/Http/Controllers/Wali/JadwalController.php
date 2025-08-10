<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wali = $user->wali;
        $siswas = $wali->siswas()->with('kelas')->get();
        
        return view('wali.jadwal.index', compact('siswas'));
    }

    public function show($siswaId)
    {
        $user = Auth::user();
        $wali = $user->wali;
        
        // Verify that the student is related to this wali
        $siswa = $wali->siswas()->with('kelas')->findOrFail($siswaId);
        
        $tahunAjaran = $siswa->kelas->tahun_ajaran ?? '2024/2025';
        
        $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('status', 'aktif')
            ->with(['mapel', 'guru'])
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get();
        
        // Define all days of the week in order
        $allDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        // Group schedules by day
        $jadwalsByDay = $jadwals->groupBy('hari');
        
        // Create sorted array with all days, including empty ones
        $jadwalsSorted = collect();
        foreach ($allDays as $day) {
            $jadwalsSorted[$day] = $jadwalsByDay->get($day, collect());
        }
        
        return view('wali.jadwal.show', compact('siswa', 'jadwalsSorted'));
    }
}