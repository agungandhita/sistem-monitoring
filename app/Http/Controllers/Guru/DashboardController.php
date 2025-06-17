<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::guard('guru')->user();
        
        // Get today's schedule for the teacher
        $today = now()->format('l'); // Get day name in English
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $hariIni = $hariIndonesia[$today] ?? 'Senin';
        $tahunAjaran = '2024/2025'; // You can make this dynamic
        
        $jadwalHariIni = Jadwal::with(['mapel', 'kelas'])
            ->where('guru_id', $guru->guru_id)
            ->where('hari', $hariIni)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('status', 'aktif')
            ->orderBy('jam_ke')
            ->get();
            
        // Count today's schedule
        $totalJadwalHariIni = $jadwalHariIni->count();
            
        // Get total classes taught by this teacher
        $totalKelas = Jadwal::where('guru_id', $guru->guru_id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('status', 'aktif')
            ->distinct('kelas_id')
            ->count();
            
        // Get total subjects taught by this teacher
        $totalMapel = Jadwal::where('guru_id', $guru->guru_id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('status', 'aktif')
            ->distinct('mapel_id')
            ->count();
            
        // Get this week's schedule
        $jadwalMingguIni = Jadwal::with(['mapel', 'kelas'])
            ->where('guru_id', $guru->guru_id)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('status', 'aktif')
            ->orderBy('hari')
            ->orderBy('jam_ke')
            ->get()
            ->groupBy('hari');
            
        // Count total schedule for this week
        $totalJadwalMingguIni = $jadwalMingguIni->flatten()->count();
        
        return view('guru.dashboard.index', compact(
            'guru', 
            'jadwalHariIni',
            'totalJadwalHariIni',
            'totalKelas', 
            'totalMapel', 
            'jadwalMingguIni',
            'totalJadwalMingguIni',
            'hariIni'
        ));
    }
}