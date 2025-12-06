<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Evento;
use App\Models\Equipo;

class AdminController extends Controller
{
    /**
     * Mostrar la vista de gestión de eventos para administradores.
     */
    public function eventos()
    {
        $usuario = auth()->user();

        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Filtrado por pestañas: 'todos' | 'pendientes' | 'publicados'
        $status = request()->get('status', 'pendientes');

        $query = \App\Models\Evento::query();

        if ($status === 'pendientes') {
            $query->where('estado', 'pendiente');
        } elseif ($status === 'publicados') {
            $query->where('estado', 'publicado');
        }

        // Usar paginación para la lista de admin
        $eventos = $query->orderBy('fecha_inicio', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.eventos', compact('eventos', 'status'));
    }

    /**
     * Actualizar el estado de un evento.
     */
    public function updateEventoStatus(Request $request, \App\Models\Evento $evento)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $data = $request->validate([
            'estado' => 'required|in:pendiente,publicado'
        ]);

        $evento->update(['estado' => $data['estado']]);

        return back()->with('success', 'Estado del evento actualizado a "' . $data['estado'] . '".');
    }

    /**
     * Mostrar la vista de gestión de equipos.
     */
    public function equipos()
    {
        $usuario = auth()->user();

        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $equipos = Equipo::with('evento')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.equipos', compact('equipos'));
    }

    /**
     * Mostrar la vista de perfil.
     */
    public function perfil()
    {
        $usuario = auth()->user();

        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        return view('admin.perfil');
    }

    /**
     * Mostrar la vista de configuración.
     */
    public function configuracion()
    {
        $usuario = auth()->user();

        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        return view('admin.configuracion');
    }

    /**
     * Actualizar el estado de un equipo.
     */
    public function updateEquipoStatus(Request $request, \App\Models\Equipo $equipo)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $data = $request->validate([
            'estado' => 'required|in:en revisión,aprobado,rechazado'
        ]);

        $equipo->update(['estado' => $data['estado']]);

        // Obtener las estadísticas actualizadas
        $estadisticas = DB::table('equipos')
            ->selectRaw("
                SUM(CASE WHEN LOWER(TRIM(estado)) = 'en revisión' THEN 1 ELSE 0 END) as en_revision,
                SUM(CASE WHEN LOWER(TRIM(estado)) = 'aprobado' THEN 1 ELSE 0 END) as aprobado,
                SUM(CASE WHEN LOWER(TRIM(estado)) = 'rechazado' THEN 1 ELSE 0 END) as rechazado
            ")
            ->first();

        if ($request->expectsJson()) {
            return response()->json([
                'estado' => $data['estado'],
                'estadisticas' => $estadisticas
            ]);
        }

        return back()->with('success', 'Estado del equipo actualizado a "' . $data['estado'] . '".');
    }

    /**
     * Mostrar formulario para crear un nuevo evento desde el admin.
     */
    public function crearEvento()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        return view('admin.eventos.create');
    }

    /**
     * Guardar un nuevo evento desde el admin.
     */
    public function guardarEvento(Request $request)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'reglas' => 'nullable|string',
            'premios' => 'nullable|string',
            'otra_informacion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:pendiente,publicado',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('eventos', 'public');
        }

        Evento::create($validated);

        return redirect()->route('admin.eventos')->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Ver detalles de un evento desde el panel admin.
     */
    public function verEvento(Evento $evento)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $evento->load('equipos.participantes');
        return view('admin.eventos.show', compact('evento'));
    }

    /**
     * Mostrar formulario para crear un nuevo equipo desde el admin.
     */
    public function crearEquipo()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        return view('admin.equipos.create');
    }

    /**
     * Guardar un nuevo equipo desde el admin.
     */
    public function guardarEquipo(Request $request)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:en revisión,aprobado,rechazado',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('equipos', 'public');
        }

        Equipo::create($validated);

        return redirect()->route('admin.equipos')->with('success', 'Equipo creado exitosamente.');
    }

    /**
     * Ver detalles de un equipo desde el panel admin.
     */
    public function verEquipo(Equipo $equipo)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $equipo->load('evento', 'participantes');
        return view('admin.equipos.show', compact('equipo'));
    }
}
