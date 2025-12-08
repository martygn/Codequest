<?php

namespace App\Http\Controllers;

use App\Models\Repositorio;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RepositorioController extends Controller
{
    /**
     * Mostrar formulario para subir/editar repositorio (para líder del equipo)
     */
    public function show(Equipo $equipo)
    {
        $usuario = Auth::user();

        // Verificar que sea líder del equipo
        if ($equipo->id_lider !== $usuario->id && !$usuario->esAdmin()) {
            abort(403, 'Solo el líder del equipo puede gestionar el repositorio.');
        }

        // Obtener o crear repositorio
        $repositorio = $equipo->repositorio;

        if (!$repositorio && $equipo->id_evento) {
            $repositorio = new Repositorio([
                'equipo_id' => $equipo->id_equipo,
                'evento_id' => $equipo->id_evento,
                'estado' => 'no_enviado'
            ]);
        }

        return view('repositorios.show', compact('equipo', 'repositorio'));
    }

    /**
     * Guardar/actualizar repositorio
     */
    public function store(Request $request, Equipo $equipo)
    {
        $usuario = Auth::user();

        // Verificar que sea líder del equipo
        if ($equipo->id_lider !== $usuario->id && !$usuario->esAdmin()) {
            abort(403, 'Solo el líder del equipo puede gestionar el repositorio.');
        }

        // Validar que el equipo esté inscrito en un evento
        if (!$equipo->id_evento) {
            return back()->with('error', '❌ El equipo debe estar inscrito en un evento para subir el repositorio.');
        }

        $validated = $request->validate([
            'url_github' => 'nullable|string|url',
            'url_gitlab' => 'nullable|string|url',
            'url_bitbucket' => 'nullable|string|url',
            'url_personalizado' => 'nullable|string|url',
            'archivo' => 'nullable|file|mimes:zip,rar,7z|max:102400',
            'rama_produccion' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string|max:1000'
        ]);

        // Validar que al menos un campo esté lleno
        if (!$validated['url_github'] && !$validated['url_gitlab'] && !$validated['url_bitbucket'] && 
            !$validated['url_personalizado'] && !$request->hasFile('archivo')) {
            return back()->with('error', '❌ Debes proporcionar al menos una URL o un archivo.');
        }

        // Obtener o crear repositorio
        $repositorio = $equipo->repositorio ?? new Repositorio([
            'equipo_id' => $equipo->id_equipo,
            'evento_id' => $equipo->id_evento
        ]);

        // Actualizar campos URL
        $repositorio->url_github = $validated['url_github'];
        $repositorio->url_gitlab = $validated['url_gitlab'];
        $repositorio->url_bitbucket = $validated['url_bitbucket'];
        $repositorio->url_personalizado = $validated['url_personalizado'];
        $repositorio->rama_produccion = $validated['rama_produccion'] ?? 'main';
        $repositorio->descripcion = $validated['descripcion'];

        // Manejar subida de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($repositorio->archivo_path) {
                Storage::disk('public')->delete($repositorio->archivo_path);
            }

            $archivo = $request->file('archivo');
            $ruta = $archivo->store('repositorios', 'public');
            $repositorio->archivo_path = $ruta;
            $repositorio->archivo_nombre = $archivo->getClientOriginalName();
            $repositorio->archivo_tamaño = $archivo->getSize() / 1024;
        }

        // Marcar como enviado
        $repositorio->marcarEnviado();

        return redirect()->route('equipos.show', $equipo->id_equipo)
            ->with('success', '✅ Repositorio enviado exitosamente. Espera la verificación del administrador.');
    }

    /**
     * Descargar archivo del repositorio (admin o equipo)
     */
    public function descargar(Repositorio $repositorio)
    {
        $usuario = Auth::user();

        // Verificar permisos
        if (!$usuario->esAdmin() && $repositorio->equipo->id_lider !== $usuario->id) {
            abort(403, 'No tienes permiso para descargar este archivo.');
        }

        if (!$repositorio->archivo_path) {
            return back()->with('error', '❌ No hay archivo para descargar.');
        }

        return Storage::disk('public')->download($repositorio->archivo_path, $repositorio->archivo_nombre);
    }

    /**
     * Eliminar repositorio (solo admin)
     */
    public function destroy(Repositorio $repositorio)
    {
        if (!Auth::user()->esAdmin()) {
            abort(403, 'Solo los administradores pueden eliminar repositorios.');
        }

        // Eliminar archivo si existe
        if ($repositorio->archivo_path) {
            Storage::disk('public')->delete($repositorio->archivo_path);
        }

        $equipoId = $repositorio->equipo_id;
        $repositorio->delete();

        return redirect()->route('equipos.show', $equipoId)
            ->with('success', '✅ Repositorio eliminado.');
    }

    /**
     * Verificar repositorio (solo admin)
     */
    public function verificar(Repositorio $repositorio)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo los administradores pueden verificar repositorios.');
        }

        $repositorio->marcarVerificado($usuario->id);

        return back()->with('success', '✅ Repositorio verificado exitosamente.');
    }

    /**
     * Rechazar repositorio (solo admin)
     */
    public function rechazar(Request $request, Repositorio $repositorio)
    {
        $usuario = Auth::user();

        if (!$usuario->esAdmin()) {
            abort(403, 'Solo los administradores pueden rechazar repositorios.');
        }

        $validated = $request->validate([
            'motivo' => 'required|string|max:500'
        ]);

        $repositorio->marcarRechazado();

        return back()->with('success', '✅ Repositorio rechazado. Se notificará al equipo.');
    }
}
