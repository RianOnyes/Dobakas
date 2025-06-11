<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php', // <-- Scheduling di sini
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Di sinilah tempat baru untuk mendaftarkan middleware alias
        // yang dulu ada di Kernel.php
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'donatur' => \App\Http\Middleware\DonatrurMiddleware::class,
            'organisasi' => \App\Http\Middleware\OrganisasiMiddleware::class,
            // 'auth' => \App\Http\Middleware\Authenticate::class,
        ]);

        // Anda juga bisa menambahkan middleware global, dll di sini
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
