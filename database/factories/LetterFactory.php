<?php

namespace Database\Factories;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LetterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'resident_id' => Resident::factory(),
            'jenis_surat' => $this->faker->randomElement(['SKCK', 'Domisili', 'Usaha']),
            'keperluan' => $this->faker->sentence(),
            'tanggal_pengajuan' => now(),
            'status' => 'Menunggu',
            'file_surat' => null,
            'signed_by' => null,
            'tanggal_disetujui' => null,
        ];
    }
}

