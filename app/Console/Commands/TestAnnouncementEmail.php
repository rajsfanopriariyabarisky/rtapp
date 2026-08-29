<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Console\Command;

class TestAnnouncementEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:announcement-email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email notifikasi pengumuman';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            // Test ke email tertentu
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("User dengan email {$email} tidak ditemukan!");
                return 1;
            }
        } else {
            // Ambil user pertama yang role warga
            $user = User::where('role', 'warga')->first();
            if (!$user) {
                $this->error("Tidak ada user dengan role warga!");
                return 1;
            }
        }

        // Buat pengumuman dummy untuk testing
        $announcement = Announcement::create([
            'title' => 'Pengumuman Test - ' . now()->format('d/m/Y H:i'),
            'content' => 'Ini adalah pengumuman test untuk memverifikasi sistem email notifikasi. Pengumuman ini dibuat pada ' . now()->format('d/m/Y H:i:s'),
            'is_public' => true,
            'user_id' => 1,
        ]);

        try {
            // $user->notify(new NewAnnouncementNotification($announcement));
            $this->info("✅ Email test berhasil dikirim ke: {$user->email}");
            $this->info("📧 Subject: Pengumuman Baru: {$announcement->title}");
        } catch (\Exception $e) {
            $this->error("❌ Gagal kirim email: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
