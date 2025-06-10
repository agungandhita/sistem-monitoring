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
        Schema::create('guru', function (Blueprint $table) {
            $table->id('guru_id');
            $table->string('nuptk', 16)->unique()->comment('Nomor Unik Pendidik dan Tenaga Kependidikan');
            $table->string('nip', 18)->unique()->comment('Nomor Induk Pegawai');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
