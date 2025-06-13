<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\GuruMapel;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with('kurikulum')
                     ->orderBy('tingkat')
                     ->orderBy('nama_kelas')
                     ->paginate(10);
        
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurikulums = Kurikulum::all();
        return view('admin.kelas.create', compact('kurikulums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:10',
            'tingkat' => 'required|integer|min:1|max:6',
            'tahun_ajaran' => 'required|string',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id',
            'kapasitas' => 'required|integer|min:1|max:50',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);
    
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'tahun_ajaran' => $request->tahun_ajaran,
            'kurikulum_id' => $request->kurikulum_id,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
            'updated_at' => null,
        ]);
        
        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::with(['kurikulum', 'siswas', 'guruMapels.guru', 'guruMapels.mapel'])->find($id);
        return view('admin.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)  // Hapus parameter Kelas $kelas yang duplikat
    {
        $kelas = Kelas::findOrFail($id); // Ambil data berdasarkan ID
        $kurikulums = Kurikulum::all();
        return view('admin.kelas.edit', compact('kelas', 'kurikulums'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:10',
            'tingkat' => 'required|integer|min:1|max:6',
            'tahun_ajaran' => 'required|string|regex:/^\\d{4}\/\\d{4}$/',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id',
            'kapasitas' => 'required|integer|min:1|max:50',
            'status' => 'required|in:aktif,tidak_aktif'
        ], [
            'nama_kelas.required' => 'Nama kelas harus diisi',
            'nama_kelas.max' => 'Nama kelas maksimal 10 karakter',
            'tingkat.required' => 'Tingkat harus diisi',
            'tingkat.min' => 'Tingkat minimal 1',
            'tingkat.max' => 'Tingkat maksimal 6',
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi',
            'tahun_ajaran.regex' => 'Format tahun ajaran harus YYYY/YYYY',
            'kurikulum_id.required' => 'Kurikulum harus dipilih',
            'kurikulum_id.exists' => 'Kurikulum tidak valid',
            'kapasitas.required' => 'Kapasitas harus diisi',
            'kapasitas.min' => 'Kapasitas minimal 1',
            'kapasitas.max' => 'Kapasitas maksimal 50',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status harus aktif atau tidak aktif'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Terjadi kesalahan validasi');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check unique constraint (exclude current record)
        $exists = Kelas::where('nama_kelas', $request->nama_kelas)
                       ->where('tahun_ajaran', $request->tahun_ajaran)
                       ->where('kelas_id', '!=', $kelas->kelas_id)
                       ->exists();
        
        if ($exists) {
            Alert::error('Error', 'Nama kelas sudah ada untuk tahun ajaran ini');
            return redirect()->back()->withInput();
        }

        try {
            $kelas->update($request->all());
            Alert::success('Berhasil', 'Data kelas berhasil diperbarui');
            return redirect()->route('admin.kelas.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat memperbarui data');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        try {
            // Check if class has students
            if ($kelas->siswas()->count() > 0) {
                Alert::error('Error', 'Tidak dapat menghapus kelas yang masih memiliki siswa');
                return redirect()->back();
            }

            // Check if class has teacher assignments
            if ($kelas->guruMapels()->count() > 0) {
                Alert::error('Error', 'Tidak dapat menghapus kelas yang masih memiliki penugasan guru');
                return redirect()->back();
            }

            $kelas->delete();
            Alert::success('Berhasil', 'Data kelas berhasil dihapus');
            return redirect()->route('admin.kelas.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menghapus data');
            return redirect()->back();
        }
    }

    /**
     * Get classes by tingkat (AJAX)
     */
    public function getByTingkat($tingkat)
    {
        $kelas = Kelas::where('tingkat', $tingkat)
                     ->where('status', 'aktif')
                     ->orderBy('nama_kelas')
                     ->get(['kelas_id', 'nama_kelas']);
        
        return response()->json($kelas);
    }

    /**
     * Get classes by kurikulum (AJAX)
     */
    public function getByKurikulum($kurikulum_id)
    {
        $kelas = Kelas::where('kurikulum_id', $kurikulum_id)
                     ->where('status', 'aktif')
                     ->orderBy('tingkat')
                     ->orderBy('nama_kelas')
                     ->get(['kelas_id', 'nama_kelas', 'tingkat']);
                     dd($kelas);
        
        return response()->json($kelas);
    }
}