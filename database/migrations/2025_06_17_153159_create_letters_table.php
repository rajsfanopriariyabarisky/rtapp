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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_surat', ['SKCK', 'Domisili', 'Usaha', 'Kematian']);
            $table->text('keperluan');
            $table->date('tanggal_pengajuan');
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->string('file_surat')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal_disetujui')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
