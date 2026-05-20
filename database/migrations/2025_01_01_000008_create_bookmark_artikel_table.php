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
        Schema::create('bookmark_artikel', function (Blueprint $table) {
            $table->foreignId('warga_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('artikel_id')->constrained('artikel_edukasi')->onDelete('cascade');
            $table->timestamp('created_at')->nullable();

            $table->primary(['warga_id', 'artikel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmark_artikel');
    }
};
