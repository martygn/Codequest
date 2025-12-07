<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Notificacion;
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
        $usuario = Usuario::find(Auth::id());

        $query = Equipo::with('evento')
            ->withCount('participantes')
            ->orderBy('created_at', 'desc');

        $filtro = $request->get('filtro', 'todos');

        switch ($filtro) {
            case 'mis_eventos':
                $query->whereHas('participantes', function ($q) use ($usuario) {
                    $q->where('usuario_id', $usuario->id);
                });
                break;

            case 'eventos_pasados':
                $query->whereHas('evento', function ($q) {
                    $q->where('fecha_fin', '<', Carbon::now());
                });
                break;

            case 'todos':
            default:
                break;
        }

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

        $equipos = $query->paginate(10);

        return view('equipos.index', compact('equipos', 'filtro'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:equipos,nombre',
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], [
            'nombre.required' => 'El nombre del equipo es obligatorio.',
            'nombre.unique' => 'Ya existe un equipo con ese nombre.',
            'nombre_proyecto.required' => 'El nombre del proyecto es obligatorio.',
            'descripcion.required' => 'La descripción del equipo es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
        ]);

        $validated['estado'] = 'en revisión';

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('equipos/banners', 'public');
        }

        $equipo = Equipo::create($validated);
        $usuario = Usuario::find(Auth::id());
        $equipo->participantes()->attach($usuario->id, ['posicion' => 'Líder']);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', '🎉 ¡Equipo creado exitosamente! Tu equipo está ahora en revisión.');
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['evento', 'participantes']);
        $usuario = Usuario::find(Auth::id());

        // El usuario puede ver el equipo si:
        // 1. Es administrador
        // 2. Es miembro del equipo
        // 3. El equipo está aprobado (cualquiera puede verlo)
        $puedeVer = $usuario->esAdministrador() || $equipo->tieneMiembro($usuario->id) || $equipo->estado === 'aprobado';

        if (!$puedeVer) {
            abort(403, 'No tienes permiso para ver este equipo.');
        }

        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        $eventos = Evento::where('fecha_fin', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('equipos.edit', compact('equipo', 'eventos'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

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

        if ($request->hasFile('banner')) {
            if ($equipo->banner && Storage::disk('public')->exists($equipo->banner)) {
                Storage::disk('public')->delete($equipo->banner);
            }
            $validated['banner'] = $request->file('banner')->store('equipos/banners', 'public');
        }

        $equipo->update($validated);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', '✅ Equipo actualizado exitosamente.');
    }

    public function destroy(Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$usuario->esAdministrador() &&
            !$equipo->participantes()->where('usuario_id', $usuario->id)->where('posicion', 'Líder')->exists()) {
            abort(403, 'Solo los administradores o el líder del equipo pueden eliminarlo.');
        }

        if ($equipo->banner && Storage::disk('public')->exists($equipo->banner)) {
            Storage::disk('public')->delete($equipo->banner);
        }

        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', '🗑️ Equipo eliminado exitosamente.');
    }

    public function unirse(Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$usuario) {
            return redirect()->route('login');
        }

        if ($usuario->tipo !== 'participante') {
            abort(403, 'Solo los participantes pueden unirse a equipos.');
        }

        if ($equipo->tieneMiembro($usuario->id)) {
            return back()->with('error', '❌ Ya eres miembro de este equipo.');
        }

        if ($equipo->participantes()->count() >= 4) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de miembros permitido (4).');
        }

        $numeroDeMiembros = $equipo->participantes()->count();
        $posiciones = [
            1 => 'Programador Front-end',
            2 => 'Programador Back-end',
            3 => 'Diseñador'
        ];

        $indice = $numeroDeMiembros; 
        $posicion = $posiciones[$indice] ?? 'Miembro';

        $equipo->participantes()->attach($usuario->id, [
            'posicion' => $posicion
        ]);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', "✅ ¡Te has unido al equipo exitosamente como {$posicion}!");
    }

    public function updateStatus(Request $request, Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$usuario->esAdministrador()) {
            abort(403, 'Solo los administradores pueden cambiar el estado del equipo.');
        }

        $request->validate([
            'estado' => 'required|in:en revisión,aprobado,rechazado'
        ]);

        $equipo->update(['estado' => $request->estado]);

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

    public function agregarParticipante(Request $request, Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para agregar participantes a este equipo.');
        }

        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'posicion' => 'required|string|max:255'
        ]);

        if ($equipo->tieneMiembro($validated['usuario_id'])) {
            return back()->with('error', '❌ Este usuario ya es miembro del equipo.');
        }

        if ($equipo->participantes()->count() >= 5) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de participantes permitido (5).');
        }

        $equipo->participantes()->attach($validated['usuario_id'], [
            'posicion' => $validated['posicion']
        ]);

        return back()->with('success', '✅ Participante agregado exitosamente.');
    }

    public function removerParticipante(Equipo $equipo, $usuarioId)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para remover participantes de este equipo.');
        }

        if (!$equipo->tieneMiembro($usuarioId)) {
            return back()->with('error', '❌ Este usuario no es miembro del equipo.');
        }

        $esLider = $equipo->participantes()
            ->where('usuario_id', $usuarioId)
            ->where('posicion', 'Líder')
            ->exists();

        if ($esLider && $equipo->participantes()->where('posicion', 'Líder')->count() <= 1) {
            return back()->with('error', '❌ No puedes eliminar al único líder del equipo.');
        }

        $equipo->participantes()->detach($usuarioId);

        return back()->with('success', '✅ Participante removido exitosamente.');
    }

    public function actualizarPosicion(Request $request, Equipo $equipo, $usuarioId)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$equipo->tieneMiembro($usuario->id) && !$usuario->esAdministrador()) {
            abort(403, 'No tienes permiso para actualizar posiciones en este equipo.');
        }

        $request->validate([
            'posicion' => 'required|string|max:255'
        ]);

        $equipo->participantes()->updateExistingPivot($usuarioId, [
            'posicion' => $request->posicion
        ]);

        return back()->with('success', '✅ Posición actualizada exitosamente.');
    }

    public function exportarCSV()
    {
        $usuario = Usuario::find(Auth::id());

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

    // ==========================================
    //      NUEVAS FUNCIONES PARA EL JUGADOR
    // ==========================================

    /**
     * Muestra la vista "Mis Equipos" para el jugador.
     */
    public function misEquipos()
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();

        // Obtenemos TODOS los equipos donde el usuario es participante
        $misEquipos = Equipo::whereHas('participantes', function($q) use ($user) {
            $q->where('usuario_id', $user->id);
        })->with(['participantes', 'evento'])->get();

        // Pasamos 'misEquipos' a la vista
        return view('player.equipos', compact('misEquipos', 'user'));
    }

    /**
     * Permite al usuario salir de su equipo.
     */
    public function salir(Request $request)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();

        // Obtener el equipo_id del request
        $equipoId = $request->input('equipo_id');
        
        // Si no viene en el request, buscar el primer equipo del usuario (compatibilidad)
        if (!$equipoId) {
            $equipo = Equipo::whereHas('participantes', function($q) use ($user) {
                $q->where('usuario_id', $user->id);
            })->first();
        } else {
            $equipo = Equipo::find($equipoId);
        }

        if ($equipo) {
            // Verificar si el usuario es el líder del equipo
            $esLider = $equipo->participantes()
                ->wherePivot('usuario_id', $user->id)
                ->wherePivot('posicion', 'Líder')
                ->exists();

            if ($esLider) {
                // Si es el líder, disolver el equipo completamente
                // Obtener todos los participantes (excepto el líder) para notificarles
                $otrosParticipantes = $equipo->participantes()
                    ->where('usuario_id', '!=', $user->id)
                    ->get();

                // Crear notificaciones para todos los demás miembros
                $nombreEquipo = $equipo->nombre;
                foreach ($otrosParticipantes as $participante) {
                    Notificacion::create([
                        'usuario_id' => $participante->id,
                        'titulo' => '⚠️ Equipo Disuelto',
                        'mensaje' => "El equipo '{$nombreEquipo}' ha sido disuelto por su líder. Se han removido todas las inscripciones a eventos.",
                        'tipo' => 'warning',
                        'leida' => false,
                    ]);
                }

                // Eliminar todas las relaciones de participantes
                $equipo->participantes()->detach();

                // Eliminar el equipo completamente
                $equipo->delete();

                return back()->with('success', '✨ El equipo ha sido disuelto. Se ha notificado a todos los miembros.');
            } else {
                // Si no es el líder, simplemente retirarse del equipo
                $equipo->participantes()->detach($user->id);
                
                return back()->with('success', 'Has salido del equipo correctamente.');
            }
        }

        return back()->with('error', 'No perteneces a este equipo.');
    }

    /**
     * Expulsar un miembro del equipo (solo para líderes)
     */
    public function expulsarMiembro(Request $request, Equipo $equipo, Usuario $usuario)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();

        // Verificar que el usuario logueado es el líder del equipo
        $esLider = $equipo->participantes()
            ->wherePivot('usuario_id', $user->id)
            ->wherePivot('posicion', 'Líder')
            ->exists();

        if (!$esLider) {
            return back()->with('error', 'Solo el líder puede expulsar miembros del equipo.');
        }

        // No permitir que el líder se expulse a sí mismo
        if ($usuario->id === $user->id) {
            return back()->with('error', 'No puedes expulsarte a ti mismo del equipo.');
        }

        // Verificar que el usuario a expulsar está en el equipo
        $esMiembro = $equipo->participantes()
            ->where('usuario_id', $usuario->id)
            ->exists();

        if (!$esMiembro) {
            return back()->with('error', 'Este usuario no es miembro del equipo.');
        }

        // Obtener la razón de expulsión
        $razon = $request->input('razon', 'Tu cuenta ha sido removida del equipo.');

        // Crear notificación de expulsión
        Notificacion::create([
            'usuario_id' => $usuario->id,
            'titulo' => '❌ Expulsado del Equipo',
            'mensaje' => "Has sido expulsado del equipo '{$equipo->nombre}'. Razón: {$razon}",
            'tipo' => 'error',
            'leida' => false,
        ]);

        // Expulsar al miembro
        $equipo->participantes()->detach($usuario->id);

        return back()->with('success', "El miembro {$usuario->nombre} ha sido expulsado del equipo.");
    }

    /**
     * Expulsa un miembro desde la vista mis-equipos
     */
    public function expulsarMiembroDesdeMyTeam(Request $request, Equipo $equipo, Usuario $usuario)
    {
        $userAutenticado = Auth::user();

        // Verificar que el usuario autenticado sea líder del equipo
        $esLider = $equipo->participantes()->wherePivot('usuario_id', $userAutenticado->id)->wherePivot('posicion', 'Líder')->exists();

        if (!$esLider) {
            return back()->with('error', 'No tienes permisos para expulsar miembros de este equipo.');
        }

        // Validar que el usuario a expulsar no sea el líder
        if ($usuario->id === $userAutenticado->id) {
            return back()->with('error', 'No puedes expulsarte a ti mismo.');
        }

        // Validar que el usuario sea miembro del equipo
        $esMiembro = $equipo->participantes()->where('usuario_id', $usuario->id)->exists();

        if (!$esMiembro) {
            return back()->with('error', 'Este usuario no es miembro del equipo.');
        }

        // Obtener la razón de expulsión
        $razon = $request->input('razon', 'Tu cuenta ha sido removida del equipo.');

        // Crear notificación de expulsión
        Notificacion::create([
            'usuario_id' => $usuario->id,
            'titulo' => '❌ Expulsado del Equipo',
            'mensaje' => "Has sido expulsado del equipo '{$equipo->nombre}'. Razón: {$razon}",
            'tipo' => 'error',
            'leida' => false,
        ]);

        // Expulsar al miembro
        $equipo->participantes()->detach($usuario->id);

        return back()->with('success', "El miembro {$usuario->nombre} ha sido expulsado del equipo.");
    }
}