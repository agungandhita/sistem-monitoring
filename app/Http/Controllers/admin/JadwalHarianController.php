<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalHarian;
use App\Models\Rombel;
use App\Models\Mapel;
use App\Models\Guru;

use Illuminate\Validation\Rule;

class JadwalHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JadwalHarian::with(['rombel.kelas', 'mapel', 'guru']);
        
        // Filter by rombel_id if provided
        if ($request->has('rombel_id')) {
            $query->where('rombel_id', $request->rombel_id);
        }
        
        // Filter by guru_id if provided
        if ($request->has('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }
        
        // Filter by mapel_id if provided
        if ($request->has('mapel_id')) {
            $query->where('mapel_id', $request->mapel_id);
        }
        
        // Filter by hari if provided
        if ($request->has('hari')) {
            $query->where('hari', $request->hari);
        }
        
        // Filter by tahun_ajaran if provided
        if ($request->has('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        // Filter by semester if provided
        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $jadwal = $query->orderBy('hari')
                       ->orderBy('jam_mulai')
                       ->orderBy('jam_ke')
                       ->paginate(20);
        
        // Get filter options
        $rombels = Rombel::with('kelas')->where('status', 'aktif')->orderBy('nama_rombel')->get();
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama_mapel')->get();
        $gurus = Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        
        return view('admin.jadwal-harian.index', compact('jadwal', 'rombels', 'mapels', 'gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rombels = Rombel::with('kelas')->where('status', 'aktif')->orderBy('nama_rombel')->get();
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama_mapel')->get();
        $gurus = Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        
        return view('admin.jadwal-harian.create', compact('rombels', 'mapels', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rombel_id' => 'required|exists:rombels,rombel_id',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'guru_id' => 'required|exists:gurus,guru_id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jam_ke' => 'required|integer|min:1|max:10',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|integer|in:1,2',
            'keterangan' => 'nullable|string',
            'status' => 'in:aktif,tidak_aktif'
        ]);
        
        // Check for schedule conflicts
        $conflict = JadwalHarian::checkConflict(
            $validated['rombel_id'],
            $validated['guru_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $validated['tahun_ajaran'],
            $validated['semester']
        );
        
        if ($conflict) {
            return redirect()->back()->withErrors([
                'conflict' => 'Terdapat konflik jadwal dengan jadwal yang sudah ada'
            ])->withInput();
        }
        
        // Check for unique combination
        $exists = JadwalHarian::where('rombel_id', $validated['rombel_id'])
                             ->where('hari', $validated['hari'])
                             ->where('jam_ke', $validated['jam_ke'])
                             ->where('tahun_ajaran', $validated['tahun_ajaran'])
                             ->where('semester', $validated['semester'])
                             ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'jam_ke' => 'Jadwal untuk rombel, hari, dan jam ke yang sama sudah ada'
            ])->withInput();
        }
        
        $jadwal = JadwalHarian::create($validated);
        
        return redirect()->route('admin.jadwal-harian.index')
                        ->with('success', 'Jadwal harian berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jadwal = JadwalHarian::with([
            'rombel.kelas',
            'rombel.siswas' => function($query) {
                $query->wherePivot('status', 'aktif');
            },
            'mapel',
            'guru'
        ])->find($id);
        
        if (!$jadwal) {
            abort(404, 'Jadwal harian tidak ditemukan');
        }
        
        return view('admin.jadwal-harian.show', compact('jadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = JadwalHarian::with(['rombel.kelas', 'mapel', 'guru'])->find($id);
        
        if (!$jadwal) {
            abort(404, 'Jadwal harian tidak ditemukan');
        }
        
        $rombels = Rombel::with('kelas')->where('status', 'aktif')->orderBy('nama_rombel')->get();
        $mapels = Mapel::where('status', 'aktif')->orderBy('nama_mapel')->get();
        $gurus = Guru::where('status', 'aktif')->orderBy('nama_lengkap')->get();
        
        return view('admin.jadwal-harian.edit', compact('jadwal', 'rombels', 'mapels', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = JadwalHarian::find($id);
        
        if (!$jadwal) {
            abort(404, 'Jadwal harian tidak ditemukan');
        }
        
        $validated = $request->validate([
            'rombel_id' => 'required|exists:rombels,rombel_id',
            'mapel_id' => 'required|exists:mapels,mapel_id',
            'guru_id' => 'required|exists:gurus,guru_id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jam_ke' => 'required|integer|min:1|max:10',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|integer|in:1,2',
            'keterangan' => 'nullable|string',
            'status' => 'in:aktif,tidak_aktif'
        ]);
        
        // Check for schedule conflicts (excluding current record)
        $conflict = JadwalHarian::checkConflict(
            $validated['rombel_id'],
            $validated['guru_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $validated['tahun_ajaran'],
            $validated['semester'],
            $id // exclude current record
        );
        
        if ($conflict) {
            return redirect()->back()->withErrors([
                'conflict' => 'Terdapat konflik jadwal dengan jadwal yang sudah ada'
            ])->withInput();
        }
        
        // Check for unique combination (excluding current record)
        $exists = JadwalHarian::where('rombel_id', $validated['rombel_id'])
                             ->where('hari', $validated['hari'])
                             ->where('jam_ke', $validated['jam_ke'])
                             ->where('tahun_ajaran', $validated['tahun_ajaran'])
                             ->where('semester', $validated['semester'])
                             ->where('jadwal_id', '!=', $id)
                             ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'jam_ke' => 'Jadwal untuk rombel, hari, dan jam ke yang sama sudah ada'
            ])->withInput();
        }
        
        $jadwal->update($validated);
        
        return redirect()->route('admin.jadwal-harian.index')
                        ->with('success', 'Jadwal harian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalHarian::find($id);
        
        if (!$jadwal) {
            abort(404, 'Jadwal harian tidak ditemukan');
        }
        
        $jadwal->delete();
        
        return redirect()->route('admin.jadwal-harian.index')
                        ->with('success', 'Jadwal harian berhasil dihapus');
    }
    
    /**
     * Get weekly schedule for a specific rombel
     */
    public function getWeeklySchedule(Request $request, string $rombelId)
    {
        $rombel = Rombel::find($rombelId);
        
        if (!$rombel) {
            abort(404, 'Rombel tidak ditemukan');
        }
        
        $tahunAjaran = $request->get('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $semester = $request->get('semester', 1);
        
        $schedule = JadwalHarian::getWeeklySchedule($rombelId, $tahunAjaran, $semester);
        
        return view('admin.jadwal-harian.weekly-schedule', compact('rombel', 'tahunAjaran', 'semester', 'schedule'));
    }
    
    /**
     * Get teacher's schedule
     */
    public function getTeacherSchedule(Request $request, string $guruId)
    {
        $guru = Guru::find($guruId);
        
        if (!$guru) {
            abort(404, 'Guru tidak ditemukan');
        }
        
        $tahunAjaran = $request->get('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $semester = $request->get('semester', 1);
        
        $schedule = JadwalHarian::with(['rombel.kelas', 'mapel'])
                               ->where('guru_id', $guruId)
                               ->where('tahun_ajaran', $tahunAjaran)
                               ->where('semester', $semester)
                               ->where('status', 'aktif')
                               ->orderBy('hari')
                               ->orderBy('jam_mulai')
                               ->get()
                               ->groupBy('hari');
        
        return view('admin.jadwal-harian.teacher-schedule', compact('guru', 'tahunAjaran', 'semester', 'schedule'));
    }
    
    /**
     * Bulk create schedules
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'schedules' => 'required|array|min:1',
            'schedules.*.rombel_id' => 'required|exists:rombels,rombel_id',
            'schedules.*.mapel_id' => 'required|exists:mapels,mapel_id',
            'schedules.*.guru_id' => 'required|exists:gurus,guru_id',
            'schedules.*.hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'schedules.*.jam_mulai' => 'required|date_format:H:i',
            'schedules.*.jam_selesai' => 'required|date_format:H:i',
            'schedules.*.jam_ke' => 'required|integer|min:1|max:10',
            'schedules.*.tahun_ajaran' => 'required|string|max:20',
            'schedules.*.semester' => 'required|integer|in:1,2',
            'schedules.*.keterangan' => 'nullable|string',
            'schedules.*.status' => 'in:aktif,tidak_aktif'
        ]);
        
        $createdSchedules = [];
        $errors = [];
        
        foreach ($validated['schedules'] as $index => $scheduleData) {
            // Validate jam_selesai is after jam_mulai
            if ($scheduleData['jam_selesai'] <= $scheduleData['jam_mulai']) {
                $errors[] = "Schedule {$index}: Jam selesai harus setelah jam mulai";
                continue;
            }
            
            // Check for conflicts
            $conflict = JadwalHarian::checkConflict(
                $scheduleData['rombel_id'],
                $scheduleData['guru_id'],
                $scheduleData['hari'],
                $scheduleData['jam_mulai'],
                $scheduleData['jam_selesai'],
                $scheduleData['tahun_ajaran'],
                $scheduleData['semester']
            );
            
            if ($conflict) {
                $errors[] = "Schedule {$index}: Terdapat konflik jadwal";
                continue;
            }
            
            // Check for unique combination
            $exists = JadwalHarian::where('rombel_id', $scheduleData['rombel_id'])
                                 ->where('hari', $scheduleData['hari'])
                                 ->where('jam_ke', $scheduleData['jam_ke'])
                                 ->where('tahun_ajaran', $scheduleData['tahun_ajaran'])
                                 ->where('semester', $scheduleData['semester'])
                                 ->exists();
            
            if ($exists) {
                $errors[] = "Schedule {$index}: Jadwal untuk rombel, hari, dan jam ke yang sama sudah ada";
                continue;
            }
            
            try {
                $jadwal = JadwalHarian::create($scheduleData);
                $createdSchedules[] = $jadwal;
            } catch (\Exception $e) {
                $errors[] = "Schedule {$index}: " . $e->getMessage();
            }
        }
        
        if (empty($errors)) {
            return redirect()->route('admin.jadwal-harian.index')
                            ->with('success', 'Semua jadwal berhasil dibuat');
        } else {
            $errorMessage = 'Beberapa jadwal berhasil dibuat, ada yang gagal: ' . implode(', ', $errors);
            return redirect()->route('admin.jadwal-harian.index')
                            ->with('warning', $errorMessage);
        }
    }
}
