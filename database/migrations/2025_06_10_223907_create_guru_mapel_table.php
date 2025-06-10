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
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('mapel_id');
            $table->string('kelas', 10);
            $table->string('tahun_ajaran', 9); // Format: 2023/2024
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('guru_id')->references('guru_id')->on('guru')->onDelete('cascade');
            $table->foreign('mapel_id')->references('mapel_id')->on('mapel')->onDelete('cascade');

            // Unique constraint to prevent duplicate assignments
            $table->unique(['guru_id', 'mapel_id', 'kelas', 'tahun_ajaran'], 'unique_guru_mapel_assignment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mapel');
    }
};
