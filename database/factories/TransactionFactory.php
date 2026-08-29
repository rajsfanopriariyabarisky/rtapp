<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tanggal' => now(),
            'tipe' => $this->faker->randomElement(['Pemasukan', 'Pengeluaran']),
            'kategori' => $this->faker->randomElement(['Iuran', 'Donasi', 'Kegiatan']),
            'jumlah' => $this->faker->randomFloat(2, 10000, 1000000),
            'keterangan' => $this->faker->sentence(),
            'bukti' => null,
            'created_by' => User::factory(),
        ];
    }
}

