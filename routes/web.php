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
use App\Http\Controllers\NotificacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTAS PÚBLICAS / INICIALES ---

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Rutas de autenticación predeterminadas (Breeze)
require __DIR__.'/auth.php';

// Rutas de autenticación Social (Google/Facebook)
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// --- GRUPO DE RUTAS PROTEGIDAS (USUARIOS LOGUEADOS) ---
Route::middleware(['auth'])->group(function () {
    
    // 1. DASHBOARD GENERAL
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    //       NOTIFICACIONES
    // ==========================================
    Route::post('/notificaciones/{notificacion}/marcar-leida', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.marcar-todas-leidas');

    // ==========================================
    //       RUTAS DEL JUGADOR / USUARIO
    // ==========================================
    
    // A. MI PERFIL (Usando UserProfileController)
    Route::get('/mi-perfil', [UserProfileController::class, 'show'])->name('player.perfil');
    Route::put('/mi-perfil', [UserProfileController::class, 'update'])->name('player.perfil.update');

    // B. MIS EQUIPOS (Usando EquipoController)
    Route::get('/mis-equipos', [EquipoController::class, 'misEquipos'])->name('player.equipos');
    Route::post('/mis-equipos/salir', [EquipoController::class, 'salir'])->name('player.equipos.salir');
    Route::post('/mis-equipos/{equipo}/expulsar/{usuario}', [EquipoController::class, 'expulsarMiembroDesdeMyTeam'])->name('player.equipos.expulsar');
    Route::post('/equipos/{equipo}/expulsar/{usuario}', [EquipoController::class, 'expulsarMiembro'])->name('equipos.expulsar-miembro');
    
    // Ruta auxiliar para buscar equipos
    Route::get('/equipos/buscar', [EquipoController::class, 'index'])->name('equipos.index'); 

    // C. MIS EVENTOS (Usando EventoController)
    Route::get('/mis-eventos', [EventoController::class, 'misEventos'])->name('player.eventos');
    
    // Ruta auxiliar para ver eventos disponibles
    Route::get('/eventos/disponibles', [EventoController::class, 'index'])->name('eventos.index');

    // ==========================================
    //       RUTAS DE RECURSOS (CRUDs)
    // ==========================================

    // Eventos y Equipos (Operaciones estándar)
    Route::resource('eventos', EventoController::class)->parameters(['eventos' => 'evento:id_evento']);
    Route::resource('equipos', EquipoController::class)->parameters(['equipos' => 'equipo:id_equipo']);

    // Acciones específicas de Eventos
    Route::post('/eventos/{evento}/unirse', [EventoController::class, 'unirse'])->name('eventos.unirse');

    // Acciones específicas de Equipos
    Route::post('/equipos/{equipo}/unirse', [EquipoController::class, 'unirse'])->name('equipos.unirse');
    Route::post('/equipos/{equipo}/participantes', [EquipoController::class, 'agregarParticipante'])->name('equipos.participantes.agregar');
    Route::delete('/equipos/{equipo}/participantes/{usuario}', [EquipoController::class, 'removerParticipante'])->name('equipos.participantes.remover');

    // Perfil estándar de Laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ==========================================
    //          RUTAS DE ADMINISTRADOR
    // ==========================================
    Route::middleware(['is.admin'])->group(function () {
        
        // Vistas principales Admin
        Route::get('/admin/eventos', [AdminController::class, 'eventos'])->name('admin.eventos');
        Route::get('/admin/equipos', [AdminController::class, 'equipos'])->name('admin.equipos');
        Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil');
        
        // --- CONFIGURACIÓN ADMIN (CORREGIDO AQUI) ---
        // 1. Vista del formulario
        Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
        
        // 2. Ruta para actualizar Info (Nombre/Email)
        // CAMBIO: Nombre ajustado para coincidir con el formulario blade (admin.updateInfo)
        Route::put('/admin/configuracion/info', [AdminController::class, 'updateInfo'])->name('admin.updateInfo');
        
        // 3. Ruta para cambiar Contraseña
        // CAMBIO: Nombre ajustado para coincidir con el formulario blade (admin.updatePassword)
        Route::put('/admin/configuracion/password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

        // Acciones Rápidas y API Admin
        Route::get('/admin/api/equipos/stats', [DashboardController::class, 'equiposStats'])->name('admin.equipos.stats');
        Route::patch('/admin/eventos/{evento}/status', [AdminController::class, 'updateEventoStatus'])->name('admin.eventos.update-status');
        Route::patch('/equipos/{equipo}/status', [AdminController::class, 'updateEquipoStatus'])->name('equipos.update-status');
        
        // CRUDs específicos Admin (Crear Eventos/Equipos desde admin)
        Route::get('/admin/eventos/crear', [AdminController::class, 'crearEvento'])->name('admin.eventos.create');
        Route::post('/admin/eventos', [AdminController::class, 'guardarEvento'])->name('admin.eventos.store');
        Route::get('/admin/eventos/{evento}/detalles', [AdminController::class, 'verEvento'])->name('admin.eventos.show');
        
        Route::get('/admin/equipos/crear', [AdminController::class, 'crearEquipo'])->name('admin.equipos.create');
        Route::post('/admin/equipos', [AdminController::class, 'guardarEquipo'])->name('admin.equipos.store');
        Route::get('/admin/equipos/{equipo}/detalles', [AdminController::class, 'verEquipo'])->name('admin.equipos.show');
    });
});