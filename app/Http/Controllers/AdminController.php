<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Actualizar el estado de un evento (acción rápida desde el panel admin).
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
     * Mostrar la vista de gestión de equipos para administradores.
     */
    public function equipos()
    {
        $usuario = auth()->user();

        if (!$usuario || !method_exists($usuario, 'esAdmin') || !$usuario->esAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        return view('admin.equipos');
    }

    /**
     * Mostrar la vista de perfil del administrador.
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
     * Mostrar la vista de configuración del administrador.
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
     * Actualizar el estado de un equipo (acción rápida desde el panel admin).
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
}
