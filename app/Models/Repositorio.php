<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repositorio extends Model
{
    use HasFactory;

    protected $table = 'repositorios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'equipo_id',
        'evento_id',
        'url_github',
        'url_gitlab',
        'url_bitbucket',
        'url_personalizado',
        'archivo_path',
        'archivo_nombre',
        'archivo_tamaño',
        'descripcion',
        'rama_produccion',
        'estado',
        'verificado_por',
        'enviado_en',
        'vencimiento_envio'
    ];

    protected $casts = [
        'enviado_en' => 'datetime',
        'vencimiento_envio' => 'datetime',
    ];

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
     * Relación con usuario verificador (N:1)
     */
    public function verificador()
    {
        return $this->belongsTo(Usuario::class, 'verificado_por', 'id');
    }

    /**
     * Verificar si el repositorio fue enviado
     */
    public function estaEnviado()
    {
        return $this->estado !== 'no_enviado';
    }

    /**
     * Verificar si el repositorio está verificado
     */
    public function estaVerificado()
    {
        return $this->estado === 'verificado';
    }

    /**
     * Obtener URL del repositorio (prioridad: personalizado > github > gitlab > bitbucket)
     */
    public function obtenerUrl()
    {
        return $this->url_personalizado 
            ?? $this->url_github 
            ?? $this->url_gitlab 
            ?? $this->url_bitbucket;
    }

    /**
     * Obtener tipo de repositorio
     */
    public function obtenerTipo()
    {
        if ($this->url_github) return 'GitHub';
        if ($this->url_gitlab) return 'GitLab';
        if ($this->url_bitbucket) return 'Bitbucket';
        if ($this->url_personalizado) return 'Personalizado';
        if ($this->archivo_path) return 'Archivo (ZIP)';
        return 'No especificado';
    }

    /**
     * Marcar como enviado
     */
    public function marcarEnviado()
    {
        $this->estado = 'enviado';
        $this->enviado_en = now();
        return $this->save();
    }

    /**
     * Marcar como verificado
     */
    public function marcarVerificado($usuarioId)
    {
        $this->estado = 'verificado';
        $this->verificado_por = $usuarioId;
        return $this->save();
    }

    /**
     * Marcar como rechazado
     */
    public function marcarRechazado()
    {
        $this->estado = 'rechazado';
        return $this->save();
    }
}
