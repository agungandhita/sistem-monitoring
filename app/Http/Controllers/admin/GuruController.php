<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::paginate(10);
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nuptk' => 'nullable|string|max:20|unique:gurus,nuptk',
            'nip' => 'nullable|string|max:20|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'required|email|unique:gurus,email',
            'password' => 'required|string|min:8',
            'jabatan' => 'required|string|max:100',
            'tahun_masuk' => 'required|string|max:4'
        ]);

        try {
            $data = $request->only([
                'nuptk', 'nip', 'nama', 'alamat', 'tanggal_lahir',
                'nomor_hp', 'email', 'jabatan', 'tahun_masuk'
            ]);
            
            $data['password'] = Hash::make($request->password);
            
            // Handle file upload
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/guru'), $filename);
                $data['foto'] = $filename;
            }

            Guru::create($data);
            Alert::success('Berhasil', 'Data guru berhasil ditambahkan');
            return redirect()->route('admin.guru.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load('mapels');
        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nuptk' => 'nullable|string|max:20|unique:gurus,nuptk,' . $guru->guru_id . ',guru_id',
            'nip' => 'nullable|string|max:20|unique:gurus,nip,' . $guru->guru_id . ',guru_id',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nomor_hp' => 'required|string|max:20',
            'email' => 'required|email|unique:gurus,email,' . $guru->guru_id . ',guru_id',
            'password' => 'nullable|string|min:8',
            'jabatan' => 'required|string|max:100',
            'tahun_masuk' => 'required|string|max:4'
        ]);

        try {
            $data = $request->only([
                'nuptk', 'nip', 'nama', 'alamat', 'tanggal_lahir',
                'nomor_hp', 'email', 'jabatan', 'tahun_masuk'
            ]);
            
            // Update password only if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            
            // Handle file upload
            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($guru->foto && file_exists(public_path('uploads/guru/' . $guru->foto))) {
                    unlink(public_path('uploads/guru/' . $guru->foto));
                }
                
                $foto = $request->file('foto');
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/guru'), $filename);
                $data['foto'] = $filename;
            }

            $guru->update($data);
            Alert::success('Berhasil', 'Data guru berhasil diperbarui');
            return redirect()->route('admin.guru.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        try {
            // Delete photo if exists
            if ($guru->foto && file_exists(public_path('uploads/guru/' . $guru->foto))) {
                unlink(public_path('uploads/guru/' . $guru->foto));
            }
            
            $guru->delete();
            Alert::success('Berhasil', 'Data guru berhasil dihapus');
            return redirect()->route('admin.guru.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}
