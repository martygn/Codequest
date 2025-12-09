<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Proyecto - Juez</title>
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
        }

        .file-icon {
            font-size: 3rem;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #495057;
        }

        .progress-sm {
            height: 8px;
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
        <!-- Navegación -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('juez.panel') }}">Panel</a></li>
                <li class="breadcrumb-item"><a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}">Proyectos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ver Proyecto</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">{{ $repositorio->equipo->nombre_proyecto }}</h1>
                        <p class="mb-0 opacity-75">Equipo: {{ $repositorio->equipo->nombre }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white text-primary fs-6 px-3 py-2">
                            @if($repositorio->calificacion_total)
                                {{ $repositorio->calificacion_total }}/100
                            @else
                                Sin calificar
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información principal -->
            <div class="col-lg-8">
                <!-- Archivo del proyecto -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-file me-2"></i>Archivo del Proyecto</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center p-4 border rounded bg-light">
                            @php
                                $extension = pathinfo($repositorio->archivo_nombre, PATHINFO_EXTENSION);
                                $iconColor = $extension === 'pdf' ? 'text-danger' :
                                            ($extension === 'zip' ? 'text-warning' : 'text-primary');
                                $icon = $extension === 'pdf' ? 'file-pdf' :
                                       ($extension === 'zip' ? 'file-zipper' : 'file-powerpoint');
                            @endphp
                            <i class="fas fa-{{ $icon }} file-icon {{ $iconColor }} mb-3"></i>
                            <h5 class="mb-2">{{ $repositorio->archivo_nombre }}</h5>
                            <div class="text-muted mb-3">
                                <span class="me-3"><i class="fas fa-hdd me-1"></i> {{ number_format($repositorio->archivo_tamaño / 1024, 1) }} KB</span>
                                <span><i class="fas fa-calendar me-1"></i> {{ $repositorio->enviado_en->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ Storage::url($repositorio->archivo_path) }}"
                                   target="_blank"
                                   class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>Ver Archivo
                                </a>
                                <a href="{{ route('proyectos.download', $repositorio) }}"
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-download me-2"></i>Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Descripción del Proyecto</h5>
                    </div>
                    <div class="card-body">
                        @if($repositorio->descripcion)
                            <p class="mb-0">{{ $repositorio->descripcion }}</p>
                        @else
                            <p class="text-muted mb-0"><em>El equipo no proporcionó una descripción adicional.</em></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información lateral -->
            <div class="col-lg-4">
                <!-- Información del equipo -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Equipo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">Nombre del equipo:</h6>
                            <p class="mb-0">{{ $repositorio->equipo->nombre }}</p>
                        </div>

                        <h6 class="fw-bold mb-2">Integrantes:</h6>
                        <div class="list-group list-group-flush">
                            @foreach($repositorio->equipo->participantes as $miembro)
                            <div class="list-group-item d-flex align-items-center px-0 py-2">
                                <div class="member-avatar me-3">
                                    {{ substr($miembro->nombre, 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $miembro->nombre }}</div>
                                    <small class="text-muted">{{ $miembro->correo }}</small>
                                </div>
                                @if($miembro->id == $repositorio->equipo->id_lider)
                                    <span class="badge bg-warning text-dark">Líder</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('proyecto.juez.calificar-juez', $repositorio) }}"
                               class="btn btn-success btn-lg">
                                <i class="fas fa-star me-2"></i>
                                {{ $repositorio->calificacion_total ? 'Editar Calificación' : 'Calificar Proyecto' }}
                            </a>
                            <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
