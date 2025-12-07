<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Usamos 'User' ya que es el nombre de tu clase Modelo (aunque la tabla sea 'usuarios')

class UserProfileController extends Controller
{
    /**
     * Muestra la vista de "Mi Perfil".
     */
    public function show()
    {
        $user = Auth::user();
        return view('player.perfil', compact('user'));
    }

    /**
     * Actualiza la información del perfil (Nombres separados y Correo).
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // 1. Validamos los campos que vienen del formulario nuevo
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            // Validamos 'email' verificando que sea único en la tabla 'usuarios' columna 'correo'
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,correo,'.$user->id],
        ]);

        // 2. Guardamos mapeando los inputs a las columnas reales de la BD
        $user->forceFill([
            'nombre' => $validated['nombre'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'correo' => $validated['email'], // Input 'email' va a columna 'correo'
        ])->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}