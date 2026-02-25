<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengenal'; // Beritahu Laravel PK kamu bukan 'id'
    public $incrementing = false;       // PK kamu string
    protected $keyType = 'string';

    protected $fillable = ['pengenal', 'nama', 'email', 'kata_sandi', 'peran'];

    protected $hidden = ['kata_sandi', 'remember_token'];

    // WAJIB: Supaya Laravel cek kolom kata_sandi saat login
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}