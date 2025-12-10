<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos - {{ $evento->nombre }} - Juez</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #0d1117;
            --bg-card: #161b22;
            --bg-deep: #0a192f;
            --border: #30363d;
            --text: #c9d1d9;
            --text-muted: #8b949e;
            --accent: #58a6ff;
            --success: #3fb950;
            --warning: #f0b14a;
            --danger: #f85149;
        }

        body {
            background: linear-gradient(135deg, #0a192f 0%, #0d1117 100%);
            color: var(--text);
            min-height: 100vh;
            font-family: 'Segoe UI Variable', system-ui, sans-serif;
        }

        /* Sidebar-style header */
        .page-header {
            background: linear-gradient(135deg, #0d1117, #161b22);
            border-bottom: 1px solid var(--border);
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .event-selector {
            display: inline-flex;
            background: #1f2328;
            border-radius: 50px;
            overflow: hidden;
            border: 1px solid var(--border);
            padding: 4px;
        }

        .event-tab {
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .event-tab.active {
            background: linear-gradient(90deg, #00d4aa, #00b894);
            color: black;
            font-weight: 600;
        }

        .event-tab:not(.active):hover {
            background: rgba(88, 166, 255, 0.2);
            color: var(--accent);
        }

        /* Card estilo panel */
        .event-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(88, 166, 255, 0.15);
            border-color: var(--accent);
        }

        .event-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
        }

        .badge-published {
            background: linear-gradient(90deg, #00d4aa, #00b894);
            color: black;
            font-weight: 600;
            padding: 0.4em 1em;
            border-radius: 50px;
            font-size: 0.85rem;
        }

        /* Tabla estilo GitHub */
        .table-dark-custom {
            background: transparent;
            color: var(--text);
        }

        .table-dark-custom thead th {
            background: #1f2328;
            border-bottom: 1px solid var(--border);
            color: #58a6ff;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.8px;
            font-weight: 600;
        }

        .table-dark-custom tbody td {
            border-color: var(--border);
            vertical-align: middle;
        }

        .table-dark-custom tbody tr:hover {
            background: rgba(88, 166, 255, 0.1);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #58a6ff, #1f6feb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
        }

        .badge-neon {
            background: linear-gradient(90deg, #00d4aa, #00b894);
            color: black;
            font-weight: 600;
            border-radius: 50px;
            padding: 0.35em 0.9em;
            font-size: 0.8rem;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
        }

        .btn-view { background: #238636; color: white; }
        .btn-calify { background: #bb8009; color: white; }
        .btn-download { background: #394150; color: #58a6ff; }

        .progress-thin {
            height: 6px;
            background: #30363d;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <!-- Header estilo panel -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 text-white mb-1">Panel de Evaluación</h1>
                    <p class="text-muted">Evalúa los equipos asignados en los eventos</p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="event-selector">
                    <div class="event-tab active">
                        {{ $evento->nombre }}
                    </div>
                    <!-- Puedes agregar más tabs si hay varios eventos -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <!-- Card del evento activo -->
        <div class="event-card mb-5">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h3 class="event-title">{{ $evento->nombre }}</h3>
                        <p class="text-muted mb-2">{{ $evento->descripcion }}</p>
                        <div class="d-flex gap-4 text-muted small">
                            <span>Inicia: {{ $evento->fecha_inicio->format('d M Y, H:i') }}</span>
                            <span>Finaliza: {{ $evento->fecha_fin->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge-published">Publicado</span>
                        <div class="text-muted small mt-2">{{ $proyectos->count() }} equipos asignados</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de proyectos -->
        <div class="card bg-transparent border-0 shadow-none">
            <div class="card-body p-0">
                <h4 class="mb-3 text-white">Equipos para Evaluar</h4>
                <p class="text-muted mb-4">Haz clic en "Ver Proyecto" para revisar y calificar</p>

                <div class="table-responsive">
                    <table class="table table-dark-custom table-hover">
                        <thead>
                            <tr>
                                <th>EQUIPO</th>
                                <th>PROYECTO</th>
                                <th>ESTADO</th>
                                <th>MIEMBROS</th>
                                <th>CALIFICACIÓN</th>
                                <th>ACCIONES</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proyectos as $proyecto)
                                @php
                                    $equipo = $proyecto->equipo;
                                    $calificacion = $proyecto->calificacion_total;
                                    $miembros = $equipo->participantes;
                                    $lider = $miembros->where('id', $equipo->id_lider)->first();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle">
                                                {{ substr($equipo->nombre, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-white">{{ $equipo->nombre }}</div>
                                                <small class="text-muted">{{ $equipo->nombre_proyecto }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if($proyecto->archivo_nombre)
                                            <div class="text-success small">Entregado</div>
                                            <div class="text-muted">{{ $proyecto->archivo_nombre }}</div>
                                        @else
                                            <span class="text-danger">No entregado</span>
                                        @endif
                                    </td>

                                    <td>
                                        @switch($proyecto->estado)
                                            @case('verificado')
                                                <span class="badge-neon">Aprobado</span>
                                                @break
                                            @case('rechazado')
                                                <span class="badge" style="background:#da3633;">Rechazado</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Pendiente</span>
                                        @endswitch
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            @foreach($miembros->take(3) as $m)
                                                <div class="avatar-circle" style="width:32px;height:32px;font-size:0.8rem;">
                                                    {{ substr($m->nombre, 0, 1) }}
                                                </div>
                                            @endforeach
                                            @if($miembros->count() > 3)
                                                <div class="avatar-circle bg-secondary" style="width:32px;height:32px;font-size:0.7rem;">
                                                    +{{ $miembros->count() - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if($calificacion)
                                            <div class="d-flex align-items-center gap-2">
                                                <strong class="text-success">{{ $calificacion }}/100</strong>
                                                <div class="progress-thin flex-grow-1">
                                                    <div class="bg-success" style="width: {{ $calificacion }}%; height: 100%; border-radius: 3px;"></div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-warning">Sin calificar</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('proyecto.juez.ver-juez', $proyecto) }}"
                                               class="btn-action btn-view" title="Ver proyecto">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('proyecto.juez.calificar-juez', $proyecto) }}"
                                               class="btn-action btn-calify" title="Calificar">
                                                <i class="fas fa-star"></i>
                                            </a>
                                            @if($proyecto->archivo_nombre)
                                            <a href="{{ route('proyectos.download', $proyecto) }}"
                                               class="btn-action btn-download" title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay proyectos asignados aún</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>