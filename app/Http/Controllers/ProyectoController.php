<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Repositorio;
use App\Models\Evento;
use App\Models\CalificacionEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProyectoController extends Controller
{
    /**
     * Mostrar formulario para subir proyecto
     */
    public function create(Equipo $equipo)
    {
        $usuario = Auth::user();

        // Verificar que sea líder del equipo
        if ($equipo->id_lider !== $usuario->id) {
            abort(403, 'Solo el líder del equipo puede subir el proyecto.');
        }

        // Verificar que el equipo tenga evento
        if (!$equipo->evento) {
            return back()->with('error', 'El equipo no está inscrito en ningún evento.');
        }

        $evento = $equipo->evento;

        // Verificar que el evento esté en curso (con hora límite 23:59)
        $now = Carbon::now();
        $fechaInicioEvento = Carbon::parse($evento->fecha_inicio)->startOfDay();
        $fechaFinEvento = Carbon::parse($evento->fecha_fin)->setTime(23, 59, 59);

        if ($now->lessThan($fechaInicioEvento)) {
            return back()->with('error', 'El evento aún no ha comenzado.');
        }

        if ($now->greaterThan($fechaFinEvento)) {
            return back()->with('error', 'El evento ya ha terminado. No se pueden subir proyectos.');
        }

        // Cargar relaciones necesarias
        $equipo->load(['evento', 'repositorio', 'lider', 'participantes']);

        return view('player.proyecto.subir', compact('equipo', 'evento'));
    }

    /**
     * Guardar proyecto
     */
    public function store(Request $request, Equipo $equipo)
    {
        $usuario = Auth::user();

        // Verificar que sea líder del equipo
        if ($equipo->id_lider !== $usuario->id) {
            abort(403, 'Solo el líder del equipo puede subir el proyecto.');
        }

        $evento = $equipo->evento;

        // Verificar que el evento esté en curso
        $now = Carbon::now();
        $fechaFinEvento = Carbon::parse($evento->fecha_fin)->setTime(23, 59, 59);

        if ($now->lessThan($evento->fecha_inicio)) {
            return back()->with('error', 'El evento aún no ha comenzado.');
        }

        if ($now->greaterThan($fechaFinEvento)) {
            return back()->with('error', 'El evento ya ha terminado. No se pueden subir proyectos.');
        }

        $validated = $request->validate([
            'archivo' => 'required|file|mimes:zip,pdf,pptx|max:10240', // 10MB máximo
            'comentarios' => 'nullable|string|max:1000',
        ]);

        // Crear o actualizar repositorio
        $repositorio = $equipo->repositorio ?? new Repositorio();
        $repositorio->equipo_id = $equipo->id_equipo;
        $repositorio->evento_id = $evento->id_evento;

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($repositorio->archivo_path && Storage::disk('public')->exists($repositorio->archivo_path)) {
                Storage::disk('public')->delete($repositorio->archivo_path);
            }

            $archivo = $request->file('archivo');
            $nombreArchivo = $equipo->nombre . '_' . $equipo->nombre_proyecto . '_' . time() . '.' . $archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('proyectos', $nombreArchivo, 'public');

            $repositorio->archivo_path = $ruta;
            $repositorio->archivo_nombre = $archivo->getClientOriginalName();
            $repositorio->archivo_tamaño = $archivo->getSize();
        }

        $repositorio->descripcion = $validated['comentarios'] ?? null;
        $repositorio->estado = 'enviado';
        $repositorio->enviado_en = $now;
        $repositorio->save();

        return redirect()->route('player.equipos')
            ->with('success', 'Proyecto subido exitosamente. Espera la calificación del juez.');
    }

    /**
     * Descargar proyecto
     */
    public function download(Repositorio $repositorio)
    {
        // Verificar permisos
        $usuario = Auth::user();

        // Pueden descargar: equipo, jueces del evento, admin
        $puedeDescargar = false;

        // Si es miembro del equipo
        if ($repositorio->equipo->participantes->contains($usuario->id)) {
            $puedeDescargar = true;
        }

        // Si es juez del evento
        if ($usuario->esJuez() && $repositorio->evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            $puedeDescargar = true;
        }

        // Si es admin
        if ($usuario->esAdmin()) {
            $puedeDescargar = true;
        }

        if (!$puedeDescargar) {
            abort(403, 'No tienes permiso para descargar este proyecto.');
        }

        return Storage::disk('public')->download($repositorio->archivo_path, $repositorio->archivo_nombre);
    }

    /**
     * Listar proyectos para juez
     */
    public function listarJuez(Evento $evento)
    {
        $usuario = Auth::user();

        // Verificar que sea juez del evento
        if (!$usuario->esJuez() || !$evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'No tienes permiso para ver estos proyectos.');
        }

        $proyectos = Repositorio::where('evento_id', $evento->id_evento)
            ->with(['equipo', 'equipo.participantes'])
            ->orderBy('enviado_en', 'desc')
            ->get();

        return view('juez.proyectos.listar', compact('evento', 'proyectos'));
    }

    /**
     * Ver proyecto para juez
     */
    public function verJuez(Repositorio $repositorio)
    {
        $usuario = Auth::user();

        // Verificar que sea juez del evento
        if (!$usuario->esJuez() || !$repositorio->evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'No tienes permiso para ver este proyecto.');
        }

        return view('juez.proyectos.ver', compact('repositorio'));
    }

    /**
     * Mostrar formulario de calificación para juez
     */
    public function calificarJuez(Repositorio $repositorio)
    {
        $usuario = Auth::user();

        // Verificar que sea juez del evento
        if (!$usuario->esJuez() || !$repositorio->evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'No tienes permiso para calificar este proyecto.');
        }

        $detalleCalificacion = $repositorio->calificacion_detalle ? json_decode($repositorio->calificacion_detalle, true) : null;

        return view('juez.proyectos.calificar', compact('repositorio', 'detalleCalificacion'));
    }

    /**
     * Guardar calificación del juez
     */
    public function guardarCalificacion(Request $request, Repositorio $repositorio)
    {
        $usuario = Auth::user();

        // Verificar que sea juez del evento
        if (!$usuario->esJuez() || !$repositorio->evento->jueces()->where('usuario_id', $usuario->id)->exists()) {
            abort(403, 'No tienes permiso para calificar este proyecto.');
        }

        $validated = $request->validate([
            'puntaje_innovacion' => 'required|numeric|min:0|max:30',
            'puntaje_funcionalidad' => 'required|numeric|min:0|max:30',
            'puntaje_impacto' => 'required|numeric|min:0|max:20',
            'puntaje_presentacion' => 'required|numeric|min:0|max:20',
            'comentarios' => 'nullable|string|max:1000',
        ]);

        // Calcular puntaje total
        $puntajeTotal =
            $validated['puntaje_innovacion'] +
            $validated['puntaje_funcionalidad'] +
            $validated['puntaje_impacto'] +
            $validated['puntaje_presentacion'];

        $repositorio->calificacion_total = $puntajeTotal;
        $repositorio->calificacion_detalle = json_encode([
            'innovacion' => $validated['puntaje_innovacion'],
            'funcionalidad' => $validated['puntaje_funcionalidad'],
            'impacto' => $validated['puntaje_impacto'],
            'presentacion' => $validated['puntaje_presentacion'],
            'comentarios' => $validated['comentarios'],
            'calificado_por' => $usuario->id,
            'calificado_en' => Carbon::now()->toDateTimeString(),
        ]);
        $repositorio->save();

        // Guardar también en la tabla de calificaciones para el panel de resultados
        CalificacionEquipo::updateOrCreate(
            [
                'juez_id' => $usuario->id,
                'equipo_id' => $repositorio->equipo->id_equipo,
                'evento_id' => $repositorio->evento->id_evento,
            ],
            [
                'puntaje_innovacion' => $validated['puntaje_innovacion'],
                'puntaje_funcionalidad' => $validated['puntaje_funcionalidad'],
                'puntaje_impacto' => $validated['puntaje_impacto'],
                'puntaje_presentacion' => $validated['puntaje_presentacion'],
                'observaciones' => $validated['comentarios'] ?? '',
            ]
        );

        // Notificar al líder del equipo
        $lider = $repositorio->equipo->lider;
        if ($lider) {
            // Crear notificación
            $notificacion = new \App\Models\Notificacion();
            $notificacion->usuario_id = $lider->id;
            $notificacion->tipo = 'calificacion';
            $notificacion->titulo = 'Tu proyecto ha sido calificado';
            $notificacion->mensaje = 'El proyecto "' . $repositorio->equipo->nombre_proyecto .
                '" ha sido calificado con ' . $puntajeTotal . ' puntos por el juez ' . $usuario->nombre;
            $notificacion->enlace = route('player.equipos');
            $notificacion->leida = false;
            $notificacion->save();
        }

        return redirect()->route('proyecto.juez.ver-juez', $repositorio)
            ->with('success', 'Proyecto calificado exitosamente.');
    }
}
