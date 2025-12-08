<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
        {
        $request->validate([
        'nombre' => ['required', 'string', 'max:100'],
        'apellido_paterno' => ['required', 'string', 'max:100'],
        'apellido_materno' => ['nullable', 'string', 'max:100'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,correo'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $usuario = Usuario::create([
        'nombre' => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno ?? '',
        'correo' => $request->email,
        'contrasena' => Hash::make($request->password),
        'tipo' => 'participante',
    ]);

        event(new Registered($usuario));

        // Loguear usando el modelo Usuario para que el provider 'users' (config/auth.php)
        // que apunta a App\Models\Usuario pueda recuperar al usuario en siguientes requests.
        Auth::login($usuario);

        return redirect(route('dashboard', absolute: false));
    }
}
