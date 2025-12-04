<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
Route::get('/equipos/crear', [EquipoController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');

// Rutas de autenticación OAuth (Google y Facebook)
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])
    ->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// Incluir rutas de autenticación (Laravel Breeze / Auth)
require __DIR__.'/auth.php';

// --- INICIO DEL GRUPO DE RUTAS PROTEGIDAS ---
Route::middleware(['auth.usuario'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes (requieren además ser admin)
    Route::get('/admin/eventos', [AdminController::class, 'eventos'])->name('admin.eventos')->middleware('is.admin');
    Route::get('/admin/equipos', [AdminController::class, 'equipos'])->name('admin.equipos')->middleware('is.admin');
    Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil')->middleware('is.admin');
    Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion')->middleware('is.admin');

    // Endpoint para estadísticas de equipos (usado por el panel admin)
    Route::get('/admin/api/equipos/stats', [DashboardController::class, 'equiposStats'])
        ->name('admin.equipos.stats')
        ->middleware('is.admin');

    // Ruta para actualizar estado de un evento desde el panel admin
    Route::patch('/admin/eventos/{evento}/status', [AdminController::class, 'updateEventoStatus'])
        ->name('admin.eventos.update-status')
        ->middleware('is.admin');

    // Eventos
    Route::resource('eventos', EventoController::class)->parameters([
        'eventos' => 'evento:id_evento'
    ]);

    // Equipos
    Route::resource('equipos', EquipoController::class)->parameters([
        'equipos' => 'equipo:id_equipo'
    ]);

    // Ruta para unirse a un equipo
    Route::post('/equipos/{equipo}/unirse', [EquipoController::class, 'unirse'])
        ->name('equipos.unirse');

    // Ruta para actualizar estado del equipo
    Route::patch('/equipos/{equipo}/status', [EquipoController::class, 'updateStatus'])
        ->name('equipos.update-status');

    // Gestión de participantes
    Route::post('/equipos/{equipo}/participantes', [EquipoController::class, 'agregarParticipante'])
        ->name('equipos.participantes.agregar');
        
    Route::delete('/equipos/{equipo}/participantes/{usuario}', [EquipoController::class, 'removerParticipante'])
        ->name('equipos.participantes.remover');
});

// Grupo de rutas que requieren iniciar sesión
Route::middleware('auth')->group(function () {
    // --- Rutas por defecto de Laravel (Editar cuenta, borrar, cambiar pass) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- El perfil estilo Dashboard/Minecraft ---
    // --- Tu nueva ruta de perfil ---
    Route::get('/mi-perfil', [UserProfileController::class, 'show'])->name('profile.custom');
});