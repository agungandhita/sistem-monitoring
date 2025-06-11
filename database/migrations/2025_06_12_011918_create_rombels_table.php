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
        Schema::create('rombels', function (Blueprint $table) {
            $table->id('rombel_id');
            $table->foreignId('kelas_id')->constrained('kelas', 'kelas_id')->onDelete('cascade');
            $table->string('nama_rombel'); // e.g., "Rombel A", "Rombel B"
            $table->string('tahun_ajaran');
            $table->integer('kapasitas_maksimal')->default(30);
            $table->integer('jumlah_siswa_saat_ini')->default(0);
            $table->foreignId('wali_kelas_id')->nullable()->constrained('gurus', 'guru_id')->onDelete('set null');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index(['kelas_id', 'tahun_ajaran']);
            $table->unique(['nama_rombel', 'kelas_id', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
