<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'pengenal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['pengenal', 'nama', 'email', 'kata_sandi', 'peran'];

    // INI WAJIB: Supaya Laravel tahu kolom password adalah 'kata_sandi'
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}