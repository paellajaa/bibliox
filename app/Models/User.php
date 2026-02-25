<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

protected $table = 'pengguna';
protected $primaryKey = 'pengenal';
public $incrementing = false; // Karena 'ADM001' bukan angka auto-increment
protected $keyType = 'string'; // Karena 'ADM001' adalah string

    protected $fillable = ['pengenal', 'nama', 'email', 'kata_sandi', 'peran'];

    protected $hidden = ['kata_sandi', 'remember_token'];

    // WAJIB ADA!
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}