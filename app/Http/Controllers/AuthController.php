<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->username)->first();

    if ($user && \Hash::check($request->password, $user->kata_sandi)) {
        \Auth::login($user); // Login user
        $request->session()->regenerate(); // Buat session baru agar tidak expired
        
        return ($user->peran === 'admin') 
            ? redirect()->intended('/admin/dashboard') 
            : redirect()->intended('/anggota/dashboard');
    }

    return back()->withErrors(['username' => 'Kredensial salah!'])->withInput();
}

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $pengenal = 'USR' . rand(100, 999);

        $user = User::create([
            'pengenal' => $pengenal,
            'nama' => $request->nama,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->password),
            'peran' => 'anggota',
        ]);

        Auth::login($user);
        return redirect()->route('anggota.dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
}