<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Controllers\Auth\SocialAuthController;

// Google OAuth
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Facebook OAuth
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])
    ->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Eventos
    Route::resource('eventos', EventoController::class)->parameters([
        'eventos' => 'evento:id_evento'
    ]);

    // Equipos
    Route::resource('equipos', EquipoController::class)->parameters([
        'equipos' => 'equipo:id_equipo'
    ]);

    // Rutas adicionales para equipos
    Route::post('/equipos/{equipo}/abandonar', [EquipoController::class, 'abandonar'])
        ->name('equipos.abandonar');

    Route::get('/equipos/{equipo}/subir-proyecto', [EquipoController::class, 'mostrarSubirProyecto'])
        ->name('equipos.subir-proyecto');

    Route::post('/equipos/{equipo}/subir-proyecto', [EquipoController::class, 'subirProyecto'])
        ->name('equipos.subir-proyecto.store');

    // Gestión de participantes en equipos
    Route::post('/equipos/{equipo}/participantes', [EquipoController::class, 'agregarParticipante'])
        ->name('equipos.participantes.agregar');
    Route::delete('/equipos/{equipo}/participantes/{usuario}', [EquipoController::class, 'removerParticipante'])
        ->name('equipos.participantes.remover');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    // Buscar usuario
    Route::get('/buscar-usuario', function (Request $request) {
    $request->validate([
        'correo' => 'required|email'
    ]);
    $usuario = Usuario::where('correo', $request->correo)->first();
    return response()->json([
        'existe' => $usuario !== null,
        'usuario' => $usuario ? [
            'id' => $usuario->id,
            'nombre_completo' => $usuario->nombre_completo,
            'correo' => $usuario->correo
        ] : null
    ]);
});

require __DIR__.'/auth.php';
