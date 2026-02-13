<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) return $this->authenticatedRedirect();
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            // Pakai 'username' sesuai name di input form yang baru kita perbaiki
            'username' => 'required', 
            'password' => 'required',
        ]);

        // Karena di database kolomnya 'email', kita mapping 'username' dari form ke 'email'
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return $this->authenticatedRedirect();
        }

        throw ValidationException::withMessages([
            'username' => ['Email atau kata sandi salah.'],
        ]);
    }

    public function showRegister() {
        if (Auth::check()) return $this->authenticatedRedirect();
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'nama' => 'required|string|max:255',
            // PENTING: Cek ke tabel 'pengguna' kolom 'email'
            'username' => 'required|string|email|max:255|unique:pengguna,email', 
            'password' => 'required|min:6|confirmed', 
        ]);

        // 2. Generate Pengenal Otomatis
        $count = User::count() + 1;
       $pengenal = date('Y') . str_pad($count, 3, '0', STR_PAD_LEFT);

        // 3. Simpan ke Database
        $user = User::create([
            'pengenal'   => $pengenal,
            'nama'       => $request->nama,
            'email'      => $request->username, // Simpan input username ke kolom email
            'kata_sandi' => Hash::make($request->password),
            'peran'      => 'anggota',
        ]);

        // 4. Langsung Login
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('anggota.dashboard')->with('success', 'Selamat Datang! Akun kamu berhasil dibuat.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Redirect berdasarkan peran setelah login/register
     */
    protected function authenticatedRedirect() {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();
        if ($user->peran === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('anggota.dashboard');
    }
}