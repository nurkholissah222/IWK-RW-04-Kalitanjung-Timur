<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin_petugas' => \App\Http\Middleware\AdminOrPetugas::class,
            'ensure_rt' => \App\Http\Middleware\EnsureAccessRT::class,
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'role_rw' => \App\Http\Middleware\RoleRW::class,
            'role_rt' => \App\Http\Middleware\RoleRT::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
