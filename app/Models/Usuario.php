<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

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
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {

    }

    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    /**
     * Accessor para name
     */
    public function getNameAttribute()
    {
        return $this->nombre_completo;
    }

    /**
     * Accessor para email
     */
    public function getEmailAttribute()
    {
        return $this->correo;
    }

    /**
     * Setter para email
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['correo'] = $value;
    }

    /**
     * Setter para password
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['contrasena'] = Hash::make($value);
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function esAdministrador()
    {
        return $this->tipo === 'administrador';
    }

    /**
     * Alias para compatibilidad con el modelo User (esAdmin())
     */
    public function esAdmin()
    {
        return $this->esAdministrador();
    }

    /**
     * Verificar si el usuario es participante
     */
    public function esParticipante()
    {
        return $this->tipo === 'participante';
    }

    /**
     * Relación con equipos
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'participante_equipo', 'usuario_id', 'equipo_id')
            ->withPivot('posicion')
            ->withTimestamps();
    }

    /**
     * Relación con eventos (a través de equipos)
     * Un usuario puede participar en varios eventos a través de sus equipos
     */
    public function eventos()
    {
        // Obtener los eventos de los equipos en los que participa el usuario
        return Evento::query()
            ->join('equipos', 'eventos.id_evento', '=', 'equipos.id_evento')
            ->join('participante_equipo', 'equipos.id_equipo', '=', 'participante_equipo.equipo_id')
            ->where('participante_equipo.usuario_id', $this->id)
            ->select('eventos.*')
            ->distinct();
    }

    /**
     * Verificar si el usuario tiene un equipo aprobado para un evento
     */
    public function tieneEquipoAprobado()
    {
        return $this->equipos()
            ->where('aprobado', true)
            ->exists();
    }

    /**
     * Verificar si el usuario tiene equipo aprobado en un evento específico
     */
    public function tieneEquipoAprobadoEnEvento($eventoId)
    {
        return $this->equipos()
            ->where('aprobado', true)
            ->where('id_evento', $eventoId)
            ->exists();
    }

    /**
     * Obtener equipos aprobados del usuario
     */
    public function equiposAprobados()
    {
        return $this->equipos()
            ->where('aprobado', true)
            ->get();
    }

    /**
     * Scope para administradores
     */
    public function scopeAdministradores($query)
    {
        return $query->where('tipo', 'administrador');
    }

    /**
     * Scope para participantes
     */
    public function scopeParticipantes($query)
    {
        return $query->where('tipo', 'participante');
    }
}
