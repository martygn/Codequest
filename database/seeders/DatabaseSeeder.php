<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios administradores
        $admin = Usuario::create([
            'nombre' => 'Admin',
            'apellido_paterno' => 'CodeQuest',
            'apellido_materno' => 'Sistema',
            'correo' => 'admin@codequest.com',
            'contrasena' => ('password'),
            'tipo' => 'administrador',
        ]);

        // Crear usuarios participantes
        $participante1 = Usuario::create([
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'García',
            'correo' => 'juan@codequest.com',
            'contrasena' => Hash::make('password'),
            'tipo' => 'participante',
        ]);

        $participante2 = Usuario::create([
            'nombre' => 'María',
            'apellido_paterno' => 'López',
            'apellido_materno' => 'Rodríguez',
            'correo' => 'maria@codequest.com',
            'contrasena' => Hash::make('password'),
            'tipo' => 'participante',
        ]);

        $participante3 = Usuario::create([
            'nombre' => 'Carlos',
            'apellido_paterno' => 'Martínez',
            'apellido_materno' => 'Sánchez',
            'correo' => 'carlos@codequest.com',
            'contrasena' => Hash::make('password'),
            'tipo' => 'participante',
        ]);

        $participante4 = Usuario::create([
            'nombre' => 'Ana',
            'apellido_paterno' => 'González',
            'apellido_materno' => 'Fernández',
            'correo' => 'ana@codequest.com',
            'contrasena' => Hash::make('password'),
            'tipo' => 'participante',
        ]);

        // Crear eventos de ejemplo
        $evento1 = Evento::create([
            'nombre' => 'Desafío de Programación Regional',
            'descripcion' => 'Competencia de programación para estudiantes universitarios de la región',
            'fecha_inicio' => now()->addDays(30),
            'fecha_fin' => now()->addDays(31),
            'lugar' => 'Universidad Nacional',
        ]);

        $evento2 = Evento::create([
            'nombre' => 'Maratón de Código Universitario',
            'descripcion' => 'Evento de 24 horas de programación continua',
            'fecha_inicio' => now()->addDays(60),
            'fecha_fin' => now()->addDays(61),
            'lugar' => 'Centro de Convenciones',
        ]);

        $evento3 = Evento::create([
            'nombre' => 'Competencia de Algoritmos Avanzados',
            'descripcion' => 'Desafíos de algoritmos y estructuras de datos avanzadas',
            'fecha_inicio' => now()->addDays(90),
            'fecha_fin' => now()->addDays(92),
            'lugar' => 'Instituto Tecnológico',
        ]);

        // Crear equipos de ejemplo
        $equipo1 = Equipo::create([
            'nombre' => 'Equipo Alpha',
            'descripcion' => 'Especialistas en algoritmos y estructuras de datos',
            'id_evento' => $evento1->id_evento,
        ]);

        $equipo2 = Equipo::create([
            'nombre' => 'Equipo Beta',
            'descripcion' => 'Enfocados en desarrollo web y aplicaciones',
            'id_evento' => $evento2->id_evento,
        ]);

        $equipo3 = Equipo::create([
            'nombre' => 'Equipo Gamma',
            'descripcion' => 'Expertos en inteligencia artificial y machine learning',
            'id_evento' => $evento3->id_evento,
        ]);

        // Agregar participantes a los equipos con posiciones
        $equipo1->participantes()->attach([
            $participante1->id => ['posicion' => 'Líder'],
            $participante2->id => ['posicion' => 'Desarrollador'],
            $participante3->id => ['posicion' => 'Diseñador'],
        ]);

        $equipo2->participantes()->attach([
            $participante2->id => ['posicion' => 'Líder'],
            $participante4->id => ['posicion' => 'Desarrollador'],
        ]);

        $equipo3->participantes()->attach([
            $participante3->id => ['posicion' => 'Líder'],
            $participante1->id => ['posicion' => 'Investigador'],
            $participante4->id => ['posicion' => 'Analista'],
        ]);

        $this->command->info('✅ Base de datos poblada con datos de prueba!');
        $this->command->info('');
        $this->command->info('👥 Usuarios creados:');
        $this->command->info('📧 admin@codequest.com / password (Administrador)');
        $this->command->info('📧 juan@codequest.com / password (Participante)');
        $this->command->info('📧 maria@codequest.com / password (Participante)');
        $this->command->info('📧 carlos@codequest.com / password (Participante)');
        $this->command->info('📧 ana@codequest.com / password (Participante)');
        $this->command->info('');
        $this->command->info('🎯 Eventos creados: 3');
        $this->command->info('👥 Equipos creados: 3');
    }
}