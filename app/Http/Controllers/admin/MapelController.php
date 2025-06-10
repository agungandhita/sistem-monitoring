<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapels = Mapel::with('gurus')->paginate(10);
        return view('admin.mapel.index', compact('mapels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapel,kode_mapel|max:10',
            'nama_mapel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            Mapel::create([
                'kode_mapel' => strtoupper($request->kode_mapel),
                'nama_mapel' => $request->nama_mapel,
                'deskripsi' => $request->deskripsi
            ]);

            Alert::success('Berhasil', 'Mata pelajaran berhasil ditambahkan');
            return redirect()->route('mapel.index');
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
        
        // Get teachers grouped by class and academic year
        $teachersByClass = $mapel->gurus()
            ->withPivot(['kelas', 'tahun_ajaran', 'status', 'catatan'])
            ->get()
            ->groupBy(function($guru) {
                return $guru->pivot->tahun_ajaran . '|' . $guru->pivot->kelas;
            });
            
        return view('admin.mapel.show', compact('mapel', 'teachersByClass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        return view('admin.mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'kode_mapel' => 'required|max:10|unique:mapel,kode_mapel,' . $mapel->mapel_id . ',mapel_id',
            'nama_mapel' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $mapel->update([
                'kode_mapel' => strtoupper($request->kode_mapel),
                'nama_mapel' => $request->nama_mapel,
                'deskripsi' => $request->deskripsi
            ]);

            Alert::success('Berhasil', 'Mata pelajaran berhasil diperbarui');
            return redirect()->route('mapel.index');
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
            // Check if mapel is assigned to any guru
            if ($mapel->gurus()->count() > 0) {
                Alert::warning('Peringatan', 'Mata pelajaran tidak dapat dihapus karena masih ditugaskan ke guru');
                return redirect()->route('mapel.index');
            }
            
            $mapel->delete();
            Alert::success('Berhasil', 'Mata pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
        }
        
        return redirect()->route('mapel.index');
    }

    /**
     * Show form to assign teachers to subject
     */
    public function assignGuru(Mapel $mapel)
    {
        $gurus = Guru::all();
        $assignedGurus = $mapel->gurus;
        
        // Get available classes (you might want to make this dynamic)
        $availableClasses = ['1A', '1B', '2A', '2B', '3A', '3B', '4A', '4B', '5A', '5B', '6A', '6B'];
        
        return view('admin.mapel.assign-guru', compact('mapel', 'gurus', 'assignedGurus', 'availableClasses'));
    }

    /**
     * Store teacher assignment to subject
     */
    public function storeAssignGuru(Request $request, Mapel $mapel)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,guru_id',
            'kelas' => 'required|array',
            'kelas.*' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'status' => 'required|in:aktif,tidak_aktif',
            'catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->kelas as $kelas) {
                // Check if assignment already exists
                $exists = $mapel->gurus()
                    ->wherePivot('guru_id', $request->guru_id)
                    ->wherePivot('kelas', $kelas)
                    ->wherePivot('tahun_ajaran', $request->tahun_ajaran)
                    ->exists();
                
                if (!$exists) {
                    $mapel->gurus()->attach($request->guru_id, [
                        'kelas' => $kelas,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'status' => $request->status,
                        'catatan' => $request->catatan
                    ]);
                }
            }

            DB::commit();
            Alert::success('Berhasil', 'Guru berhasil ditugaskan ke mata pelajaran');
            return redirect()->route('mapel.assign-guru', $mapel);
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat menugaskan guru');
            return back()->withInput();
        }
    }

    /**
     * Get subjects data for AJAX requests
     */
    public function getMapels()
    {
        $mapels = Mapel::select('mapel_id', 'kode_mapel', 'nama_mapel')->get();
        return response()->json($mapels);
    }

    /**
     * Get subject details with assigned teachers
     */
    public function getMapelDetails(Mapel $mapel)
    {
        $mapel->load(['gurus' => function($query) {
            $query->withPivot(['kelas', 'tahun_ajaran', 'status', 'catatan']);
        }]);
        
        return response()->json($mapel);
    }

    /**
     * Get teaching assignments by academic year
     */
    public function getAssignmentsByYear($tahunAjaran)
    {
        $assignments = DB::table('guru_mapel')
            ->join('guru', 'guru_mapel.guru_id', '=', 'guru.guru_id')
            ->join('mapel', 'guru_mapel.mapel_id', '=', 'mapel.mapel_id')
            ->where('guru_mapel.tahun_ajaran', $tahunAjaran)
            ->select(
                'guru.nama as guru_nama',
                'mapel.nama_mapel',
                'guru_mapel.kelas',
                'guru_mapel.status',
                'guru_mapel.catatan'
            )
            ->orderBy('guru.nama')
            ->orderBy('mapel.nama_mapel')
            ->orderBy('guru_mapel.kelas')
            ->get()
            ->groupBy('guru_nama');
            
        return response()->json($assignments);
    }

    /**
     * Get teaching assignments by class
     */
    public function getAssignmentsByClass($kelas)
    {
        $assignments = DB::table('guru_mapel')
            ->join('guru', 'guru_mapel.guru_id', '=', 'guru.guru_id')
            ->join('mapel', 'guru_mapel.mapel_id', '=', 'mapel.mapel_id')
            ->where('guru_mapel.kelas', $kelas)
            ->where('guru_mapel.status', 'aktif')
            ->select(
                'guru.nama as guru_nama',
                'mapel.nama_mapel',
                'guru_mapel.tahun_ajaran',
                'guru_mapel.catatan'
            )
            ->orderBy('mapel.nama_mapel')
            ->get();
            
        return response()->json($assignments);
    }

    /**
     * Bulk assign teachers to multiple subjects
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.guru_id' => 'required|exists:guru,guru_id',
            'assignments.*.mapel_id' => 'required|exists:mapel,mapel_id',
            'assignments.*.kelas' => 'required|string',
            'assignments.*.tahun_ajaran' => 'required|string',
            'assignments.*.status' => 'required|in:aktif,tidak_aktif'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->assignments as $assignment) {
                // Check if assignment already exists
                $exists = DB::table('guru_mapel')
                    ->where('guru_id', $assignment['guru_id'])
                    ->where('mapel_id', $assignment['mapel_id'])
                    ->where('kelas', $assignment['kelas'])
                    ->where('tahun_ajaran', $assignment['tahun_ajaran'])
                    ->exists();
                
                if (!$exists) {
                    DB::table('guru_mapel')->insert([
                        'guru_id' => $assignment['guru_id'],
                        'mapel_id' => $assignment['mapel_id'],
                        'kelas' => $assignment['kelas'],
                        'tahun_ajaran' => $assignment['tahun_ajaran'],
                        'status' => $assignment['status'],
                        'catatan' => $assignment['catatan'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();
            Alert::success('Berhasil', 'Penugasan massal berhasil dilakukan');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat melakukan penugasan']);
        }
    }
}