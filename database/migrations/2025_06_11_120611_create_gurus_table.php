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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id('guru_id');
            $table->string('nuptk')->nullable()->unique();
            $table->string('nip')->nullable()->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('foto')->nullable();
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('nomor_hp');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('jabatan');
            $table->string('tahun_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
