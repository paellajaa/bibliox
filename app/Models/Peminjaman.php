<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Nama tabel harus sesuai dengan di database
    protected $table = 'peminjaman';

    // Daftar kolom yang boleh diisi secara massal
   protected $fillable = [
    'user_id',
    'buku_id',
    'tanggal_pinjam',
    'durasi_hari',
    'tanggal_jatuh_tempo',
    'tanggal_kembali',
    'status',
    'total_denda',
    'status_denda',
    'catatan_siswa', 
    'catatan_admin'  
];
    /**
     * Hubungan ke model Buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'kode_buku');
    }

    /**
     * Hubungan ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'pengenal');
    }
}