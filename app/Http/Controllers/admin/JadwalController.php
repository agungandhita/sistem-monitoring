<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\GuruMapel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jadwal::with(['guru', 'mapel', 'kelas', 'kurikulum']);
        
        // Filter berdasarkan kelas jika ada
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        // Filter berdasarkan hari jika ada
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }
        
        // Filter berdasarkan tahun ajaran jika ada
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        $jadwals = $query->orderBy('hari')
                        ->orderBy('jam_ke')
                        ->paginate(15);
        
        // Data untuk filter
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $tahunAjaran = Jadwal::select('tahun_ajaran')
                            ->distinct()
                            ->orderBy('tahun_ajaran', 'desc')
                            ->pluck('tahun_ajaran');
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        return view('admin.jadwal.index', compact('jadwals', 'kelas', 'tahunAjaran', 'hari'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::orderBy('nama')->get();
        $mapels = Mapel::orderBy('mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jamKe = range(1, 10); // Jam ke 1-10
        
        return view('admin.jadwal.create', compact('gurus', 'mapels', 'kelas', 'kurikulums', 'hari', 'jamKe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_ke' => 'required|integer|min:1|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'guru_id' => 'required|exists:gurus,guru_id',
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id',
            'tahun_ajaran' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        // Cek konflik jadwal
        $conflict = $this->checkScheduleConflict(
            $request->hari,
            $request->jam_ke,
            $request->guru_id,
            $request->kelas_id,
            $request->tahun_ajaran
        );
        
        if ($conflict) {
            Alert::error('Error', $conflict);
            return back()->withInput();
        }
        
        // Cek apakah guru mengajar mapel ini
        $guruMapel = GuruMapel::where('guru_id', $request->guru_id)
                             ->where('mapel_id', $request->mapel_id)
                             ->where('kurikulum_id', $request->kurikulum_id)
                             ->first();
        
        if (!$guruMapel) {
            Alert::error('Error', 'Guru tidak terdaftar mengajar mata pelajaran ini pada kurikulum yang dipilih.');
            return back()->withInput();
        }
        
        try {
            Jadwal::create($request->all());
            Alert::success('Berhasil', 'Jadwal berhasil ditambahkan.');
            return redirect()->route('admin.jadwal.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan jadwal.');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jadwal = Jadwal::with(['guru', 'mapel', 'kelas', 'kurikulum'])->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $gurus = Guru::orderBy('nama_guru')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $kurikulums = Kurikulum::orderBy('nama_kurikulum')->get();
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jamKe = range(1, 10);
        
        return view('admin.jadwal.edit', compact('jadwal', 'gurus', 'mapels', 'kelas', 'kurikulums', 'hari', 'jamKe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_ke' => 'required|integer|min:1|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'guru_id' => 'required|exists:gurus,guru_id',
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id',
            'tahun_ajaran' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak_aktif',
            'catatan' => 'nullable|string|max:500'
        ]);
        
        // Cek konflik jadwal (kecuali jadwal yang sedang diedit)
        $conflict = $this->checkScheduleConflict(
            $request->hari,
            $request->jam_ke,
            $request->guru_id,
            $request->kelas_id,
            $request->tahun_ajaran,
            $id
        );
        
        if ($conflict) {
            Alert::error('Error', $conflict);
            return back()->withInput();
        }
        
        // Cek apakah guru mengajar mapel ini
        $guruMapel = GuruMapel::where('guru_id', $request->guru_id)
                             ->where('mapel_id', $request->mapel_id)
                             ->where('kurikulum_id', $request->kurikulum_id)
                             ->first();
        
        if (!$guruMapel) {
            Alert::error('Error', 'Guru tidak terdaftar mengajar mata pelajaran ini pada kurikulum yang dipilih.');
            return back()->withInput();
        }
        
        try {
            $jadwal->update($request->all());
            Alert::success('Berhasil', 'Jadwal berhasil diperbarui.');
            return redirect()->route('admin.jadwal.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat memperbarui jadwal.');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jadwal = Jadwal::findOrFail($id);
            $jadwal->delete();
            Alert::success('Berhasil', 'Jadwal berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle foreign key constraint violation
            if ($e->getCode() == '23000') {
                Alert::error('Error', 'Jadwal tidak dapat dihapus karena masih terkait dengan data lain.');
            } else {
                Alert::error('Error', 'Terjadi kesalahan database saat menghapus jadwal.');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menghapus jadwal: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.jadwal.index');
    }
    
    /**
     * Get mapels by guru for AJAX
     */
    public function getMapelsByGuru(Request $request)
    {
        try {
            $request->validate([
                'guru_id' => 'required|exists:gurus,guru_id',
                'kurikulum_id' => 'required|exists:kurikulums,kurikulum_id'
            ]);
            
            $guruId = $request->guru_id;
            $kurikulumId = $request->kurikulum_id;
            
            $mapels = GuruMapel::with('mapel')
                              ->where('guru_id', $guruId)
                              ->where('kurikulum_id', $kurikulumId)
                              ->get()
                              ->pluck('mapel')
                              ->unique('mapel_id')
                              ->values(); // Reset array keys
            
            return response()->json($mapels);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data mata pelajaran'], 500);
        }
    }
    
    /**
     * Get schedule by class and day for AJAX
     */
    public function getScheduleByClass(Request $request)
    {
        try {
            $request->validate([
                'kelas_id' => 'required|exists:kelas,kelas_id',
                'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
                'tahun_ajaran' => 'required|string'
            ]);
            
            $kelasId = $request->kelas_id;
            $hari = $request->hari;
            $tahunAjaran = $request->tahun_ajaran;
            
            $jadwals = Jadwal::with(['guru', 'mapel'])
                            ->where('kelas_id', $kelasId)
                            ->where('hari', $hari)
                            ->where('tahun_ajaran', $tahunAjaran)
                            ->where('status', 'aktif')
                            ->orderBy('jam_ke')
                            ->get();
            
            return response()->json($jadwals);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data jadwal'], 500);
        }
    }
    
    /**
     * Check for schedule conflicts
     */
    private function checkScheduleConflict($hari, $jamKe, $guruId, $kelasId, $tahunAjaran, $excludeId = null)
    {
        // Cek konflik guru (guru tidak bisa mengajar di 2 tempat pada waktu yang sama)
        $guruConflict = Jadwal::where('hari', $hari)
                             ->where('jam_ke', $jamKe)
                             ->where('guru_id', $guruId)
                             ->where('tahun_ajaran', $tahunAjaran)
                             ->where('status', 'aktif')
                             ->when($excludeId, function($query) use ($excludeId) {
                                 return $query->where('jadwal_id', '!=', $excludeId);
                             })
                             ->first();
        
        if ($guruConflict) {
            return 'Guru sudah memiliki jadwal mengajar pada hari dan jam yang sama.';
        }
        
        // Cek konflik kelas (kelas tidak bisa memiliki 2 mata pelajaran pada waktu yang sama)
        $kelasConflict = Jadwal::where('hari', $hari)
                              ->where('jam_ke', $jamKe)
                              ->where('kelas_id', $kelasId)
                              ->where('tahun_ajaran', $tahunAjaran)
                              ->where('status', 'aktif')
                              ->when($excludeId, function($query) use ($excludeId) {
                                  return $query->where('jadwal_id', '!=', $excludeId);
                              })
                              ->first();
        
        if ($kelasConflict) {
            return 'Kelas sudah memiliki jadwal pelajaran pada hari dan jam yang sama.';
        }
        
        return null;
    }
    
    /**
     * Display schedules by day
     */
    public function showByDay(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'kelas_id' => 'nullable|exists:kelas,kelas_id',
            'tahun_ajaran' => 'nullable|string'
        ]);
        
        $hari = $request->hari;
        $kelasId = $request->kelas_id;
        $tahunAjaran = $request->tahun_ajaran;
        
        $query = Jadwal::with(['guru', 'mapel', 'kelas', 'kurikulum'])
                       ->where('hari', $hari)
                       ->where('status', 'aktif')
                       ->orderBy('jam_ke');
        
        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }
        
        if ($tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        }
        
        $jadwals = $query->get();
        
        // Data untuk filter
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $tahunAjaranList = Jadwal::select('tahun_ajaran')
                                ->distinct()
                                ->orderBy('tahun_ajaran', 'desc')
                                ->pluck('tahun_ajaran');
        
        return view('admin.jadwal.by-day', compact('jadwals', 'hari', 'kelas', 'tahunAjaranList', 'kelasId', 'tahunAjaran'));
    }
}