<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\CalificacionEquipo;
use App\Models\Notificacion;
use App\Models\Constancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
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
            $equipo = $grupoEquipo->first()->equipo;
            return [
                'equipo' => $equipo,
                'puntaje_promedio' => round(collect($califs)->avg('puntaje_final'), 2),
                'puntajes_jueces' => collect($califs)->pluck('puntaje_final')->toArray(),
                'calificaciones_count' => count($califs),
                'desviacion_estandar' => $this->calcularDesviacion(collect($califs)->pluck('puntaje_final')->toArray()),
                'posicion_ganador' => $equipo->posicion_ganador // Ahora se obtiene del modelo Equipo
            ];
        })->sortByDesc('puntaje_promedio')->values();

        // Obtener ganadores por posición (buscar en ranking el equipo con la posición correcta)
        $ganadores = [
            1 => $ranking->firstWhere('posicion_ganador', 1),
            2 => $ranking->firstWhere('posicion_ganador', 2),
            3 => $ranking->firstWhere('posicion_ganador', 3)
        ];

        return view('admin.resultados.show', compact('evento', 'ranking', 'calificaciones', 'ganadores'));
    }

    /**
     * Marcar equipo ganador (1er, 2do o 3er lugar)
     */
    public function marcarGanador(Request $request, Evento $evento)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden marcar ganadores.');
        }

        $validated = $request->validate([
            'equipo_id' => 'required|exists:equipos,id_equipo',
            'posicion' => 'required|in:0,1,2,3'
        ]);

        $posicion = (int)$validated['posicion'];

        $equipo = \App\Models\Equipo::find($validated['equipo_id']);

        // Verificar que el equipo pertenece al evento
        if ($equipo->id_evento !== $evento->id_evento) {
            return back()->with('error', '❌ El equipo no pertenece a este evento.');
        }

        // Si la posición es 0, desmarcar al equipo
        if ($posicion === 0) {
            $equipo->posicion_ganador = null;
            $equipo->save();

            return back()->with('success', '✅ Equipo desmarcado exitosamente.');
        }

        // Desmarcar el lugar específico (si ya existe otro equipo en esa posición en el mismo evento)
        \App\Models\Equipo::where('id_evento', $evento->id_evento)
            ->where('posicion_ganador', $posicion)
            ->update(['posicion_ganador' => null]);

        // Marcar nuevo ganador en la posición especificada
        $equipo->posicion_ganador = $posicion;
        $equipo->save();

        // Crear notificación para el líder del equipo ganador
        $equipo = \App\Models\Equipo::find($validated['equipo_id']);
        if ($equipo && $equipo->lider) {
            $lugares = [
                1 => ['emoji' => '🥇', 'texto' => 'Primer Lugar'],
                2 => ['emoji' => '🥈', 'texto' => 'Segundo Lugar'],
                3 => ['emoji' => '🥉', 'texto' => 'Tercer Lugar']
            ];

            $lugar = $lugares[$posicion];

            $notificacion = new Notificacion();
            $notificacion->usuario_id = $equipo->lider->id;
            $notificacion->tipo = 'ganador';
            $notificacion->titulo = $lugar['emoji'] . ' ¡' . $lugar['texto'] . '!';
            $notificacion->mensaje = 'El equipo "' . $equipo->nombre . '" ha obtenido el ' . $lugar['texto'] . ' en el evento "' . $evento->nombre . '".';
            $notificacion->enlace = route('admin.resultados.show', $evento->id_evento);
            $notificacion->leida = false;
            $notificacion->save();
        }

        return back()->with('success', '✅ Posición marcada exitosamente.');
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
     * Generar constancia para equipo ganador (1er, 2do o 3er lugar)
     */
    public function generarConstancia(Request $request, Evento $evento)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo administradores pueden generar constancias.');
        }

        // Validar posición solicitada
        $posicion = $request->input('posicion', 1);
        if (!in_array($posicion, [1, 2, 3])) {
            return back()->with('error', '❌ Posición no válida.');
        }

        // Buscar equipo en la posición solicitada
        $equipo = \App\Models\Equipo::where('id_evento', $evento->id_evento)
            ->where('posicion_ganador', $posicion)
            ->with(['lider', 'participantes'])
            ->first();

        if (!$equipo) {
            $lugares = [1 => 'primer', 2 => 'segundo', 3 => 'tercer'];
            return back()->with('error', '❌ No hay equipo marcado en ' . $lugares[$posicion] . ' lugar.');
        }

        // Obtener calificaciones del equipo
        $calificacionesGanador = CalificacionEquipo::where('evento_id', $evento->id_evento)
            ->where('equipo_id', $equipo->id_equipo)
            ->get();

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
                'calificaciones_count',
                'posicion'
            ));
        }

        // Si se solicita enviar por correo
        if ($request->has('enviar_correo')) {
            return $this->enviarConstanciaPorCorreo($evento, $equipo, $calificacion, $puntaje_final, $calificaciones_count, $posicion);
        }

        // Generar PDF
        $pdf = Pdf::loadView('admin.resultados.constancia', compact(
            'evento',
            'equipo',
            'calificacion',
            'puntaje_final',
            'calificaciones_count',
            'posicion'
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
    private function enviarConstanciaPorCorreo(Evento $evento, $equipo, $calificacion, $puntaje_final, $calificaciones_count, $posicion = 1)
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
                'calificaciones_count',
                'posicion'
            ));

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);

            // Nombre del archivo PDF
            $nombreArchivo = 'Constancia_' . str_replace(' ', '_', $equipo->nombre) . '_' . str_replace(' ', '_', $evento->nombre) . '.pdf';
            
            // Guardar PDF en storage
            $rutaPdf = 'constancias/' . date('Y/m/d') . '/' . $nombreArchivo;
            Storage::disk('public')->put($rutaPdf, $pdf->output());

            // Guardar registro de constancia en la BD PRIMERO (antes de enviar correo)
            $constancia = Constancia::create([
                'id_evento' => $evento->id_evento,
                'id_equipo' => $equipo->id_equipo,
                'id_juez' => null,
                'ruta_pdf' => $rutaPdf,
                'fecha_envio' => now(),
            ]);

            // Luego intentar enviar correo
            try {
                Mail::send('emails.constancia', compact('equipo', 'evento'), function ($message) use ($lider, $evento, $pdf, $nombreArchivo) {
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
            } catch (\Exception $mailError) {
                // Si el correo falla, la constancia ya está guardada en BD
                return back()->with('warning', '⚠️ Constancia guardada pero hubo un error al enviar el correo: ' . $mailError->getMessage());
            }
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al generar la constancia: ' . $e->getMessage());
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

    /**
     * Descargar PDF de constancia
     */
    public function descargarConstancia(Constancia $constancia)
    {
        // Verificar que el usuario tenga acceso (juez del evento o admin)
        $usuario = Auth::user();
        
        if (!$usuario) {
            abort(401, 'No autenticado.');
        }

        // Verificar si es admin o juez del evento
        $esAdmin = $usuario->esAdmin();
        $eventoAsignado = $usuario->eventosAsignados()->where('id_evento', $constancia->id_evento)->exists();

        if (!$esAdmin && !$eventoAsignado) {
            abort(403, 'No tienes permiso para descargar esta constancia.');
        }

        // Verificar que el archivo existe
        if (!$constancia->ruta_pdf || !Storage::disk('public')->exists($constancia->ruta_pdf)) {
            return back()->with('error', '❌ El archivo de constancia no existe.');
        }

        // Descargar el archivo
        return Storage::disk('public')->download($constancia->ruta_pdf);
    }
}
