<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'pengguna';
    
    // Konfigurasi Primary Key karena bukan 'id' dan bukan Auto Increment
    protected $primaryKey = 'pengenal'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'pengenal',
        'nama',
        'email',
        'kata_sandi',
        'peran',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    /**
     * Beritahu Laravel bahwa kolom password kita namanya 'kata_sandi'
     */
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kata_sandi' => 'hashed',
    ];
}