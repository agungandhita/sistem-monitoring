<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kurikulums = Kurikulum::paginate(10);
        return view('admin.kurikulum.index', compact('kurikulums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kurikulum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:20'
        ]);

        try {
            Kurikulum::create([
                'nama_kurikulum' => $request->nama_kurikulum,
                'tahun_ajaran' => $request->tahun_ajaran
            ]);

            Alert::success('Berhasil', 'Data kurikulum berhasil ditambahkan');
            return redirect()->route('admin.kurikulum.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kurikulum $kurikulum)
    {
        $kurikulum->load('gurus', 'mapels');
        $gurus = $kurikulum->gurus;
        $mapels = $kurikulum->mapels;
        return view('admin.kurikulum.show', compact('kurikulum', 'gurus', 'mapels'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kurikulum $kurikulum)
    {
        return view('admin.kurikulum.edit', compact('kurikulum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        $request->validate([
            'nama_kurikulum' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:20'
        ]);

        try {
            $kurikulum->update([
                'nama_kurikulum' => $request->nama_kurikulum,
                'tahun_ajaran' => $request->tahun_ajaran
            ]);

            Alert::success('Berhasil', 'Data kurikulum berhasil diperbarui');
            return redirect()->route('admin.kurikulum.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kurikulum $kurikulum)
    {
        try {
            $kurikulum->delete();
            Alert::success('Berhasil', 'Data kurikulum berhasil dihapus');
            return redirect()->route('admin.kurikulum.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}
