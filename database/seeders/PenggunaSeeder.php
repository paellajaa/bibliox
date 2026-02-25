<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     User::updateOrCreate(
    ['email' => 'admin@test.com'],
    [
        'pengenal'   => 'ADM001',
        'nama'       => 'Administrator',
        'kata_sandi' => Hash::make('admin123'),
        'peran'      => 'admin',
    ]
);
    }
}