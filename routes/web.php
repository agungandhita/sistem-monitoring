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

    Route::get('/', [App\Http\Controllers\auth\LoginController::class, 'index'])->name('beranda');
    Route::post('/masuk', [App\Http\Controllers\auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\auth\RegisterController::class, 'index'])->name('register');
    Route::post('/register/akun', [App\Http\Controllers\auth\RegisterController::class, 'store']);
});

Route::middleware('admin')->group(function () {

    Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('guru', App\Http\Controllers\Admin\GuruController::class);
    
    // Guru-Mapel Assignment Routes
    Route::get('guru/{guru}/assign-mapel', [App\Http\Controllers\Admin\GuruController::class, 'assignMapel'])->name('guru.assign-mapel');
    Route::post('guru/{guru}/assign-mapel', [App\Http\Controllers\Admin\GuruController::class, 'storeAssignMapel'])->name('guru.store-assign-mapel');
    Route::delete('guru/{guru}/remove-assign-mapel', [App\Http\Controllers\Admin\GuruController::class, 'removeAssignMapel'])->name('guru.remove-assign-mapel');
    Route::put('guru/{guru}/update-assign-mapel', [App\Http\Controllers\Admin\GuruController::class, 'updateAssignMapel'])->name('guru.update-assign-mapel');

    Route::get('/mapel', [App\Http\Controllers\Admin\MapelController::class, 'index'])->name('mapel.index');
    Route::post('/mapel/store', [App\Http\Controllers\Admin\MapelController::class, 'store'])->name('mapel.store');
    Route::put('/mapel/{mapel}', [App\Http\Controllers\Admin\MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{mapel}', [App\Http\Controllers\Admin\MapelController::class, 'destroy'])->name('mapel.destroy');

    // Student Management Routes - PINDAHKAN ROUTE KHUSUS KE ATAS
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

});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\auth\LoginController::class, 'logout']);
});
