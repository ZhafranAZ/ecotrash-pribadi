<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom is_processed untuk tracking FIFO coin expiry.
     * Kolom ini menandai apakah record koin 'masuk' sudah diproses
     * oleh cron job expired atau belum, mencegah double-deduction.
     */
    public function up(): void
    {
        Schema::table('riwayat_koin', function (Blueprint $table) {
            $table->boolean('is_processed')->default(false)->after('expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_koin', function (Blueprint $table) {
            $table->dropColumn('is_processed');
        });
    }
};
