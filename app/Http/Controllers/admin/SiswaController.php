<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Wali;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::with(['walis', 'kelas'])->paginate(10);
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $walis = Wali::with('user')->get();
        $kelas = Kelas::with('kurikulum')->where('status', 'aktif')->get();
        return view('admin.siswa.create', compact('walis', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'tahun_masuk' => 'required|string|max:4',
            'status' => 'required|in:aktif,tidak_aktif,lulus',
            'catatan' => 'nullable|string',
            'wali_ids' => 'array',
            'wali_ids.*' => 'exists:walis,wali_id',
            'hubungan' => 'array',
            'hubungan.*' => 'in:ayah,ibu,kakek,nenek,paman,bibi,kakak,lainnya'
        ]);

        DB::beginTransaction();
        try {
            $siswa = Siswa::create($request->only([
                'nis', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
                'alamat', 'telepon', 'kelas_id', 'tahun_masuk', 'status', 'catatan'
            ]));

            // Attach guardians with relationship type
            if ($request->has('wali_ids') && is_array($request->wali_ids)) {
                foreach ($request->wali_ids as $index => $wali_id) {
                    $hubungan = $request->hubungan[$index] ?? 'lainnya';
                    $siswa->walis()->attach($wali_id, ['hubungan' => $hubungan]);
                }
            }

            DB::commit();
            Alert::success('Berhasil', 'Data siswa berhasil ditambahkan');
            return redirect()->route('admin.siswa.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('walis.user');
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load(['walis', 'kelas']);
        $walis = Wali::with('user')->get();
        $kelas = Kelas::with('kurikulum')->where('status', 'aktif')->get();
        return view('admin.siswa.edit', compact('siswa', 'walis', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->siswa_id . ',siswa_id',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'kelas_id' => 'required|exists:kelas,kelas_id',
            'tahun_masuk' => 'required|string|max:4',
            'status' => 'required|in:aktif,tidak_aktif,lulus',
            'catatan' => 'nullable|string',
            'wali_ids' => 'array',
            'wali_ids.*' => 'exists:walis,wali_id',
            'hubungan' => 'array',
            'hubungan.*' => 'in:ayah,ibu,kakek,nenek,paman,bibi,kakak,lainnya'
        ]);

        DB::beginTransaction();
        try {
            $siswa->update($request->only([
                'nis', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
                'alamat', 'telepon', 'kelas_id', 'tahun_masuk', 'status', 'catatan'
            ]));

            // Sync guardians with relationship type
            $siswa->walis()->detach();
            if ($request->has('wali_ids') && is_array($request->wali_ids)) {
                foreach ($request->wali_ids as $index => $wali_id) {
                    $hubungan = $request->hubungan[$index] ?? 'lainnya';
                    $siswa->walis()->attach($wali_id, ['hubungan' => $hubungan]);
                }
            }

            DB::commit();
            Alert::success('Berhasil', 'Data siswa berhasil diperbarui');
            return redirect()->route('admin.siswa.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->walis()->detach();
            $siswa->delete();
            Alert::success('Berhasil', 'Data siswa berhasil dihapus');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
        }
        return redirect()->route('admin.siswa.index');
    }

    /**
     * Show form to create guardian account
     */
    public function createWali()
    {
        return view('admin.siswa.create-wali');
    }

    /**
     * Store guardian account
     */
    public function storeWali(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P'
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'role' => 'wali'
            ]);

            // Create wali profile
            Wali::create([
                'user_id' => $user->user_id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'pekerjaan' => $request->pekerjaan,
                'jenis_kelamin' => $request->jenis_kelamin
            ]);

            DB::commit();
            Alert::success('Berhasil', 'Akun wali berhasil dibuat');
            return redirect()->route('admin.siswa.create');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal', 'Terjadi kesalahan saat membuat akun wali');
            return back()->withInput();
        }
    }

    /**
     * Get guardians for AJAX
     */
    public function getWalis()
    {
        $walis = Wali::with('user')->get();
        return response()->json($walis);
    }

    /**
     * Get available students for AJAX (students not in any active rombel)
     */
    public function available()
    {
        $siswas = Siswa::where('status', 'aktif')
            ->select('siswa_id', 'nama', 'nis')
            ->orderBy('nama')
            ->get();
        
        return response()->json($siswas);
    }
}