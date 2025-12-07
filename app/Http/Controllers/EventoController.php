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
            // Filtra por la columna 'estado'
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
        return view('eventos.show', compact('evento'));
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

    // ==========================================
    //       FUNCIONES DEL JUGADOR
    // ==========================================

    /**
     * Muestra la vista "Mis Eventos" para el jugador.
     */
    public function misEventos()
    {
        $user = Auth::user();
        
        // 1. Obtener el equipo del usuario
        $miEquipo = Equipo::whereHas('participantes', function($q) use ($user) {
            $q->where('usuario_id', $user->id);
        })->with('evento')->first();

        // 2. Obtener los eventos
        $misEventos = [];
        if ($miEquipo && $miEquipo->evento) {
            $misEventos = [$miEquipo->evento];
        }

        // Determinar si es líder
        $soyLider = false;
        if ($miEquipo) {
            $participanteUsuario = $miEquipo->participantes->find($user->id);
            // Ajusta 'posicion' según tu tabla pivote (puede ser 'pivot_posicion')
            if ($participanteUsuario && $participanteUsuario->pivot->posicion === 'Líder') {
                $soyLider = true;
            }
        }

        return view('player.eventos', compact('misEventos', 'soyLider', 'miEquipo'));
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

        // Verificar si el equipo ya está inscrito en este evento
        if ($equipoUsuario->id_evento === $evento->id_evento) {
            return back()->with('info', 'Tu equipo ya está inscrito en este evento.');
        }

        // Actualizar el evento del equipo
        $equipoUsuario->update(['id_evento' => $evento->id_evento]);

        return back()->with('success', '¡Tu equipo se ha inscrito exitosamente en el evento!');
    }
}