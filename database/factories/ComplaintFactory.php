<?php

namespace Database\Factories;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    public function definition(): array
    {
        return [
            'resident_id' => Resident::factory(),
            'judul' => $this->faker->sentence(),
            'isi' => $this->faker->paragraph(),
            'foto' => null,
            'status' => 'Diterima',
            'ditanggapi_oleh' => null,
            'tanggal_pengaduan' => now(),
            'tanggal_tanggapan' => null,
        ];
    }
}

