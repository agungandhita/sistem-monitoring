<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapels = Mapel::with('kurikulums')->paginate(10);
        return view('admin.mapel.index', compact('mapels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurikulums = Kurikulum::all();
        
        // Check if there are any kurikulums
        if ($kurikulums->isEmpty()) {
            Alert::warning('Peringatan', 'Anda harus menambahkan kurikulum terlebih dahulu sebelum menambah mata pelajaran.');
            return redirect()->route('admin.kurikulum.index');
        }
        
        return view('admin.mapel.create', compact('kurikulums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:10|unique:mapels,kode_mapel',
            'mapel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id'
        ]);

        try {
            Mapel::create($request->only(['kode_mapel', 'mapel', 'deskripsi', 'kurikulum_id']));
            Alert::success('Berhasil', 'Data mata pelajaran berhasil ditambahkan');
            return redirect()->route('admin.mapel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mapel $mapel)
    {
        $mapel->load('gurus');
        return view('admin.mapel.show', compact('mapel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        $kurikulums = Kurikulum::all();
        return view('admin.mapel.edit', compact('mapel', 'kurikulums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:10|unique:mapels,kode_mapel,' . $mapel->mapel_id . ',mapel_id',
            'mapel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id'
        ]);

        try {
            $mapel->update($request->only(['kode_mapel', 'mapel', 'deskripsi', 'kurikulum_id']));
            Alert::success('Berhasil', 'Data mata pelajaran berhasil diperbarui');
            return redirect()->route('admin.mapel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        try {
            $mapel->delete();
            Alert::success('Berhasil', 'Data mata pelajaran berhasil dihapus');
            return redirect()->route('admin.mapel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}
