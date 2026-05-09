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
        $dbConnected = false;
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {
            $dbConnected = false;
        }

        View::share('db_connected', $dbConnected);

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
