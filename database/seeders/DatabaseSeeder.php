<?php

namespace Database\Seeders;

use App\Models\User;
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
            'contrasena' => Hash::make('password'),
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

        $evento4 = Evento::create([
            'nombre' => 'Hackathon Nacional de Innovación',
            'descripcion' => 'Maratón de desarrollo de soluciones innovadoras',
            'fecha_inicio' => now()->addDays(120),
            'fecha_fin' => now()->addDays(122),
            'lugar' => 'Centro Tecnológico Nacional',
        ]);

        $evento5 = Evento::create([
            'nombre' => 'Competencia de Desarrollo Web',
            'descripcion' => 'Desafío de diseño y desarrollo de aplicaciones web modernas',
            'fecha_inicio' => now()->addDays(45),
            'fecha_fin' => now()->addDays(46),
            'lugar' => 'Campus Digital',
        ]);

        $evento6 = Evento::create([
            'nombre' => 'Summit de Ciberseguridad',
            'descripcion' => 'Conferencia y competencia sobre seguridad informática',
            'fecha_inicio' => now()->addDays(75),
            'fecha_fin' => now()->addDays(77),
            'lugar' => 'Centro de Convenciones Internacional',
        ]);

        $evento7 = Evento::create([
            'nombre' => 'Competencia de Inteligencia Artificial',
            'descripcion' => 'Desafío de machine learning y procesamiento de datos',
            'fecha_inicio' => now()->addDays(105),
            'fecha_fin' => now()->addDays(107),
            'lugar' => 'Instituto de Investigación Tecnológica',
        ]);

        $evento8 = Evento::create([
            'nombre' => 'Challenge de Programación Competitiva',
            'descripcion' => 'Competencia de resolución rápida de problemas algorítmicos',
            'fecha_inicio' => now()->addDays(15),
            'fecha_fin' => now()->addDays(16),
            'lugar' => 'Universidad Central',
        ]);

        $evento9 = Evento::create([
            'nombre' => 'Conferencia de Desarrollo Backend',
            'descripcion' => 'Taller intensivo sobre arquitectura y desarrollo backend',
            'fecha_inicio' => now()->addDays(50),
            'fecha_fin' => now()->addDays(51),
            'lugar' => 'Auditorio Principal',
        ]);

        $evento10 = Evento::create([
            'nombre' => 'Torneo de Videojuegos con Desarrollo',
            'descripcion' => 'Competencia de creación de juegos en 48 horas',
            'fecha_inicio' => now()->addDays(135),
            'fecha_fin' => now()->addDays(137),
            'lugar' => 'Zona de Innovación Digital',
        ]);

        // Ejemplo de equipos (sin evento asignado, como si fueran creados por participantes)
        $equipo1 = Equipo::create([
            'nombre' => 'Equipo Alpha',
            'nombre_proyecto' => 'Proyecto 1',
            'descripcion' => 'Especialistas en algoritmos y estructuras de datos',
            'estado' => 'aprobado',
        ]);

        $equipo2 = Equipo::create([
            'nombre' => 'Equipo Beta',
            'nombre_proyecto' => 'Proyecto 2',
            'descripcion' => 'Enfocados en desarrollo web y aplicaciones',
            'estado' => 'en revisión',
        ]);

        $equipo3 = Equipo::create([
            'nombre' => 'Equipo Gamma',
            'nombre_proyecto' => 'Proyecto 3',
            'descripcion' => 'Expertos en inteligencia artificial y machine learning',
            'estado' => 'rechazado',
        ]);

        $equipo4 = Equipo::create([
            'nombre' => 'Los Innovadores',
            'nombre_proyecto' => 'Solución Disruptiva',
            'descripcion' => 'Creación de soluciones innovadoras con IA',
            'estado' => 'aprobado',
        ]);

        $equipo5 = Equipo::create([
            'nombre' => 'Web Masters',
            'nombre_proyecto' => 'Plataforma Web',
            'descripcion' => 'Desarrollo de aplicaciones web de alto rendimiento',
            'estado' => 'aprobado',
        ]);

        $equipo6 = Equipo::create([
            'nombre' => 'Cyber Defenders',
            'nombre_proyecto' => 'Sistema de Seguridad',
            'descripcion' => 'Especialistas en ciberseguridad y protección de datos',
            'estado' => 'en revisión',
        ]);

        $equipo7 = Equipo::create([
            'nombre' => 'Data Scientists Pro',
            'nombre_proyecto' => 'Análisis Predictivo',
            'descripcion' => 'Análisis de datos e inteligencia artificial avanzada',
            'estado' => 'aprobado',
        ]);

        $equipo8 = Equipo::create([
            'nombre' => 'Code Warriors',
            'nombre_proyecto' => 'Soluciones Algorítmicas',
            'descripcion' => 'Expertos en resolución de problemas algorítmicos complejos',
            'estado' => 'aprobado',
        ]);

        $equipo9 = Equipo::create([
            'nombre' => 'Backend Builders',
            'nombre_proyecto' => 'Arquitectura de Servicios',
            'descripcion' => 'Desarrollo de APIs y arquitectura backend escalable',
            'estado' => 'en revisión',
        ]);

        $equipo10 = Equipo::create([
            'nombre' => 'Game Dev Team',
            'nombre_proyecto' => 'Juego Interactivo',
            'descripcion' => 'Desarrollo de videojuegos con características avanzadas',
            'estado' => 'aprobado',
        ]);

        // Agregar participantes a los equipos
        $equipo1->participantes()->attach($participante1->id, ['posicion' => 'Líder']);
        $equipo2->participantes()->attach($participante2->id, ['posicion' => 'Líder']);
        $equipo3->participantes()->attach($participante3->id, ['posicion' => 'Líder']);
        $equipo4->participantes()->attach($participante4->id, ['posicion' => 'Líder']);
        $equipo5->participantes()->attach($participante1->id, ['posicion' => 'Líder']);
        $equipo6->participantes()->attach($participante2->id, ['posicion' => 'Líder']);
        $equipo7->participantes()->attach($participante3->id, ['posicion' => 'Líder']);
        $equipo8->participantes()->attach($participante4->id, ['posicion' => 'Líder']);
        $equipo9->participantes()->attach($participante1->id, ['posicion' => 'Líder']);
        $equipo10->participantes()->attach($participante2->id, ['posicion' => 'Líder']);

        $this->command->info('✅ Base de datos poblada con datos de prueba!');
        $this->command->info('');
        $this->command->info('👥 Usuarios creados:');
        $this->command->info('📧 admin@codequest.com / password (Administrador)');
        $this->command->info('📧 juan@codequest.com / password (Participante)');
        $this->command->info('📧 maria@codequest.com / password (Participante)');
        $this->command->info('📧 carlos@codequest.com / password (Participante)');
        $this->command->info('📧 ana@codequest.com / password (Participante)');
        $this->command->info('');
        $this->command->info('🎯 Eventos creados: 10');
        $this->command->info('👥 Equipos creados: 10');
    }
}
