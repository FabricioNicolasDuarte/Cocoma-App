<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <-- Importamos la clase Request

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // --- CONFIGURACIÓN CORRECTA Y DEFINITIVA ---
        // Le decimos a Laravel que confíe en todos los proxies de Render
        // usando las constantes correctas de la clase Request.
        $middleware->trustProxies(
            '*', // El primer argumento es la lista de proxies
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );
        // ------------------------------------------
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

