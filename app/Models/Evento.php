<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';

    /**
     * Los atributos que son asignables masivamente.
     * Estos coinciden con los inputs de tu formulario "Registro de Evento".
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'reglas',           // Campo del formulario
        'premios',          // Campo del formulario
        'otra_informacion', // Campo del formulario
        'lugar',
        'foto',
        'estado'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /**
     * Relación con equipos (1:N)
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_evento', 'id_evento');
    }

    /**
     * Relación: jueces asignados a este evento
     */
    public function jueces()
    {
        return $this->belongsToMany(\App\Models\Usuario::class, 'juez_evento', 'evento_id', 'usuario_id', 'id_evento', 'id')
            ->withTimestamps();
    }

    /**
     * Relación: Repositorios de este evento (1:M)
     */
    public function repositorios()
    {
        return $this->hasMany(Repositorio::class, 'evento_id', 'id_evento');
    }

    /**
     * Relación: Calificaciones de equipos en este evento (1:M)
     */
    public function calificaciones()
    {
        return $this->hasMany(CalificacionEquipo::class, 'evento_id', 'id_evento');
    }

    // --- Scopes (Filtros) ---

    public function scopeProximos($query)
    {
        return $query->where('fecha_inicio', '>=', now())
            ->orderBy('fecha_inicio', 'asc');
    }

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
        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return false;
        }

        $now = now();
        return $now->between($this->fecha_inicio, $this->fecha_fin);
    }

    public function haFinalizado()
    {
        return now()->greaterThan($this->fecha_fin);
    }
}
