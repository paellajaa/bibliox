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
        // 1. Daftarkan alias 'peran' agar web.php mengenali middleware-mu
        $middleware->alias([
            'peran' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // 2. BYPASS CSRF untuk Login & Register agar TIDAK Page Expired (419)
        $middleware->validateCsrfTokens(except: [
            'login',
            'register',
            'logout'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();