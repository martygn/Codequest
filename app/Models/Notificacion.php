<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'mensaje',
        'tipo',
        'leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
    ];

    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    /**
     * Scope para notificaciones no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }
}
