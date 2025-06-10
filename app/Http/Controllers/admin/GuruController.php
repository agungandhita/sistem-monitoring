<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::with('mapels')->paginate(10);
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nuptk' => 'required|unique:guru,nuptk|size:16',
            'nip' => 'required|unique:guru,nip|size:18',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'required|email|unique:guru,email',
            'password' => 'required|min:8|confirmed',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'nuptk', 'nip', 'nama', 'jabatan', 'email', 
                'jenis_kelamin', 'alamat', 'telepon'
            ]);
            
            $data['password'] = Hash::make($request->password);
            
            // Handle file upload
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/guru'), $filename);
                $data['foto'] = $filename;
            }

            Guru::create($data);

            DB::commit();
            Alert::success('Berhasil', 'Data guru berhasil ditambahkan');
            return redirect()->route('guru.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load('mapels');
        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nuptk' => 'required|size:16|unique:guru,nuptk,' . $guru->guru_id . ',guru_id',
            'nip' => 'required|size:18|unique:guru,nip,' . $guru->guru_id . ',guru_id',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'required|email|unique:guru,email,' . $guru->guru_id . ',guru_id',
            'password' => 'nullable|min:8|confirmed',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'nuptk', 'nip', 'nama', 'jabatan', 'email', 
                'jenis_kelamin', 'alamat', 'telepon'
            ]);
            
            // Update password only if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            
            // Handle file upload
            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($guru->foto && file_exists(public_path('uploads/guru/' . $guru->foto))) {
                    unlink(public_path('uploads/guru/' . $guru->foto));
                }
                
                $foto = $request->file('foto');
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/guru'), $filename);
                $data['foto'] = $filename;
            }

            $guru->update($data);

            DB::commit();
            Alert::success('Berhasil', 'Data guru berhasil diperbarui');
            return redirect()->route('guru.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        try {
            // Delete photo if exists
            if ($guru->foto && file_exists(public_path('uploads/guru/' . $guru->foto))) {
                unlink(public_path('uploads/guru/' . $guru->foto));
            }
            
            // Detach all mapel relationships
            $guru->mapels()->detach();
            
            $guru->delete();
            Alert::success('Berhasil', 'Data guru berhasil dihapus');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
        }
        return redirect()->route('guru.index');
    }

    /**
     * Show form to assign mapel to guru
     */
    public function assignMapel(Guru $guru)
    {
        $mapels = Mapel::all();
        $assignedMapels = $guru->mapels;
        
        // Get available classes (you might want to make this dynamic)
        $availableClasses = ['1A', '1B', '2A', '2B', '3A', '3B', '4A', '4B', '5A', '5B', '6A', '6B'];
        
        return view('admin.guru.assign-mapel', compact('guru', 'mapels', 'assignedMapels', 'availableClasses'));
    }

    /**
     * Store mapel assignment
     */
    public function storeAssignMapel(Request $request, Guru $guru)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel,mapel_id',
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
                $exists = $guru->mapels()
                    ->wherePivot('mapel_id', $request->mapel_id)
                    ->wherePivot('kelas', $kelas)
                    ->wherePivot('tahun_ajaran', $request->tahun_ajaran)
                    ->exists();
                
                if (!$exists) {
                    $guru->mapels()->attach($request->mapel_id, [
                        'kelas' => $kelas,
                        'tahun_ajaran' => $request->tahun_ajaran,
                        'status' => $request->status,
                        'catatan' => $request->catatan
                    ]);
                }
            }

            DB::commit();
            Alert::success('Berhasil', 'Mapel berhasil ditugaskan ke guru');
            return redirect()->route('guru.assign-mapel', $guru);
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat menugaskan mapel');
            return back()->withInput();
        }
    }

    /**
     * Update mapel assignment
     */
    public function updateAssignMapel(Request $request, Guru $guru)
    {
        $request->validate([
            'assignment_id' => 'required',
            'status' => 'required|in:aktif,tidak_aktif',
            'catatan' => 'nullable|string'
        ]);

        try {
            // Parse assignment_id to get mapel_id, kelas, and tahun_ajaran
            $assignmentData = explode('|', $request->assignment_id);
            if (count($assignmentData) !== 3) {
                throw new \Exception('Invalid assignment ID format');
            }
            
            [$mapelId, $kelas, $tahunAjaran] = $assignmentData;
            
            $guru->mapels()
                ->wherePivot('mapel_id', $mapelId)
                ->wherePivot('kelas', $kelas)
                ->wherePivot('tahun_ajaran', $tahunAjaran)
                ->updateExistingPivot($mapelId, [
                    'status' => $request->status,
                    'catatan' => $request->catatan
                ]);

            Alert::success('Berhasil', 'Penugasan mapel berhasil diperbarui');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui penugasan');
        }
        
        return redirect()->route('guru.assign-mapel', $guru);
    }

    /**
     * Remove mapel assignment
     */
    public function removeAssignMapel(Request $request, Guru $guru)
    {
        $request->validate([
            'assignment_id' => 'required'
        ]);

        try {
            // Parse assignment_id to get mapel_id, kelas, and tahun_ajaran
            $assignmentData = explode('|', $request->assignment_id);
            if (count($assignmentData) !== 3) {
                throw new \Exception('Invalid assignment ID format');
            }
            
            [$mapelId, $kelas, $tahunAjaran] = $assignmentData;
            
            // Find and detach the specific assignment
            DB::table('guru_mapel')
                ->where('guru_id', $guru->guru_id)
                ->where('mapel_id', $mapelId)
                ->where('kelas', $kelas)
                ->where('tahun_ajaran', $tahunAjaran)
                ->delete();

            Alert::success('Berhasil', 'Penugasan mapel berhasil dihapus');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus penugasan');
        }
        
        return redirect()->route('guru.assign-mapel', $guru);
    }
}