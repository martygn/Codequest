<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $search = request()->get('search', null);

        $query = \App\Models\Evento::query();

        // Filtrar por estado si aplica
        if ($status === 'pendientes') {
            $query->where('estado', 'pendiente');
        } elseif ($status === 'publicados') {
            $query->where('estado', 'publicado');
        }

        // Filtrar por búsqueda en nombre
        if (!empty($search)) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        // Usar paginación para la lista de admin
        $eventos = $query->orderBy('fecha_inicio', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.eventos', compact('eventos', 'status', 'search'));
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
}
