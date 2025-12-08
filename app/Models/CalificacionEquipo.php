<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionEquipo extends Model
{
    use HasFactory;

    protected $table = 'juez_calificaciones_equipo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'juez_id',
        'equipo_id',
        'evento_id',
        'puntaje_creatividad',
        'puntaje_funcionalidad',
        'puntaje_diseño',
        'puntaje_presentacion',
        'puntaje_documentacion',
        'puntaje_final',
        'promedio_jueces',
        'observaciones',
        'recomendaciones',
        'ganador'
    ];

    protected $casts = [
        'puntaje_final' => 'decimal:2',
        'promedio_jueces' => 'decimal:2',
        'ganador' => 'boolean',
    ];

    /**
     * Relación con juez (N:1)
     */
    public function juez()
    {
        return $this->belongsTo(Usuario::class, 'juez_id', 'id');
    }

    /**
     * Relación con equipo (N:1)
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id_equipo');
    }

    /**
     * Relación con evento (N:1)
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id', 'id_evento');
    }

    /**
     * Calcular puntaje final (promedio de todos los criterios)
     */
    public function calcularPuntajeFinal()
    {
        $puntajes = [
            $this->puntaje_creatividad,
            $this->puntaje_funcionalidad,
            $this->puntaje_diseño,
            $this->puntaje_presentacion,
            $this->puntaje_documentacion
        ];

        // Filtrar valores null
        $puntajes = array_filter($puntajes, fn($p) => $p !== null);

        if (empty($puntajes)) {
            return null;
        }

        return round(array_sum($puntajes) / count($puntajes), 2);
    }

    /**
     * Guardar y calcular puntaje final automáticamente
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->puntaje_final = $model->calcularPuntajeFinal();
        });
    }

    /**
     * Verificar si la calificación está completa
     */
    public function estaCompleta()
    {
        return $this->puntaje_creatividad !== null
            && $this->puntaje_funcionalidad !== null
            && $this->puntaje_diseño !== null
            && $this->puntaje_presentacion !== null;
    }

    /**
     * Obtener color según puntaje
     */
    public function obtenerColor()
    {
        if (!$this->puntaje_final) return 'gray';
        
        if ($this->puntaje_final >= 8) return 'green';
        if ($this->puntaje_final >= 6) return 'yellow';
        if ($this->puntaje_final >= 4) return 'orange';
        return 'red';
    }

    /**
     * Scope: Calificaciones de un evento
     */
    public function scopeDelEvento($query, $eventoId)
    {
        return $query->where('evento_id', $eventoId);
    }

    /**
     * Scope: Calificaciones de un juez
     */
    public function scopeDelJuez($query, $juezId)
    {
        return $query->where('juez_id', $juezId);
    }

    /**
     * Scope: Calificaciones de un equipo
     */
    public function scopeDelEquipo($query, $equipoId)
    {
        return $query->where('equipo_id', $equipoId);
    }
}
