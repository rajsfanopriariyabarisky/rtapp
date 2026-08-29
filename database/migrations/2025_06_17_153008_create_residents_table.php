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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('pekerjaan');
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai']);
            $table->enum('status_tinggal', ['Tetap', 'Pindah', 'Meninggal'])->default('Tetap');
            $table->text('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
