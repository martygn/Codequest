<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Evento;
use App\Models\Usuario;
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
        $eventos = Evento::where('fecha_inicio', '>=', now())
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('equipos.create', compact('eventos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos del equipo
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_evento' => 'required|exists:eventos,id_evento',
            'integrantes' => 'required|array|min:1',
            'integrantes.*.correo' => 'required|email',
            'integrantes.*.cargo' => 'required|string|in:Diseñador,Programador back-end,Programador front-end',
        ]);

        $correoUsuarioActual = Auth::user()->correo;
        foreach ($request->integrantes as $integrante) {
            if ($integrante['correo'] == $correoUsuarioActual) {
                return back()->withErrors(['integrantes' => 'No puedes agregarte a ti mismo como integrante adicional.']);
            }
        }

        // Subir banner si existe
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('equipos', 'public');
        }

        // Crear el equipo
        $equipo = Equipo::create($validated);

        // Agregar al usuario actual como LÍDER
        $equipo->participantes()->attach(Auth::id(), ['posicion' => 'Líder']);

        // Procesar otros integrantes
        $invitacionesEnviadas = [];
        $usuariosNoEncontrados = [];

        foreach ($request->integrantes as $integrante) {
            // Buscar usuario por correo
            $usuario = Usuario::where('correo', $integrante['correo'])->first();

            if ($usuario) {
                // Usuario existe, agregar al equipo
                if (!$equipo->tieneMiembro($usuario->id)) {
                    $equipo->participantes()->attach($usuario->id, [
                        'posicion' => $integrante['cargo'],
                        'estado_invitacion' => 'aceptada'
                    ]);
                }
            } else {
                // Usuario no existe, crear invitación
                $usuariosNoEncontrados[] = $integrante['correo'];
            }
        }

        // Mensaje de éxito
        $mensaje = 'Equipo creado exitosamente. ';

        if (count($usuariosNoEncontrados) > 0) {
            $mensaje .= 'Invitaciones enviadas a: ' . implode(', ', $usuariosNoEncontrados);
        }

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', $mensaje);
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
        if (!Auth::user()->esAdministrador()) {
            abort(403, 'Solo los administradores pueden eliminar equipos.');
        }

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

    /**
     * Abandonar equipo
     */
    public function abandonar(Equipo $equipo)
    {
        if (!$equipo->tieneMiembro(Auth::id())) {
            return redirect()->route('equipos.show', $equipo->id_equipo)
                ->with('error', 'No eres miembro de este equipo.');
        }

        if ($equipo->participantes()->count() <= 1) {
            $equipo->delete();
            return redirect()->route('dashboard')
                ->with('success', 'Has abandonado el equipo. Como eras el último miembro, el equipo ha sido eliminado.');
        }

        $equipo->participantes()->detach(Auth::id());

        return redirect()->route('dashboard')
            ->with('success', 'Has abandonado el equipo exitosamente.');
    }

    /**
     * Mostrar formulario para subir proyecto
     */
    public function mostrarSubirProyecto(Equipo $equipo)
    {
        if (!$equipo->tieneMiembro(Auth::id())) {
            abort(403, 'No tienes permiso para subir proyectos a este equipo.');
        }

        return view('equipos.subir-proyecto', compact('equipo'));
    }

    /**
     * Procesar subida de proyecto
     */
    public function subirProyecto(Request $request, Equipo $equipo)
    {
        if (!$equipo->tieneMiembro(Auth::id())) {
            abort(403, 'No tienes permiso para subir proyectos a este equipo.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'repositorio_url' => 'nullable|url',
            'archivo' => 'nullable|file|max:10240',
            'video_url' => 'nullable|url'
        ]);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', 'Proyecto subido exitosamente.');
    }
}
