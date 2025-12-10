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
        Schema::create('constancias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento')->onDelete('cascade');
            $table->foreignId('id_equipo')->constrained('equipos', 'id_equipo')->onDelete('cascade');
            $table->foreignId('id_juez')->constrained('usuarios', 'id')->onDelete('cascade');
            $table->string('ruta_pdf')->nullable()->comment('Ruta del archivo PDF generado');
            $table->timestamp('fecha_generacion')->useCurrent();
            $table->timestamp('fecha_envio')->nullable()->comment('Fecha cuando se envió por correo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constancias');
    }
};
