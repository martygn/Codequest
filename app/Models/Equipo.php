<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'banner',
        'id_evento',
        'estado'
    ];

    protected $attributes = [
        'estado' => 'activo'
    ];

    /**
     * Relación con evento (N:1)
     * Un equipo pertenece a un evento
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Relación con participantes (N:M)
     * Un equipo tiene muchos participantes
     */
    public function participantes()
    {
        return $this->belongsToMany(Usuario::class, 'participante_equipo', 'equipo_id', 'usuario_id')
            ->withPivot('posicion', 'created_at')
            ->withTimestamps();
    }

    /**
     * Verificar si un usuario es miembro del equipo
     */
    public function tieneMiembro($usuarioId)
    {
        return $this->participantes()->where('usuario_id', $usuarioId)->exists();
    }

    /**
     * Scope para equipos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para equipos inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    /**
     * Marcar equipo como activo
     */
    public function activar()
    {
        $this->update(['estado' => 'activo']);
        return $this;
    }

    /**
     * Marcar equipo como inactivo
     */
    public function desactivar()
    {
        $this->update(['estado' => 'inactivo']);
        return $this;
    }
}
