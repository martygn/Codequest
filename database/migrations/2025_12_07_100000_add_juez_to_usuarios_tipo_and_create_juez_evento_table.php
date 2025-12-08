<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar opción 'juez' al enum 'tipo' en tabla usuarios.
        // Usamos DB::statement para soportar MySQL enums.
        DB::statement("ALTER TABLE `usuarios` MODIFY `tipo` ENUM('administrador','participante','juez') NOT NULL DEFAULT 'participante'");

        // Crear tabla pivote para asignar jueces a eventos
        if (!Schema::hasTable('juez_evento')) {
            Schema::create('juez_evento', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('usuario_id');
                $table->unsignedBigInteger('evento_id');
                $table->timestamps();

                $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
                $table->foreign('evento_id')->references('id_evento')->on('eventos')->onDelete('cascade');
                $table->unique(['usuario_id','evento_id']);
            });
        }
    }

    public function down(): void
    {
        // Revertir enum (dejar como estaba: administrador, participante)
        DB::statement("ALTER TABLE `usuarios` MODIFY `tipo` ENUM('administrador','participante') NOT NULL DEFAULT 'participante'");

        Schema::dropIfExists('juez_evento');
    }
};
