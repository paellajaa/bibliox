<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_buku'     => Buku::sum('stok') ?? 0, 
            'total_anggota'  => User::where('peran', 'anggota')->count(),
            'pinjaman_aktif' => Peminjaman::where('status', 'dipinjam')->count(),
            'total_denda'    => Peminjaman::sum('total_denda') ?? 0,
        ];
        return view('admin.dashboard', $data);
    }

    public function anggota()
    {
        $user = Auth::user();
        $user_id = $user->pengenal; 

        $data = [
            'buku_dipinjam' => Peminjaman::where('user_id', $user_id)->where('status', 'dipinjam')->count(),
            'total_denda'   => Peminjaman::where('user_id', $user_id)->sum('total_denda') ?? 0,
            
            // DISINI KUNCINYA: Pakai nama 'all_books' dan jangan pakai paginate dulu biar gak error links()
            'all_books'     => Buku::latest()->get(), 
            
            'total_katalog' => Buku::count(),
        ];

        return view('anggota.dashboard', $data);
    }
}