<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Equipo;
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

                // Verificar si tiene ALGÚN equipo aprobado
                $tieneEquipoAprobado = $usuario->equipos()
                    ->where('aprobado', true)
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

        // Verificar que el usuario tenga al menos un equipo aprobado
        $equiposAprobados = $usuario->equipos()->where('aprobado', true)->get();

        if ($equiposAprobados->isEmpty()) {
            return redirect()->route('equipos.create')
                ->with('info', 'Debes crear un equipo aprobado antes de inscribirte a un evento.');
        }

        // Si solo tiene un equipo aprobado, usarlo automáticamente
        if ($equiposAprobados->count() === 1) {
            $equipo = $equiposAprobados->first();
            $equipo->id_evento = $evento->id_evento;
            $equipo->save();

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

        // Verificar que el equipo pertenezca al usuario y esté aprobado
        $equipo = $usuario->equipos()
            ->where('id_equipo', $request->equipo_id)
            ->where('aprobado', true)
            ->first();

        if (!$equipo) {
            return back()->with('error', '❌ Equipo no encontrado o no aprobado.');
        }

        // Asignar el evento al equipo
        $equipo->id_evento = $evento->id_evento;
        $equipo->save();

        return redirect()->route('eventos.show', $evento->id_evento)
            ->with('success', '✅ Tu equipo se ha inscrito exitosamente al evento.');
    }

    // Agregar este método al controlador EventoController
    private function verificarEquipoParaInscripcion($usuario)
    {
        // Verificar si el usuario tiene al menos un equipo aprobado
        $equiposAprobados = $usuario->equipos()->where('aprobado', true)->count();

        if ($equiposAprobados === 0) {
            session()->flash('info', 'Debes crear un equipo y que sea aprobado antes de inscribirte a un evento.');
            return redirect()->route('equipos.create');
        }

        return null;
    }
}
