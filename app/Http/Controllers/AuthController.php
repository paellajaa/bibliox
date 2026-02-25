<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) return $this->authenticatedRedirect();
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required', 
            'password' => 'required',
        ]);

        // Cari berdasarkan kolom pengenal (ID)
        $user = User::where('pengenal', $request->username)->first();

        // Cek password manual terhadap kolom kata_sandi
        if ($user && Hash::check($request->password, $user->kata_sandi)) {
            Auth::login($user, $request->has('remember'));
            
            // WAJIB: Simpan session sebelum redirect
            $request->session()->regenerate();
            $request->session()->save();

            return $this->authenticatedRedirect();
        }

        return back()->withErrors(['username' => 'ID atau Kata Sandi salah!'])->withInput();
    }

    public function showRegister() {
        if (Auth::check()) return $this->authenticatedRedirect();
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email', 
            'password' => 'required|min:6|confirmed', 
        ]);

        $count = User::count() + 1;
        $pengenal = date('Y') . str_pad($count, 3, '0', STR_PAD_LEFT);

        $user = User::create([
            'pengenal'   => $pengenal,
            'nama'       => $request->nama,
            'email'      => $request->email,
            'kata_sandi' => Hash::make($request->password),
            'peran'      => 'anggota',
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->save();

        return redirect()->route('anggota.dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function authenticatedRedirect() {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        if ($user->peran === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('anggota.dashboard');
    }
}