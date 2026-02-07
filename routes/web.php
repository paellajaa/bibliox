<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BukuController;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - BIBLIOX DIGITAL LIBRARY
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

// 4. ADMIN ROUTES
Route::middleware(['auth', 'peran:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'total_buku' => Buku::count(), 
            'total_anggota' => User::where('peran', 'anggota')->count(),
            'peminjaman_aktif' => 0 
        ]);
    })->name('dashboard');

    // Manajemen Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');          
    Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.create');   
    Route::post('/buku/simpan', [BukuController::class, 'store'])->name('buku.store');    
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');    
    Route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update'); 
    Route::delete('/buku/hapus/{id}', [BukuController::class, 'destroy'])->name('buku.destroy'); 
});

// 5. ANGGOTA ROUTES
// Note: Middleware disamakan menjadi 'peran' sesuai kolom database
Route::middleware(['auth', 'peran:anggota'])->group(function () {
    
    Route::get('/anggota/dashboard', function () {
        // Mengirimkan data buku asli ke view
        $all_books = Buku::all(); 
        
        // Menghitung statistik sederhana untuk dashboard anggota
        $total_katalog = Buku::count();
        $buku_dipinjam = 0; // Nanti bisa dihitung dari tabel peminjaman

        return view('anggota.dashboard', [
            'all_books' => $all_books,
            'total_katalog' => $total_katalog,
            'buku_dipinjam' => $buku_dipinjam
        ]);
    })->name('anggota.dashboard');

    // Route Proses Pinjam
    Route::post('/pinjam/{id}', [BukuController::class, 'pinjam'])->name('buku.pinjam');
});