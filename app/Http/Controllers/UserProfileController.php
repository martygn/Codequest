<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        // Obtener el usuario logueado con sus equipos
        $user = Auth::user();
        $user->load('equipos'); // Cargar la relación de equipos

        // Obtener los eventos del usuario a través de sus equipos
        $eventos = $user->eventos()->get();

        // Retornar la vista pasando las variables
        return view('profile.custom-show', compact('user', 'eventos'));
    }
}