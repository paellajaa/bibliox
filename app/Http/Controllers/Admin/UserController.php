<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna
     */
    public function index()
    {
        // Ambil semua user terbaru
        $users = User::latest()->get();
        
        // Hitung total berdasarkan peran untuk statistik di header
        $totalAdmin = User::where('peran', 'admin')->count();
        $totalAnggota = User::where('peran', 'anggota')->count();

        return view('admin.users.index', compact('users', 'totalAdmin', 'totalAnggota'));
    }

    /**
     * Menghapus akun pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // PROTEKSI: Jangan biarkan admin hapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Waduh Bang, jangan hapus akun sendiri dong! Nanti siapa yang jaga perpus?');
        }

        // Hapus user dari database
        $user->delete();

        return back()->with('success', 'Akun ' . $user->nama . ' berhasil dihapus dari sistem.');
    }
}