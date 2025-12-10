<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AuthenticateUsuario;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registrar nuestro middleware
        $middleware->alias([
            'auth.usuario' => AuthenticateUsuario::class,
            'is.admin' => App\Http\Middleware\IsAdmin::class,
            'is.juez' => App\Http\Middleware\IsJuez::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Manejar error de archivos demasiado grandes
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            return back()->with('error', '❌ El archivo es demasiado grande. El tamaño máximo permitido es 50MB. Por favor, comprime tu proyecto o reduce el tamaño del archivo.')->withInput();
        });
    })->create();
