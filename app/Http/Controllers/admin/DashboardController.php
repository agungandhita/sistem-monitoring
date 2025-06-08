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
        // Get current hour for greeting
        $currentHour = date('H');
        
        // Get counts for dashboard statistics
        $totalGuru = User::where('role', 'guru')->count();
        $totalWali = User::where('role', 'wali')->count();
        
        // Return view with dashboard data
        return view('admin.dashboard.index', compact(
            'currentHour',
            'totalGuru',
            'totalWali',
        ));
    }
}