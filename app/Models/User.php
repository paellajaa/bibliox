<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna'; // Nama tabel custom
    protected $primaryKey = 'pengenal'; // PK custom

    protected $fillable = [
        'nama', 'email', 'peran', 'kata_sandi',
    ];

    protected $hidden = [
        'kata_sandi', 'remember_token',
    ];

    // Karena nama kolom password kita custom, beri tahu Laravel
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}