<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Resident;
use App\Models\Letter;
use App\Models\Complaint;
use App\Models\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the UserLoginSeeder first
        $this->call([
            UserLoginSeeder::class,
        ]);

        User::factory()->count(5)->create();
        Resident::factory()->count(20)->create();

        // Ambil data relasi asli
        $residents = Resident::all();
        $users = User::all();

        // Seed surat
        $residents->each(function ($resident) use ($users) {
            Letter::factory()->count(2)->create([
                'resident_id' => $resident->id,
                'signed_by' => $users->random()->id,
                'status' => 'Disetujui',
                'tanggal_disetujui' => now(),
            ]);
        });

        // Seed pengaduan
        $residents->each(function ($resident) use ($users) {
            Complaint::factory()->count(1)->create([
                'resident_id' => $resident->id,
                'ditanggapi_oleh' => $users->random()->id,
                'status' => 'Selesai',
                'tanggal_tanggapan' => now(),
            ]);
        });
    }
}
