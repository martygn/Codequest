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

// Rutas Públicas/Semi-públicas de Equipos (si se requiere acceso antes de login, dejarlas fuera del auth)
Route::get('/equipos/crear', [EquipoController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');

// --- GRUPO DE RUTAS PROTEGIDAS (Requiere Login) ---
Route::middleware(['auth'])->group(function () {

    // Dashboard General
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
    Route::get('/equipos/buscar', [EquipoController::class, 'index'])->name('equipos.buscar'); 

    // C. MIS EVENTOS (Usando EventoController)
    Route::get('/mis-eventos', [EventoController::class, 'misEventos'])->name('player.eventos');
    
    // Ruta auxiliar para ver eventos disponibles
    Route::get('/eventos/disponibles', [EventoController::class, 'disponibles'])->name('eventos.disponibles');

    // Unirse a un evento
    Route::post('/eventos/{evento}/unirse', [EventoController::class, 'unirse'])
        ->name('eventos.unirse');

    // Inscribir equipo a evento (GET para mostrar formulario/selección)
    Route::get('/eventos/{evento}/inscribir-equipo', [EventoController::class, 'inscribirEquipo'])
        ->name('eventos.inscribir-equipo');

    // Seleccionar equipo para evento (POST para procesar selección)
    Route::post('/eventos/{evento}/seleccionar-equipo', [EventoController::class, 'seleccionarEquipoParaEvento'])
        ->name('eventos.seleccionar-equipo');

    // Equipos
    Route::resource('equipos', EquipoController::class)->parameters([
        'equipos' => 'equipo:id_equipo'
    ]);

    // Ruta para unirse a un equipo
    Route::post('/equipos/{equipo}/unirse', [EquipoController::class, 'unirse'])
        ->name('equipos.unirse');

    // Gestión de participantes
    Route::post('/equipos/{equipo}/participantes', [EquipoController::class, 'agregarParticipante'])
        ->name('equipos.participantes.agregar');

    Route::delete('/equipos/{equipo}/participantes/{usuario}', [EquipoController::class, 'removerParticipante'])
        ->name('equipos.participantes.remover');

    // Solicitar unirse a equipo
    Route::post('/equipos/{equipo}/solicitar-unirse', [EquipoController::class, 'solicitarUnirse'])
        ->name('equipos.solicitar-unirse');

    // Líder acepta solicitud
    Route::post('/equipos/{equipo}/aceptar-solicitud/{usuario}', [EquipoController::class, 'aceptarSolicitudLider'])
        ->name('equipos.aceptar-solicitud-lider');

    // Líder rechaza solicitud
    Route::post('/equipos/{equipo}/rechazar-solicitud/{usuario}', [EquipoController::class, 'rechazarSolicitudLider'])
        ->name('equipos.rechazar-solicitud-lider');

    // Salir del equipo
    Route::post('/equipos/{equipo}/salir', [EquipoController::class, 'salir'])->name('equipos.salir');

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
        Route::get('/admin/eventos/crear', [AdminController::class, 'crearEvento'])->name('admin.eventos.create');
        Route::post('/admin/eventos', [AdminController::class, 'guardarEvento'])->name('admin.eventos.store');
        Route::get('/admin/eventos/{evento}/detalles', [AdminController::class, 'verEvento'])->name('admin.eventos.show');

        Route::get('/admin/equipos', [AdminController::class, 'equipos'])->name('admin.equipos');
        Route::get('/admin/equipos/crear', [AdminController::class, 'crearEquipo'])->name('admin.equipos.create');
        Route::post('/admin/equipos', [AdminController::class, 'guardarEquipo'])->name('admin.equipos.store');
        Route::get('/admin/equipos/{equipo}/detalles', [AdminController::class, 'verEquipo'])->name('admin.equipos.show');

        Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil');
        Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');

        // --- CONFIGURACIÓN ADMIN ---
        Route::put('/admin/configuracion/info', [AdminController::class, 'updateInfo'])->name('admin.updateInfo');
        Route::put('/admin/configuracion/password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

        // Acciones Rápidas y API Admin
        Route::get('/admin/api/equipos/stats', [DashboardController::class, 'equiposStats'])->name('admin.equipos.stats');
        Route::patch('/admin/eventos/{evento}/status', [AdminController::class, 'updateEventoStatus'])->name('admin.eventos.update-status');
        Route::patch('/equipos/{equipo}/status', [AdminController::class, 'updateEquipoStatus'])->name('equipos.update-status');

        // Vista simplificada de equipo para admin
        Route::get('/admin/equipos/{equipo}/info', [EquipoController::class, 'verInfoEquipo'])
            ->name('admin.equipos.info');
    });

    // ===============================================
    //      RUTAS DE PERFIL DE USUARIO
    // ===============================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mi-perfil', [UserProfileController::class, 'show'])->name('profile.custom');
});
