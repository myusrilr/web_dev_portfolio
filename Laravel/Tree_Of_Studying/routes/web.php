<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TikController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\OrangTuaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login_page', [AuthController::class, 'loginPage'])->name('login_page');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

// Rute autentikasi
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/dashboard/guru', [GuruController::class, 'index'])->name('dashboard.guru');
Route::get('/dashboard/murid', [MuridController::class, 'index'])->name('dashboard.murid');
Route::get('/dashboard/orang-tua', [OrangTuaController::class, 'index'])->name('dashboard.orang-tua');

// Rute khusus pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('dashboard');
    });

    Route::middleware('role:murid')->prefix('murid')->name('murid.')->group(function () {
        Route::get('/', [MuridController::class, 'index'])->name('dashboard');
    });

    Route::middleware('role:orang_tua')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'index'])->name('dashboard');
    });

    // Rute untuk guru
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/landing-brain', [GuruController::class, 'landing_brain'])->name('landing-brain'); 
        Route::get('/landing-island', [GuruController::class, 'landing_island'])->name('landing-island');
        Route::get('/', [GuruController::class, 'index'])->name('dashboard'); // Rute untuk dashboard
        Route::get('/biji-ide', [GuruController::class, 'bijiIde'])->name('biji-ide');
        Route::get('/guru/edit-biji/{id}', [GuruController::class, 'editBiji'])->name('guru.edit-biji');
        Route::get('/biji-ide/create-task', [GuruController::class, 'createTask'])->name('create-task');
        Route::post('/biji-ide/store-task', [GuruController::class, 'storeTask'])->name('store-task');
        // Tambahkan rute lainnya sesuai kebutuhan
    });

    // Rute untuk murid
    Route::middleware('role:murid')->prefix('murid')->name('murid.')->group(function () {
        Route::get('/', [MuridController::class, 'index'])->name('dashboard');
        Route::get('/biji-ide/create', [MuridController::class, 'create'])->name('create-biji');
        Route::post('/biji-ide', [MuridController::class, 'store'])->name('store-biji');
    });

    // Rute untuk orang tua
    Route::middleware('role:orang_tua')->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/', [OrangTuaController::class, 'index'])->name('dashboard');
        Route::get('/biji-ide', [OrangTuaController::class, 'bijiIde'])->name('biji-ide');
    });

    // Rute untuk profil
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
});

Route::get('/api/tik/titles', [TikController::class, 'getTitles'])->name('tik.titles');
