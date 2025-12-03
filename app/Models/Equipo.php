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
    'id_evento',
    'logo',             // Nuevo
    'designer_name',    // Nuevo
    'frontend_name',    // Nuevo
    'backend_name',     // Nuevo
    'id_lider'
];

    protected $casts = [
        'estado' => 'string',
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

    /**
     * Verificar si el equipo tiene cupo disponible (máximo 4 miembros)
     */
    public function tieneCupoDisponible()
    {
        return $this->participantes()->count() < 4;
    }

    /**
     * Obtener la siguiente posición automática según orden de unión
     */
    public function obtenerSiguientePosicion()
    {
        $numeroMiembros = $this->participantes()->count();

        // Mapa de posiciones según el orden de unión
        $posiciones = [
            1 => 'Programador Front-end', // Primer participante (después del líder)
            2 => 'Programador Back-end',  // Segundo participante
            3 => 'Diseñador'              // Tercer participante
        ];

        return $posiciones[$numeroMiembros] ?? 'Miembro';
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
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, $estado)
    {
        if ($estado !== 'todos') {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    /**
     * Scope para eventos pasados
     */
    public function scopeEventosPasados($query)
    {
        return $query->whereHas('evento', function ($q) {
            $q->where('fecha_fin', '<', now());
        });
    }

    /**
     * Scope para mis eventos (eventos donde el usuario es participante)
     */
    public function scopeMisEventos($query, $usuarioId)
    {
        return $query->whereHas('participantes', function ($q) use ($usuarioId) {
            $q->where('usuario_id', $usuarioId);
        });
    }

    /**
     * Obtener el líder del equipo
     */
    public function lider()
    {
        return $this->participantes()->wherePivot('posicion', 'Líder')->first();
    }

    /**
     * Verificar si el usuario es el líder del equipo
     */
    public function esLider($usuarioId)
    {
        return $this->participantes()
            ->where('usuario_id', $usuarioId)
            ->wherePivot('posicion', 'Líder')
            ->exists();
    }
}
