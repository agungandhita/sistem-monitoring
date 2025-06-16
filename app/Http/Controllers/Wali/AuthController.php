<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('wali.auth.login', [
            'title' => 'Login Wali'
        ]);
    }

    public function loginWali(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tambahkan kondisi role wali
        $credentials['role'] = 'wali';

        if (Auth::guard('wali')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('wali.dashboard');
        }

        return back()->with('LoginError', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::guard('wali')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('wali.login');
    }
}