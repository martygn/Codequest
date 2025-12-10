<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminar la restricción CHECK de PostgreSQL que impide agregar 'juez' como tipo
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // Buscar y eliminar la restricción CHECK
            DB::statement('ALTER TABLE usuarios DROP CONSTRAINT IF EXISTS usuarios_tipo_check');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario recrear la restricción en rollback
        // porque ya fue reemplazada por VARCHAR
    }
};
