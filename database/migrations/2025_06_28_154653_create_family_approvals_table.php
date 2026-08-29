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
        Schema::create('family_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kepala keluarga yang mengajukan
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'])->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai']);
            $table->enum('status_tinggal', ['Tetap', 'Pindah', 'Meninggal'])->default('Tetap');
            $table->text('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->enum('hubungan_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Saudara', 'Lainnya']);
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // RT yang menyetujui/menolak
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_approvals');
    }
};
