<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'nama' => 'Admin Bibliox',
            'email' => 'admin@bibliox.com',
            'peran' => 'admin',
            'kata_sandi' => Hash::make('admin123'),
        ]);

        // 2. Buat Akun Anggota Contoh (Untuk Testing)
        User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'peran' => 'anggota',
            'kata_sandi' => Hash::make('anggota123'),
        ]);

        User::create([
            'nama' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'peran' => 'anggota',
            'kata_sandi' => Hash::make('anggota123'),
        ]);
    }
}