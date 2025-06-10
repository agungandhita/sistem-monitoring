<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id('guru_id');
            $table->string('nuptk')->unique();
            $table->unsignedBigInteger('mapel_id')->nullable(); // Nullable karena guru mungkin belum ditugaskan mapel
            $table->string('nip')->unique();
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('foto')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat');
            $table->string('telepon');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};