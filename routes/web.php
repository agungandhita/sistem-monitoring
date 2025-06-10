<?php

use App\Models\Nilai;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
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

    Route::get('/', [LoginController::class, 'index'])->name('beranda');
    Route::post('/masuk', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register/akun', [RegisterController::class, 'store']);
});

Route::middleware('admin')->group(function () {

    Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('guru', GuruController::class);

    Route::get('/mapel', [App\Http\Controllers\Admin\MapelController::class, 'index'])->name('mapel.index');
    Route::post('/mapel/store', [App\Http\Controllers\Admin\MapelController::class, 'store'])->name('mapel.store');
    Route::put('/mapel/{mapel}', [App\Http\Controllers\Admin\MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{mapel}', [App\Http\Controllers\Admin\MapelController::class, 'destroy'])->name('mapel.destroy');

    // Student Management Routes - PINDAHKAN ROUTE KHUSUS KE ATAS
    Route::get('siswa/create-wali', [SiswaController::class, 'createWali'])->name('admin.siswa.create-wali');
    Route::post('siswa/store-wali', [SiswaController::class, 'storeWali'])->name('admin.siswa.store-wali');
    Route::get('siswa/get-walis', [SiswaController::class, 'getWalis'])->name('admin.siswa.get-walis');
    
    Route::resource('siswa', SiswaController::class)->names([
        'index' => 'admin.siswa.index',
        'create' => 'admin.siswa.create',
        'store' => 'admin.siswa.store',
        'show' => 'admin.siswa.show',
        'edit' => 'admin.siswa.edit',
        'update' => 'admin.siswa.update',
        'destroy' => 'admin.siswa.destroy'
    ]);

});





Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});
