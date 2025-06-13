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
            $table->string('nama_kelas'); // contoh: "1A", "2B", "3C"
            $table->integer('tingkat'); // 1-6 untuk SD
            $table->string('tahun_ajaran'); // contoh: "2024/2025"
            $table->foreignId('kurikulum_id')->constrained('kurikulums', 'kurikulum_id')->onDelete('cascade');
            $table->integer('kapasitas')->default(30);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            
            // Pastikan nama kelas unik per tahun ajaran
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