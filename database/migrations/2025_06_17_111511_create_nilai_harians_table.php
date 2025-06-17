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
        Schema::create('nilai_harians', function (Blueprint $table) {
            $table->id('nilai_id');
            $table->foreignId('siswa_id')->constrained('siswas', 'siswa_id')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus', 'guru_id')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels', 'mapel_id')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas', 'kelas_id')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('nilai', 5, 2); // nilai dengan 2 desimal, max 999.99
            $table->enum('jenis_penilaian', ['Tugas', 'Kuis', 'Ulangan Harian', 'Praktik', 'Lainnya']);
            $table->string('keterangan')->nullable();
            $table->string('semester', 10);
            $table->string('tahun_ajaran', 20);
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['siswa_id', 'mapel_id', 'tanggal']);
            $table->index(['kelas_id', 'mapel_id', 'tanggal']);
            $table->index(['guru_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_harians');
    }
};