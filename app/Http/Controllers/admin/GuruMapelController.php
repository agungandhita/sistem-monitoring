<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GuruMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::with([
            'mapels' => function($query) {
                $query->withPivot('kurikulum_id', 'kelas');
            }
        ])->paginate(10);
        
        // Get all kurikulum IDs from pivot data
        $kurikulumIds = [];
        foreach ($gurus as $guru) {
            foreach ($guru->mapels as $mapel) {
                if ($mapel->pivot->kurikulum_id) {
                    $kurikulumIds[] = $mapel->pivot->kurikulum_id;
                }
            }
        }
        
        // Load all kurikulums at once
        $kurikulums = Kurikulum::whereIn('kurikulum_id', array_unique($kurikulumIds))
                              ->get()
                              ->keyBy('kurikulum_id');
        
        // Attach kurikulum data to each mapel
        foreach ($gurus as $guru) {
            foreach ($guru->mapels as $mapel) {
                if ($mapel->pivot->kurikulum_id && isset($kurikulums[$mapel->pivot->kurikulum_id])) {
                    $mapel->kurikulum = $kurikulums[$mapel->pivot->kurikulum_id];
                }
            }
        }
        
        return view('admin.guru-mapel.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kurikulums = Kurikulum::all();
        return view('admin.guru-mapel.create', compact('gurus', 'mapels', 'kurikulums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,guru_id',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id',
            'kelas' => 'required|string|max:10'
        ]);

        try {
            $guru = Guru::find($request->guru_id);
            
            // Check if the combination already exists
            $exists = $guru->mapels()
                ->wherePivot('mapel_id', $request->mapel_id)
                ->wherePivot('kurikulum_id', $request->kurikulum_id)
                ->wherePivot('kelas', $request->kelas)
                ->exists();

            if ($exists) {
                Alert::error('Gagal', 'Kombinasi guru, mata pelajaran, kurikulum, dan kelas sudah ada');
                return back()->withInput();
            }

            $guru->mapels()->attach($request->mapel_id, [
                'kurikulum_id' => $request->kurikulum_id,
                'kelas' => $request->kelas
            ]);

            Alert::success('Berhasil', 'Penugasan guru berhasil ditambahkan');
            return redirect()->route('admin.guru-mapel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($guru_id)
    {
        $guru = Guru::with(['mapels' => function($query) {
            $query->withPivot('kurikulum_id', 'kelas');
        }])->findOrFail($guru_id);
        
        return view('admin.guru-mapel.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($guru_id, $mapel_id, $kurikulum_id, $kelas)
    {
        $guru = Guru::findOrFail($guru_id);
        $mapel = Mapel::findOrFail($mapel_id);
        $kurikulum = Kurikulum::findOrFail($kurikulum_id);
        
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kurikulums = Kurikulum::all();
        
        return view('admin.guru-mapel.edit', compact('guru', 'mapel', 'kurikulum', 'kelas', 'gurus', 'mapels', 'kurikulums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $guru_id, $mapel_id, $kurikulum_id, $kelas)
    {
        $request->validate([
            'new_guru_id' => 'required|exists:gurus,guru_id',
            'new_mapel_id' => 'required|exists:mapels,mapel_id',
            'new_kurikulum_id' => 'required|exists:kurikulums,kurikulum_id',
            'new_kelas' => 'required|string|max:10'
        ]);

        try {
            $oldGuru = Guru::findOrFail($guru_id);
            $newGuru = Guru::findOrFail($request->new_guru_id);
            
            // Check if the new combination already exists (except current record)
            $exists = $newGuru->mapels()
                ->wherePivot('mapel_id', $request->new_mapel_id)
                ->wherePivot('kurikulum_id', $request->new_kurikulum_id)
                ->wherePivot('kelas', $request->new_kelas)
                ->exists();

            if ($exists && !($guru_id == $request->new_guru_id && 
                           $mapel_id == $request->new_mapel_id && 
                           $kurikulum_id == $request->new_kurikulum_id && 
                           $kelas == $request->new_kelas)) {
                Alert::error('Gagal', 'Kombinasi guru, mata pelajaran, kurikulum, dan kelas sudah ada');
                return back()->withInput();
            }

            // Remove old relationship
            $oldGuru->mapels()->wherePivot('mapel_id', $mapel_id)
                ->wherePivot('kurikulum_id', $kurikulum_id)
                ->wherePivot('kelas', $kelas)
                ->detach();

            // Add new relationship
            $newGuru->mapels()->attach($request->new_mapel_id, [
                'kurikulum_id' => $request->new_kurikulum_id,
                'kelas' => $request->new_kelas
            ]);

            Alert::success('Berhasil', 'Penugasan guru berhasil diperbarui');
            return redirect()->route('admin.guru-mapel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($guru_id, $mapel_id, $kurikulum_id, $kelas)
    {
        try {
            $guru = Guru::findOrFail($guru_id);
            
            $guru->mapels()->wherePivot('mapel_id', $mapel_id)
                ->wherePivot('kurikulum_id', $kurikulum_id)
                ->wherePivot('kelas', $kelas)
                ->detach();

            Alert::success('Berhasil', 'Penugasan guru berhasil dihapus');
            return redirect()->route('admin.guru-mapel.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}
