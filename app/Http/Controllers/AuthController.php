<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('correo', $request->email)->first();

        // Si no existe, mostrar error
        if (!$usuario) {
            return back()->withErrors([
                'email' => 'El correo no está registrado.',
            ])->withInput();
        }

        // Verificar contraseña de manera flexible
        $passwordValido = false;

        // Contraseña hasheada
        if (Hash::check($request->password, $usuario->contrasena)) {
            $passwordValido = true;
        }
        // Contraseña en texto plano
        elseif ($usuario->contrasena === $request->password) {
            $passwordValido = true;
            // Hashear la contraseña
            $usuario->contrasena = Hash::make($request->password);
            $usuario->save();
        }

        if (!$passwordValido) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ])->withInput();
        }

        // Guardar usuario en sesión manualmente
        $request->session()->put('usuario', $usuario);
        $request->session()->put('usuario_id', $usuario->id);

        // Usar Auth de Laravel por compatibilidad
        Auth::login($usuario);

        // Redirigir al dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        // Limpiar sesión manual
        $request->session()->forget('usuario');
        $request->session()->forget('usuario_id');

        // Cerrar sesión de Laravel
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Verificar si hay usuario autenticado
     */
    public static function check()
    {
        // Verificar tanto la sesión manual como Auth
        if (session()->has('usuario')) {
            return true;
        }
        return Auth::check();
    }

    /**
     * Obtener usuario autenticado
     */
    public static function user()
    {
        // Obtener de sesión manual primero
        if (session()->has('usuario')) {
            return session('usuario');
        }
        return Auth::user();
    }
}
