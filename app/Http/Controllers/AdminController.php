<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Evento;
use App\Models\Equipo;
use App\Models\Usuario; // Modelo de usuarios del sistema
use App\Models\CalificacionEquipo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // --- MÉTODOS DE VISTAS ---

    public function eventos()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }

        $status = request()->get('status', 'pendientes');
        $query = Evento::query();

        // Búsqueda por texto
        $search = request()->get('search');
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($status === 'pendientes') { $query->where('estado', 'pendiente'); } 
        elseif ($status === 'publicados') { $query->where('estado', 'publicado'); }

        $eventos = $query->orderBy('fecha_inicio', 'desc')->paginate(10)->withQueryString();
        return view('admin.eventos', compact('eventos', 'status', 'search'));
    }

    public function updateEventoStatus(Request $request, Evento $evento)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }
        
        $request->validate(['estado' => 'required|in:pendiente,publicado']);
        $evento->update(['estado' => $request->estado]);
        
        return back()->with('success', 'Estado del evento actualizado.');
    }

    public function equipos()
    {
    $usuario = auth()->user();
    if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
        abort(403, 'Acceso no autorizado.');
    }

    $query = \App\Models\Equipo::with('evento');

    // Búsqueda
    if ($search = request('search')) {
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('nombre_proyecto', 'like', "%{$search}%");
        });
    }

    // Filtro por estado
    if ($estado = request('estado')) {
        $query->where('estado', $estado);
    }

    $equipos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

    return view('admin.equipos', compact('equipos'));
    }

    public function perfil()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }
        return view('admin.perfil');
    }

    public function configuracion()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }
        return view('admin.configuracion');
    }

    public function resultados()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }

        // Obtener eventos con repositorios calificados
        $eventos = Evento::with(['repositorios' => function ($query) {
            $query->where('calificacion_total', '>', 0)->with('equipo');
        }])->get();

        $resultados = $eventos->map(function ($evento) {
            // Filtrar solo repositorios con calificación
            $repositoriosCalificados = $evento->repositorios->filter(function ($repo) {
                return $repo->calificacion_total > 0;
            });
            
            if ($repositoriosCalificados->isEmpty()) {
                return null;
            }

            // Crear ranking ordenado por calificación total
            $ranking = $repositoriosCalificados->map(function ($repositorio) {
                $detalles = json_decode($repositorio->calificacion_detalle, true) ?? [];
                return [
                    'equipo' => $repositorio->equipo,
                    'repositorio' => $repositorio,
                    'puntaje_total' => $repositorio->calificacion_total,
                    'detalles' => $detalles,
                    'calificado_en' => $detalles['calificado_en'] ?? null
                ];
            })->sortByDesc('puntaje_total');

            return [
                'evento' => $evento,
                'ranking' => $ranking
            ];
        })->filter();

        return view('admin.resultados_panel', compact('resultados'));
    }

    public function updateEquipoStatus(Request $request, Equipo $equipo)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }
        
        $request->validate(['estado' => 'required|in:en revisión,aprobado,rechazado']);
        $equipo->update(['estado' => $request->estado]);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Estado del equipo actualizado.');
    }
        /**
     * Mostrar detalles de un equipo específico
     */
    public function verEquipo(Equipo $equipo)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Cargar relaciones necesarias
        $equipo->load('evento', 'participantes');

        return view('admin.equipos.show', compact('equipo'));
    }

    /**
     * Mostrar detalles de un evento específico (panel admin).
     */
    public function verEvento(Evento $evento)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Cargar relaciones necesarias: equipos y sus participantes
        $evento->load('equipos.participantes');

        return view('admin.eventos.show', compact('evento'));
    }

    /**
     * Mostrar formulario de creación de evento (panel admin).
     */
    public function crearEvento()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Usar vista específica del panel admin
        return view('admin.eventos.create');
    }

    /**
     * Guardar evento creado desde panel admin.
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
            'estado' => 'nullable|in:pendiente,publicado',
        ]);

        if (empty($validated['estado'])) {
            $validated['estado'] = 'pendiente';
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('eventos', 'public');
        }

        Evento::create($validated);

        return redirect()->route('admin.eventos')->with('success', 'Evento creado exitosamente.');
    }

    // --- MÉTODOS DE ACTUALIZACIÓN DE PERFIL Y CONTRASEÑA ---

    /**
     * 1. Guardar Información Personal (Nombre y Correo).
     */
    public function updateInfo(Request $request)
    {
        $user = auth()->user();

        // 1. Validamos los 3 campos de nombre + el email
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo,' . $user->id],
        ]);

        // 2. Guardamos cada dato en su columna correcta de la BD
        $user->forceFill([
            'nombre' => $validated['nombre'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'correo' => $validated['email'], // El input 'email' va a la columna 'correo'
        ])->save();

        return back()->with('success', 'Información personal actualizada correctamente.');
    }
    /**
     * 2. Guardar Nueva Contraseña.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || !method_exists($user, 'esAdmin') || !$user->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Guardar la nueva contraseña. El modelo `Usuario` tiene un mutator
        // `setPasswordAttribute` que hace el hash, por eso aquí asignamos
        // la contraseña en texto plano y dejamos que el modelo la encripte.
        $user->password = $validated['password'];
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    // ------------------ JUECES (Admin) ------------------

    public function jueces()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }

        $jueces = Usuario::where('tipo', 'juez')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.jueces.index', compact('jueces'));
    }

    public function crearJuez()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }

        return view('admin.jueces.create');
    }

    public function guardarJuez(Request $request)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo'
        ]);

        $password = Str::random(10);

        $juez = new Usuario();
        $juez->nombre = $validated['nombre'];
        $juez->apellido_paterno = $validated['apellido_paterno'] ?? null;
        $juez->apellido_materno = $validated['apellido_materno'] ?? null;
        $juez->correo = $validated['correo'];
        $juez->password = $password; // el mutator del modelo hace el hash
        $juez->tipo = 'juez';
        $juez->save();

        try {
            Mail::send('emails.juez_credentials', ['juez' => $juez, 'password' => $password], function ($m) use ($juez) {
                $m->to($juez->correo, $juez->nombre_completo)->subject('Tus credenciales como Juez - CodeQuest');
            });
            $emailEnviado = true;
        } catch (\Exception $e) {
            $emailEnviado = false;
        }

        // Mostrar las credenciales en una vista de confirmación
        return view('admin.jueces.credentials', compact('juez', 'password', 'emailEnviado'));
    }

    /**
     * Mostrar formulario para asignar eventos a un juez
     */
    public function asignarEventosJuez(Usuario $juez)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Obtener todos los eventos
        $eventos = Evento::orderBy('nombre')->get();

        // Obtener eventos ya asignados al juez
        $eventosAsignados = $juez->eventosAsignados()->pluck('id_evento')->toArray();

        return view('admin.jueces.asignar', compact('juez', 'eventos', 'eventosAsignados'));
    }

    /**
     * Guardar asignación de eventos a un juez
     */
    public function guardarAsignacionEventosJuez(Request $request, Usuario $juez)
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'eventos' => 'array',
            'eventos.*' => 'exists:eventos,id_evento'
        ]);

        // Sincronizar eventos asignados (solo los seleccionados)
        $eventosIds = $validated['eventos'] ?? [];
        $juez->eventosAsignados()->sync($eventosIds);

        return redirect()->route('admin.jueces')->with('success', 'Eventos asignados al juez correctamente.');
    }
}
