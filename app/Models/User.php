<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nombre de la tabla en la base de datos.
     */
    protected $table = 'usuarios';

    /**
     * Los atributos que se pueden llenar masivamente.
     * AQUI AGREGAMOS TUS APELLIDOS y CORREGIMOS LA CONTRASEÑA.
     */
    protected $fillable = [
        'nombre',
        'apellido_paterno', // Nuevo: Para guardar el apellido paterno
        'apellido_materno', // Nuevo: Para guardar el apellido materno
        'username',
        'correo',
        'contrasena',       // Corregido: Tu BD usa 'contrasena', no 'password'
        'role',
    ];

    /**
     * Atributos ocultos.
     */
    protected $hidden = [
        'contrasena', // Ocultamos la columna real
        'remember_token',
    ];

    /**
     * Casts de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN DE AUTENTICACIÓN (IMPORTANTE)
    |--------------------------------------------------------------------------
    */
    
    // Le dice a Laravel que tu columna de contraseña se llama 'contrasena'
    public function getAuthPasswordName()
    {
        return 'contrasena';
    }

    /*
    |--------------------------------------------------------------------------
    | COMPATIBILIDAD DE LECTURA (Getters)
    |--------------------------------------------------------------------------
    */

    // Permite leer $user->name (devuelve 'nombre' de la BD)
    public function getNameAttribute()
    {
        return $this->attributes['nombre'] ?? null;
    }

    // Permite leer $user->email (devuelve 'correo' de la BD)
    public function getEmailAttribute()
    {
        return $this->attributes['correo'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'participante_equipo', 'usuario_id', 'equipo_id')
                    ->withPivot('rol', 'posicion')
                    ->withTimestamps();
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_user', 'user_id', 'evento_id')
                    ->withTimestamps();
    }
    
    /*
    |--------------------------------------------------------------------------
    | Funciones Auxiliares
    |--------------------------------------------------------------------------
    */

    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }
}