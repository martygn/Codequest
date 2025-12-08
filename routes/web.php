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
use App\Http\Controllers\JuezController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\RepositorioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ResultadoController;

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

// Rutas de autenticación Social
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// Rutas Públicas de Equipos
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
    
    // 1. MI PERFIL (Corrección: Nombre correcto 'player.perfil')
    Route::get('/mi-perfil', [UserProfileController::class, 'show'])->name('player.perfil');
    Route::put('/mi-perfil', [UserProfileController::class, 'update'])->name('player.perfil.update');

    // 2. MIS EQUIPOS
    Route::get('/mis-equipos', [EquipoController::class, 'misEquipos'])->name('player.equipos');
    // Corrección: Usamos 'abandonarEquipo' para evitar conflictos en el controlador
    Route::post('/mis-equipos/salir', [EquipoController::class, 'abandonarEquipo'])->name('player.equipos.salir');
    Route::post('/mis-equipos/{equipo}/expulsar/{usuario}', [EquipoController::class, 'expulsarMiembroDesdeMyTeam'])->name('player.equipos.expulsar');
    
    // 3. MIS EVENTOS
    Route::get('/mis-eventos', [EventoController::class, 'misEventos'])->name('player.eventos');
    Route::get('/eventos/disponibles', [EventoController::class, 'disponibles'])->name('eventos.disponibles');

    // ==========================================
    //       GESTIÓN DE EVENTOS (Resource)
    // ==========================================
    // Esta línea crea automáticamente 'eventos.index'
    Route::resource('eventos', EventoController::class);

    // Rutas extra de eventos
    Route::post('/eventos/{evento}/unirse', [EventoController::class, 'unirse'])->name('eventos.unirse');
    Route::get('/eventos/{evento}/inscribir-equipo', [EventoController::class, 'inscribirEquipo'])->name('eventos.inscribir-equipo');
    Route::post('/eventos/{evento}/seleccionar-equipo', [EventoController::class, 'seleccionarEquipoParaEvento'])->name('eventos.seleccionar-equipo');

    // ==========================================
    //       GESTIÓN DE EQUIPOS (Resource)
    // ==========================================
    Route::get('/equipos/buscar', [EquipoController::class, 'index'])->name('equipos.buscar'); 
    
    Route::resource('equipos', EquipoController::class)->parameters([
        'equipos' => 'equipo:id_equipo'
    ]);

    // Rutas extra de equipos
    Route::post('/equipos/{equipo}/unirse', [EquipoController::class, 'unirse'])->name('equipos.unirse');
    Route::post('/equipos/{equipo}/participantes', [EquipoController::class, 'agregarParticipante'])->name('equipos.participantes.agregar');
    Route::delete('/equipos/{equipo}/participantes/{usuario}', [EquipoController::class, 'removerParticipante'])->name('equipos.participantes.remover');
    Route::post('/equipos/{equipo}/expulsar/{usuario}', [EquipoController::class, 'expulsarMiembro'])->name('equipos.expulsar-miembro');
    
    Route::post('/equipos/{equipo}/solicitar-unirse', [EquipoController::class, 'solicitarUnirse'])->name('equipos.solicitar-unirse');
    Route::post('/equipos/{equipo}/aceptar-solicitud/{usuario}', [EquipoController::class, 'aceptarSolicitudLider'])->name('equipos.aceptar-solicitud-lider');
    Route::post('/equipos/{equipo}/rechazar-solicitud/{usuario}', [EquipoController::class, 'rechazarSolicitudLider'])->name('equipos.rechazar-solicitud-lider');
    Route::post('/equipos/{equipo}/salir', [EquipoController::class, 'salir'])->name('equipos.salir');
    // Ruta para que el líder desasocie el equipo del evento (Mis Eventos -> Salir del evento)
    Route::post('/equipos/{equipo}/quitar-evento', [EquipoController::class, 'quitarEvento'])->name('equipos.quitar-evento');

    // ==========================================
    //    REPOSITORIOS & CALIFICACIONES
    // ==========================================
    // Repositorios (Líder del equipo)
    Route::get('/equipos/{equipo}/repositorio', [RepositorioController::class, 'show'])->name('repositorios.show');
    Route::post('/equipos/{equipo}/repositorio', [RepositorioController::class, 'store'])->name('repositorios.store');
    Route::post('/repositorios/{repositorio}/descargar', [RepositorioController::class, 'descargar'])->name('repositorios.descargar');
    
    // Calificaciones (Juez)
    Route::get('/equipos/{equipo}/calificar', [CalificacionController::class, 'show'])->name('calificaciones.show');
    Route::post('/equipos/{equipo}/calificar', [CalificacionController::class, 'store'])->name('calificaciones.store');
    Route::post('/calificaciones/{calificacion}', [CalificacionController::class, 'update'])->name('calificaciones.update');
    Route::get('/eventos/{evento}/calificaciones', [CalificacionController::class, 'listar'])->name('calificaciones.listar');
    Route::get('/eventos/{evento}/ranking', [CalificacionController::class, 'ranking'])->name('calificaciones.ranking');

    // ==========================================
    //      PERFIL DE LARAVEL (Breeze)
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ==========================================
    //          RUTAS DE ADMINISTRADOR
    // ==========================================
    Route::middleware(['is.admin'])->group(function () {
        Route::get('/admin/eventos', [AdminController::class, 'eventos'])->name('admin.eventos');
        Route::get('/admin/eventos/crear', [AdminController::class, 'crearEvento'])->name('admin.eventos.create');
        Route::post('/admin/eventos', [AdminController::class, 'guardarEvento'])->name('admin.eventos.store');
        Route::get('/admin/eventos/{evento}/detalles', [AdminController::class, 'verEvento'])->name('admin.eventos.show');

        Route::get('/admin/equipos', [AdminController::class, 'equipos'])->name('admin.equipos');
        Route::get('/admin/equipos/crear', [AdminController::class, 'crearEquipo'])->name('admin.equipos.create');
        Route::post('/admin/equipos', [AdminController::class, 'guardarEquipo'])->name('admin.equipos.store');
        Route::get('/admin/equipos/{equipo}/detalles', [AdminController::class, 'verEquipo'])->name('admin.equipos.show');
        Route::get('/admin/equipos/{equipo}/info', [EquipoController::class, 'verInfoEquipo'])->name('admin.equipos.info');

        Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil');
        Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
        Route::get('/admin/resultados-panel', [AdminController::class, 'resultados'])->name('admin.resultados-panel');

        Route::put('/admin/configuracion/info', [AdminController::class, 'updateInfo'])->name('admin.updateInfo');
        Route::put('/admin/configuracion/password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

        Route::get('/admin/api/equipos/stats', [DashboardController::class, 'equiposStats'])->name('admin.equipos.stats');
        Route::patch('/admin/eventos/{evento}/status', [AdminController::class, 'updateEventoStatus'])->name('admin.eventos.update-status');
        Route::patch('/equipos/{equipo}/status', [AdminController::class, 'updateEquipoStatus'])->name('equipos.update-status');
        
        // Jueces (Admin)
        Route::get('/admin/jueces', [AdminController::class, 'jueces'])->name('admin.jueces');
        Route::get('/admin/jueces/crear', [AdminController::class, 'crearJuez'])->name('admin.jueces.create');
        Route::post('/admin/jueces', [AdminController::class, 'guardarJuez'])->name('admin.jueces.store');
        Route::get('/admin/jueces/{juez}/asignar-eventos', [AdminController::class, 'asignarEventosJuez'])->name('admin.jueces.asignar-eventos');
        Route::post('/admin/jueces/{juez}/guardar-asignacion', [AdminController::class, 'guardarAsignacionEventosJuez'])->name('admin.jueces.guardar-asignacion');

        // Repositorios & Calificaciones (Admin)
        Route::post('/repositorios/{repositorio}/verificar', [RepositorioController::class, 'verificar'])->name('repositorios.verificar');
        Route::post('/repositorios/{repositorio}/rechazar', [RepositorioController::class, 'rechazar'])->name('repositorios.rechazar');
        Route::delete('/repositorios/{repositorio}', [RepositorioController::class, 'destroy'])->name('repositorios.destroy');
        Route::delete('/calificaciones/{calificacion}', [CalificacionController::class, 'destroy'])->name('calificaciones.destroy');

        // Resultados (Admin)
        Route::get('/admin/resultados', [ResultadoController::class, 'index'])->name('admin.resultados.index');
        Route::get('/admin/eventos/{evento}/resultados', [ResultadoController::class, 'show'])->name('admin.resultados.show');
        Route::post('/admin/eventos/{evento}/marcar-ganador', [ResultadoController::class, 'marcarGanador'])->name('admin.resultados.marcar-ganador');
        Route::get('/admin/eventos/{evento}/exportar-resultados', [ResultadoController::class, 'exportarPDF'])->name('admin.resultados.exportar');
        Route::get('/admin/eventos/{evento}/constancia', [ResultadoController::class, 'generarConstancia'])->name('admin.resultados.constancia');
    });

    // ==========================================
    //          RUTAS DE JUEZ
    // ==========================================
    Route::middleware(['is.juez'])->group(function () {
        Route::get('/juez/panel', [JuezController::class, 'panel'])->name('juez.panel');
        Route::get('/juez/constancias', [JuezController::class, 'historialConstancias'])->name('juez.constancias');
    });
});