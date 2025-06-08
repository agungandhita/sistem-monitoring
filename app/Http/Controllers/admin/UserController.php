<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    public function index(Request $request)
    {

        $data = User::where('role', 'nadzom')->orWhere('role', 'quran')->get();


        $query = $request->input('query');

        if ($query) {
            $users = User::where('nama', 'like', "%$query%")
                ->get();
        } else {
            $users = User::where('role', 'nadzom')
                ->orWhere('role', 'quran')
                ->get();
        }

        // dd($data);


        return view('admin.akun.index', [
            'data' => $data,
            'users' => $users,
            'query' => $query
        ]);
    }

    public function store(Request $request)
    {
        $cek = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'role' => 'required',
        ]);

        $cek['password'] = bcrypt($cek['password']);

        User::create([
            'nama' => $cek['nama'],
            'email' => $cek['email'],
            'password' => $cek['password'],
            'alamat' => $cek['alamat'],
            'telepon' => $cek['telepon'],
            'role' => $cek['role'],

        ]);
        return redirect('/user')->with('success', 'Your operation was successful.');
    }

    public function update(Request $request, $id)
    {

        $cek = $request->validate([
            'email' => 'required|email:rfc,dns|unique:users',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        User::find($id)->update([
            'email' => $cek['email'],
            'alamat' => $cek['alamat'],
            'telepon' => $cek['telepon']
        ]);

        return redirect('/user')->with('succes', 'berhasil update');
    }

    public function destroy(User $user, $id)
    {

        // $data = User::where('user_id', $id)->first();

        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        return redirect('/user')->with('success', 'Delete successful to the Guide');
    }
}
