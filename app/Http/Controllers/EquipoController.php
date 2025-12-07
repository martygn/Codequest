<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\Equipo;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el usuario actual
    $usuario = Usuario::find(Auth::id());

    // Iniciar consulta con relaciones y conteo de participantes
    $query = Equipo::with('evento')
        ->withCount('participantes')
        ->orderBy('created_at', 'desc');

    // Solo mostrar equipos aprobados para usuarios normales
    if (!$usuario->esAdministrador()) {
        $query->where('aprobado', true);
    }

        // Filtros basados en las pestañas
        $filtro = $request->get('filtro', 'todos');

        switch ($filtro) {
            case 'mis_eventos':
                $query->whereHas('participantes', function ($q) use ($usuario) {
                    $q->where('usuario_id', $usuario->id);
                });
                break;

            case 'eventos_pasados':
                $query->whereHas('evento', function ($q) {
                    $q->where('fecha_fin', '<', now());
                });
                break;

            case 'todos':
            default:
                break;
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('nombre_proyecto', 'like', "%{$search}%");
            });
        }

        $equipos = $query->paginate(10);

        return view('equipos.index', compact('equipos', 'filtro'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No mostrar eventos en el formulario de creación
        return view('equipos.create');
    }

    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Validación de datos corregida
    $validated = $request->validate([
        'nombre' => 'required|string|max:255|unique:equipos',
        'nombre_proyecto' => 'required|string|max:255',
        'descripcion' => 'required|string|min:10',
        'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
    ]);

    // Establecer al creador como líder automáticamente
    $validated['id_lider'] = Auth::id();
    $validated['estado'] = 'en revisión';
    $validated['aprobado'] = false;

    // Manejar la carga del banner
    if ($request->hasFile('banner')) {
        $validated['banner'] = $request->file('banner')->store('equipos/banners', 'public');
    }

    // Crear el equipo
    try {
        $equipo = Equipo::create($validated);

        // Agregar al creador como participante (líder)
        $equipo->participantes()->attach(Auth::id(), ['posicion' => 'Líder']);

        \Log::info('Equipo creado exitosamente', [
            'equipo_id' => $equipo->id_equipo,
            'usuario_id' => Auth::id(),
            'nombre' => $equipo->nombre
        ]);

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', '🎉 ¡Equipo creado exitosamente! Tu equipo está ahora en revisión y será visible después de ser aprobado por un administrador.');

    } catch (\Exception $e) {
        \Log::error('Error al crear equipo', [
            'error' => $e->getMessage(),
            'usuario_id' => Auth::id(),
            'data' => $validated
        ]);

        return back()->with('error', '❌ Ocurrió un error al crear el equipo. Por favor, intenta nuevamente.')
                    ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        $equipo->load(['evento', 'participantes', 'lider']);

        // Obtener el usuario actual
        $usuario = Usuario::find(Auth::id());

        // Verificar permisos
        if (!$equipo->estaAprobado() && !$usuario->esAdministrador() && !$equipo->esLider($usuario->id)) {
            abort(403, 'Este equipo está en revisión.');
        }

        return view('equipos.show', compact('equipo'));
    }

    /**
     * Solicitar unirse a un equipo
     */
    public function solicitarUnirse(Equipo $equipo)
    {
        $usuario = Usuario::find(Auth::id());

        if (!$usuario || $usuario->tipo !== 'participante') {
            abort(403, 'Solo los participantes pueden unirse a equipos.');
        }

        // Verificar si ya es miembro
        if ($equipo->tieneMiembro($usuario->id)) {
            return back()->with('error', '❌ Ya eres miembro de este equipo.');
        }

        // Verificar si ya tiene solicitud pendiente
        if ($equipo->tieneSolicitudPendiente($usuario->id)) {
            return back()->with('error', '❌ Ya has enviado una solicitud para unirte a este equipo.');
        }

        // Verificar cupo disponible
        if (!$equipo->tieneCupoDisponible()) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de miembros permitido (4).');
        }

        // Verificar si el equipo está aprobado
        if (!$equipo->estaAprobado()) {
            return back()->with('error', '❌ Este equipo no está aprobado para recibir solicitudes.');
        }

        // Agregar solicitud
        $equipo->agregarSolicitud($usuario->id);

        return back()->with('success', '✅ Solicitud enviada. Espera a que el líder del equipo la acepte.');
    }

    /**
     * Salir/Abandonar equipo
     */
    public function salir(Equipo $equipo)
    {
        $usuario = Auth::user();

        // Verificar que el usuario sea miembro del equipo
        if (!$equipo->tieneMiembro($usuario->id)) {
            return back()->with('error', '❌ No eres miembro de este equipo.');
        }

        // Obtener todos los participantes ordenados por fecha de unión
        $participantes = $equipo->participantes()
            ->orderBy('participante_equipo.created_at')
            ->get();

        $totalMiembros = $participantes->count();
        $esLider = $equipo->esLider($usuario->id);

        // Caso 1: Si solo hay un miembro (el líder) y es el único
        if ($totalMiembros === 1 && $esLider) {
            // Eliminar el equipo completamente
            if ($equipo->banner && Storage::disk('public')->exists($equipo->banner)) {
                Storage::disk('public')->delete($equipo->banner);
            }

            $equipo->delete();

            return redirect()->route('equipos.index')
                ->with('success', '🗑️ El equipo ha sido eliminado porque eras el único miembro.');
        }

        // Caso 2: Si es el líder y hay más miembros
        if ($esLider) {
            // Encontrar al segundo miembro más antiguo (después del líder)
            $segundoMiembro = $participantes
                ->where('id', '!=', $usuario->id)
                ->first();

            if ($segundoMiembro) {
                // Asignar nuevo líder
                $equipo->id_lider = $segundoMiembro->id;
                $equipo->save();

                // Actualizar la posición del nuevo líder en la tabla pivote
                $equipo->participantes()->updateExistingPivot($segundoMiembro->id, [
                    'posicion' => 'Líder'
                ]);
            }
        }

        // Caso 3: Si es un miembro normal, reasignar posiciones
        if (!$esLider && $totalMiembros > 1) {
            // Obtener la posición del miembro que sale
            $miembroSaliente = $equipo->participantes()
                ->where('usuario_id', $usuario->id)
                ->first();

            $posicionSaliente = $miembroSaliente->pivot->posicion;

            // Si el que sale tiene una posición específica (no "Miembro")
            if (in_array($posicionSaliente, ['Programador Front-end', 'Programador Back-end', 'Diseñador'])) {
                // Obtener miembros que se unieron después del que sale
                $miembrosPosteriores = $equipo->participantes()
                    ->where('participante_equipo.created_at', '>', $miembroSaliente->pivot->created_at)
                    ->orderBy('participante_equipo.created_at')
                    ->get();

                // Si hay miembros posteriores, el primero toma la posición del que sale
                if ($miembrosPosteriores->isNotEmpty()) {
                    $siguienteMiembro = $miembrosPosteriores->first();
                    $equipo->participantes()->updateExistingPivot($siguienteMiembro->id, [
                        'posicion' => $posicionSaliente
                    ]);

                    // El resto mantiene sus posiciones
                }
            }
        }

        // Eliminar al usuario del equipo
        $equipo->participantes()->detach($usuario->id);

        $mensaje = $esLider ?
            '✅ Has abandonado el equipo como líder. El nuevo líder es ' . ($segundoMiembro->nombre_completo ?? 'no asignado') :
            '✅ Has salido del equipo.';

        return back()->with('success', $mensaje);
    }

    /**
     * Aceptar solicitud de unión
     */
    public function aceptarSolicitud(Equipo $equipo, Usuario $usuario)
    {
        // Verificar que el usuario actual sea el líder
        if (!Auth::user()->esAdministrador() && $equipo->id_lider != Auth::id()) {
            abort(403, 'Solo el líder del equipo puede aceptar solicitudes.');
        }

        // Verificar si la solicitud existe
        if (!$equipo->tieneSolicitudPendiente($usuario->id)) {
            return back()->with('error', '❌ No hay solicitud pendiente de este usuario.');
        }

        // Verificar cupo disponible
        if (!$equipo->tieneCupoDisponible()) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de miembros permitido (4).');
        }

        // Aceptar solicitud y agregar como participante
        $equipo->aceptarSolicitud($usuario->id);

        // Determinar posición automática
        $numeroMiembros = $equipo->participantes()->count();
        $posiciones = [
            1 => 'Programador Front-end',
            2 => 'Programador Back-end',
            3 => 'Diseñador'
        ];
        $posicion = $posiciones[$numeroMiembros] ?? 'Miembro';

        $equipo->participantes()->attach($usuario->id, ['posicion' => $posicion]);

        return back()->with('success', "✅ Solicitud aceptada. {$usuario->nombre} se ha unido al equipo como {$posicion}.");
    }

    /**
     * Rechazar solicitud de unión
     */
    public function rechazarSolicitud(Equipo $equipo, Usuario $usuario)
    {
        // Verificar que el usuario actual sea el líder
        if (!Auth::user()->esAdministrador() && $equipo->id_lider != Auth::id()) {
            abort(403, 'Solo el líder del equipo puede rechazar solicitudes.');
        }

        // Rechazar solicitud
        $equipo->rechazarSolicitud($usuario->id);

        return back()->with('success', '✅ Solicitud rechazada.');
    }

    /**
     * Agregar método para que el líder acepte solicitudes
     */
    public function aceptarSolicitudLider(Request $request, Equipo $equipo, Usuario $usuario)
    {
        // Verificar que el usuario actual sea el líder
        if ($equipo->id_lider != Auth::id()) {
            abort(403, 'Solo el líder del equipo puede aceptar solicitudes.');
        }

        // Verificar si la solicitud existe
        if (!$equipo->tieneSolicitudPendiente($usuario->id)) {
            return back()->with('error', '❌ No hay solicitud pendiente de este usuario.');
        }

        // Verificar cupo disponible
        if (!$equipo->tieneCupoDisponible()) {
            return back()->with('error', '❌ El equipo ya tiene el máximo de miembros permitido (4).');
        }

        // Aceptar solicitud
        $equipo->aceptarSolicitud($usuario->id);

        // Determinar posición automática
        $numeroMiembros = $equipo->participantes()->count();
        $posiciones = [
            1 => 'Programador Front-end',
            2 => 'Programador Back-end',
            3 => 'Diseñador'
        ];
        $posicion = $posiciones[$numeroMiembros] ?? 'Miembro';

        // Agregar como participante
        $equipo->participantes()->attach($usuario->id, ['posicion' => $posicion]);

        return back()->with('success', "✅ Solicitud aceptada. {$usuario->nombre} se ha unido al equipo como {$posicion}.");
    }

    /**
     * Agregar método para que el líder rechace solicitudes
     */
    public function rechazarSolicitudLider(Request $request, Equipo $equipo, Usuario $usuario)
    {
        // Verificar que el usuario actual sea el líder
        if ($equipo->id_lider != Auth::id()) {
            abort(403, 'Solo el líder del equipo puede rechazar solicitudes.');
        }

        // Rechazar solicitud
        $equipo->rechazarSolicitud($usuario->id);

        return back()->with('success', '✅ Solicitud rechazada.');
    }

    /**
     * Método para mostrar información simplificada del equipo (para admin)
     */
    public function verInfoEquipo(Equipo $equipo)
    {
        $usuario = auth()->user();

        if (!$usuario->esAdministrador()) {
            abort(403, 'Acceso no autorizado.');
        }

        $info = $equipo->getInfoParaAdmin();

        return view('admin.equipos.info', compact('info', 'equipo'));
    }

    /**
 * Aprobar equipo (admin)
 */
public function aprobar(Equipo $equipo)
{
    if (!Auth::user()->esAdministrador()) {
        abort(403, 'Solo los administradores pueden aprobar equipos.');
    }

    $equipo->aprobado = true;      // Esto debe ser true (1)
    $equipo->estado = 'aprobado';  // Esto debe ser 'aprobado'
    $equipo->save();

    return back()->with('success', '✅ Equipo aprobado exitosamente.');
}

    /**
     * Rechazar equipo (admin)
     */
    public function rechazar(Equipo $equipo)
{
    if (!Auth::user()->esAdministrador()) {
        abort(403, 'Solo los administradores pueden rechazar equipos.');
    }

    // Verificar si el equipo está en un evento activo
    if ($equipo->estaEnEventoActivo()) {
        return back()->with('error', '❌ No se puede rechazar un equipo que está en un evento activo.');
    }

    // Actualizar AMBOS campos
    $equipo->aprobado = false;
    $equipo->estado = 'rechazado';
    $equipo->save();

    return back()->with('success', '✅ Equipo rechazado.');
}

    /**
     * Asignar evento a equipo (admin)
     */
    public function asignarEvento(Request $request, Equipo $equipo)
    {
        if (!Auth::user()->esAdministrador()) {
            abort(403, 'Solo los administradores pueden asignar eventos.');
        }

        $request->validate([
            'id_evento' => 'required|exists:eventos,id_evento'
        ]);

        $equipo->update(['id_evento' => $request->id_evento]);

        return back()->with('success', '✅ Evento asignado al equipo exitosamente.');
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

        // Actualizar ambos campos según el estado
        $estado = $request->estado;
        $equipo->estado = $estado;
        $equipo->aprobado = ($estado === 'aprobado'); // true si es 'aprobado', false si no
        $equipo->save();

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
