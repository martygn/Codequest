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
        Schema::table('constancias', function (Blueprint $table) {
            $table->foreignId('id_juez')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('constancias', function (Blueprint $table) {
            $table->foreignId('id_juez')->nullable(false)->change();
        });
    }
};
