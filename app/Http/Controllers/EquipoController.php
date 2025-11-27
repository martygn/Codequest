<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipos = Equipo::with('evento')
            ->withCount('participantes')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('equipos.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eventos = Evento::proximos()->get();
        return view('equipos.create', compact('eventos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_evento' => 'required|exists:eventos,id_evento',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('equipos', 'public');
        }

        $equipo = Equipo::create($validated);

        // Agregar al usuario actual como miembro del equipo con posición "líder"
        $equipo->participantes()->attach(Auth::id(), ['posicion' => 'Líder']);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', 'Equipo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        $equipo->load(['evento', 'participantes']);
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipo $equipo)
    {
        // Verificar que el usuario sea miembro del equipo o administrador
        if (!$equipo->tieneMiembro(Auth::id()) && !Auth::user()->esAdministrador()) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        $eventos = Evento::all();
        return view('equipos.edit', compact('equipo', 'eventos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipo $equipo)
    {
        // Verificar que el usuario sea miembro del equipo o administrador
        if (!$equipo->tieneMiembro(Auth::id()) && !Auth::user()->esAdministrador()) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_evento' => 'required|exists:eventos,id_evento',
        ]);

        if ($request->hasFile('banner')) {
            // Eliminar banner anterior si existe
            if ($equipo->banner) {
                Storage::disk('public')->delete($equipo->banner);
            }
            $validated['banner'] = $request->file('banner')->store('equipos', 'public');
        }

        $equipo->update($validated);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', 'Equipo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        // Verificar que el usuario sea administrador
        if (!Auth::user()->esAdministrador()) {
            abort(403, 'Solo los administradores pueden eliminar equipos.');
        }

        // Eliminar banner si existe
        if ($equipo->banner) {
            Storage::disk('public')->delete($equipo->banner);
        }

        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado exitosamente.');
    }

    /**
     * Agregar un participante al equipo
     */
    public function agregarParticipante(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'posicion' => 'nullable|string|max:255'
        ]);

        if ($equipo->tieneMiembro($validated['usuario_id'])) {
            return back()->with('error', 'Este participante ya es miembro del equipo.');
        }

        $equipo->participantes()->attach($validated['usuario_id'], [
            'posicion' => $validated['posicion'] ?? 'Miembro'
        ]);

        return back()->with('success', 'Participante agregado exitosamente.');
    }

    /**
     * Remover un participante del equipo
     */
    public function removerParticipante(Equipo $equipo, $usuarioId)
    {
        if (!$equipo->tieneMiembro($usuarioId)) {
            return back()->with('error', 'Este usuario no es miembro del equipo.');
        }

        $equipo->participantes()->detach($usuarioId);

        return back()->with('success', 'Participante removido exitosamente.');
    }
}