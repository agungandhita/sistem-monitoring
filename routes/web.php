<?php

use App\Models\NilaiHarian;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\GuruMapelController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Guru\AuthController as GuruAuthController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiHarianController;
use App\Http\Controllers\Wali\NilaiHarianController as WaliNilaiHarianController;
use App\Http\Controllers\Admin\NilaiHarianController as AdminNilaiHarianController;
use App\Http\Controllers\Guru\CatatanPerkembanganController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes for Admin
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login'); // Changed from 'login.admin' to 'login'
    Route::post('/masuk', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register/akun', [RegisterController::class, 'store']);
});

// Guru Routes - Guest (untuk login)
Route::prefix('guru')->middleware('guest:guru')->group(function () {
    Route::get('/login', [LoginController::class, 'guruIndex'])->name('guru.login');
    Route::post('/login/guru', [LoginController::class, 'guruLogin'])->name('guru.login.post');
});

   // Wali Routes - Guest (untuk login)
   Route::prefix('wali')->middleware('guest:wali')->group(function () {
    Route::get('/login', [App\Http\Controllers\Wali\AuthController::class, 'showLoginForm'])->name('wali.login');
    Route::post('/login/wali', [App\Http\Controllers\Wali\AuthController::class, 'loginWali'])->name('wali.login.post');
});

// Routes untuk Wali dengan middleware auth:wali
Route::middleware(['auth:wali'])->group(function () {
    Route::get('/wali/dashboard', [App\Http\Controllers\Wali\DashboardController::class, 'index'])->name('wali.dashboard');
    Route::post('/wali/logout', [App\Http\Controllers\Wali\AuthController::class, 'logout'])->name('wali.logout');
    
    // Catatan Perkembangan
    Route::get('/wali/catatan-perkembangan', [App\Http\Controllers\Wali\CatatanPerkembanganController::class, 'index'])->name('wali.catatan-perkembangan.index');
Route::get('/wali/catatan-perkembangan/{siswa}', [App\Http\Controllers\Wali\CatatanPerkembanganController::class, 'show'])->name('wali.catatan-perkembangan.show');

// Nilai Harian untuk Wali
Route::get('/wali/nilai-harian', [WaliNilaiHarianController::class, 'index'])->name('wali.nilai-harian.index');
Route::get('/wali/nilai-harian/{siswa}', [WaliNilaiHarianController::class, 'show'])->name('wali.nilai-harian.show');
Route::get('/wali/nilai-harian/{siswa}/riwayat', [WaliNilaiHarianController::class, 'riwayat'])->name('wali.nilai-harian.riwayat');
    
    // Jadwal
    Route::get('/wali/jadwal', [App\Http\Controllers\Wali\JadwalController::class, 'index'])->name('wali.jadwal.index');
    Route::get('/wali/jadwal/{siswa}', [App\Http\Controllers\Wali\JadwalController::class, 'show'])->name('wali.jadwal.show');
});

// Admin Routes
Route::middleware('admin')->group(function () {
    Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Student Management Routes - sudah konsisten
    Route::get('siswa/create-wali', [App\Http\Controllers\Admin\SiswaController::class, 'createWali'])->name('admin.siswa.create-wali');
    Route::post('siswa/store-wali', [App\Http\Controllers\Admin\SiswaController::class, 'storeWali'])->name('admin.siswa.store-wali');
    Route::get('siswa/get-walis', [App\Http\Controllers\Admin\SiswaController::class, 'getWalis'])->name('admin.siswa.get-walis');
    
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class)->names([
        'index' => 'admin.siswa.index',
        'create' => 'admin.siswa.create',
        'store' => 'admin.siswa.store',
        'show' => 'admin.siswa.show',
        'edit' => 'admin.siswa.edit',
        'update' => 'admin.siswa.update',
        'destroy' => 'admin.siswa.destroy'
    ]);
    
    // Subject Management Routes
    Route::resource('mapel', App\Http\Controllers\Admin\MapelController::class)->names([
        'index' => 'admin.mapel.index',
        'create' => 'admin.mapel.create',
        'store' => 'admin.mapel.store',
        'show' => 'admin.mapel.show',
        'edit' => 'admin.mapel.edit',
        'update' => 'admin.mapel.update',
        'destroy' => 'admin.mapel.destroy'
    ]);
    
    // Teacher Management Routes
    Route::resource('guru', App\Http\Controllers\Admin\GuruController::class)->names([
        'index' => 'admin.guru.index',
        'create' => 'admin.guru.create',
        'store' => 'admin.guru.store',
        'show' => 'admin.guru.show',
        'edit' => 'admin.guru.edit',
        'update' => 'admin.guru.update',
        'destroy' => 'admin.guru.destroy'
    ]);
    
    // Teacher-Subject Assignment Routes
    Route::prefix('guru-mapel')->name('admin.guru-mapel.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GuruMapelController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\GuruMapelController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\GuruMapelController::class, 'store'])->name('store');
        Route::get('/{guru_id}', [App\Http\Controllers\Admin\GuruMapelController::class, 'show'])->name('show');
        Route::get('/{guru_id}/{mapel_id}/{kurikulum_id}/{kelas}/edit', [App\Http\Controllers\Admin\GuruMapelController::class, 'edit'])->name('edit');
        Route::put('/{guru_id}/{mapel_id}/{kurikulum_id}/{kelas}', [App\Http\Controllers\Admin\GuruMapelController::class, 'update'])->name('update');
        Route::delete('/{guru_id}/{mapel_id}/{kurikulum_id}/{kelas}', [App\Http\Controllers\Admin\GuruMapelController::class, 'destroy'])->name('destroy');
    });

    // Curriculum Management Routes
    Route::resource('kurikulum', App\Http\Controllers\Admin\KurikulumController::class)->names([
        'index' => 'admin.kurikulum.index',
        'create' => 'admin.kurikulum.create',
        'store' => 'admin.kurikulum.store',
        'show' => 'admin.kurikulum.show',
        'edit' => 'admin.kurikulum.edit',
        'update' => 'admin.kurikulum.update',
        'destroy' => 'admin.kurikulum.destroy'
    ]);
    
    // Class Management Routes
    Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class)->parameters([
        'kelas' => 'kelas'  // Pastikan parameter name konsisten
    ])->names([
        'index' => 'admin.kelas.index',
        'create' => 'admin.kelas.create',
        'store' => 'admin.kelas.store',
        'show' => 'admin.kelas.show',
        'edit' => 'admin.kelas.edit',
        'update' => 'admin.kelas.update',
        'destroy' => 'admin.kelas.destroy'
    ]);
    
    // Class AJAX Routes
    Route::get('kelas/by-tingkat/{tingkat}', [App\Http\Controllers\Admin\KelasController::class, 'getByTingkat'])->name('admin.kelas.by-tingkat');
    Route::get('kelas/by-kurikulum/{kurikulum_id}', [App\Http\Controllers\Admin\KelasController::class, 'getByKurikulum'])->name('admin.kelas.by-kurikulum');
 
    Route::get('jadwal/by-day', [App\Http\Controllers\Admin\JadwalController::class, 'showByDay'])->name('admin.jadwal.by-day');
    
    Route::resource('jadwal', App\Http\Controllers\Admin\JadwalController::class)->names([
        'index' => 'admin.jadwal.index',
        'create' => 'admin.jadwal.create',
        'store' => 'admin.jadwal.store',
        'show' => 'admin.jadwal.show',
        'edit' => 'admin.jadwal.edit',
        'update' => 'admin.jadwal.update',
        'destroy' => 'admin.jadwal.destroy'
    ]);
    
    // Nilai Harian untuk Admin
    Route::get('/admin/nilai-harian', [AdminNilaiHarianController::class, 'index'])->name('admin.nilai-harian.index');
    Route::get('/admin/nilai-harian/laporan', [AdminNilaiHarianController::class, 'laporan'])->name('admin.nilai-harian.laporan');
    Route::get('/admin/nilai-harian/export', [AdminNilaiHarianController::class, 'export'])->name('admin.nilai-harian.export');
    
    // AJAX Routes
    Route::get('get-mapels-by-guru', [App\Http\Controllers\Admin\JadwalController::class, 'getMapelsByGuru'])->name('admin.jadwal.get-mapels-by-guru');
    Route::get('get-schedule-by-class', [App\Http\Controllers\Admin\JadwalController::class, 'getScheduleByClass'])->name('admin.jadwal.get-schedule-by-class');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Guru Routes dengan middleware auth:guru
Route::middleware(['auth:guru'])->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
    Route::post('/guru/logout', [LoginController::class, 'guruLogout'])->name('guru.logout');
    
    // Nilai Harian
    Route::get('/nilai-harian', [NilaiHarianController::class, 'index'])->name('guru.nilai-harian.index');
    Route::post('/nilai-harian', [NilaiHarianController::class, 'store'])->name('guru.nilai-harian.store');
    
    // Catatan Perkembangan
    Route::get('/catatan-perkembangan', [CatatanPerkembanganController::class, 'index'])->name('guru.catatan-perkembangan.index');
    Route::get('/catatan-perkembangan/create/{siswa}', [CatatanPerkembanganController::class, 'create'])->name('guru.catatan-perkembangan.create');
    Route::post('/catatan-perkembangan', [CatatanPerkembanganController::class, 'store'])->name('guru.catatan-perkembangan.store');
    Route::get('/catatan-perkembangan/{siswa}', [CatatanPerkembanganController::class, 'show'])->name('guru.catatan-perkembangan.show');
});

