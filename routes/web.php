<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController; // <-- 1. IMPORTANTE: Importamos tu nuevo controlador
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas que requieren iniciar sesión
Route::middleware('auth')->group(function () {
    // --- Rutas por defecto de Laravel (Editar cuenta, borrar, cambiar pass) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 2. TU NUEVA RUTA (El perfil estilo Dashboard/Minecraft) ---
    Route::get('/mi-perfil', [UserProfileController::class, 'show'])->name('profile.custom');
});

require __DIR__.'/auth.php';
