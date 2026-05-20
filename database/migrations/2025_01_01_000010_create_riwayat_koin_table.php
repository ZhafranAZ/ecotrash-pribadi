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
        Schema::create('riwayat_koin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe_transaksi', ['masuk', 'keluar', 'expired']);
            $table->integer('jumlah');
            $table->enum('sumber', ['pesanan', 'laporan_liar', 'penukaran', 'sistem']);
            $table->string('referensi_id')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_koin');
    }
};
