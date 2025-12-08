<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\CalificacionEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultadoController extends Controller
{
    /**
     * Dashboard de resultados (admin)
     */
    public function index()
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden ver el dashboard de resultados.');
        }

        // Obtener eventos con calificaciones
        $eventos = Evento::with(['calificaciones', 'equipos'])->get();

        $resultados = $eventos->map(function ($evento) {
            $calificaciones = CalificacionEquipo::where('evento_id', $evento->id_evento)->get();
            
            if ($calificaciones->isEmpty()) {
                return null;
            }

            $ranking = $calificaciones->groupBy('equipo_id')->map(function ($grupoEquipo) {
                return [
                    'equipo' => $grupoEquipo->first()->equipo,
                    'puntaje_promedio' => round(collect($grupoEquipo)->avg('puntaje_final'), 2),
                    'calificaciones_count' => $grupoEquipo->count(),
                    'ganador' => $grupoEquipo->first()->ganador ?? false
                ];
            })->sortByDesc('puntaje_promedio');

            return [
                'evento' => $evento,
                'ranking' => $ranking
            ];
        })->filter();

        return view('admin.resultados.index', compact('resultados'));
    }

    /**
     * Ver resultados detallados de un evento
     */
    public function show(Evento $evento)
    {
        $usuario = Auth::user();

        // Verificar permisos
        if (!$usuario->esAdmin() && !$evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'No tienes permiso para ver estos resultados.');
        }

        // Obtener calificaciones
        $calificaciones = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->with(['equipo', 'juez'])
            ->get();

        // Calcular ranking
        $ranking = $calificaciones->groupBy('equipo_id')->map(function ($grupoEquipo) {
            $califs = $grupoEquipo->all();
            return [
                'equipo' => $grupoEquipo->first()->equipo,
                'puntaje_promedio' => round(collect($califs)->avg('puntaje_final'), 2),
                'puntajes_jueces' => collect($califs)->pluck('puntaje_final')->toArray(),
                'calificaciones_count' => count($califs),
                'desviacion_estandar' => $this->calcularDesviacion(collect($califs)->pluck('puntaje_final')->toArray()),
                'ganador' => $grupoEquipo->first()->ganador ?? false
            ];
        })->sortByDesc('puntaje_promedio')->values();

        // Obtener ganador si existe
        $ganador = $ranking->first();

        return view('admin.resultados.show', compact('evento', 'ranking', 'calificaciones', 'ganador'));
    }

    /**
     * Marcar equipo ganador
     */
    public function marcarGanador(Request $request, Evento $evento)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden marcar ganadores.');
        }

        $validated = $request->validate([
            'equipo_id' => 'required|exists:equipos,id_equipo'
        ]);

        // Desmarcar todos los ganadores previos de este evento
        CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->update(['ganador' => false]);

        // Marcar nuevo ganador
        CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->where('equipo_id', $validated['equipo_id'])
            ->update(['ganador' => true]);

        return back()->with('success', '✅ Ganador marcado exitosamente.');
    }

    /**
     * Exportar resultados a PDF
     */
    public function exportarPDF(Evento $evento)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden exportar resultados.');
        }

        $calificaciones = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->with(['equipo', 'juez'])
            ->get();

        $ranking = $calificaciones->groupBy('equipo_id')->map(function ($grupoEquipo) {
            $califs = $grupoEquipo->all();
            return [
                'equipo' => $grupoEquipo->first()->equipo,
                'puntaje_promedio' => round(collect($califs)->avg('puntaje_final'), 2),
                'calificaciones_count' => count($califs),
                'ganador' => $grupoEquipo->first()->ganador ?? false
            ];
        })->sortByDesc('puntaje_promedio');

        // Aquí se integraría con una librería como DomPDF o mPDF
        // Por ahora, retornamos vista para generar PDF
        return view('admin.resultados.pdf', compact('evento', 'ranking'))->render();
    }

    /**
     * Generar constancia para equipo ganador
     */
    public function generarConstancia(Evento $evento)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden generar constancias.');
        }

        $ganador = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->where('ganador', true)
            ->with('equipo')
            ->first();

        if (!$ganador) {
            return back()->with('error', '❌ No hay ganador definido para este evento.');
        }

        return view('admin.resultados.constancia', [
            'evento' => $evento,
            'ganador' => $ganador->equipo,
            'puntaje_final' => CalificacionEquipo::where('evento_id', $evento->id_evento)
                ->where('equipo_id', $ganador->equipo_id)
                ->avg('puntaje_final')
        ]);
    }

    /**
     * Calcular desviación estándar de puntuaciones
     */
    private function calcularDesviacion($puntajes)
    {
        if (empty($puntajes) || count($puntajes) < 2) {
            return 0;
        }

        $promedio = array_sum($puntajes) / count($puntajes);
        $sumaDesviaciones = array_reduce($puntajes, function ($carry, $puntaje) use ($promedio) {
            return $carry + pow($puntaje - $promedio, 2);
        }, 0);

        $varianza = $sumaDesviaciones / count($puntajes);
        return round(sqrt($varianza), 2);
    }
}
