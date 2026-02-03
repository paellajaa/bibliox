<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', function () { 
    return view('welcome'); 
});

// --- Rute GUEST (Hanya untuk yang BELUM Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// --- Rute AUTH (Harus Login) ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Rute Khusus ADMIN ---
Route::middleware(['auth', 'peran:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Buku (Index, Create, Store, Edit, Update, Destroy)
    Route::resource('buku', BukuController::class);
});

// --- Rute Khusus ANGGOTA ---
Route::middleware(['auth', 'peran:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', function () {
        return "Halo Anggota! Selamat datang di Katalog BIBLIOX.";
    })->name('dashboard');
});