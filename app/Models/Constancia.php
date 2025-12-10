<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    protected $table = 'constancias';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_evento',
        'id_equipo',
        'id_juez',
        'ruta_pdf',
        'fecha_generacion',
        'fecha_envio',
    ];

    protected $casts = [
        'fecha_generacion' => 'datetime',
        'fecha_envio' => 'datetime',
    ];

    // Relaciones
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    public function juez()
    {
        return $this->belongsTo(Usuario::class, 'id_juez', 'id');
    }
}
