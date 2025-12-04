<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        // Obtener el usuario logueado
        $user = Auth::user();

        // Retornar la vista pasando la variable $user
        return view('profile.custom-show', compact('user'));
    }
}