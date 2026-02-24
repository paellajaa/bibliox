<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama supaya tidak dobel
        User::where('pengenal', 'ADM001')->delete();

        User::create([
            'pengenal'   => 'ADM001',
            'nama'       => 'Administrator',
            'email'      => 'admin@bibliox.com',
            'kata_sandi' => Hash::make('admin123'), // WAJIB pakai Hash::make
            'peran'      => 'admin',
        ]);
    }
}