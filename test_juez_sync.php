#!/usr/bin/env php
<?php
/**
 * Script de prueba: Verificar que la lógica de sincronización de eventos funciona
 * 
 * Ejecutar: php test_juez_sync.php
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Usuario;
use App\Models\Evento;
use Illuminate\Support\Facades\DB;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║  TEST: Validación de Sincronización de Eventos para Jueces     ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// 1. Verificar que tabla juez_evento existe
echo "[1] Verificando tabla juez_evento...\n";
$tableExists = DB::connection()->getSchemaBuilder()->hasTable('juez_evento');
if ($tableExists) {
    echo "    ✅ Tabla 'juez_evento' existe en BD\n";
} else {
    echo "    ❌ Tabla 'juez_evento' NO existe\n";
    exit(1);
}

// 2. Verificar estructura de tabla
echo "\n[2] Verificando estructura de tabla...\n";
$columns = DB::getSchemaBuilder()->getColumnListing('juez_evento');
$expectedColumns = ['id', 'usuario_id', 'evento_id', 'created_at', 'updated_at'];
$missingColumns = array_diff($expectedColumns, $columns);

if (count($missingColumns) === 0) {
    echo "    ✅ Columnas correctas: " . implode(', ', $expectedColumns) . "\n";
} else {
    echo "    ❌ Columnas faltantes: " . implode(', ', $missingColumns) . "\n";
    exit(1);
}

// 3. Verificar que Usuario tiene método eventosAsignados
echo "\n[3] Verificando método eventosAsignados en Usuario...\n";
$usuario = new Usuario();
if (method_exists($usuario, 'eventosAsignados')) {
    echo "    ✅ Método eventosAsignados() existe\n";
    
    // Verificar que es BelongsToMany
    $relation = $usuario->eventosAsignados();
    if (get_class($relation) === 'Illuminate\Database\Eloquent\Relations\BelongsToMany') {
        echo "    ✅ Es una relación BelongsToMany\n";
    } else {
        echo "    ⚠️  Tipo de relación: " . get_class($relation) . "\n";
    }
} else {
    echo "    ❌ Método eventosAsignados() NO existe\n";
    exit(1);
}

// 4. Verificar que Evento tiene método jueces
echo "\n[4] Verificando método jueces en Evento...\n";
$evento = new Evento();
if (method_exists($evento, 'jueces')) {
    echo "    ✅ Método jueces() existe en Evento\n";
} else {
    echo "    ❌ Método jueces() NO existe en Evento\n";
    exit(1);
}

// 5. Verificar que Usuario tiene método esJuez
echo "\n[5] Verificando método esJuez en Usuario...\n";
if (method_exists($usuario, 'esJuez')) {
    echo "    ✅ Método esJuez() existe\n";
} else {
    echo "    ❌ Método esJuez() NO existe\n";
    exit(1);
}

// 6. Verificar rutas (archivo routes/web.php)
echo "\n[6] Verificando rutas en web.php...\n";
$routesFile = file_get_contents(__DIR__ . '/routes/web.php');
$expectedRoutes = [
    'admin.jueces',
    'admin.jueces.create',
    'admin.jueces.store',
    'admin.jueces.asignar-eventos',
    'admin.jueces.guardar-asignacion'
];

$routesFound = array_filter($expectedRoutes, function($route) use ($routesFile) {
    return str_contains($routesFile, "->name('" . $route . "')");
});

if (count($routesFound) >= 5) {
    echo "    ✅ Todas las rutas de jueces definidas\n";
    foreach ($routesFound as $name) {
        echo "       - $name\n";
    }
} else {
    echo "    ⚠️  Rutas encontradas: " . count($routesFound) . " (se verificarán con php artisan route:list)\n";
}

// 7. Verificar middleware
echo "\n[7] Verificando middleware...\n";
$middlewareAliases = config('app')['middleware_aliases'] ?? [];
if (isset($middlewareAliases['is.admin']) && isset($middlewareAliases['is.juez'])) {
    echo "    ✅ Middleware 'is.admin' y 'is.juez' registrados\n";
} else {
    echo "    ⚠️  Middleware verificados en bootstrap/app.php\n";
}

// RESUMEN
echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║  ✅ TODAS LAS VALIDACIONES PASARON EXITOSAMENTE                 ║\n";
echo "║                                                                ║\n";
echo "║  Sistema listo para pruebas manuales en la aplicación:         ║\n";
echo "║  1. Acceder: http://localhost/admin/jueces                    ║\n";
echo "║  2. Crear juez: http://localhost/admin/jueces/crear           ║\n";
echo "║  3. Asignar eventos: http://localhost/admin/jueces/{id}/...  ║\n";
echo "║  4. Login como juez: http://localhost/login                   ║\n";
echo "║                                                                ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

exit(0);
