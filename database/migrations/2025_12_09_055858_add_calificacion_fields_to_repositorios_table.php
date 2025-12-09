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
        Schema::table('repositorios', function (Blueprint $table) {
            $table->decimal('calificacion_total', 5, 2)->nullable()->after('estado');
            $table->json('calificacion_detalle')->nullable()->after('calificacion_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repositorios', function (Blueprint $table) {
            $table->dropColumn(['calificacion_total', 'calificacion_detalle']);
        });
    }
};
