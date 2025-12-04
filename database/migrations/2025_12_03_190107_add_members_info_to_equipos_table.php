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
    Schema::table('equipos', function (Blueprint $table) {
        $table->string('logo')->nullable()->after('descripcion'); // Cambiamos banner por logo
        $table->string('designer_name')->nullable();
        $table->string('frontend_name')->nullable();
        $table->string('backend_name')->nullable();
        // Asegurarnos que existe id_lider si lo usamos
        if (!Schema::hasColumn('equipos', 'id_lider')) {
            $table->unsignedBigInteger('id_lider')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            //
        });
    }
};
