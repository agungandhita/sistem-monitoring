<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.index', [
            'tittle' => 'login'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'telepon' => ['telepon'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();

            if ($user->role == 'admin') {
                return redirect()->intended('/admin');
            } elseif ($user->role == 'nadzom') {
                return redirect()->intended('/guru');
            } elseif ($user->role == 'wali') {
                return redirect()->intended('/wali');
            }
        }
 
        return back()->with('LoginError', 'Login Failed!');
    }

    public function guruIndex()
    {
        return view('guru.auth.login', [
            'tittle' => 'login guru'
        ]);
    }

    // Method untuk login guru dengan guard terpisah
    public function guruLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('guru')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('guru.dashboard');
        }

        return back()->with('LoginError', 'Login Failed!');
    }

    // Method untuk logout guru
    public function guruLogout(Request $request)
    {
        Auth::guard('guru')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('guru.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login'); // Changed from 'login.admin' to 'login'
    }
}
