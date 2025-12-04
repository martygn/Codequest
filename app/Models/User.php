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
     * Usamos SOLO los nombres reales de la BD.
     */
    protected $fillable = [
        'nombre',   // Columna Real
        'username',
        'correo',   // Columna Real
        'password',
        'role',
    ];

    /**
     * Atributos ocultos.
     */
    protected $hidden = [
        'password',
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
    | COMPATIBILIDAD DE LECTURA (Solo Getters)
    |--------------------------------------------------------------------------
    | Mantenemos esto para que Auth::user()->name y Auth::user()->email
    | sigan funcionando en tus Vistas HTML.
    |
    | HEMOS ELIMINADO LOS "SETTERS" para obligar a que el guardado sea
    | directo a las columnas 'nombre' y 'correo', evitando duplicaciones.
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