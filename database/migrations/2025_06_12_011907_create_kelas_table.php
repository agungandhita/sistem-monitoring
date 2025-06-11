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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('kelas_id');
            $table->string('nama_kelas'); // e.g., "1A", "2B", "3C"
            $table->integer('tingkat'); // Grade level 1-6
            $table->string('tahun_ajaran'); // e.g., "2024/2025"
            $table->integer('kapasitas_maksimal')->default(30);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index(['tingkat', 'tahun_ajaran']);
            $table->unique(['nama_kelas', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
