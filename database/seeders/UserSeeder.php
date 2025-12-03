<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Admin CodeQuest',
            'username' => 'admin',
            'email' => 'admin@codequest.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Crear usuarios normales de prueba
        User::create([
            'name' => 'Juan Pérez',
            'username' => 'juan',
            'email' => 'juan@codequest.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'María López',
            'username' => 'maria',
            'email' => 'maria@codequest.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Carlos Martínez',
            'username' => 'carlos',
            'email' => 'carlos@codequest.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ana García',
            'username' => 'ana',
            'email' => 'ana@codequest.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->command->info('✅ Usuarios creados en la tabla users!');
        $this->command->info('');
        $this->command->info('👥 Usuarios de prueba:');
        $this->command->info('📧 admin@codequest.com / password (Administrador)');
        $this->command->info('📧 juan@codequest.com / password (Usuario normal)');
        $this->command->info('📧 maria@codequest.com / password (Usuario normal)');
        $this->command->info('📧 carlos@codequest.com / password (Usuario normal)');
        $this->command->info('📧 ana@codequest.com / password (Usuario normal)');
    }
}
