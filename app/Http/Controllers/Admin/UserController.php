<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // WAJIB ADA

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna
     */
    public function index()
    {
        // 1. Ambil semua user terbaru
        $users = User::latest()->get();
        
        // 2. Hitung total berdasarkan peran (Pastikan kolom 'peran' ada di DB)
        $totalAdmin = User::where('peran', 'admin')->count();
        $totalAnggota = User::where('peran', 'anggota')->count();

        // 3. Kirim data ke view
        return view('admin.users.index', [
            'users' => $users,
            'totalAdmin' => $totalAdmin,
            'totalAnggota' => $totalAnggota
        ]);
    }

    /**
     * Menghapus akun pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // PROTEKSI: Jangan biarkan admin hapus dirinya sendiri
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Waduh Bang, jangan hapus akun sendiri dong!');
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus!');
    }
}