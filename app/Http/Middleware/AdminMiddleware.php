<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verifica si es administrador
        if (Auth::user()->tipo !== 'administrador') {
            abort(403, 'Acceso no autorizado. Solo administradores pueden realizar esta acción.');
        }

        return $next($request);
    }
}
