<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Midtrans\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $pendingCount = 0;

            if (
                Schema::hasTable('users') &&
                Schema::hasColumn('users', 'status_akun')
            ) {
                $pendingCount = User::where('status_akun', 'pending')->count();
            }

            $view->with('akunBaruCount', $pendingCount);
        });

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}