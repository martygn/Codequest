<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsJuez
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || !method_exists($user, 'esJuez') || !$user->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
