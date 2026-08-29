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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->string('judul');
            $table->text('isi');
            $table->string('foto')->nullable();
            $table->enum('status', ['Diterima', 'Diproses', 'Selesai'])->default('Diterima');
            $table->foreignId('ditanggapi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_pengaduan')->useCurrent();
            $table->timestamp('tanggal_tanggapan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
