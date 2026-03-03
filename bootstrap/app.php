<?php

/*
|--------------------------------------------------------------------------
| bootstrap/app.php  —  Tambahkan alias middleware 'admin'
|--------------------------------------------------------------------------
|
| Salin blok withMiddleware() ini ke file bootstrap/app.php
| yang ada di proyek Laravel Anda.
|
*/

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ← Tambahkan alias ini
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();