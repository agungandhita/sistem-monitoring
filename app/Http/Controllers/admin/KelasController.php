<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kelas::with(['rombels.waliKelas']);
        
        // Filter by tingkat if provided
        if ($request->has('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        
        // Filter by tahun_ajaran if provided
        if ($request->has('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $kelas = $query->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        // Get unique tahun ajaran for filter dropdown
        $tahunAjaranList = Kelas::distinct()->pluck('tahun_ajaran')->sort()->values();
        
        return view('admin.kelas.index', compact('kelas', 'tahunAjaranList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:10',
            'tingkat' => 'required|integer|min:1|max:6',
            'tahun_ajaran' => 'required|string|max:20',
            'kapasitas_maksimal' => 'integer|min:1|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'in:aktif,tidak_aktif'
        ]);
        
        // Check for unique combination
        $exists = Kelas::where('nama_kelas', $validated['nama_kelas'])
                       ->where('tahun_ajaran', $validated['tahun_ajaran'])
                       ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'nama_kelas' => 'Kelas dengan nama dan tahun ajaran yang sama sudah ada'
            ])->withInput();
        }
        
        Kelas::create($validated);
        
        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Kelas berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = Kelas::with([
            'rombels.waliKelas',
            'rombels.siswas' => function($query) {
                $query->wherePivot('status', 'aktif');
            }
        ])->find($id);
        
        if (!$kelas) {
            abort(404, 'Kelas tidak ditemukan');
        }
        
        return view('admin.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::find($id);
        
        if (!$kelas) {
            abort(404, 'Kelas tidak ditemukan');
        }
        
        return view('admin.kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kelas = Kelas::find($id);
        
        if (!$kelas) {
            abort(404, 'Kelas tidak ditemukan');
        }
        
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:10',
            'tingkat' => 'required|integer|min:1|max:6',
            'tahun_ajaran' => 'required|string|max:20',
            'kapasitas_maksimal' => 'integer|min:1|max:50',
            'deskripsi' => 'nullable|string',
            'status' => 'in:aktif,tidak_aktif'
        ]);
        
        // Check for unique combination (excluding current record)
        $exists = Kelas::where('nama_kelas', $validated['nama_kelas'])
                       ->where('tahun_ajaran', $validated['tahun_ajaran'])
                       ->where('kelas_id', '!=', $id)
                       ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'nama_kelas' => 'Kelas dengan nama dan tahun ajaran yang sama sudah ada'
            ])->withInput();
        }
        
        $kelas->update($validated);
        
        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::find($id);
        
        if (!$kelas) {
            abort(404, 'Kelas tidak ditemukan');
        }
        
        // Check if kelas has active rombels
        $hasActiveRombels = $kelas->rombels()->where('status', 'aktif')->exists();
        
        if ($hasActiveRombels) {
            return redirect()->route('admin.kelas.index')
                            ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki rombel aktif');
        }
        
        $kelas->delete();
        
        return redirect()->route('admin.kelas.index')
                        ->with('success', 'Kelas berhasil dihapus');
    }
}
