<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Validation\Rule;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rombel::with(['kelas', 'waliKelas', 'siswas' => function($query) {
            $query->wherePivot('status', 'aktif');
        }]);
        
        // Filter by kelas_id if provided
        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        // Filter by tahun_ajaran if provided
        if ($request->has('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by wali_kelas_id if provided
        if ($request->has('wali_kelas_id')) {
            $query->where('wali_kelas_id', $request->wali_kelas_id);
        }
        
        $rombels = $query->orderBy('nama_rombel')->get();
        
        return view('admin.rombel.index', compact('rombels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::where('status', 'aktif')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $gurus = Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        
        return view('admin.rombel.create', compact('kelas', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'nama_rombel' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
            'kapasitas_maksimal' => 'integer|min:1|max:50',
            'wali_kelas_id' => 'nullable|exists:gurus,guru_id',
            'deskripsi' => 'nullable|string',
            'status' => 'in:aktif,tidak_aktif'
        ]);
        
        // Check for unique combination
        $exists = Rombel::where('nama_rombel', $validated['nama_rombel'])
                        ->where('kelas_id', $validated['kelas_id'])
                        ->where('tahun_ajaran', $validated['tahun_ajaran'])
                        ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'nama_rombel' => 'Rombel dengan nama, kelas, dan tahun ajaran yang sama sudah ada'
            ])->withInput();
        }
        
        // Check if wali kelas is already assigned to another active rombel
        if (isset($validated['wali_kelas_id'])) {
            $waliExists = Rombel::where('wali_kelas_id', $validated['wali_kelas_id'])
                               ->where('status', 'aktif')
                               ->where('tahun_ajaran', $validated['tahun_ajaran'])
                               ->exists();
            
            if ($waliExists) {
                return redirect()->back()->withErrors([
                    'wali_kelas_id' => 'Guru sudah menjadi wali kelas di rombel lain untuk tahun ajaran yang sama'
                ])->withInput();
            }
        }
        
        Rombel::create($validated);
        
        return redirect()->route('admin.rombel.index')
                        ->with('success', 'Rombel berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rombel = Rombel::with([
            'kelas',
            'waliKelas',
            'siswas' => function($query) {
                $query->wherePivot('status', 'aktif')
                      ->withPivot(['tahun_ajaran', 'tanggal_masuk', 'tanggal_keluar', 'status', 'keterangan']);
            },
            'jadwalHarian.mapel',
            'jadwalHarian.guru'
        ])->find($id);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        return view('admin.rombel.show', compact('rombel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rombel = Rombel::with(['kelas', 'waliKelas'])->find($id);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        $kelas = Kelas::where('status', 'aktif')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $gurus = Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        
        return view('admin.rombel.edit', compact('rombel', 'kelas', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rombel = Rombel::find($id);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'nama_rombel' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
            'kapasitas_maksimal' => 'integer|min:1|max:50',
            'wali_kelas_id' => 'nullable|exists:gurus,guru_id',
            'deskripsi' => 'nullable|string',
            'status' => 'in:aktif,tidak_aktif'
        ]);
        
        // Check for unique combination (excluding current record)
        $exists = Rombel::where('nama_rombel', $validated['nama_rombel'])
                        ->where('kelas_id', $validated['kelas_id'])
                        ->where('tahun_ajaran', $validated['tahun_ajaran'])
                        ->where('rombel_id', '!=', $id)
                        ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'nama_rombel' => 'Rombel dengan nama, kelas, dan tahun ajaran yang sama sudah ada'
            ])->withInput();
        }
        
        // Check if wali kelas is already assigned to another active rombel (excluding current)
        if (isset($validated['wali_kelas_id'])) {
            $waliExists = Rombel::where('wali_kelas_id', $validated['wali_kelas_id'])
                               ->where('status', 'aktif')
                               ->where('tahun_ajaran', $validated['tahun_ajaran'])
                               ->where('rombel_id', '!=', $id)
                               ->exists();
            
            if ($waliExists) {
                return redirect()->back()->withErrors([
                    'wali_kelas_id' => 'Guru sudah menjadi wali kelas di rombel lain untuk tahun ajaran yang sama'
                ])->withInput();
            }
        }
        
        // Check if reducing capacity below current student count
        if (isset($validated['kapasitas_maksimal'])) {
            $currentStudentCount = $rombel->siswas()->wherePivot('status', 'aktif')->count();
            if ($validated['kapasitas_maksimal'] < $currentStudentCount) {
                return redirect()->back()->withErrors([
                    'kapasitas_maksimal' => "Kapasitas maksimal tidak boleh kurang dari jumlah siswa saat ini ({$currentStudentCount})"
                ])->withInput();
            }
        }
        
        $rombel->update($validated);
        
        return redirect()->route('admin.rombel.index')
                        ->with('success', 'Rombel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rombel = Rombel::find($id);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        // Check if rombel has active students
        $hasActiveStudents = $rombel->siswas()->wherePivot('status', 'aktif')->exists();
        
        if ($hasActiveStudents) {
            return redirect()->route('admin.rombel.index')
                            ->with('error', 'Tidak dapat menghapus rombel yang masih memiliki siswa aktif');
        }
        
        // Check if rombel has active schedules
        $hasActiveSchedules = $rombel->jadwalHarian()->where('status', 'aktif')->exists();
        
        if ($hasActiveSchedules) {
            return redirect()->route('admin.rombel.index')
                            ->with('error', 'Tidak dapat menghapus rombel yang masih memiliki jadwal aktif');
        }
        
        $rombel->delete();
        
        return redirect()->route('admin.rombel.index')
                        ->with('success', 'Rombel berhasil dihapus');
    }
    
    /**
     * Add student to rombel
     */
    public function addStudent(Request $request, string $id)
    {
        $rombel = Rombel::find($id);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,siswa_id',
            'tahun_ajaran' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);
        
        // Check if student is already in this rombel for the same academic year
        $exists = $rombel->siswas()
                         ->wherePivot('siswa_id', $validated['siswa_id'])
                         ->wherePivot('tahun_ajaran', $validated['tahun_ajaran'])
                         ->wherePivot('status', 'aktif')
                         ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'siswa_id' => 'Siswa sudah terdaftar di rombel ini untuk tahun ajaran yang sama'
            ])->withInput();
        }
        
        // Check capacity
        if (!$rombel->canAddStudent()) {
            return redirect()->back()->withErrors([
                'siswa_id' => 'Kapasitas rombel sudah penuh'
            ])->withInput();
        }
        
        // Add student to rombel
        $rombel->siswas()->attach($validated['siswa_id'], [
            'tahun_ajaran' => $validated['tahun_ajaran'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'status' => 'aktif',
            'keterangan' => $validated['keterangan'] ?? null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Update student count
        $rombel->updateStudentCount();
        
        return redirect()->route('admin.rombel.show', $id)
                        ->with('success', 'Siswa berhasil ditambahkan ke rombel');
    }
    
    /**
     * Remove student from rombel
     */
    public function removeStudent(Request $request, string $id, string $siswaId)
    {
        $rombel = Rombel::find($id);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        $validated = $request->validate([
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);
        
        // Check if student is in this rombel
        $pivot = $rombel->siswas()
                        ->wherePivot('siswa_id', $siswaId)
                        ->wherePivot('status', 'aktif')
                        ->first();
        
        if (!$pivot) {
            return redirect()->route('admin.rombel.show', $id)
                            ->with('error', 'Siswa tidak ditemukan di rombel ini atau sudah tidak aktif');
        }
        
        // Update pivot record
        $rombel->siswas()->updateExistingPivot($siswaId, [
            'tanggal_keluar' => $validated['tanggal_keluar'],
            'status' => 'tidak_aktif',
            'keterangan' => $validated['keterangan'] ?? $pivot->pivot->keterangan,
            'updated_at' => now()
        ]);
        
        // Update student count
        $rombel->updateStudentCount();
        
        return redirect()->route('admin.rombel.show', $id)
                        ->with('success', 'Siswa berhasil dikeluarkan dari rombel');
    }
}
