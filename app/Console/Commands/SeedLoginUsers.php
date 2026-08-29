<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\UserLoginSeeder;

class SeedLoginUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:login-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed users for login testing (all roles except RW)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding login users...');
        
        $seeder = new UserLoginSeeder();
        $seeder->run();
        
        $this->info('Login users seeded successfully!');
        
        return Command::SUCCESS;
    }
} 