<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.copyreg');
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email:rfc,dns|unique:users',
            'telepon' => 'required',
            'alamat' => 'required',
            'password' => 'required|min:5|max:255',
        ]);


        $validasi['password'] = bcrypt($validasi['password']);

        $proses = User::create([
            'nama' => $validasi['nama'],
            'email' => $validasi['email'],
            'telepon' => $validasi['telepon'],
            'alamat' => $validasi['alamat'],
            'password' => $validasi['password'],
            'updated_at' => null
        ]);

        if ($proses) {
            return redirect('/')->with('toast_success', 'Registration successfull !!');
        } else {
            return redirect()->back()->with('warning', 'Registrasi Gagal');
        }
    }
}
