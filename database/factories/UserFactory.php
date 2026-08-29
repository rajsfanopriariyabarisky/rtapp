<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // default
            'role' => $this->faker->randomElement(['admin', 'rt', 'rw', 'petugas']),
        ];
    }
}
