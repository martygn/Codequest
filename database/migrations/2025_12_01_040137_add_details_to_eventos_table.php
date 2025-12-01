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
        $table->text('reglas')->nullable()->after('descripcion');
        $table->text('premios')->nullable()->after('reglas');
        $table->text('otra_informacion')->nullable()->after('premios');
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
