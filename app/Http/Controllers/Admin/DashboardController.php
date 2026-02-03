<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil statistik ringkas
        $data = [
            'total_buku' => 0, // Nanti diisi setelah tabel buku ada datanya
            'total_anggota' => User::where('peran', 'anggota')->count(),
            'pinjaman_aktif' => 0,
            'total_denda' => 0,
        ];

        return view('admin.dashboard', $data);
    }
}