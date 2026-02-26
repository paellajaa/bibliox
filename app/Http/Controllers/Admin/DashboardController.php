<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
// app/Http/Controllers/Admin/DashboardController.php

public function index(Request $request)
{
    // 1. Mulai query dasar
    $query = Buku::query();

    // 2. Filter Kategori (Lakukan ini dulu agar mengunci hasil)
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // 3. Logika Pencarian (Harus dibungkus GROUP agar tidak bocor kategori)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('judul', 'like', '%' . $search . '%')
              ->orWhere('penulis', 'like', '%' . $search . '%');
        });
    }

    // 4. Eksekusi query
    $all_books = $query->get();
    
    // 5. Ambil daftar kategori yang UNIK dari database untuk tombol filter
    $daftarKategori = Buku::whereNotNull('kategori')
                          ->distinct()
                          ->pluck('kategori');

    return view('anggota.dashboard', compact('all_books', 'daftarKategori'));
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