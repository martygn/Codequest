<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            // Hacer id_evento nullable
            $table->unsignedBigInteger('id_evento')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            // Revertir a no nullable
            $table->unsignedBigInteger('id_evento')->nullable(false)->change();
        });
    }
};
