<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'contrasena',
        'tipo'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'tipo' => 'string',
    ];

    /**
     * Override del método getAuthPassword para usar 'contrasena' en lugar de 'password'
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Override del método getEmailForPasswordReset para usar 'correo' en lugar de 'email'
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    /**
     * Accessor para name (compatibilidad con Breeze)
     */
    public function getNameAttribute()
    {
        return $this->nombre_completo;
    }

    /**
     * Accessor para email (compatibilidad con Breeze)
     */
    public function getEmailAttribute()
    {
        return $this->correo;
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function esAdministrador()
    {
        return $this->tipo === 'administrador';
    }

    /**
     * Verificar si el usuario es participante
     */
    public function esParticipante()
    {
        return $this->tipo === 'participante';
    }

    /**
     * Relación con equipos (N:M) - solo para participantes
     * Un participante puede estar en muchos equipos
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'participante_equipo', 'usuario_id', 'equipo_id')
            ->withPivot('posicion')
            ->withTimestamps();
    }

    /**
     * Scope para obtener solo administradores
     */
    public function scopeAdministradores($query)
    {
        return $query->where('tipo', 'administrador');
    }

    /**
     * Scope para obtener solo participantes
     */
    public function scopeParticipantes($query)
    {
        return $query->where('tipo', 'participante');
    }
}