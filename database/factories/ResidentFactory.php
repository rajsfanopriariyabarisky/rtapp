<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'nama_lengkap' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'pekerjaan' => $this->faker->jobTitle(),
            'status_perkawinan' => $this->faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai']),
            'status_tinggal' => 'Tetap',
            'alamat' => $this->faker->address(),
            'rt' => $this->faker->randomElement(['001', '002', '003']),
            'rw' => $this->faker->randomElement(['001', '002']),
            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
        ];
    }
}



