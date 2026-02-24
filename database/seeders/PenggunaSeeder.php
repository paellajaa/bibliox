<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak bentrok
        User::where('email', 'admin@bibliox.com')->delete();

        // Buat Akun Admin Baru sesuai keinginan
        User::create([
            'pengenal'   => 'ADM001',           // Berikan ID pengenal manual
            'nama'       => 'Admin Baru',
            'email'      => 'admin@test.com',   // Ganti email ke sini
            'kata_sandi' => Hash::make('admin123'), // Password tetap admin123
            'peran'      => 'admin',
        ]);
    }
}