<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'lugar',
        'foto'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /**
     * Relación con equipos (1:N)
     * Un evento tiene muchos equipos
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_evento', 'id_evento');
    }

    /**
     * Scope para eventos próximos
     */
    public function scopeProximos($query)
    {
        return $query->where('fecha_inicio', '>=', now())
            ->orderBy('fecha_inicio', 'asc');
    }

    /**
     * Scope para eventos activos (en curso)
     */
    public function scopeActivos($query)
    {
        return $query->where('fecha_inicio', '<=', now())
            ->where('fecha_fin', '>=', now());
    }

    /**
     * Verificar si el evento está activo
     */
    public function estaActivo()
    {
        return now()->between($this->fecha_inicio, $this->fecha_fin);
    }

    /**
     * Verificar si el evento ya finalizó
     */
    public function haFinalizado()
    {
        return now()->greaterThan($this->fecha_fin);
    }
}