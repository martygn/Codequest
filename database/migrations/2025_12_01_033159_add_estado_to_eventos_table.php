<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('eventos', function (Blueprint $table) {
        // Agrega la columna estado, por defecto 'pendiente'
        $table->enum('estado', ['pendiente', 'publicado'])->default('pendiente')->after('lugar');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            //
        });
    }
};
