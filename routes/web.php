<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por autenticación
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

require __DIR__.'/auth.php';