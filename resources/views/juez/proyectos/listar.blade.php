<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos - {{ $evento->nombre }} - Juez</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            border-radius: 10px 10px 0 0;
            background-color: #2c3e50;
            color: white;
        }

        .badge-estado {
            font-size: 0.75em;
            padding: 5px 10px;
        }

        .table th {
            background-color: #f1f5f9;
            font-weight: 600;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('juez.panel') }}">Panel del Juez</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('juez.panel') }}">Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Proyectos - {{ $evento->nombre }}</h1>
                <p class="text-muted">Revisa y califica los proyectos de los equipos</p>
            </div>
            <div>
                <a href="{{ route('juez.panel') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                </a>
            </div>
        </div>

        <!-- Tabla de proyectos -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Lista de Proyectos</h5>
            </div>
            <div class="card-body p-0">
                @if($proyectos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="20%">Equipo</th>
                                    <th width="25%">Proyecto</th>
                                    <th width="15%">Fecha de entrega</th>
                                    <th width="15%">Estado</th>
                                    <th width="15%">Calificación</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proyectos as $proyecto)
                                @php
                                    $equipo = $proyecto->equipo;
                                    $calificacion = $proyecto->calificacion_total;
                                @endphp
                                <tr>
                                    <!-- Equipo -->
                                    <td>
                                        <div class="fw-bold">{{ $equipo->nombre }}</div>
                                        <small class="text-muted">{{ $equipo->nombre_proyecto }}</small>
                                    </td>

                                    <!-- Proyecto -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $extension = pathinfo($proyecto->archivo_nombre, PATHINFO_EXTENSION);
                                                $iconColor = $extension === 'pdf' ? 'text-danger' :
                                                            ($extension === 'zip' ? 'text-warning' : 'text-primary');
                                                $icon = $extension === 'pdf' ? 'file-pdf' :
                                                       ($extension === 'zip' ? 'file-zipper' : 'file-powerpoint');
                                            @endphp
                                            <i class="fas fa-{{ $icon }} fa-lg {{ $iconColor }} me-2"></i>
                                            <div>
                                                <div class="fw-medium">{{ $proyecto->archivo_nombre }}</div>
                                                <small class="text-muted">
                                                    {{ number_format($proyecto->archivo_tamaño / 1024, 1) }} KB
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Fecha -->
                                    <td>
                                        <div>{{ $proyecto->enviado_en->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $proyecto->enviado_en->format('H:i') }}</small>
                                    </td>

                                    <!-- Estado -->
                                    <td>
                                        @if($proyecto->estado == 'verificado')
                                            <span class="badge bg-success badge-estado">Verificado</span>
                                        @elseif($proyecto->estado == 'rechazado')
                                            <span class="badge bg-danger badge-estado">Rechazado</span>
                                        @else
                                            <span class="badge bg-warning badge-estado">Enviado</span>
                                        @endif
                                    </td>

                                    <!-- Calificación -->
                                    <td>
                                        @if($calificacion)
                                            <div class="d-flex align-items-center">
                                                <span class="fw-bold text-success me-2">{{ $calificacion }}/100</span>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $calificacion }}%"></div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-warning fw-medium">Pendiente</span>
                                        @endif
                                    </td>

                                    <!-- Acciones -->
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('proyecto.juez.ver-juez', $proyecto) }}"
                                               class="btn btn-outline-primary" title="Ver proyecto">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('proyecto.juez.calificar-juez', $proyecto) }}"
                                               class="btn btn-outline-success {{ $calificacion ? 'btn-warning' : 'btn-success' }}"
                                               title="{{ $calificacion ? 'Editar calificación' : 'Calificar' }}">
                                                <i class="fas fa-star"></i>
                                            </a>
                                            <a href="{{ route('proyectos.download', $proyecto) }}"
                                               class="btn btn-outline-info" title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted mb-2">No hay proyectos aún</h4>
                        <p class="text-muted">Los equipos aún no han subido sus proyectos para este evento.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        @if($proyectos->count() > 0)
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total</h6>
                                <h3 class="mb-0">{{ $proyectos->count() }}</h3>
                            </div>
                            <i class="fas fa-folder fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Calificados</h6>
                                <h3 class="mb-0">{{ $proyectos->whereNotNull('calificacion_total')->count() }}</h3>
                            </div>
                            <i class="fas fa-check-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Pendientes</h6>
                                <h3 class="mb-0">{{ $proyectos->whereNull('calificacion_total')->count() }}</h3>
                            </div>
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Verificados</h6>
                                <h3 class="mb-0">{{ $proyectos->where('estado', 'verificado')->count() }}</h3>
                            </div>
                            <i class="fas fa-shield-check fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
