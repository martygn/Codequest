<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Proyecto - Juez</title>
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

        .criterio-item {
            border-left: 4px solid #0d6efd;
            padding-left: 15px;
            margin-bottom: 20px;
        }

        .criterio-item.innovacion { border-color: #dc3545; }
        .criterio-item.funcionalidad { border-color: #198754; }
        .criterio-item.impacto { border-color: #ffc107; }
        .criterio-item.presentacion { border-color: #0dcaf0; }

        .range-value {
            font-size: 1.5rem;
            font-weight: bold;
            min-width: 50px;
            text-align: center;
        }

        input[type="range"] {
            width: 100%;
            height: 10px;
            -webkit-appearance: none;
            background: #e9ecef;
            border-radius: 5px;
            outline: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #0d6efd;
            cursor: pointer;
        }

        .total-score {
            font-size: 3rem;
            font-weight: bold;
        }

        .progress-lg {
            height: 20px;
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
                <li class="breadcrumb-item"><a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}">Ver Proyecto</a></li>
                <li class="breadcrumb-item active" aria-current="page">Calificar</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1">Calificar Proyecto</h1>
                        <p class="mb-0 opacity-75">{{ $repositorio->equipo->nombre }} - {{ $repositorio->equipo->nombre_proyecto }}</p>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}"
                           class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver al proyecto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if($detalleCalificacion && $detalleCalificacion['calificado_por'] == auth()->id())
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Ya has calificado este proyecto.</strong> Puedes editar tu calificación a continuación.
        </div>
        @endif

        <div class="row">
            <!-- Formulario de calificación -->
            <div class="col-lg-8">
                <form action="{{ route('proyecto.juez.guardar-calificacion', $repositorio) }}" method="POST">
                    @csrf

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-star me-2"></i>Criterios de Evaluación</h5>
                        </div>
                        <div class="card-body">
                            <!-- Innovación -->
                            <div class="criterio-item innovacion mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0 text-danger">Innovación y creatividad</h5>
                                    <div class="range-value text-danger" id="valorInnovacion">
                                        {{ $detalleCalificacion['innovacion'] ?? 0 }}
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Originalidad y enfoque novedoso de la solución (0-30 puntos)</p>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 text-muted">0</span>
                                    <input type="range" id="puntaje_innovacion" name="puntaje_innovacion"
                                           min="0" max="30" step="0.5"
                                           value="{{ $detalleCalificacion['innovacion'] ?? 15 }}"
                                           class="flex-grow-1"
                                           oninput="actualizarValor('innovacion', this.value); calcularTotal();">
                                    <span class="ms-2 text-muted">30</span>
                                </div>
                            </div>

                            <!-- Funcionalidad -->
                            <div class="criterio-item funcionalidad mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0 text-success">Funcionalidad técnica</h5>
                                    <div class="range-value text-success" id="valorFuncionalidad">
                                        {{ $detalleCalificacion['funcionalidad'] ?? 0 }}
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Calidad técnica y funcionamiento del proyecto (0-30 puntos)</p>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 text-muted">0</span>
                                    <input type="range" id="puntaje_funcionalidad" name="puntaje_funcionalidad"
                                           min="0" max="30" step="0.5"
                                           value="{{ $detalleCalificacion['funcionalidad'] ?? 15 }}"
                                           class="flex-grow-1"
                                           oninput="actualizarValor('funcionalidad', this.value); calcularTotal();">
                                    <span class="ms-2 text-muted">30</span>
                                </div>
                            </div>

                            <!-- Impacto -->
                            <div class="criterio-item impacto mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0 text-warning">Impacto y escalabilidad</h5>
                                    <div class="range-value text-warning" id="valorImpacto">
                                        {{ $detalleCalificacion['impacto'] ?? 0 }}
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Potencial de impacto y crecimiento (0-20 puntos)</p>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 text-muted">0</span>
                                    <input type="range" id="puntaje_impacto" name="puntaje_impacto"
                                           min="0" max="20" step="0.5"
                                           value="{{ $detalleCalificacion['impacto'] ?? 10 }}"
                                           class="flex-grow-1"
                                           oninput="actualizarValor('impacto', this.value); calcularTotal();">
                                    <span class="ms-2 text-muted">20</span>
                                </div>
                            </div>

                            <!-- Presentación -->
                            <div class="criterio-item presentacion mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0 text-info">Claridad en presentación</h5>
                                    <div class="range-value text-info" id="valorPresentacion">
                                        {{ $detalleCalificacion['presentacion'] ?? 0 }}
                                    </div>
                                </div>
                                <p class="text-muted mb-3">Documentación y exposición clara (0-20 puntos)</p>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 text-muted">0</span>
                                    <input type="range" id="puntaje_presentacion" name="puntaje_presentacion"
                                           min="0" max="20" step="0.5"
                                           value="{{ $detalleCalificacion['presentacion'] ?? 10 }}"
                                           class="flex-grow-1"
                                           oninput="actualizarValor('presentacion', this.value); calcularTotal();">
                                    <span class="ms-2 text-muted">20</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comentarios -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-comment me-2"></i>Comentarios</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="comentarios" class="form-label">Comentarios para el equipo (opcional)</label>
                                <textarea class="form-control" id="comentarios" name="comentarios" rows="4"
                                          placeholder="Proporciona retroalimentación constructiva sobre el proyecto...">{{ $detalleCalificacion['comentarios'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg py-3">
                            <i class="fas fa-save me-2"></i>
                            {{ $detalleCalificacion ? 'Actualizar Calificación' : 'Guardar Calificación' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Panel de resumen -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Resumen de Calificación</h5>
                    </div>
                    <div class="card-body">
                        <!-- Puntuación total -->
                        <div class="text-center mb-4">
                            <div class="total-score text-primary mb-2" id="puntajeTotal">
                                {{ $detalleCalificacion ? $repositorio->calificacion_total : '0' }}
                            </div>
                            <div class="progress progress-lg mb-2">
                                <div class="progress-bar bg-primary" id="progressBar"
                                     style="width: {{ $detalleCalificacion ? $repositorio->calificacion_total : 0 }}%"></div>
                            </div>
                            <p class="text-muted mb-0">Puntuación total /100</p>
                        </div>

                        <!-- Desglose -->
                        <h6 class="fw-bold mb-3">Desglose por criterio:</h6>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-danger">Innovación</span>
                                <span class="fw-bold" id="desgloseInnovacion">{{ $detalleCalificacion['innovacion'] ?? 0 }}/30</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-success">Funcionalidad</span>
                                <span class="fw-bold" id="desgloseFuncionalidad">{{ $detalleCalificacion['funcionalidad'] ?? 0 }}/30</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-warning">Impacto</span>
                                <span class="fw-bold" id="desgloseImpacto">{{ $detalleCalificacion['impacto'] ?? 0 }}/20</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-info">Presentación</span>
                                <span class="fw-bold" id="desglosePresentacion">{{ $detalleCalificacion['presentacion'] ?? 0 }}/20</span>
                            </li>
                        </ul>

                        <!-- Información del proyecto -->
                        <div class="border-top pt-3">
                            <h6 class="fw-bold mb-2">Información del proyecto:</h6>
                            <p class="mb-1"><small><strong>Equipo:</strong> {{ $repositorio->equipo->nombre }}</small></p>
                            <p class="mb-1"><small><strong>Proyecto:</strong> {{ $repositorio->equipo->nombre_proyecto }}</small></p>
                            <p class="mb-0"><small><strong>Archivo:</strong> {{ $repositorio->archivo_nombre }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function actualizarValor(criterio, valor) {
            document.getElementById(`valor${criterio.charAt(0).toUpperCase() + criterio.slice(1)}`).textContent = valor;
            document.getElementById(`desglose${criterio.charAt(0).toUpperCase() + criterio.slice(1)}`).textContent = valor + '/' +
                (criterio === 'innovacion' || criterio === 'funcionalidad' ? '30' : '20');
        }

        function calcularTotal() {
            const innovacion = parseFloat(document.getElementById('puntaje_innovacion').value) || 0;
            const funcionalidad = parseFloat(document.getElementById('puntaje_funcionalidad').value) || 0;
            const impacto = parseFloat(document.getElementById('puntaje_impacto').value) || 0;
            const presentacion = parseFloat(document.getElementById('puntaje_presentacion').value) || 0;

            const total = innovacion + funcionalidad + impacto + presentacion;

            document.getElementById('puntajeTotal').textContent = total.toFixed(1);
            document.getElementById('progressBar').style.width = total + '%';

            // Actualizar desglose
            actualizarValor('innovacion', innovacion);
            actualizarValor('funcionalidad', funcionalidad);
            actualizarValor('impacto', impacto);
            actualizarValor('presentacion', presentacion);
        }

        // Calcular total inicial
        document.addEventListener('DOMContentLoaded', function() {
            calcularTotal();

            // Agregar event listeners a todos los sliders
            document.querySelectorAll('input[type="range"]').forEach(slider => {
                slider.addEventListener('input', calcularTotal);
            });
        });
    </script>
</body>
</html>
