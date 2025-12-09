<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class JuezController extends Controller
{
    /**
     * Panel principal del juez - Muestra el evento asignado y equipos a evaluar
     */
    public function panel(Request $request)
    {
        $juez = auth()->user();

        if (! $juez || ! method_exists($juez, 'esJuez') || ! $juez->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Obtener los eventos asignados al juez
        $eventosAsignados = $juez->eventosAsignados()->get();

        // Obtener evento desde el parámetro de query o usar el primero
        $eventoId = $request->query('evento');
        $evento = $eventosAsignados->firstWhere('id_evento', $eventoId) ?? $eventosAsignados->first();

        if ($evento) {
            // Obtener equipos del evento asignado con sus calificaciones (paginado)
            // La restricción de calificación se aplica en el frontend y en CalificacionController
            $equipos = Equipo::where('id_evento', $evento->id_evento)
                ->with('participantes', 'lider', 'calificaciones')
                ->orderBy('estado')
                ->orderBy('nombre')
                ->paginate(12)
                ->withQueryString();
        } else {
            // Paginator vacío cuando no hay evento
            $equipos = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
        }

        return view('juez.panel', compact('juez', 'evento', 'equipos', 'eventosAsignados'));
    }

    /**
     * Historial de constancias generadas por el juez
     */
    public function historialConstancias()
    {
        $juez = auth()->user();

        if (! $juez || ! method_exists($juez, 'esJuez') || ! $juez->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Aquí se cargarían las constancias generadas por este juez
        // Por ahora, devolvemos una lista vacía (se implementará con la BD de constancias)
        $constancias = [];

        return view('juez.constancias', compact('constancias', 'juez'));
    }

    /**
     * Mostrar la vista de configuración del juez
     */
    public function configuracion()
    {
        $juez = auth()->user();

        if (! $juez || ! method_exists($juez, 'esJuez') || ! $juez->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        return view('juez.configuracion');
    }

    /**
     * Actualizar información personal del juez
     */
    public function updateInfo(Request $request)
    {
        $user = auth()->user();

        if (! $user || ! method_exists($user, 'esJuez') || ! $user->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo,'.$user->id],
        ]);

        $user->forceFill([
            'nombre' => $validated['nombre'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'correo' => $validated['email'],
        ])->save();

        return back()->with('success', 'Información personal actualizada correctamente.');
    }

    /**
     * Actualizar contraseña del juez
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (! $user || ! method_exists($user, 'esJuez') || ! $user->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Actualizar directamente el campo contrasena con hash
        $user->contrasena = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $user->save();

        // Regenerar la sesión para evitar problemas de autenticación
        $request->session()->regenerate();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
