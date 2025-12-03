<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Iniciar consulta con relaciones y conteo de participantes
        $query = Equipo::with('evento')
            ->withCount('participantes')
            ->orderBy('created_at', 'desc');

        // Filtros basados en las pestañas
        $filtro = $request->get('filtro', 'todos');

        switch ($filtro) {
            case 'mis_eventos':
                // Filtrar equipos donde el usuario autenticado es participante
                $query->whereHas('participantes', function ($q) use ($usuario) {
                    $q->where('usuario_id', $usuario->id);
                });
                break;

            case 'eventos_pasados':
                // Filtrar equipos cuyo evento ya finalizó
                $query->whereHas('evento', function ($q) {
                    $q->where('fecha_fin', '<', Carbon::now());
                });
                break;

            case 'todos':
            default:
                // Sin filtro adicional - mostrar todos
                break;
        }

        // Búsqueda por nombre del equipo o nombre del proyecto
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('nombre_proyecto', 'like', "%{$search}%")
                  ->orWhereHas('evento', function ($eventoQuery) use ($search) {
                      $eventoQuery->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Paginación
        $equipos = $query->paginate(10);

        return view('equipos.index', compact('equipos', 'filtro'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener solo eventos próximos o activos para crear equipos
        $eventos = Evento::where('fecha_fin', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('equipos.create', compact('eventos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:equipos,nombre',
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB máximo
            'id_evento' => 'required|exists:eventos,id_evento',
        ], [
            'nombre.required' => 'El nombre del equipo es obligatorio.',
            'nombre.unique' => 'Ya existe un equipo con ese nombre.',
            'nombre_proyecto.required' => 'El nombre del proyecto es obligatorio.',
            'descripcion.required' => 'La descripción del equipo es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'id_evento.required' => 'Debes seleccionar un evento para el equipo.',
        ]);

        // Establecer estado inicial
        $validated['estado'] = 'en revisión';

        // Manejar la carga del banner
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('equipos/banners', 'public');
        }

        // Crear el equipo
        $equipo = Equipo::create($validated);

        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Agregar al usuario actual como miembro del equipo con posición "líder"
        $equipo->participantes()->attach($usuario->id, ['posicion' => 'Líder']);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', '🎉 ¡Equipo creado exitosamente! Tu equipo está ahora en revisión.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        // Cargar relaciones necesarias
        $equipo->load(['evento', 'participantes']);

        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar si el usuario puede ver el equipo (miembro o administrador)
        if (!$usuario->esAdministrador() && !$equipo->tieneMiembro($usuario->id)) {
            // Solo mostrar equipos públicos o donde el usuario es miembro
            if ($equipo->estado !== 'aprobado') {
                abort(403, 'No tienes permiso para ver este equipo.');
            }
        }

        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipo $equipo)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar que el usuario sea miembro del equipo o administrador
        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        $eventos = Evento::where('fecha_fin', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('equipos.edit', compact('equipo', 'eventos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipo $equipo)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar que el usuario sea miembro del equipo o administrador
        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:equipos,nombre,' . $equipo->id_equipo . ',id_equipo',
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'id_evento' => 'required|exists:eventos,id_evento',
        ], [
            'nombre.required' => 'El nombre del equipo es obligatorio.',
            'nombre.unique' => 'Ya existe un equipo con ese nombre.',
            'nombre_proyecto.required' => 'El nombre del proyecto es obligatorio.',
            'descripcion.required' => 'La descripción del equipo es obligatoria.',
        ]);

        // Manejar la carga del nuevo banner
        if ($request->hasFile('banner')) {
            // Eliminar banner anterior si existe
            if ($equipo->banner && Storage::disk('public')->exists($equipo->banner)) {
                Storage::disk('public')->delete($equipo->banner);
            }
            $validated['banner'] = $request->file('banner')->store('equipos/banners', 'public');
        }

        // Actualizar el equipo
        $equipo->update($validated);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', '✅ Equipo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar que el usuario sea administrador o líder del equipo
        if (!$usuario->esAdministrador() &&
            !$equipo->participantes()->where('usuario_id', $usuario->id)->where('posicion', 'Líder')->exists()) {
            abort(403, 'Solo los administradores o el líder del equipo pueden eliminarlo.');
        }

        // Eliminar banner si existe
        if ($equipo->banner && Storage::disk('public')->exists($equipo->banner)) {
            Storage::disk('public')->delete($equipo->banner);
        }

        // Eliminar el equipo (las relaciones se eliminarán por cascade)
        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', '🗑️ Equipo eliminado exitosamente.');
    }

    /**
     * Método para que un participante se una a un equipo
     */
    public function unirse(Equipo $equipo)
    {
        // Obtener el usuario actual
        $usuario = Usuario::find(Auth::id());

        // Verificar autenticación
        if (!$usuario) {
            return redirect()->route('login');
        }

        // Verificar que solo participantes puedan unirse
        if ($usuario->tipo !== 'participante') {
            abort(403, 'Solo los participantes pueden unirse a equipos.');
        }

        // Verificar que el usuario no sea ya miembro
        if ($equipo->tieneMiembro($usuario->id)) {
            return back()->with('error', '❌ Ya eres miembro de este equipo.');
        }

        // Verificar límite de miembros (máximo 4 incluyendo al líder)
        if ($equipo->participantes()->count() >= 4) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de miembros permitido (4).');
        }

        // Determinar la posición automática según el orden de unión
        $numeroDeMiembros = $equipo->participantes()->count();

        // Mapa de posiciones según el orden de unión (excluyendo al líder)
        $posiciones = [
            1 => 'Programador Front-end', // Primer participante en unirse
            2 => 'Programador Back-end',  // Segundo participante en unirse
            3 => 'Diseñador'              // Tercer participante en unirse
        ];

        // Obtener la posición correspondiente
        $indice = $numeroDeMiembros; // El líder es el miembro 0, el primero en unirse será miembro 1
        $posicion = $posiciones[$indice] ?? 'Miembro';

        // Agregar al usuario como participante con la posición automática
        $equipo->participantes()->attach($usuario->id, [
            'posicion' => $posicion
        ]);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', "✅ ¡Te has unido al equipo exitosamente como {$posicion}!");
    }

    /**
     * Update the status of a team (for administrators).
     */
    public function updateStatus(Request $request, Equipo $equipo)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Solo administradores pueden cambiar el estado del equipo
        if (!$usuario->esAdministrador()) {
            abort(403, 'Solo los administradores pueden cambiar el estado del equipo.');
        }

        $request->validate([
            'estado' => 'required|in:en revisión,aprobado,rechazado'
        ]);

        $equipo->update(['estado' => $request->estado]);

        // Si la petición espera JSON (AJAX), retornar conteos actualizados
        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            $totales = Equipo::selectRaw(
                "SUM(CASE WHEN LOWER(TRIM(estado)) = 'en revisión' THEN 1 ELSE 0 END) as en_revision,"
                . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'aprobado' THEN 1 ELSE 0 END) as aprobado,"
                . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'rechazado' THEN 1 ELSE 0 END) as rechazado"
            )->first();

            $estadisticas = [
                'en_revision' => (int)($totales->en_revision ?? 0),
                'aprobado' => (int)($totales->aprobado ?? 0),
                'rechazado' => (int)($totales->rechazado ?? 0),
            ];

            return response()->json([
                'success' => true,
                'estado' => $equipo->estado,
                'estadisticas' => $estadisticas,
            ]);
        }

        return back()->with('success', '✅ Estado del equipo actualizado a "' . ucfirst($request->estado) . '".');
    }

    /**
     * Agregar un participante al equipo
     */
    public function agregarParticipante(Request $request, Equipo $equipo)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar permisos
        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para agregar participantes a este equipo.');
        }

        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'posicion' => 'required|string|max:255'
        ]);

        // Verificar que el usuario no sea ya miembro
        if ($equipo->tieneMiembro($validated['usuario_id'])) {
            return back()->with('error', '❌ Este usuario ya es miembro del equipo.');
        }

        // Verificar límite de participantes (ejemplo: máximo 5)
        if ($equipo->participantes()->count() >= 5) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de participantes permitido (5).');
        }

        // Agregar participante
        $equipo->participantes()->attach($validated['usuario_id'], [
            'posicion' => $validated['posicion']
        ]);

        return back()->with('success', '✅ Participante agregado exitosamente.');
    }

    /**
     * Remover un participante del equipo
     */
    public function removerParticipante(Equipo $equipo, $usuarioId)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar permisos
        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para remover participantes de este equipo.');
        }

        // Verificar que el usuario sea miembro
        if (!$equipo->tieneMiembro($usuarioId)) {
            return back()->with('error', '❌ Este usuario no es miembro del equipo.');
        }

        // Verificar que no se elimine al último líder
        $esLider = $equipo->participantes()
            ->where('usuario_id', $usuarioId)
            ->where('posicion', 'Líder')
            ->exists();

        if ($esLider && $equipo->participantes()->where('posicion', 'Líder')->count() <= 1) {
            return back()->with('error', '❌ No puedes eliminar al único líder del equipo.');
        }

        // Remover participante
        $equipo->participantes()->detach($usuarioId);

        return back()->with('success', '✅ Participante removido exitosamente.');
    }

    /**
     * Actualizar la posición de un participante
     */
    public function actualizarPosicion(Request $request, Equipo $equipo, $usuarioId)
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Verificar permisos
        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para actualizar posiciones en este equipo.');
        }

        $request->validate([
            'posicion' => 'required|string|max:255'
        ]);

        // Actualizar posición
        $equipo->participantes()->updateExistingPivot($usuarioId, [
            'posicion' => $request->posicion
        ]);

        return back()->with('success', '✅ Posición actualizada exitosamente.');
    }

    /**
     * Exportar lista de equipos a CSV
     */
    public function exportarCSV()
    {
        // Obtener el usuario actual como instancia de Usuario
        $usuario = Usuario::find(Auth::id());

        // Solo administradores pueden exportar
        if (!$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para exportar la lista de equipos.');
        }

        $equipos = Equipo::with(['evento', 'participantes'])->get();

        $csvData = "Nombre del equipo,Nombre del proyecto,Evento,Estado,Integrantes,Fecha de creación\n";

        foreach ($equipos as $equipo) {
            $integrantes = $equipo->participantes->map(function ($participante) {
                return $participante->nombre_completo . ' (' . $participante->pivot->posicion . ')';
            })->implode('; ');

            $csvData .= "\"{$equipo->nombre}\",\"{$equipo->nombre_proyecto}\",\"{$equipo->evento->nombre}\",\"{$equipo->estado}\",\"{$integrantes}\",\"{$equipo->created_at->format('Y-m-d')}\"\n";
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="equipos_' . date('Y-m-d') . '.csv"',
        ];

        return response($csvData, 200, $headers);
    }
}
