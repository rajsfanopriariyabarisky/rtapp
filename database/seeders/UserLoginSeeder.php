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
        User::updateOrCreate(
            ['email' => 'admin@rtrwapp.com'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status_akun' => 'disetujui',
            ]
        );

        // RT User
        User::updateOrCreate(
            ['email' => 'rt@rtrwapp.com'],
            [
                'nama' => 'Ketua RT',
                'password' => Hash::make('rt123'),
                'role' => 'rt',
                'status_akun' => 'disetujui',
            ]
        );

        // Petugas User
        User::updateOrCreate(
            ['email' => 'petugas@rtrwapp.com'],
            [
                'nama' => 'Petugas',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'status_akun' => 'disetujui',
            ]
        );

        // Warga User 1
        User::updateOrCreate(
            ['email' => 'warga1@rtrwapp.com'],
            [
                'nama' => 'Warga Satu',
                'password' => Hash::make('warga123'),
                'role' => 'warga',
                'status_akun' => 'disetujui',
            ]
        );

        // Warga User 2
        User::updateOrCreate(
            ['email' => 'warga2@rtrwapp.com'],
            [
                'nama' => 'Warga Dua',
                'password' => Hash::make('warga123'),
                'role' => 'warga',
                'status_akun' => 'disetujui',
            ]
        );

        // Warga User 3 - Pending
        User::updateOrCreate(
            ['email' => 'wargapending@rtrwapp.com'],
            [
                'nama' => 'Warga Pending',
                'password' => Hash::make('warga123'),
                'role' => 'warga',
                'status_akun' => 'pending',
            ]
        );

        // Warga User 4 - Ditolak
        User::updateOrCreate(
            ['email' => 'wargaditolak@rtrwapp.com'],
            [
                'nama' => 'Warga Ditolak',
                'password' => Hash::make('warga123'),
                'role' => 'warga',
                'status_akun' => 'ditolak',
            ]
        );

        $this->command->info('User login seeders created/updated successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@rtrwapp.com / admin123');
        $this->command->info('RT: rt@rtrwapp.com / rt123');
        $this->command->info('Petugas: petugas@rtrwapp.com / petugas123');
        $this->command->info('Warga 1: warga1@rtrwapp.com / warga123');
        $this->command->info('Warga 2: warga2@rtrwapp.com / warga123');
        $this->command->info('Warga Pending: wargapending@rtrwapp.com / warga123');
        $this->command->info('Warga Ditolak: wargaditolak@rtrwapp.com / warga123');
    }
}