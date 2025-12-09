<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Obtener notificaciones del usuario autenticado
     */
    public function index()
    {
        $usuario = Auth::user();

        $notificaciones = Notificacion::where('usuario_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('notificaciones.index', compact('notificaciones'));
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarLeida(Notificacion $notificacion)
    {
        // Verificar que la notificación pertenece al usuario autenticado
        if ($notificacion->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para modificar esta notificación.');
        }

        $notificacion->update(['leida' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasLeidas()
    {
        Auth::user()->notificaciones()->update(['leida' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Obtener notificaciones no leídas (para el contador en tiempo real)
     */
    public function noLeidas()
    {
        $usuario = Auth::user();

        $notificaciones = Notificacion::where('usuario_id', $usuario->id)
            ->noLeidas()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'notificaciones' => $notificaciones,
            'total' => Notificacion::where('usuario_id', $usuario->id)->noLeidas()->count()
        ]);
    }

    /**
     * Eliminar una notificación
     */
    public function eliminar(Notificacion $notificacion)
    {
        $usuario = Auth::user();

        // Verificar que la notificación pertenece al usuario
        if ($notificacion->usuario_id !== $usuario->id) {
            abort(403, 'No tienes permiso para eliminar esta notificación.');
        }

        $notificacion->delete();

        return back()->with('success', 'Notificación eliminada correctamente.');
    }
}
