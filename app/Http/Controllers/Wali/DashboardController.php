<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Jadwal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wali = $user->wali;
        
        // Get students associated with this wali
        $siswas = $wali->siswas()->with('kelas')->get();
        
        // Count total students
        $totalSiswas = $siswas->count();
        
        return view('wali.dashboard', compact('wali', 'siswas', 'totalSiswas'));
    }
}