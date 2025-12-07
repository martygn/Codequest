<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->string('nombre');
            $table->string('nombre_proyecto')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('banner')->nullable();
            $table->enum('estado', ['en revisión', 'aprobado', 'rechazado'])->default('en revisión');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->timestamps();

            // Agregar índice para búsquedas
            $table->index(['nombre', 'nombre_proyecto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
