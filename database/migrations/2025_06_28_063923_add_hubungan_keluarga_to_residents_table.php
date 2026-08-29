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
        Schema::table('residents', function (Blueprint $table) {
            $table->enum('hubungan_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Saudara', 'Lainnya'])->default('Lainnya')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn('hubungan_keluarga');
        });
    }
};
