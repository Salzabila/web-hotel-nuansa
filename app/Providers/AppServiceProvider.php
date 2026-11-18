<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production' || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || isset($_SERVER['VERCEL'])) {
            URL::forceScheme('https');
        }

        // Pastikan database SQLite di lingkungan Serverless / Vercel menggunakan /tmp yang writeable
        if (config('database.default') === 'sqlite' || env('DB_CONNECTION') === 'sqlite') {
            $tmpDb = '/tmp/database.sqlite';
            $defaultDb = database_path('database.sqlite');
            if (isset($_SERVER['VERCEL']) || is_dir('/tmp')) {
                if (!file_exists($tmpDb) && file_exists($defaultDb)) {
                    @copy($defaultDb, $tmpDb);
                }
                if (file_exists($tmpDb)) {
                    config(['database.connections.sqlite.database' => $tmpDb]);
                }
            }
        }
    }
}
