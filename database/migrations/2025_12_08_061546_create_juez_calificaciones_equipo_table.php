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
        Schema::create('juez_calificaciones_equipo', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->unsignedBigInteger('juez_id');
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('evento_id');
            
            // Puntajes por criterio (1-10)
            $table->integer('puntaje_creatividad')->nullable();
            $table->integer('puntaje_funcionalidad')->nullable();
            $table->integer('puntaje_diseño')->nullable();
            $table->integer('puntaje_presentacion')->nullable();
            $table->integer('puntaje_documentacion')->nullable();
            
            // Totales
            $table->decimal('puntaje_final', 5, 2)->nullable();
            $table->decimal('promedio_jueces', 5, 2)->nullable(); // Calculado después
            
            // Detalles
            $table->text('observaciones')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->boolean('ganador')->default(false);
            
            // Timestamps
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('juez_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('equipo_id')->references('id_equipo')->on('equipos')->onDelete('cascade');
            $table->foreign('evento_id')->references('id_evento')->on('eventos')->onDelete('cascade');
            
            // Constraint único: un juez califica un equipo una sola vez por evento
            $table->unique(['juez_id', 'equipo_id', 'evento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juez_calificaciones_equipo');
    }
};
