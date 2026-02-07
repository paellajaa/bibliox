<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk Admin
     */
    public function index()
    {
        $data = [
            'total_buku'     => Buku::sum('stok'), // Menghitung semua stok buku yang ada
            'total_anggota'  => User::where('peran', 'anggota')->count(),
            'pinjaman_aktif' => Peminjaman::where('status', 'dipinjam')->count(),
            'total_denda'    => Peminjaman::sum('total_denda'),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Dashboard untuk Siswa / Anggota
     */
    public function anggota()
    {
        $user_id = Auth::user()->pengenal; // Ambil ID unik user yang login

        $data = [
            // Menghitung buku yang SEDANG dipinjam oleh user ini saja
            'buku_dipinjam' => Peminjaman::where('user_id', $user_id)
                                        ->where('status', 'dipinjam')
                                        ->count(),
            
            // Menghitung total denda user ini saja
            'total_denda'   => Peminjaman::where('user_id', $user_id)
                                        ->sum('total_denda'),

            // Ambil semua buku untuk ditampilkan di katalog dashboard
            'all_books'     => Buku::all(),
            
            // Statistik total buku di perpustakaan
            'total_katalog' => Buku::count(),
        ];

        return view('anggota.dashboard', $data);
    }
}