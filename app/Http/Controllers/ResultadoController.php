<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\CalificacionEquipo;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
        })->sortByDesc('puntaje_promedio')->values();

        // Retornar vista HTML que se puede imprimir como PDF
        return view('admin.resultados.pdf', compact('evento', 'ranking'));
    }

    /**
     * Generar constancia para equipo ganador
     */
    public function generarConstancia(Request $request, Evento $evento)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden generar constancias.');
        }

        // Buscar calificaciones del equipo ganador
        $calificacionesGanador = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->where('ganador', true)
            ->with(['equipo.lider', 'equipo.participantes'])
            ->get();

        if ($calificacionesGanador->isEmpty()) {
            return back()->with('error', '❌ No hay ganador definido para este evento.');
        }

        $equipo = $calificacionesGanador->first()->equipo;

        // Calcular puntuación final (promedio de todos los jueces)
        $puntaje_final = round($calificacionesGanador->avg('puntaje_final'), 2);

        // Obtener una calificación representativa para mostrar detalles
        $calificacion = $calificacionesGanador->first();

        // Contar jueces que calificaron
        $calificaciones_count = $calificacionesGanador->count();

        // Si se solicita ver en navegador (HTML)
        if ($request->has('preview')) {
            return view('admin.resultados.constancia', compact(
                'evento',
                'equipo',
                'calificacion',
                'puntaje_final',
                'calificaciones_count'
            ));
        }

        // Si se solicita enviar por correo
        if ($request->has('enviar_correo')) {
            return $this->enviarConstanciaPorCorreo($evento, $equipo, $calificacion, $puntaje_final, $calificaciones_count);
        }

        // Generar PDF
        $pdf = Pdf::loadView('admin.resultados.constancia', compact(
            'evento',
            'equipo',
            'calificacion',
            'puntaje_final',
            'calificaciones_count'
        ));

        // Configurar PDF
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        // Nombre del archivo
        $nombreArchivo = 'Constancia_' . str_replace(' ', '_', $equipo->nombre) . '_' . str_replace(' ', '_', $evento->nombre) . '.pdf';

        // Crear notificación para el líder del equipo
        if ($equipo->lider) {
            Notificacion::create([
                'usuario_id' => $equipo->lider->id,
                'titulo' => '¡Felicidades! Tu equipo ha ganado',
                'mensaje' => "El equipo '{$equipo->nombre}' ha obtenido el primer lugar en el evento '{$evento->nombre}'. ¡Excelente trabajo!",
                'tipo' => 'success',
            ]);
        }

        // Descargar PDF
        return $pdf->download($nombreArchivo);
    }

    /**
     * Enviar constancia por correo al líder del equipo
     */
    private function enviarConstanciaPorCorreo(Evento $evento, $equipo, $calificacion, $puntaje_final, $calificaciones_count)
    {
        try {
            $lider = $equipo->lider;

            if (!$lider || !$lider->correo) {
                return back()->with('error', '❌ El líder del equipo no tiene correo registrado.');
            }

            // Generar PDF
            $pdf = Pdf::loadView('admin.resultados.constancia', compact(
                'evento',
                'equipo',
                'calificacion',
                'puntaje_final',
                'calificaciones_count'
            ));

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);

            // Nombre del archivo PDF
            $nombreArchivo = 'Constancia_' . str_replace(' ', '_', $equipo->nombre) . '.pdf';

            // Enviar correo con PDF adjunto
            \Illuminate\Support\Facades\Mail::send('emails.constancia', compact('equipo', 'evento'), function ($message) use ($lider, $evento, $pdf, $nombreArchivo) {
                $message->to($lider->correo, $lider->nombre_completo)
                    ->subject('🏆 Constancia de Ganador - ' . $evento->nombre)
                    ->attachData($pdf->output(), $nombreArchivo, [
                        'mime' => 'application/pdf',
                    ]);
            });

            // Crear notificación para el líder del equipo
            Notificacion::create([
                'usuario_id' => $lider->id,
                'titulo' => '¡Constancia de ganador enviada!',
                'mensaje' => "Se ha enviado la constancia de ganador del evento '{$evento->nombre}' a tu correo {$lider->correo}. ¡Felicidades!",
                'tipo' => 'success',
            ]);

            return back()->with('success', '✅ Constancia enviada exitosamente al correo: ' . $lider->correo);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al enviar el correo: ' . $e->getMessage());
        }
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
