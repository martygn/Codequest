<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo; // Necesario para la función misEventos
use App\Models\Usuario; // Necesario para obtener el usuario actual
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Necesario para obtener el usuario actual

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Iniciar la consulta
        $query = Evento::query();

        // 2. Lógica del Buscador (Si el usuario escribió algo)
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

    // 3. Lógica de Pestañas (Estado)
    // Recibimos 'status' de la URL, si no existe, por defecto es 'todos'
    $status = $request->get('status', 'todos');

    if ($status !== 'todos') {
        // Filtra por la columna 'estado' que crearemos en la base de datos
        $query->where('estado', $status);
    }

        // 4. Obtener resultados (Ordenados por fecha de inicio)
        $eventos = $query->orderBy('fecha_inicio', 'desc')
                        ->paginate(10) // 10 ítems por página
                        ->withQueryString(); // Mantiene los filtros al cambiar de página

        // 5. Retornar vista con los datos y el estado actual para marcar la pestaña activa
        $currentStatus = $status;
        return view('eventos.index', compact('eventos', 'currentStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('eventos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'reglas' => 'nullable|string',
        'premios' => 'nullable|string',
        'otra_informacion' => 'nullable|string',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'estado' => 'nullable|in:pendiente,publicado',
    ]);

    if (empty($validated['estado'])) {
        $validated['estado'] = 'pendiente';
    }

        // Si no viene estado en el request, forzamos 'pendiente'
        if (empty($validated['estado'])) {
            $validated['estado'] = 'pendiente';
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('eventos', 'public');
        }

        Evento::create($validated);

        return redirect()->route('eventos.index')->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $evento->load('equipos.participantes');

        $usuario = auth()->user();
        $esParticipante = false;
        $tieneEquipoEnEsteEvento = false;
        $tieneEquipoAprobado = false;

        if ($usuario) {
            $esParticipante = $usuario->tipo === 'participante';

            if ($esParticipante) {
                // Verificar si el usuario tiene equipo aprobado para ESTE evento
                $tieneEquipoEnEsteEvento = $usuario->equipos()
                    ->where('aprobado', true)
                    ->where('id_evento', $evento->id_evento)
                    ->exists();

                // Verificar si tiene ALGÚN equipo aprobado en el que sea LÍDER
                // Solo los líderes de un equipo aprobado pueden inscribirlo en eventos
                $tieneEquipoAprobado = $usuario->equipos()
                    ->where('aprobado', true)
                    ->where('id_lider', $usuario->id)
                    ->exists();
            }
        }

        return view('eventos.show', compact(
            'evento',
            'esParticipante',
            'tieneEquipoEnEsteEvento',
            'tieneEquipoAprobado'
        ));
    }

    /**
     * Agregar método para inscribir equipo a evento
     */
    public function inscribirEquipo(Request $request, Evento $evento)
    {
        $usuario = auth()->user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        // Solo permitir inscripción si el evento está publicado
        if ($evento->estado !== 'publicado') {
            return back()->with('error', '❌ No puedes inscribir equipos en un evento que aún no ha sido publicado.');
        }

        // Verificar que el usuario tenga al menos un equipo aprobado y que además sea LÍDER
        $equiposAprobados = $usuario->equipos()
            ->where('aprobado', true)
            ->where('id_lider', $usuario->id)
            ->get();

        if ($equiposAprobados->isEmpty()) {
            return redirect()->route('equipos.create')
                ->with('info', 'Debes crear un equipo aprobado antes de inscribirte a un evento.');
        }

        // Si solo tiene un equipo aprobado, usarlo automáticamente
        if ($equiposAprobados->count() === 1) {
            $equipo = $equiposAprobados->first();

            // Verificar que el equipo no esté inscrito en otro evento distinto
            if (!is_null($equipo->id_evento) && $equipo->id_evento != $evento->id_evento) {
                return back()->with('error', '❌ Tu equipo ya está inscrito en otro evento. Desinscríbelo primero desde Mis Eventos antes de inscribirlo en este.');
            }

            // Asignar solo si no está inscrito o ya está en este mismo evento
            if (is_null($equipo->id_evento) || $equipo->id_evento == $evento->id_evento) {
                $equipo->id_evento = $evento->id_evento;
                $equipo->save();
            }

            return back()->with('success', '✅ Tu equipo se ha inscrito exitosamente al evento.');
        }

        // Si tiene múltiples equipos, mostrar formulario para seleccionar
        return view('eventos.seleccionar-equipo', compact('evento', 'equiposAprobados'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'lugar' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:pendiente,publicado'
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($evento->foto) {
                Storage::disk('public')->delete($evento->foto);
            }
            $validated['foto'] = $request->file('foto')->store('eventos', 'public');
        }

        $evento->update($validated);

        return redirect()->route('eventos.show', $evento->id_evento)
            ->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        // Eliminar foto si existe
        if ($evento->foto) {
            Storage::disk('public')->delete($evento->foto);
        }

        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Seleccionar equipo para evento (cuando tiene múltiples equipos)
     */
    public function seleccionarEquipoParaEvento(Request $request, Evento $evento)
    {
        $usuario = auth()->user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        $request->validate([
            'equipo_id' => 'required|exists:equipos,id_equipo'
        ]);

        // Verificar que el equipo pertenezca al usuario, esté aprobado y que el usuario sea LÍDER
        $equipo = $usuario->equipos()
            ->where('id_equipo', $request->equipo_id)
            ->where('aprobado', true)
            ->where('id_lider', $usuario->id)
            ->first();

        if (!$equipo) {
            return back()->with('error', '❌ Equipo no encontrado o no aprobado.');
        }

        // Verificar que el equipo no esté ya inscrito en otro evento distinto
        if (!is_null($equipo->id_evento) && $equipo->id_evento != $evento->id_evento) {
            return back()->with('error', '❌ El equipo seleccionado ya está inscrito en otro evento. Desinscríbelo primero desde Mis Eventos.');
        }

        // Asignar el evento al equipo solo si no está en otro evento
        if (is_null($equipo->id_evento) || $equipo->id_evento == $evento->id_evento) {
            $equipo->id_evento = $evento->id_evento;
            $equipo->save();
        }

        return redirect()->route('eventos.show', $evento->id_evento)
            ->with('success', '✅ Tu equipo se ha inscrito exitosamente al evento.');
    }

    /**
     * Unirse a un evento con el equipo aprobado del usuario (solo líderes)
     */
    public function unirse(Request $request, Evento $evento)
    {
        // Verificar si el evento está publicado
        if ($evento->estado !== 'publicado') {
            return back()->with('error', 'Este evento aún no ha sido publicado. Espera a que los administradores lo publiquen.');
        }

        // Obtener el usuario actual
        $usuario = Auth::user();

        // Verificar si el usuario tiene un equipo
        $equipoUsuario = Equipo::whereHas('participantes', function ($q) use ($usuario) {
            $q->where('usuario_id', $usuario->id);
        })->first();

        if (!$equipoUsuario) {
            return redirect()->route('equipos.create')
                ->with('error', 'Necesitas crear un equipo primero antes de unirte a un evento.');
        }

        // Verificar si el usuario es LÍDER del equipo
        $esLider = $equipoUsuario->participantes()
            ->wherePivot('usuario_id', $usuario->id)
            ->wherePivot('posicion', 'Líder')
            ->exists();

        if (!$esLider) {
            return back()->with('error', 'Solo el líder del equipo puede inscribirse a eventos.');
        }

        // Verificar si el equipo está aprobado
        if ($equipoUsuario->estado !== 'aprobado') {
            return back()->with('error', 'Tu equipo aún está en revisión. Espera a que los administradores lo aprueben.');
        }

        // Verificar si el equipo ya está inscrito en otro evento distinto
        if (!is_null($equipoUsuario->id_evento) && $equipoUsuario->id_evento != $evento->id_evento) {
            return back()->with('error', '❌ Tu equipo ya está inscrito en otro evento. Desinscríbelo primero desde Mis Eventos antes de inscribirte aquí.');
        }

        // Si ya está inscrito en este mismo evento, informar
        if ($equipoUsuario->id_evento === $evento->id_evento) {
            return back()->with('info', 'Tu equipo ya está inscrito en este evento.');
        }

        // Actualizar el evento del equipo
        $equipoUsuario->update(['id_evento' => $evento->id_evento]);

        return back()->with('success', '¡Tu equipo se ha inscrito exitosamente en el evento!');
    }
    /**
     * Muestra los eventos donde participa el usuario.
     */
    public function misEventos()
    {
        $usuario = Auth::user();

        // 1. Obtener los eventos (Esto ya lo tenías)
        $misEventos = Evento::whereHas('equipos.participantes', function($query) use ($usuario) {
            $query->where('usuario_id', $usuario->id);
        })->get();

        // 2. Obtener el equipo del usuario (Para corregir el error Undefined variable $miEquipo)
        // Buscamos el primer equipo donde esté el usuario
        $misEquiposUsuario = Equipo::whereHas('participantes', function($q) use ($usuario) {
            $q->where('usuario_id', $usuario->id);
        })->get();

        // Mapear equipos por su id_evento para mostrar acciones por evento
        $equiposPorEvento = [];
        foreach ($misEquiposUsuario as $e) {
            if (!is_null($e->id_evento)) {
                $equiposPorEvento[$e->id_evento] = $e;
            }
        }

        // Mantener compatibilidad con la variable miEquipo (primer equipo)
        $miEquipo = $misEquiposUsuario->first();

        // 3. Determinar si es líder (para al menos uno de sus equipos)
        $soyLider = $misEquiposUsuario->contains(function($eq) use ($usuario) {
            return $eq->id_lider === $usuario->id;
        });

        // 4. Enviamos variables a la vista
        return view('player.eventos', compact('misEventos', 'miEquipo', 'soyLider', 'equiposPorEvento'));
    }
}