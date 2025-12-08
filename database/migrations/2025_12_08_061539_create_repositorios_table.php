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
        Schema::create('repositorios', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->unsignedBigInteger('equipo_id')->unique();
            $table->unsignedBigInteger('evento_id');
            
            // URLs de repositorio
            $table->string('url_github')->nullable();
            $table->string('url_gitlab')->nullable();
            $table->string('url_bitbucket')->nullable();
            $table->string('url_personalizado')->nullable();
            
            // Archivo cargado (ZIP/RAR)
            $table->string('archivo_path')->nullable();
            $table->string('archivo_nombre')->nullable();
            $table->integer('archivo_tamaño')->nullable(); // en KB
            
            // Información
            $table->text('descripcion')->nullable();
            $table->string('rama_produccion')->default('main');
            
            // Estados
            $table->enum('estado', ['no_enviado', 'enviado', 'verificado', 'rechazado'])->default('no_enviado');
            $table->unsignedBigInteger('verificado_por')->nullable();
            
            // Timestamps
            $table->timestamp('enviado_en')->nullable();
            $table->timestamp('vencimiento_envio')->nullable();
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('equipo_id')->references('id_equipo')->on('equipos')->onDelete('cascade');
            $table->foreign('evento_id')->references('id_evento')->on('eventos')->onDelete('cascade');
            $table->foreign('verificado_por')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repositorios');
    }
};
