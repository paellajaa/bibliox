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
    ->withMiddleware(function (Middleware $middleware) {
        // INI KUNCINYA: Laravel tidak akan minta token pas kamu klik login
        $middleware->validateCsrfTokens(except: [
            'login', 
            'logout'
        ]);

        // Pastikan alias middleware 'peran' kamu sudah benar di sini
        $middleware->alias([
            'peran' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
