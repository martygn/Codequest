<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cambiar la columna 'tipo' a VARCHAR para soportar el nuevo valor 'juez'
        // Esto funciona en cualquier base de datos (MySQL, PostgreSQL, SQLite, etc.)
        Schema::table('usuarios', function (Blueprint $table) {
            // Cambiar de ENUM a VARCHAR si es necesario para compatibilidad
            $table->string('tipo', 50)->default('participante')->change();
        });

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
        // Revertir tipo a VARCHAR con valores anteriores
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('tipo', 50)->default('participante')->change();
        });

        Schema::dropIfExists('juez_evento');
    }
};
