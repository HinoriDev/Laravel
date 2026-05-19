<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware) {
        // Esta é a forma correta no Laravel 11:
        $middleware->redirectTo(
            '/entrar' // Coloque aqui o caminho da sua rota de login
        );
// 2. É AQUI que substituis o que o professor fez no Kernel.php:
        $middleware->alias([
            'autenticador' => \App\Http\Middleware\Autenticador::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
