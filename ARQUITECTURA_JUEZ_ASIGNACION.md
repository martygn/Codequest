/**
 * ===================================================================
 * SISTEMA DE JUECES - FLUJO DE ASIGNACIÓN DE EVENTOS
 * ===================================================================
 * 
 * Este archivo documenta el flujo completo de asignación de eventos
 * a jueces en la aplicación CodeQuest.
 * 
 * ===================================================================
 * COMPONENTES IMPLEMENTADOS
 * ===================================================================
 */

// 1. BASE DE DATOS
// ───────────────────────────────────────────────────────────────

ALTER TABLE usuarios MODIFY tipo ENUM(
    'administrador',
    'participante', 
    'juez'  ← NUEVO
);

CREATE TABLE juez_evento (
    id PRIMARY KEY AUTO_INCREMENT,
    usuario_id BIGINT UNSIGNED NOT NULL FOREIGN KEY,
    evento_id BIGINT UNSIGNED NOT NULL FOREIGN KEY (eventos.id_evento),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY uk_juez_evento (usuario_id, evento_id)
);


// 2. MODELOS - RELACIONES (Eloquent)
// ───────────────────────────────────────────────────────────────

class Usuario extends Authenticatable {
    
    public function esJuez(): bool {
        return $this->tipo === 'juez';
    }
    
    public function eventosAsignados(): BelongsToMany {
        return $this->belongsToMany(
            Evento::class,
            'juez_evento',
            'usuario_id',
            'evento_id',
            'id',
            'id_evento'
        )->withTimestamps();
    }
}

class Evento extends Model {
    
    public function jueces(): BelongsToMany {
        return $this->belongsToMany(
            Usuario::class,
            'juez_evento',
            'evento_id',
            'usuario_id',
            'id_evento',
            'id'
        )->withTimestamps();
    }
}


// 3. CONTROLADOR - LÓGICA DE ASIGNACIÓN
// ───────────────────────────────────────────────────────────────

class AdminController extends Controller {
    
    /**
     * PASO 1: Mostrar formulario de asignación
     * GET /admin/jueces/{juez}/asignar-eventos
     */
    public function asignarEventosJuez(Usuario $juez) {
        // Validar que sea admin
        abort_if(!auth()->user()->esAdmin(), 403);
        
        // Obtener todos los eventos disponibles
        $eventos = Evento::orderBy('nombre')->get();
        
        // Obtener eventos ya asignados a este juez
        $eventosAsignados = $juez
            ->eventosAsignados()
            ->pluck('id_evento')      // [1, 3, 5]
            ->toArray();
        
        // Pasar a vista para renderizar checkboxes
        return view('admin.jueces.asignar', compact(
            'juez',
            'eventos',
            'eventosAsignados'
        ));
    }
    
    /**
     * PASO 2: Guardar la asignación
     * POST /admin/jueces/{juez}/guardar-asignacion
     */
    public function guardarAsignacionEventosJuez(Request $request, Usuario $juez) {
        // Validar que sea admin
        abort_if(!auth()->user()->esAdmin(), 403);
        
        // Validar que los IDs de eventos existan en la BD
        $validated = $request->validate([
            'eventos' => 'array',
            'eventos.*' => 'exists:eventos,id_evento'
        ]);
        
        // Sincronizar: esto elimina eventos no seleccionados 
        // y agrega los seleccionados
        $eventosIds = $validated['eventos'] ?? [];  // [1, 3, 5]
        $juez->eventosAsignados()->sync($eventosIds);
        
        // Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.jueces')
            ->with('success', 'Eventos asignados al juez correctamente.');
    }
}


// 4. VISTAS - INTERFAZ DE USUARIO
// ───────────────────────────────────────────────────────────────

/**
 * admin/jueces/asignar.blade.php
 * 
 * Formulario con:
 * - Título y datos del juez
 * - Listado de eventos como checkboxes
 * - Marca automáticamente los ya asignados
 * - Botón para guardar y cancelar
 */
<form method="POST" action="{{ route('admin.jueces.guardar-asignacion', $juez->id) }}">
    @csrf
    
    <!-- Loop a través de TODOS los eventos -->
    @foreach($eventos as $evento)
        <label>
            <!-- Marcar si está en $eventosAsignados -->
            <input 
                type="checkbox"
                name="eventos[]"
                value="{{ $evento->id_evento }}"
                {{ in_array($evento->id_evento, $eventosAsignados) ? 'checked' : '' }}
            />
            {{ $evento->nombre }}
        </label>
    @endforeach
    
    <button type="submit">Guardar Asignaciones</button>
</form>


// 5. RUTAS
// ───────────────────────────────────────────────────────────────

Route::middleware('is.admin')->group(function () {
    // ... otras rutas admin ...
    
    // Mostrar formulario de asignación
    Route::get(
        '/admin/jueces/{juez}/asignar-eventos',
        [AdminController::class, 'asignarEventosJuez']
    )->name('admin.jueces.asignar-eventos');
    
    // Guardar asignación
    Route::post(
        '/admin/jueces/{juez}/guardar-asignacion',
        [AdminController::class, 'guardarAsignacionEventosJuez']
    )->name('admin.jueces.guardar-asignacion');
});


// ===================================================================
// FLUJO VISUAL: ¿QUÉ PASA EN CADA PASO?
// ===================================================================

/*
    
    PASO 1: Admin en /admin/jueces
    ┌─────────────────────────────────────────┐
    │  Tabla de Jueces                        │
    │  ┌───────────────────────────────────┐ │
    │  │ Nombre      │ Correo    │ Asignar │ │
    │  │ Juan Pérez  │ j@t.com   │ [CLIC] ◄─┼─────┐
    │  └───────────────────────────────────┘ │     │
    └─────────────────────────────────────────┘     │
                                                    │
    PASO 2: GET /admin/jueces/1/asignar-eventos    │
    ────────────────────────────────────────────────┤
    Controlador ejecuta:                            │
    ├─ $juez = Usuario::find(1)                 ◄──┤
    ├─ $eventos = Evento::all()                 │
    ├─ $eventosAsignados = [1, 3, 5]            │
    └─ return view('admin.jueces.asignar', ...) │
                                                │
    PASO 3: Vista renderiza checkboxes          │
    ────────────────────────────────────────────┤
    <form>                                      │
    ☑ Evento 1 (id=1)   [checked]              │
    ☐ Evento 2 (id=2)   [unchecked]            │
    ☑ Evento 3 (id=3)   [checked]              │
    ☐ Evento 4 (id=4)   [unchecked]            │
    ☑ Evento 5 (id=5)   [checked]              │
    [Guardar]                                   │
    </form>                                     │
                                                │
    PASO 4: Admin modifica selección            │
    ────────────────────────────────────────────┤
    ☑ Evento 1 (id=1)   [checked]   ← mismo    │
    ☑ Evento 2 (id=2)   [NUEVO]     ← marcado  │
    ☐ Evento 3 (id=3)   [QUITADO]   ← desmarca│
    ☐ Evento 4 (id=4)   [unchecked]            │
    ☑ Evento 5 (id=5)   [checked]   ← mismo    │
                                                │
    PASO 5: Hace submit del form                │
    ────────────────────────────────────────────┤
    POST /admin/jueces/1/guardar-asignacion    │
    Payload: eventos[] = [1, 2, 5]             │
                                                │
    PASO 6: Controlador sincroniza              │
    ────────────────────────────────────────────┤
    $juez->eventosAsignados()->sync([1, 2, 5]) │
                                                │
    Esto significa:                             │
    ✓ Evento 1 → Mantiene (ya estaba)          │
    ✓ Evento 2 → Agrega (nuevo)                │
    ✗ Evento 3 → Elimina (fue quitado)         │
    ✓ Evento 5 → Mantiene (ya estaba)          │
    
    BD resultante: juez_evento                 │
    ┌──────────────────────────┐               │
    │ usuario_id │ evento_id   │               │
    │    1       │    1        │ ← existía     │
    │    1       │    2        │ ← nuevo       │
    │    1       │    5        │ ← existía     │
    └──────────────────────────┘               │
                                                │
    PASO 7: Redirige con éxito                  │
    ────────────────────────────────────────────┤
    Redirect → /admin/jueces                   │
    Mensaje: "Eventos asignados al juez ✓"     │
    
*/

// ===================================================================
// VERIFICACIÓN: EL JUEZ ACCEDE SUS EVENTOS
// ===================================================================

class JuezController extends Controller {
    
    public function panel() {
        $juez = auth()->user();  // El juez loggeado
        
        // Obtener eventos asignados al juez
        $eventosAsignados = $juez->eventosAsignados()->get();
        
        // $eventosAsignados tendrá los eventos [1, 2, 5]
        // Que coinciden con los seleccionados en paso anterior
        
        return view('juez.panel', [
            'eventos' => $eventosAsignados
        ]);
    }
}

/**
 * Vista: juez/panel.blade.php
 * Muestra:
 * - Evento 1
 * - Evento 2  ← agregado en paso 4
 * - Evento 5
 * 
 * NO muestra: Evento 3 (fue removido)
 */


// ===================================================================
// MÉTODOS IMPORTANTES DE ELOQUENT
// ===================================================================

// belongsToMany(...)->sync([1, 2, 5])
// Sincroniza relación: solo los IDs especificados quedan en la tabla pivot
// - Elimina registros no listados
// - Agrega nuevos
// - Mantiene los existentes

// pluck('id_evento')->toArray()
// Extrae solo los IDs de eventos: [1, 3, 5]

// in_array($evento->id_evento, $eventosAsignados)
// Verifica si un evento ID está en la lista de asignados
// Devuelve true/false para el checked del checkbox

// ===================================================================
// VALIDACIONES DE SEGURIDAD
// ===================================================================

1. ✓ Solo admin puede asignar eventos (middleware is.admin)
2. ✓ Solo puede seleccionar eventos que existen (validate exists:eventos)
3. ✓ Cada juez-evento combo es único (UNIQUE constraint en BD)
4. ✓ Model binding automático: /admin/jueces/{juez} carga Usuario automáticamente

// ===================================================================
// ESTADO FINAL: TODO LISTO PARA PRUEBAS
// ===================================================================

✅ Migración aplicada (juez_evento table creada)
✅ Modelos con relaciones (Usuario↔Evento via pivot)
✅ Controlador con lógica (asignar + guardar)
✅ Vistas con formularios (checkboxes)
✅ Rutas registradas (GET y POST)
✅ Caché de vistas limpiada
✅ Guía de prueba creada (TEST_JUEZ_ASIGNACION.md)

→ Listo para ejecutar pruebas manuales en http://localhost/admin/jueces
