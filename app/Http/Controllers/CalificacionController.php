<?php

namespace App\Http\Controllers;

use App\Models\CalificacionEquipo;
use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    /**
     * Mostrar formulario para calificar un equipo (para juez)
     */
    public function show(Equipo $equipo)
    {
        $usuario = Auth::user();

        // Cargar la relación evento si no está cargada
        $equipo->load('evento');

        // Verificar que el equipo tenga evento
        if (!$equipo->evento) {
            abort(404, 'El equipo no está asociado a ningún evento.');
        }

        $evento = $equipo->evento;

        // Verificar que el usuario sea juez del evento
        if (! $evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'Solo los jueces del evento pueden calificar equipos.');
        }

        // Verificar que el equipo esté aprobado
        if ($equipo->estado !== 'aprobado') {
            return redirect()->route('juez.panel')
                ->with('error', 'Solo se pueden calificar equipos que han sido aprobados por el administrador.');
        }

        // Obtener o crear calificación
        $calificacion = CalificacionEquipo::where('juez_id', $usuario->id)
            ->where('equipo_id', $equipo->id_equipo)
            ->first();

        if (!$calificacion) {
            $calificacion = new CalificacionEquipo([
                'juez_id' => $usuario->id,
                'equipo_id' => $equipo->id_equipo,
                'evento_id' => $evento->id_evento,
            ]);
        }

        return view('juez.calificaciones.calificar', compact('equipo', 'calificacion', 'evento'));
    }

    /**
     * Guardar/actualizar calificación
     */
    public function store(Request $request, Equipo $equipo)
    {
        $usuario = Auth::user();
        $evento = $equipo->evento;

        // Verificar que sea juez del evento
        if (! $evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'Solo los jueces del evento pueden calificar equipos.');
        }

        // Verificar que el equipo esté aprobado
        if ($equipo->estado !== 'aprobado') {
            return redirect()->route('juez.panel')
                ->with('error', 'Solo se pueden calificar equipos que han sido aprobados por el administrador.');
        }

        // Validar puntuaciones (1-10)
        $validated = $request->validate([
            'puntaje_creatividad' => 'required|integer|min:1|max:10',
            'puntaje_funcionalidad' => 'required|integer|min:1|max:10',
            'puntaje_diseño' => 'required|integer|min:1|max:10',
            'puntaje_presentacion' => 'required|integer|min:1|max:10',
            'puntaje_documentacion' => 'required|integer|min:1|max:10',
            'observaciones' => 'nullable|string|max:1000',
            'recomendaciones' => 'nullable|string|max:1000',
        ]);

        // Obtener o crear calificación
        $calificacion = CalificacionEquipo::updateOrCreate(
            [
                'juez_id' => $usuario->id,
                'equipo_id' => $equipo->id_equipo,
                'evento_id' => $evento->id_evento,
            ],
            $validated
        );

        return redirect()->route('juez.panel')
            ->with('success', '✅ Calificación guardada exitosamente.');
    }

    /**
     * Actualizar calificación existente
     */
    public function update(Request $request, CalificacionEquipo $calificacion)
    {
        $usuario = Auth::user();

        // Verificar que sea el juez que creó la calificación o admin
        if ($calificacion->juez_id !== $usuario->id && ! $usuario->esAdmin()) {
            abort(403, 'No tienes permiso para editar esta calificación.');
        }

        $validated = $request->validate([
            'puntaje_creatividad' => 'required|integer|min:1|max:10',
            'puntaje_funcionalidad' => 'required|integer|min:1|max:10',
            'puntaje_diseño' => 'required|integer|min:1|max:10',
            'puntaje_presentacion' => 'required|integer|min:1|max:10',
            'puntaje_documentacion' => 'required|integer|min:1|max:10',
            'observaciones' => 'nullable|string|max:1000',
            'recomendaciones' => 'nullable|string|max:1000',
        ]);

        $calificacion->update($validated);

        return back()->with('success', '✅ Calificación actualizada.');
    }

    /**
     * Eliminar calificación (admin solo)
     */
    public function destroy(CalificacionEquipo $calificacion)
    {
        $usuario = Auth::user();

        if (! $usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden eliminar calificaciones.');
        }

        $eventoId = $calificacion->evento_id;
        $calificacion->delete();

        return redirect()->route('eventos.show', $eventoId)
            ->with('success', '✅ Calificación eliminada.');
    }

    /**
     * Listar todas las calificaciones de un evento
     */
    public function listar(Evento $evento)
    {
        $usuario = Auth::user();

        // Verificar que sea juez del evento o admin
        if (! $evento->jueces()->where('usuario_id', $usuario->id)->exists() && ! $usuario->esAdmin()) {
            abort(403, 'No tienes permiso para ver estas calificaciones.');
        }

        $calificaciones = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->with(['juez', 'equipo'])
            ->orderBy('equipo_id')
            ->get();

        // Calcular promedios por equipo
        $promedios = $calificaciones->groupBy('equipo_id')->map(function ($grupoEquipo) {
            return [
                'equipo' => $grupoEquipo->first()->equipo,
                'calificaciones' => $grupoEquipo,
                'puntaje_promedio' => round($grupoEquipo->avg('puntaje_final'), 2),
            ];
        })->sortByDesc('puntaje_promedio');

        return view('calificaciones.listar', compact('evento', 'promedios', 'calificaciones'));
    }

    /**
     * Ver ranking/resultados de un evento
     */
    public function ranking(Evento $evento)
    {
        $usuario = Auth::user();

        // Cualquiera puede ver el ranking si el evento está cerrado, solo admin puede ver borrador
        if ($evento->estado !== 'finalizado' && ! $usuario->esAdmin()) {
            abort(403, 'El evento aún no ha finalizado.');
        }

        $calificaciones = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->with(['equipo', 'juez'])
            ->get();

        // Agrupar por equipo y calcular promedio final
        $ranking = $calificaciones->groupBy('equipo_id')->map(function ($grupoEquipo) {
            $califs = $grupoEquipo->all();

            return [
                'equipo' => $grupoEquipo->first()->equipo,
                'puntaje_promedio' => round(collect($califs)->avg('puntaje_final'), 2),
                'calificaciones_count' => count($califs),
                'ganador' => $grupoEquipo->first()->ganador ?? false,
            ];
        })->sortByDesc('puntaje_promedio')->values();

        return view('calificaciones.ranking', compact('evento', 'ranking'));
    }
}
