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
        Schema::create('alamat_warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('komplek_id')->constrained('komplek')->onDelete('cascade');
            $table->string('nama_alamat');
            $table->string('blok_nomor_rumah');
            $table->text('detail_patokan')->nullable();
            $table->boolean('is_utama')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_warga');
    }
};
