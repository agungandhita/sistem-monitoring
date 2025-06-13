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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->integer('jam_ke'); // 1, 2, 3, dst
            $table->time('jam_mulai'); // contoh: 07:00
            $table->time('jam_selesai'); // contoh: 07:35
            $table->foreignId('mapel_id')->constrained('mapels', 'mapel_id')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus', 'guru_id')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas', 'kelas_id')->onDelete('cascade');
            $table->foreignId('kurikulum_id')->constrained('kurikulums', 'kurikulum_id')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Validasi: satu kelas tidak boleh punya dua pelajaran di jam yang sama
            $table->unique(['hari', 'jam_ke', 'kelas_id', 'tahun_ajaran'], 'jadwal_kelas_unique');
            
            // Validasi: satu guru tidak boleh mengajar di dua kelas berbeda di jam yang sama
            $table->unique(['hari', 'jam_ke', 'guru_id', 'tahun_ajaran'], 'jadwal_guru_unique');
            
            // Index untuk pencarian cepat
            $table->index(['hari', 'kelas_id', 'tahun_ajaran']);
            $table->index(['guru_id', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};