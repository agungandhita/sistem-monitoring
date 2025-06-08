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

        $totalGuru = User::where('role', 'guru')->count();
      

        // Return view with dashboard data
        return view('admin.dashboard.index', compact(
            'totalGuru', 
       
        ));
    }
}