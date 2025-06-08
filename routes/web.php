<?php

use App\Models\Nilai;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\WaliController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\quran\QuranController;
use App\Http\Controllers\admin\KelasContrroller;
use App\Http\Controllers\admin\SantriController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\nadzom\NadzomController;
use App\Http\Controllers\admin\DashboarController;
use App\Http\Controllers\wali\WaliController as WaliWaliController;

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

    // buat akun
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::post('/user/update/{id}', [UserController::class, 'update']);
    Route::post('/user/delete/{id}', [UserController::class, 'destroy']);



    // buat akun wali santri

    Route::get('/akun-wali', [WaliController::class, 'index']);
    Route::post('/akun-wali/create', [WaliController::class, 'store']);
    Route::post('/akun-wali/edit/{id}', [WaliController::class, 'edit']);
    Route::post('/akun-wali/delete/{id}', [WaliController::class, 'destroy']);










});





Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});
