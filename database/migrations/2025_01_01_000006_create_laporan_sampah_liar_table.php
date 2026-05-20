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
        Schema::create('laporan_sampah_liar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('users');
            $table->foreignId('komplek_id')->nullable()->constrained('komplek');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->string('alamat_lokasi')->nullable();
            $table->text('deskripsi');
            $table->string('foto_laporan_warga');
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'sedang_dibersihkan',
                'selesai',
                'ditunda',
            ]);
            $table->text('alasan_penolakan')->nullable();
            $table->text('alasan_ditunda')->nullable();
            $table->integer('koin_reward')->default(0);
            $table->foreignId('petugas_id')->nullable()->constrained('users');
            $table->string('foto_bukti_selesai_petugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_sampah_liar');
    }
};
