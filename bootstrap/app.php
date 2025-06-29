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
        
        // La línea mágica que soluciona el problema en Railway
        $middleware->trustProxies(at: '*'); 

        // Es posible que tengas otras configuraciones de middleware aquí,
        // como la verificación del token CSRF, etc. Déjalas como están.
        // Por ejemplo:
        // $middleware->validateCsrfTokens(except: [
        //     'stripe/*',
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();