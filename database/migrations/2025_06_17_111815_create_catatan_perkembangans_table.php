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
        Schema::create('catatan_perkembangans', function (Blueprint $table) {
            $table->id('catatan_id');
            $table->foreignId('siswa_id')->constrained('siswas', 'siswa_id')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus', 'guru_id')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('jenis_catatan', ['akademik', 'perilaku', 'sosial', 'kehadiran', 'lainnya']);
            $table->text('catatan');
            $table->string('semester', 10);
            $table->string('tahun_ajaran', 20);
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['siswa_id', 'tanggal']);
            $table->index(['guru_id', 'tanggal']);
            $table->index(['jenis_catatan', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_perkembangans');
    }
};
