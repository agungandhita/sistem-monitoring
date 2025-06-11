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
        Schema::create('jadwal_harian', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->foreignId('rombel_id')->constrained('rombels', 'rombel_id')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels', 'mapel_id')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus', 'guru_id')->onDelete('cascade');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('jam_ke'); // Jam pelajaran ke-berapa (1, 2, 3, dst)
            $table->string('tahun_ajaran');
            $table->string('semester'); // ganjil/genap
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes and constraints
            $table->index(['rombel_id', 'hari', 'tahun_ajaran']);
            $table->index(['guru_id', 'hari', 'jam_mulai']);
            $table->unique(['rombel_id', 'hari', 'jam_ke', 'tahun_ajaran', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_harian');
    }
};
