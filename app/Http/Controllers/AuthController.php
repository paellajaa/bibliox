<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilan Login
     */
    public function showLogin() 
    {
        // Jika sudah login, langsung lempar ke dashboard masing-masing
        if (Auth::check()) {
            return $this->authenticatedRedirect();
        }
        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'kata_sandi' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'kata_sandi.required' => 'Kata sandi tidak boleh kosong.',
        ]);

        // Laravel Auth secara default mencari field 'password'. 
        // Kita hubungkan input 'kata_sandi' ke 'password'.
        if (Auth::attempt(['email' => $request->email, 'password' => $request->kata_sandi], $request->remember)) {
            
            // WAJIB: Regenerasi session untuk mencegah serangan Session Fixation & Error 419
            $request->session()->regenerate();
            
            return $this->authenticatedRedirect();
        }

        // Jika gagal, kembali dengan pesan error
        throw ValidationException::withMessages([
            'email' => ['Email atau kata sandi yang Anda masukkan salah.'],
        ]);
    }

    /**
     * Tampilan Register
     */
    public function showRegister() 
    {
        return view('auth.register');
    }

    /**
     * Proses Register
     */
    public function register(Request $request) 
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pengguna,email'],
            'kata_sandi' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar di BIBLIOX.',
            'kata_sandi.min' => 'Kata sandi minimal 6 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'peran' => 'anggota',
            'kata_sandi' => Hash::make($request->kata_sandi),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Selamat bergabung di BIBLIOX.');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request) 
    {
        Auth::logout();

        // Bersihkan session secara total
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Helper untuk Redirect berdasarkan Peran
     */
    protected function authenticatedRedirect()
    {
        $user = Auth::user();
        if ($user->peran === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }
        return redirect()->intended('/anggota/dashboard');
    }
}