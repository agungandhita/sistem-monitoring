<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::with('guru')->get();
        return view('admin.mapel.index', compact('mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapel,kode_mapel',
            'nama_mapel' => 'required',
            'deskripsi' => 'nullable'
        ]);

        Mapel::create($request->all());
        Alert::success('Sukses', 'Data mata pelajaran berhasil ditambahkan');
        return redirect()->back();
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapel,kode_mapel,' . $mapel->mapel_id . ',mapel_id',
            'nama_mapel' => 'required',
            'deskripsi' => 'nullable'
        ]);

        $mapel->update($request->all());
        Alert::success('Sukses', 'Data mata pelajaran berhasil diperbarui');
        return redirect()->back();
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        Alert::success('Sukses', 'Data mata pelajaran berhasil dihapus');
        return redirect()->back();
    }
}