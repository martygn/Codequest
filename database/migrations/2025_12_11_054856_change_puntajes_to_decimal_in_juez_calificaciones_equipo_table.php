<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('juez_calificaciones_equipo', function (Blueprint $table) {
            $table->decimal('puntaje_innovacion', 5, 1)->nullable()->change();
            $table->decimal('puntaje_funcionalidad', 5, 1)->nullable()->change();
            $table->decimal('puntaje_impacto', 5, 1)->nullable()->change();
            $table->decimal('puntaje_presentacion', 5, 1)->nullable()->change();
            $table->decimal('puntaje_final', 6, 1)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('juez_calificaciones_equipo', function (Blueprint $table) {
            $table->integer('puntaje_innovacion')->nullable()->change();
            $table->integer('puntaje_funcionalidad')->nullable()->change();
            $table->integer('puntaje_impacto')->nullable()->change();
            $table->integer('puntaje_presentacion')->nullable()->change();
            $table->integer('puntaje_final')->nullable()->change();
        });
    }
};