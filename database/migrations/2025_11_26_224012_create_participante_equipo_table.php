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
        Schema::create('participante_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->string('posicion')->nullable(); // rol o posición del participante en el equipo
            $table->timestamps();
            
            // Un participante puede estar en múltiples equipos pero solo una vez por equipo
            $table->unique(['usuario_id', 'equipo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participante_equipo');
    }
};
