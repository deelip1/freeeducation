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
        // ✅ HIGHLIGHT: Registered the premium alias inside the single, correct middleware closure.
        $middleware->alias([
            'premium' => \App\Http\Middleware\EnsurePremiumTier::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create(); // ✅ HIGHLIGHT: create() is the final method called, terminating the chain.