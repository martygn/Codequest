<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Equipo;

class JuezController extends Controller
{
    /**
     * Panel principal del juez - Muestra el evento asignado y equipos a evaluar
     */
    public function panel()
    {
        $juez = auth()->user();
        
        if (!$juez || !method_exists($juez, 'esJuez') || !$juez->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Obtener los eventos asignados al juez
        $eventosAsignados = $juez->eventosAsignados()->get();

        // Si hay eventos, obtener el primero (el actual)
        $evento = $eventosAsignados->first();
        $equipos = [];

        if ($evento) {
            // Obtener los equipos del evento asignado
            $equipos = Equipo::where('id_evento', $evento->id_evento)
                ->with('participantes', 'lider')
                ->orderBy('nombre')
                ->get();
        }

        return view('juez.panel', compact('juez', 'evento', 'equipos', 'eventosAsignados'));
    }

    /**
     * Historial de constancias generadas por el juez
     */
    public function historialConstancias()
    {
        $juez = auth()->user();
        
        if (!$juez || !method_exists($juez, 'esJuez') || !$juez->esJuez()) {
            abort(403, 'Acceso no autorizado.');
        }

        // Aquí se cargarían las constancias generadas por este juez
        // Por ahora, devolvemos una lista vacía (se implementará con la BD de constancias)
        $constancias = [];

        return view('juez.constancias', compact('constancias', 'juez'));
    }
}
