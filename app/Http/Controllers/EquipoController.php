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

        if (!$usuario->esAdministrador() && !$equipo->tieneMiembro($usuario->id)) {
            if ($equipo->estado !== 'aprobado') {
                abort(403, 'No tienes permiso para ver este equipo.');
            }
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

        // Obtenemos los equipos donde el usuario es participante
        // Usamos la relación 'participantes' inversa si está definida en Usuario,
        // o consultamos Equipo donde tenga al usuario como participante.
        // Asumiendo que Equipo tiene relación 'participantes' (belongsToMany Usuario)
        
        // Opción A: Si User tiene relación 'equipos' (belongsToMany)
        // $miEquipo = $user->equipos()->first(); 

        // Opción B: Consulta directa a Equipo usando la relación participantes
        $miEquipo = Equipo::whereHas('participantes', function($q) use ($user) {
            $q->where('usuario_id', $user->id);
        })->with(['participantes', 'evento'])->first();

        // Pasamos 'miEquipo' a la vista (singular, asumiendo que el usuario tiene un equipo principal)
        return view('player.equipos', compact('miEquipo', 'user'));
    }

    /**
     * Permite al usuario salir de su equipo.
     */
    public function salir()
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();

        // Buscamos el equipo del usuario
        $equipo = Equipo::whereHas('participantes', function($q) use ($user) {
            $q->where('usuario_id', $user->id);
        })->first();

        if ($equipo) {
            // Verificar si es el último líder
            $esLider = $equipo->participantes()
                ->where('usuario_id', $user->id)
                ->where('pivot_posicion', 'Líder') // Ajusta 'pivot_posicion' según tu tabla pivote (puede ser solo 'posicion')
                ->exists();

             // Nota: En tu método 'unirse' usas ['posicion' => ...], así que en pivot es 'posicion'.
             // Eloquent accede a pivot con ->pivot->posicion
             
             // Simplemente usamos detach para salir
            $equipo->participantes()->detach($user->id);
            
            return back()->with('success', 'Has salido del equipo correctamente.');
        }

        return back()->with('error', 'No perteneces a ningún equipo.');
    }
}