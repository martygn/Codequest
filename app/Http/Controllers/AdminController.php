<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Evento;
use App\Models\Equipo;
use App\Models\User; // Asegúrate de importar tu modelo de usuario

class AdminController extends Controller
{
    // --- MÉTODOS DE VISTAS ---

    public function eventos()
    {
        $usuario = auth()->user();
        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) { abort(403, 'Acceso no autorizado.'); }

        $status = request()->get('status', 'pendientes');
        $query = Evento::query();

        if ($status === 'pendientes') { $query->where('estado', 'pendiente'); } 
        elseif ($status === 'publicados') { $query->where('estado', 'publicado'); }

        $eventos = $query->orderBy('fecha_inicio', 'desc')->paginate(10)->withQueryString();
        return view('admin.eventos', compact('eventos', 'status'));
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

        // IMPORTANTE: Usamos Hash::make para encriptar la contraseña antes de guardar.
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}