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
            $table->foreignId('guru_id')->constrained('gurus', 'guru_id')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels', 'mapel_id')->onDelete('cascade');
            $table->foreignId('kurikulum_id')->constrained('kurikulums', 'kurikulum_id')->onDelete('cascade');
            $table->string('kelas');
            $table->timestamps();
            
            // Ensure a teacher can only teach one subject per class per curriculum
            $table->unique(['guru_id', 'mapel_id', 'kelas', 'kurikulum_id']);
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
