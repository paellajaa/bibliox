<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengenal'; // Menggunakan kolom pengenal sebagai ID
    public $incrementing = false;       // Karena ADM001 itu string
    protected $keyType = 'string';

    protected $fillable = [
        'pengenal', 'nama', 'email', 'kata_sandi', 'peran',
    ];

    protected $hidden = [
        'kata_sandi', 'remember_token',
    ];

    // Beritahu Laravel kalau password kamu ada di kolom kata_sandi
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}