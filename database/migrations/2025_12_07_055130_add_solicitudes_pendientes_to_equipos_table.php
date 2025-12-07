<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('equipos', function (Blueprint $table) {
            // Agrega la columna como JSON (para Laravel 5.7+)
            // O como TEXT si tu versión de MySQL es antigua
            $table->json('solicitudes_pendientes')->nullable()->after('aprobado');
        });
    }

    public function down()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn('solicitudes_pendientes');
        });
    }
};
