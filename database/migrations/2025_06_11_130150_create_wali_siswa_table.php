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
        Schema::create('wali_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wali_id');
            $table->unsignedBigInteger('siswa_id');
            $table->enum('hubungan', ['ayah', 'ibu', 'kakek', 'nenek', 'paman', 'bibi', 'kakak', 'lainnya']);
            $table->timestamps();
            
            $table->foreign('wali_id')->references('wali_id')->on('walis')->onDelete('cascade');
            $table->foreign('siswa_id')->references('siswa_id')->on('siswas')->onDelete('cascade');
            $table->unique(['wali_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_siswa');
    }
};