<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Obtener usuario autenticado
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        // Si es admin, mostrar panel especial con estadísticas de equipos
        if ($usuario->esAdmin()) {
            $totales = Equipo::selectRaw(
                "SUM(CASE WHEN LOWER(TRIM(estado)) = 'en revisión' THEN 1 ELSE 0 END) as en_revision,"
                . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'aprobado' THEN 1 ELSE 0 END) as aprobado,"
                . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'rechazado' THEN 1 ELSE 0 END) as rechazado"
            )->first();

            $estadisticas = [
                'en_revision' => (int)($totales->en_revision ?? 0),
                'aprobado' => (int)($totales->aprobado ?? 0),
                'rechazado' => (int)($totales->rechazado ?? 0),
            ];

            $equipos = Equipo::withCount('participantes')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return view('admin.panel', compact('estadisticas', 'equipos'));
        }

        // Si es juez, redirigir al panel del juez
        if ($usuario->esJuez()) {
            return redirect()->route('juez.panel');
        }

        // Obtener próximos eventos
        $eventosProximos = Evento::where('fecha_inicio', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->take(12) // más eventos = carrusel más lleno
            ->get();

        // Obtener equipos destacados
        $equiposDestacados = Equipo::withCount('participantes')
            ->orderBy('participantes_count', 'desc')
            ->orderByDesc('created_at')
            ->take(15)
            ->get();

        return view('dashboard', compact('eventosProximos', 'equiposDestacados'));
    }

    /**
     * Devuelve estadísticas de equipos en JSON (para el panel admin).
     */
    public function equiposStats(Request $request)
    {
        $totales = Equipo::selectRaw(
            "SUM(CASE WHEN LOWER(TRIM(estado)) = 'en revisión' THEN 1 ELSE 0 END) as en_revision,"
            . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'aprobado' THEN 1 ELSE 0 END) as aprobado,"
            . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'rechazado' THEN 1 ELSE 0 END) as rechazado"
        )->first();

        $estadisticas = [
            'en_revision' => (int)($totales->en_revision ?? 0),
            'aprobado' => (int)($totales->aprobado ?? 0),
            'rechazado' => (int)($totales->rechazado ?? 0),
        ];

        return response()->json(['estadisticas' => $estadisticas]);
    }
}
