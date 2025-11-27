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
        'id_evento'
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
            ->withPivot('posicion')
            ->withTimestamps();
    }

    /**
     * Obtener el número de miembros del equipo
     */
    public function getNumeroMiembrosAttribute()
    {
        return $this->participantes()->count();
    }

    /**
     * Scope para equipos destacados
     */
    public function scopeDestacados($query)
    {
        return $query->withCount('participantes')
            ->orderBy('participantes_count', 'desc');
    }

    /**
     * Verificar si un usuario es miembro del equipo
     */
    public function tieneMiembro($usuarioId)
    {
        return $this->participantes()->where('usuario_id', $usuarioId)->exists();
    }

    /**
     * Obtener la posición de un participante en el equipo
     */
    public function obtenerPosicion($usuarioId)
    {
        $participante = $this->participantes()->where('usuario_id', $usuarioId)->first();
        return $participante ? $participante->pivot->posicion : null;
    }
}