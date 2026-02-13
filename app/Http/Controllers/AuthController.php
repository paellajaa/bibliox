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
            'email' => 'required|email',
            'kata_sandi' => 'required',
        ]);

        // Attempt login dengan email dan password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->kata_sandi], $request->remember)) {
            $request->session()->regenerate();
            return $this->authenticatedRedirect();
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau kata sandi salah.'],
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
        'username' => 'required|string|unique:users,username',
        'password' => 'required|min:6|confirmed', // Harus ada input password_confirmation di view
    ]);

    // 2. Generate Pengenal Otomatis (Contoh: USR-2026001)
    $count = \App\Models\User::count() + 1;
    $pengenal = 'USR-' . date('Y') . str_pad($count, 3, '0', STR_PAD_LEFT);

    // 3. Simpan ke Database
    $user = \App\Models\User::create([
        'pengenal' => $pengenal,
        'nama'     => $request->nama,
        'username' => $request->username,
        'password' => \Hash::make($request->password),
        'peran'    => 'anggota',
    ]);

    // 4. Langsung Login & Pindah ke Dashboard
    \Auth::login($user);

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