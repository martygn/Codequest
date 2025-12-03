<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;
use Closure;
use Illuminate\Http\Request;

class AuthenticateUsuario
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar autenticación usando nuestro AuthController
        if (!AuthController::check()) {
            return redirect()->route('login')->withErrors([
                'message' => 'Por favor, inicia sesión para acceder.'
            ]);
        }

        return $next($request);
    }
}
