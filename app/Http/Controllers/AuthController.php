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

        // Catatan: 'password' di sini adalah KEY sistem Laravel untuk mengecek password,
        // Laravel akan otomatis mencocokkannya ke kolom 'kata_sandi' karena sudah disetting di Model.
        if (Auth::attempt(['email' => $request->email, 'password' => $request->kata_sandi], $request->remember)) {
            $request->session()->regenerate();
            return $this->authenticatedRedirect();
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau kata sandi salah.'],
        ]);
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'kata_sandi' => 'required|min:8',
            'kata_sandi_confirmation' => 'required|same:kata_sandi',
        ]);

        // Simpan ke tabel 'pengguna' dengan nama kolom yang benar
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'peran' => 'anggota', 
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return $this->authenticatedRedirect();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

protected function authenticatedRedirect() {
    if (!Auth::check()) return redirect()->route('login');

    $user = Auth::user();
    if ($user->peran === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('anggota.dashboard');
}

    public function showRegister() {
        if (Auth::check()) return $this->authenticatedRedirect();
        return view('auth.register');
    }
}