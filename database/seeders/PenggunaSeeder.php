<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
   public function run(): void
{
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@test.com'], // Cari berdasarkan email
        [
            'pengenal'   => 'ADM001',
            'nama'       => 'Administrator',
            'kata_sandi' => \Illuminate\Support\Facades\Hash::make('admin123'), // WAJIB ADA HASH
            'peran'      => 'admin',
        ]
    );
}