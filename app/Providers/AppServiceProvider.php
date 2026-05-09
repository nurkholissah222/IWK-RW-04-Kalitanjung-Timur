<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
        // View::share('db_connected', false); // Nonaktifkan pengecekan database otomatis saat boot agar Vercel tidak crash

        // Vercel /tmp storage fix for Serverless
        if (env('VERCEL')) {
            $viewPath = '/tmp/storage/framework/views';
            if (!is_dir($viewPath)) {
                mkdir($viewPath, 0777, true);
            }
            config(['view.compiled' => $viewPath]);
        }
    }
}
