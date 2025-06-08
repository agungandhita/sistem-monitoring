<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Wali;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard statistics
        // $totalSantri = User::where('role', 'wali')->count();
        $totalGuru = User::where('role', 'guru')->count();
        // $totalWali = Wali::count();
        // $totalKelas = Kelas::count();

        // Get recent nilai entries
        // $recentNilai = Nilai::with(['user', 'kelas'])
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        // Return view with dashboard data
        return view('admin.dashboard.index', compact(
            'totalGuru', 
       
        ));
    }
}