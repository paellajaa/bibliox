<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;

Route::get('/', function () { return view('welcome'); });

// Route Guest (Hanya bisa diakses kalau belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin (Contoh)
// Rute khusus ADMIN
Route::middleware(['auth', 'peran:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('buku', BukuController::class)->names('admin.buku');
});

Route::middleware(['auth', 'peran:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('buku', BukuController::class)->names('admin.buku');
});

// Rute khusus ANGGOTA
Route::middleware(['auth', 'peran:anggota'])->prefix('anggota')->group(function () {
    Route::get('/dashboard', function () {
        return "Halo Anggota! Selamat datang di Katalog BIBLIOX.";
    })->name('anggota.dashboard');
});