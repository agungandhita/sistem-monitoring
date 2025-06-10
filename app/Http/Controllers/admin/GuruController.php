<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('mapel')->get();
        $mapel = Mapel::all();
        return view('admin.guru.index', compact('guru', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nuptk' => 'nullable|unique:guru,nuptk',
            'nip' => 'required|unique:guru,nip',
            'nama' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|unique:guru,email',
            'password' => 'nullable|string|min:8',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:255',
            'mapel_id' => 'nullable|exists:mapel,mapel_id'
        ]);

        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/guru'), $filename);
            $data['foto'] = 'uploads/guru/' . $filename;
        }

        Guru::create($data);
        Alert::success('Sukses', 'Data guru berhasil ditambahkan');
        return redirect()->route('guru.index');
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nuptk' => 'nullable|unique:guru,nuptk,' . $guru->guru_id . ',guru_id',
            'nip' => 'required|unique:guru,nip,' . $guru->guru_id . ',guru_id',
            'nama' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|unique:guru,email,' . $guru->guru_id . ',guru_id',
            'password' => 'nullable|string|min:8',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:255',
            'mapel_id' => 'nullable|exists:mapel,mapel_id'
        ]);

        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($guru->foto && file_exists(public_path($guru->foto))) {
                unlink(public_path($guru->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/guru'), $filename);
            $data['foto'] = 'uploads/guru/' . $filename;
        } else {
            // Remove foto from data if no new file uploaded
            unset($data['foto']);
        }

        $guru->update($data);
        Alert::success('Sukses', 'Data guru berhasil diperbarui');
        return redirect()->route('guru.index');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        Alert::success('Sukses', 'Data guru berhasil dihapus');
        return redirect()->route('guru.index');
    }
}