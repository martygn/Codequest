<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                     ->paginate(10) // 10 ítems por página se ve mejor en tablas
                     ->withQueryString(); // Mantiene los filtros al cambiar de página

    // 5. Retornar vista con los datos y el estado actual para marcar la pestaña activa
    return view('eventos.index', compact('eventos', 'status'));
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
        'reglas' => 'nullable|string',             // Nuevo
        'premios' => 'nullable|string',            // Nuevo
        'otra_informacion' => 'nullable|string',   // Nuevo
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'estado' => 'nullable|in:pendiente,publicado', // 'nullable' si lo mandas hidden
    ]);

    // Si no viene estado en el request (porque está hidden), forzamos 'pendiente'
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
}