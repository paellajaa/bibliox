<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // MATIKAN PENGECEKAN FOREIGN KEY SEMENTARA
        Schema::disableForeignKeyConstraints();

        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('buku_id'); 
            $table->date('tanggal_pinjam')->nullable(); 
            $table->integer('durasi_hari'); 
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('status')->default('menunggu');
            $table->integer('total_denda')->default(0);
            $table->string('status_denda')->default('lunas'); 
            $table->string('judul_pengganti')->nullable(); 
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void {
        Schema::dropIfExists('peminjaman');
    }
};