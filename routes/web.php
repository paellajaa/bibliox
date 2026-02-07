<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BukuController;
use App\Models\Buku;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes - BIBLIOX DIGITAL LIBRARY (MODIFIED)
|--------------------------------------------------------------------------
*/

// 1. HALAMAN UTAMA
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. GUEST ROUTES (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. ADMIN ROUTES (Midnight Style)
Route::middleware(['auth', 'peran:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin - Data Real
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'total_buku' => Buku::count(), 
            'total_anggota' => User::where('peran', 'anggota')->count(),
            'peminjaman_aktif' => 0 // Sementara
        ]);
    })->name('dashboard');

    // Manajemen Buku Manual
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');          
    Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.create');   
    Route::post('/buku/simpan', [BukuController::class, 'store'])->name('buku.store');    
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');    
    Route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update'); 
    Route::delete('/buku/hapus/{id}', [BukuController::class, 'destroy'])->name('buku.destroy'); 
});

// 5. ANGGOTA ROUTES (Member Area)
Route::middleware(['auth', 'peran:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    
    // Dashboard Anggota - Data Real
    Route::get('/dashboard', function () {
        return view('anggota.dashboard', [
            'buku_dipinjam' => 0, 
            'total_katalog' => Buku::count(),
            'all_books' => Buku::latest()->get() 
        ]);
    })->name('dashboard');
});