<?php

use App\Models\Nilai;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\GuruMapelController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {

    Route::get('/', [App\Http\Controllers\auth\LoginController::class, 'index'])->name('beranda');
    Route::post('/masuk', [App\Http\Controllers\auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\auth\RegisterController::class, 'index'])->name('register');
    Route::post('/register/akun', [App\Http\Controllers\auth\RegisterController::class, 'store']);
});

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
    Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class)->names([
        'index' => 'admin.kelas.index',
        'create' => 'admin.kelas.create',
        'store' => 'admin.kelas.store',
        'show' => 'admin.kelas.show',
        'edit' => 'admin.kelas.edit',
        'update' => 'admin.kelas.update',
        'destroy' => 'admin.kelas.destroy'
    ]);
    
    // Rombel Management Routes
    Route::resource('rombel', App\Http\Controllers\Admin\RombelController::class)->names([
        'index' => 'admin.rombel.index',
        'create' => 'admin.rombel.create',
        'store' => 'admin.rombel.store',
        'show' => 'admin.rombel.show',
        'edit' => 'admin.rombel.edit',
        'update' => 'admin.rombel.update',
        'destroy' => 'admin.rombel.destroy'
    ]);
    
    // Rombel Student Management
    Route::post('rombel/{rombel}/add-student', [App\Http\Controllers\Admin\RombelController::class, 'addStudent'])->name('admin.rombel.add-student');
    Route::delete('rombel/{rombel}/remove-student/{siswa}', [App\Http\Controllers\Admin\RombelController::class, 'removeStudent'])->name('admin.rombel.remove-student');
    
    // Daily Schedule Management Routes
    Route::resource('jadwal-harian', App\Http\Controllers\Admin\JadwalHarianController::class)->names([
        'index' => 'admin.jadwal-harian.index',
        'create' => 'admin.jadwal-harian.create',
        'store' => 'admin.jadwal-harian.store',
        'show' => 'admin.jadwal-harian.show',
        'edit' => 'admin.jadwal-harian.edit',
        'update' => 'admin.jadwal-harian.update',
        'destroy' => 'admin.jadwal-harian.destroy'
    ]);
    
    // Schedule Views
    Route::get('rombel/{rombel}/jadwal-mingguan', [App\Http\Controllers\Admin\JadwalHarianController::class, 'getWeeklySchedule'])->name('admin.rombel.jadwal-mingguan');
    Route::get('guru/{guru}/jadwal', [App\Http\Controllers\Admin\JadwalHarianController::class, 'getTeacherSchedule'])->name('admin.guru.jadwal');
    Route::post('jadwal-harian/bulk-store', [App\Http\Controllers\Admin\JadwalHarianController::class, 'bulkStore'])->name('admin.jadwal-harian.bulk-store');
    
    // AJAX Routes
    Route::get('siswa/available', [App\Http\Controllers\Admin\SiswaController::class, 'available'])->name('admin.siswa.available');
    
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\auth\LoginController::class, 'logout']);
});
