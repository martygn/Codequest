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
        'id_lider',
        'estado',
        'aprobado',
        'solicitudes_pendientes',
        'nombre_proyecto',
        'banner'
    ];

    protected $casts = [
        'aprobado' => 'boolean',
    ];

    /**
     * Mutator para estado: sincronizar con aprobado
     */
    public function setEstadoAttribute($value)
    {
        $this->attributes['estado'] = $value;

        // Sincronizar aprobado basado en estado
        if ($value === 'aprobado') {
            $this->attributes['aprobado'] = true;
        } elseif (in_array($value, ['en revisión', 'rechazado'])) {
            $this->attributes['aprobado'] = false;
        }
    }

    /**
     * Mutator para aprobado: sincronizar con estado
     */
    public function setAprobadoAttribute($value)
    {
        $this->attributes['aprobado'] = $value;

        // Sincronizar estado basado en aprobado
        if ($value === true || $value === 1) {
            $this->attributes['estado'] = 'aprobado';
        } elseif (($value === false || $value === 0) && $this->attributes['estado'] === 'aprobado') {
            // Solo cambiar estado si actualmente es "aprobado"
            $this->attributes['estado'] = 'en revisión';
        }
    }

    /**
     * Obtener solicitudes pendientes como array
     */
    public function getSolicitudesPendientesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Establecer solicitudes pendientes
     */
    public function setSolicitudesPendientesAttribute($value)
    {
        $this->attributes['solicitudes_pendientes'] = json_encode($value);
    }

    /**
     * Relación con evento (N:1)
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Relación con participantes (N:M)
     */
    public function participantes()
    {
        return $this->belongsToMany(Usuario::class, 'participante_equipo', 'equipo_id', 'usuario_id')
            ->withPivot('posicion')
            ->withTimestamps();
    }

    /**
     * Relación con el líder del equipo
     */
    public function lider()
    {
        return $this->belongsTo(Usuario::class, 'id_lider');
    }

    /**
     * Verificar si un usuario es miembro del equipo
     */
    public function tieneMiembro($usuarioId)
    {
        return $this->participantes()->where('usuario_id', $usuarioId)->exists();
    }

    /**
     * Verificar si el usuario es el líder
     */
    public function esLider($usuarioId)
    {
        return $this->id_lider == $usuarioId;
    }

    /**
     * Agregar solicitud de unión
     */
    public function agregarSolicitud($usuarioId)
    {
        $solicitudes = $this->solicitudes_pendientes;
        if (!in_array($usuarioId, $solicitudes)) {
            $solicitudes[] = $usuarioId;
            $this->solicitudes_pendientes = $solicitudes;
            return $this->save();
        }
        return false;
    }

    /**
     * Aceptar solicitud de unión
     */
    public function aceptarSolicitud($usuarioId)
    {
        $solicitudes = $this->solicitudes_pendientes;
        $index = array_search($usuarioId, $solicitudes);

        if ($index !== false) {
            unset($solicitudes[$index]);
            $this->solicitudes_pendientes = array_values($solicitudes);
            return $this->save();
        }
        return false;
    }

    /**
     * Rechazar solicitud de unión
     */
    public function rechazarSolicitud($usuarioId)
    {
        return $this->aceptarSolicitud($usuarioId);
    }

    /**
     * Verificar si el usuario tiene solicitud pendiente
     */
    public function tieneSolicitudPendiente($usuarioId)
    {
        $solicitudes = $this->solicitudes_pendientes;
        return in_array($usuarioId, $solicitudes);
    }

    /**
     * Verificar si el equipo está aprobado
     */
    public function estaAprobado()
    {
        return $this->aprobado == true || $this->aprobado == 1;
    }

    /**
     * Verificar si el equipo tiene cupo disponible
     */
    public function tieneCupoDisponible()
    {
        return $this->participantes()->count() < 4;
    }

    /**
     * Aprobar equipo
     */
    public function aprobar()
    {
        $this->aprobado = true;
        $this->estado = 'aprobado';
        return $this->save();
    }

    /**
     * Rechazar equipo
     */
    public function rechazar()
    {
        $this->aprobado = false;
        $this->estado = 'rechazado';
        return $this->save();
    }

    /**
     * Verificar si el equipo está en un evento activo
     */
    public function estaEnEventoActivo()
    {
        if (!$this->evento) {
            return false;
        }

        $now = now();
        return $now->between($this->evento->fecha_inicio, $this->evento->fecha_fin);
    }

    /**
     * Verificar si el usuario puede unirse al equipo
     */
    public function puedeUnirse($usuarioId)
    {
        if ($this->tieneMiembro($usuarioId)) {
            return false;
        }

        if ($this->tieneSolicitudPendiente($usuarioId)) {
            return false;
        }

        return $this->tieneCupoDisponible();
    }

    /**
     * Obtener la vista simplificada para admin
     */
    public function getInfoParaAdmin()
    {
        return [
            'id' => $this->id_equipo,
            'nombre' => $this->nombre,
            'nombre_proyecto' => $this->nombre_proyecto,
            'estado' => $this->estado,
            'lider' => $this->lider ? $this->lider->nombre_completo : 'Sin líder',
            'num_miembros' => $this->participantes()->count(),
            'evento' => $this->evento ? $this->evento->nombre : 'Sin evento',
            'fecha_creacion' => $this->created_at->format('d/m/Y'),
        ];
    }

    /**
     * Obtener miembros ordenados por fecha de unión (más antiguo primero)
     */
    public function miembrosOrdenados()
    {
        return $this->participantes()
            ->orderBy('participante_equipo.created_at')
            ->get();
    }

    /**
     * Obtener el siguiente en línea para liderazgo (excluyendo al líder actual)
     */
    public function obtenerSiguienteLider($excluirId)
    {
        return $this->participantes()
            ->where('usuario_id', '!=', $excluirId)
            ->orderBy('participante_equipo.created_at')
            ->first();
    }
}
