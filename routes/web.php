<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirección inicial
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Rutas de autenticación (Breeze/Default)
require __DIR__.'/auth.php';

// Rutas de autenticación OAuth (Social)
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// Rutas Públicas/Semi-públicas de Equipos (si se requiere acceso antes de login, dejarlas fuera del auth)
Route::get('/equipos/crear', [EquipoController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');

// --- GRUPO DE RUTAS PROTEGIDAS (Requiere Login) ---
// Nota: Usamos 'auth' estándar. Si tu middleware personalizado se llama 'auth.usuario', cámbialo aquí.
Route::middleware(['auth'])->group(function () {
    
    // Dashboard General
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de Usuario (Estándar + Custom)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mi-perfil', [UserProfileController::class, 'show'])->name('profile.custom');

    // Recursos Eventos y Equipos
    Route::resource('eventos', EventoController::class)->parameters(['eventos' => 'evento:id_evento']);
    Route::resource('equipos', EquipoController::class)->parameters(['equipos' => 'equipo:id_equipo']);

    // Funciones específicas de equipos
    Route::post('/equipos/{equipo}/unirse', [EquipoController::class, 'unirse'])->name('equipos.unirse');
    Route::post('/equipos/{equipo}/participantes', [EquipoController::class, 'agregarParticipante'])->name('equipos.participantes.agregar');
    Route::delete('/equipos/{equipo}/participantes/{usuario}', [EquipoController::class, 'removerParticipante'])->name('equipos.participantes.remover');

    // ===============================================
    //      RUTAS DE ADMINISTRADOR
    // ===============================================
    Route::middleware(['is.admin'])->group(function () {
        
        // Vistas principales Admin
        Route::get('/admin/eventos', [AdminController::class, 'eventos'])->name('admin.eventos');
        Route::get('/admin/equipos', [AdminController::class, 'equipos'])->name('admin.equipos');
        Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil');
        
        // --- CONFIGURACIÓN ADMIN ---
        // 1. Vista del formulario
        Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
        
        // 2. Ruta para actualizar Info (Nombre/Email) - IMPORTANTE: Coincide con el HTML
        Route::put('/admin/configuracion/info', [AdminController::class, 'updateInfo'])->name('admin.updateInfo');
        
        // 3. Ruta para cambiar Contraseña - IMPORTANTE: Coincide con el HTML
        Route::put('/admin/configuracion/password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

        // Acciones Rápidas y API Admin
        Route::get('/admin/api/equipos/stats', [DashboardController::class, 'equiposStats'])->name('admin.equipos.stats');
        Route::patch('/admin/eventos/{evento}/status', [AdminController::class, 'updateEventoStatus'])->name('admin.eventos.update-status');
        Route::patch('/equipos/{equipo}/status', [AdminController::class, 'updateEquipoStatus'])->name('equipos.update-status');
    });
});