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
        // Si ya tienes la tabla users de Laravel, la renombramos o eliminamos
        if (Schema::hasTable('users') && !Schema::hasTable('usuarios')) {
            Schema::rename('users', 'usuarios_backup');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('usuarios_backup')) {
            Schema::rename('usuarios_backup', 'users');
        }
    }
};
