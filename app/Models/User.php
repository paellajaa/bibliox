<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'pengenal'; // Wajib karena ID kamu bukan 'id'
    public $incrementing = false;       // Wajib karena ID kamu String
    protected $keyType = 'string';

    protected $fillable = [
        'pengenal', 'nama', 'email', 'kata_sandi', 'peran',
    ];

    protected $hidden = [
        'kata_sandi', 'remember_token',
    ];

    // Beritahu Laravel kolom passwordnya adalah 'kata_sandi'
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}