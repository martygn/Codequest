<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Separar el nombre en partes
            $nombreCompleto = explode(' ', $googleUser->name);
            $nombre = $nombreCompleto[0] ?? '';
            $apellidoPaterno = $nombreCompleto[1] ?? '';
            $apellidoMaterno = $nombreCompleto[2] ?? '';

            $usuario = Usuario::updateOrCreate(
                ['correo' => $googleUser->email],
                [
                    'nombre' => $nombre,
                    'apellido_paterno' => $apellidoPaterno,
                    'apellido_materno' => $apellidoMaterno,
                    'contrasena' => Hash::make(Str::random(24)),
                    'tipo' => 'participante',
                ]
            );

            Auth::login($usuario);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión con Google: ' . $e->getMessage());
        }
    }

    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Separar el nombre en partes
            $nombreCompleto = explode(' ', $facebookUser->name);
            $nombre = $nombreCompleto[0] ?? '';
            $apellidoPaterno = $nombreCompleto[1] ?? '';
            $apellidoMaterno = $nombreCompleto[2] ?? '';

            $usuario = Usuario::updateOrCreate(
                ['correo' => $facebookUser->email],
                [
                    'nombre' => $nombre,
                    'apellido_paterno' => $apellidoPaterno,
                    'apellido_materno' => $apellidoMaterno,
                    'contrasena' => Hash::make(Str::random(24)),
                    'tipo' => 'participante',
                ]
            );

            Auth::login($usuario);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión con Facebook: ' . $e->getMessage());
        }
    }
}