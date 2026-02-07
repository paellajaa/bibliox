<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Paksa Laravel pakai tabel 'pengguna' (sesuai database kamu)
    protected $table = 'pengguna';

    // 2. Sesuaikan nama kolom dengan yang ada di phpMyAdmin kamu
    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    // 3. PENTING: Beritahu Laravel bahwa kolom password kita namanya 'kata_sandi'
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kata_sandi' => 'hashed',
    ];
}