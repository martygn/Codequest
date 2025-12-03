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

        return view('admin.eventos');
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
