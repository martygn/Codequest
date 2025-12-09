<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Proyecto - {{ $repositorio->equipo->nombre_proyecto }}</title>

    <!-- Bootstrap 5.3 + Dark Mode -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --bs-body-bg: #0d1117;
            --bs-body-color: #c9d1d9;
            --card-bg: #161b22;
            --border-color: #30363d;
            --primary-glow: #58a6ff;
            --success-glow: #3fb950;
        }

        body {
            background: "background-dark": "#0A192F",
            color: #c9d1d9;
            min-height: 100vh;
            font-family: 'Segoe UI Variable', 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #161b22 !important;
            border-bottom: 1px solid var(--border-color);
        }

        .breadcrumb {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .breadcrumb-item a {
            color: #58a6ff;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #8b949e;
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: var(--primary-glow);
            box-shadow: 0 0 25px rgba(88, 166, 255, 0.25);
        }

        .card-header {
            background: linear-gradient(90deg, #1f6feb, #388bfd);
            color: white;
            border-bottom: none;
            font-weight: 600;
        }

        .header-project {
            background: linear-gradient(135deg, #1f6feb, #388bfd);
            border: none;
            color: white;
        }

        .header-project .badge {
            background-color: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            font-size: 1.1rem;
        }

        .file-box {
            background-color: #21262d;
            border: 2px dashed #30363d;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
        }

        .file-box:hover {
            border-color: #58a6ff;
            background-color: #1a2332;
        }

        .file-icon {
            font-size: 4.5rem;
            margin-bottom: 1rem;
        }

        .member-avatar {
            width: 48px;
            height: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #58a6ff, #1f6feb);
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .btn-success {
            background: linear-gradient(90deg, #238636, #56d364);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #1a6b92c, #40a02b);
            transform: translateY(-2px);
        }

        .text-primary { color: #58a6ff !important; }
        .text-success { color: #3fb950 !important; }
        .text-muted { color: #8b949e !important; }

        .list-group-item {
            background-color: transparent;
            border-color: var(--border-color);
            padding: 0.75rem 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('juez.panel') }}">
                Panel del Juez
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('juez.panel') }}">Inicio</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('juez.panel') }}">Panel</a></li>
                <li class="breadcrumb-item"><a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}">Proyectos</a></li>
                <li class="breadcrumb-item active">Ver Proyecto</li>
            </ol>
        </nav>

        <!-- Header del proyecto -->
        <div class="card header-project mb-5">
            <div class="card-body py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <div>
                        <h1 class="h3 mb-2">{{ $repositorio->equipo->nombre_proyecto }}</h1>
                        <p class="mb-0 opacity-90">
                            Equipo: <strong>{{ $repositorio->equipo->nombre }}</strong>
                        </p>
                    </div>
                    <div class="text-md-end">
                        <span class="badge px-4 py-3 fs-5">
                            @if($repositorio->calificacion_total)
                                {{ $repositorio->calificacion_total }} / 100
                            @else
                                Sin calificar
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Columna principal -->
            <div class="col-lg-8">

                <!-- Archivo del proyecto -->
                <div class="card mb-4">
                    <div class="card-header">
                        Archivo del Proyecto
                    </div>
                    <div class="card-body">
                        <div class="file-box">
                            @php
                                $extension = pathinfo($repositorio->archivo_nombre, PATHINFO_EXTENSION);
                                $icon = $extension === 'pdf' ? 'file-pdf text-danger' :
                                       ($extension === 'zip' ? 'file-zipper text-warning' : 'file-code text-info');
                            @endphp
                            <i class="fas fa-{{ $icon }} file-icon"></i>
                            <h5 class="mb-3">{{ $repositorio->archivo_nombre }}</h5>
                            <div class="text-muted mb-4">
                                <i class="fas fa-hdd me-2"></i> {{ number_format($repositorio->archivo_tamaño / 1024, 1) }} KB<br>
                                <i class="fas fa-calendar-alt me-2 mt-2"></i> {{ $repositorio->enviado_en->format('d/m/Y \a \l\a\s H:i') }}
                            </div>
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ Storage::url($repositorio->archivo_path) }}" target="_blank"
                                   class="btn btn-primary btn-lg px-4">
                                    Ver Archivo
                                </a>
                                <a href="{{ route('proyectos.download', $repositorio) }}"
                                   class="btn btn-outline-light btn-lg px-4">
                                    Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="card">
                    <div class="card-header">
                        Descripción del Proyecto
                    </div>
                    <div class="card-body">
                        @if($repositorio->descripcion)
                            <p class="lead">{{ $repositorio->descripcion }}</p>
                        @else
                            <p class="text-muted fst-italic">
                                El equipo no proporcionó una descripción adicional.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Equipo -->
                <div class="card mb-4">
                    <div class="card-header">
                        Equipo
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Nombre del equipo:</h6>
                        <p class="mb-4">{{ $repositorio->equipo->nombre }}</p>

                        <h6 class="fw-bold mb-3">Integrantes:</h6>
                        <div class="list-group list-group-flush">
                            @foreach($repositorio->equipo->participantes as $miembro)
                                <div class="list-group-item d-flex align-items-center py-3">
                                    <div class="member-avatar me-3">
                                        {{ substr($miembro->nombre, 0, 1) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">{{ $miembro->nombre }}</div>
                                        <small class="text-muted">{{ $miembro->correo }}</small>
                                    </div>
                                    @if($miembro->id == $repositorio->equipo->id_lider)
                                        <span class="badge bg-warning text-dark rounded-pill px-3">Líder</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="card">
                    <div class="card-header">
                        Acciones
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('proyecto.juez.calificar-juez', $repositorio) }}"
                               class="btn btn-success btn-lg shadow">
                                {{ $repositorio->calificacion_total ? 'Editar Calificación' : 'Calificar Proyecto' }}
                            </a>
                            <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}"
                               class="btn btn-outline-secondary">
                                Volver a la lista
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>