<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Wali;
use App\Models\Mapel;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current hour for greeting
        $currentHour = date('H');
        
        // Get counts for dashboard statistics
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalWali = Wali::count();
        $totalMapel = Mapel::count();
        $totalUser = User::count();
        
        // Get recent data for activity
        $recentSiswa = Siswa::with('kelas')->latest()->take(5)->get();
        $recentGuru = Guru::latest()->take(5)->get();
        $recentWali = Wali::latest()->take(5)->get();
        
        // Get statistics by gender for charts
        $guruByGender = Guru::selectRaw('jenis_kelamin, COUNT(*) as count')
                           ->groupBy('jenis_kelamin')
                           ->get();
                           
        $siswaByGender = Siswa::selectRaw('jenis_kelamin, COUNT(*) as count')
                             ->groupBy('jenis_kelamin')
                             ->get();
        
        // Get students by class with class name
        $siswaByKelas = Siswa::join('kelas', 'siswas.kelas_id', '=', 'kelas.kelas_id')
                            ->selectRaw('kelas.nama_kelas, COUNT(*) as count')
                            ->groupBy('kelas.nama_kelas')
                            ->orderBy('kelas.nama_kelas')
                            ->get();
        
        // Return view with dashboard data
        return view('admin.dashboard.index', compact(
            'currentHour',
            'totalGuru',
            'totalSiswa',
            'totalWali',
            'totalMapel',
            'totalUser',
            'recentSiswa',
            'recentGuru',
            'recentWali',
            'guruByGender',
            'siswaByGender',
            'siswaByKelas'
        ));
    }
}