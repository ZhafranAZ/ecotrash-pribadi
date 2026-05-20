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
        Schema::create('pesanan_pengangkutan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('warga_id')->constrained('users');
            $table->foreignId('komplek_id')->constrained('komplek');
            $table->string('nama_alamat_snapshot');
            $table->string('blok_nomor_rumah');
            $table->text('detail_patokan_snapshot')->nullable();
            $table->enum('kategori_sampah', ['kecil', 'sedang', 'besar']);
            $table->date('tanggal_penjemputan');
            $table->string('nama_hari_penjemputan');
            $table->text('catatan_warga')->nullable();
            $table->integer('koin_digunakan')->default(0);
            $table->integer('koin_didapat')->default(0);
            $table->integer('harga_awal');
            $table->integer('total_harga_akhir');
            $table->integer('selisih_harga')->default(0);
            $table->enum('status', [
                'menunggu_pembayaran',
                'menunggu_pembayaran_selisih',
                'menunggu',
                'diproses',
                'selesai',
                'dibatalkan',
                'hold_kapasitas',
                'gagal_pickup',
            ]);
            $table->enum('status_pembayaran', ['unpaid', 'paid', 'failed']);
            $table->enum('metode_pembayaran', ['qris', 'transfer_bank']);
            $table->string('payment_reference')->nullable();
            $table->foreignId('petugas_id')->nullable()->constrained('users');
            $table->enum('ukuran_aktual_laporan_petugas', ['sedang', 'besar'])->nullable();
            $table->text('alasan_kendala')->nullable();
            $table->string('foto_kendala')->nullable();
            $table->string('foto_bukti_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_pengangkutan');
    }
};
