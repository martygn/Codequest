<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Obtener usuario autenticado
        $usuario = AuthController::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        // Obtener próximos eventos (ordenados por fecha)
        $proximosEventos = Evento::where('fecha_inicio', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->take(3)
            ->get();

        // Obtener equipos destacados (con más miembros)
        $equiposDestacados = Equipo::withCount('participantes')
            ->orderBy('participantes_count', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact('proximosEventos', 'equiposDestacados'));
    }
}
