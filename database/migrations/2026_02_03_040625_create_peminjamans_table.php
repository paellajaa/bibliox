<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('peminjaman', function (Blueprint $col) {
    $col->id();
    $col->string('user_id'); 
    $col->string('buku_id'); 
    $col->dateTime('tanggal_pinjam');
    $col->integer('durasi_hari');
    $col->dateTime('tanggal_jatuh_tempo');
    $col->dateTime('tanggal_kembali')->nullable();
    $col->enum('status', ['menunggu', 'dipinjam', 'kembali', 'ditolak'])->default('menunggu');
    
    // UBAH BARIS INI: dari 'denda' menjadi 'total_denda'
    $col->integer('total_denda')->default(0); 
    
    // TAMBAHKAN baris ini jika Model Peminjaman membutuhkan 'status_denda'
    $col->string('status_denda')->default('lunas'); 
    
    $col->timestamps();
});
}

    public function down(): void {
        Schema::dropIfExists('peminjaman');
    }
};