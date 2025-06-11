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
        Schema::create('rombel_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombels', 'rombel_id')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas', 'siswa_id')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['aktif', 'pindah', 'lulus', 'keluar'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Indexes and constraints
            $table->index(['rombel_id', 'tahun_ajaran']);
            $table->index(['siswa_id', 'tahun_ajaran']);
            $table->unique(['rombel_id', 'siswa_id', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel_siswa');
    }
};
