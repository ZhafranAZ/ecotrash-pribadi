<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->id();
            $table->integer('konversi_koin_rupiah');
            $table->integer('harga_kategori_kecil');
            $table->integer('harga_kategori_sedang');
            $table->integer('harga_kategori_besar');
            $table->integer('bonus_koin_kecil');
            $table->integer('bonus_koin_sedang');
            $table->integer('bonus_koin_besar');
            $table->time('batas_waktu_pesan');
            $table->integer('kuota_pesanan_harian');
            $table->json('hari_operasional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_sistem');
    }
};
