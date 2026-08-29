<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@rtrwapp.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_akun' => 'disetujui',
        ]);

        // RT User
        User::create([
            'nama' => 'Ketua RT',
            'email' => 'rt@rtrwapp.com',
            'password' => Hash::make('rt123'),
            'role' => 'rt',
            'status_akun' => 'disetujui',
        ]);

        // Petugas User
        User::create([
            'nama' => 'Petugas',
            'email' => 'petugas@rtrwapp.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'status_akun' => 'disetujui',
        ]);

        // Warga User 1
        User::create([
            'nama' => 'Warga Satu',
            'email' => 'warga1@rtrwapp.com',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
            'status_akun' => 'disetujui',
        ]);

        // Warga User 2
        User::create([
            'nama' => 'Warga Dua',
            'email' => 'warga2@rtrwapp.com',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
            'status_akun' => 'disetujui',
        ]);

        // Warga User 3 (Pending Status)
        User::create([
            'nama' => 'Warga Pending',
            'email' => 'wargapending@rtrwapp.com',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
            'status_akun' => 'pending',
        ]);

        // Warga User 4 (Ditolak Status)
        User::create([
            'nama' => 'Warga Ditolak',
            'email' => 'wargaditolak@rtrwapp.com',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
            'status_akun' => 'ditolak',
        ]);

        $this->command->info('User login seeders created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@rtrwapp.com / admin123');
        $this->command->info('RT: rt@rtrwapp.com / rt123');
        $this->command->info('Petugas: petugas@rtrwapp.com / petugas123');
        $this->command->info('Warga: warga1@rtrwapp.com / warga123');
        $this->command->info('Warga 2: warga2@rtrwapp.com / warga123');
        $this->command->info('Warga Pending: wargapending@rtrwapp.com / warga123');
        $this->command->info('Warga Ditolak: wargaditolak@rtrwapp.com / warga123');
    }
} 