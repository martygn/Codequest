<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('juez_calificaciones_equipo', function (Blueprint $table) {
            // Agregar nuevos campos para la rúbrica actualizada
            $table->decimal('puntaje_innovacion', 5, 2)->nullable()->after('puntaje_creatividad');
            $table->decimal('puntaje_impacto', 5, 2)->nullable()->after('puntaje_funcionalidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('juez_calificaciones_equipo', function (Blueprint $table) {
            $table->dropColumn(['puntaje_innovacion', 'puntaje_impacto']);
        });
    }
};
