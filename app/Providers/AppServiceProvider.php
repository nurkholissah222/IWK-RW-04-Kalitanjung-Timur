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
        if (config('app.env') === 'production') {
            $viewPath = '/tmp/storage/framework/views';
            if (!is_dir($viewPath)) {
                mkdir($viewPath, 0777, true);
            }
            config(['view.compiled' => $viewPath]);
        }

        // Global Database Connection Check
        try {
            DB::connection()->getPdo();
            $db_connected = true;
        } catch (\Exception $e) {
            $db_connected = false;
        }
        View::share('db_connected', $db_connected);
    }
}
