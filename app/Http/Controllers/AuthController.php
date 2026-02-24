<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) return $this->authenticatedRedirect();
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required', // Ini menampung email dari form
            'password' => 'required',
        ]);

        // Laravel otomatis akan mengecek ke kolom 'kata_sandi' karena fungsi di Model tadi
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return $this->authenticatedRedirect();
        }

        throw ValidationException::withMessages([
            'username' => ['Kredensial yang Anda berikan salah.'],
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function authenticatedRedirect() {
        $user = Auth::user();
        if ($user->peran === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('anggota.dashboard');
    }
}