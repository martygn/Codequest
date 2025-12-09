<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Proyecto - CodeQuest</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 20px;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }

        .progress {
            border-radius: 10px;
            height: 20px;
        }

        .progress-bar {
            border-radius: 10px;
        }

        .badge {
            font-size: 0.85em;
            padding: 8px 12px;
        }

        .list-group-item {
            border: none;
            padding: 10px 0;
        }

        .btn-lg {
            padding: 10px 30px;
            border-radius: 10px;
            font-weight: 600;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        code {
            background-color: #e9ecef;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .bg-bronze {
            background-color: #cd7f32;
            color: white;
        }

        .text-bronze {
            color: #cd7f32;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            border-radius: 15px 15px 0 0;
        }

        .form-control-lg {
            border-radius: 10px;
            padding: 12px 15px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Card principal -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0"><i class="fas fa-upload me-2"></i>Subir Proyecto Final</h3>
                            <p class="mb-0 mt-2 opacity-75">Entrega final del proyecto del hackatón</p>
                        </div>
                        <a href="{{ route('player.equipos') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Mis Equipos
                        </a>
                    </div>
                </div>

                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Verificación de estado del evento -->
                    @php
                        $evento = $equipo->evento;
                        $hoy = now();

                        // Crear fechas con horas específicas
                        $fechaInicioEvento = \Carbon\Carbon::parse($evento->fecha_inicio)->startOfDay(); // 00:00:00
                        $fechaFinEvento = \Carbon\Carbon::parse($evento->fecha_fin)->setTime(23, 59, 59); // 23:59:59 del día de fin

                        $eventoActivo = $hoy->between($fechaInicioEvento, $fechaFinEvento);
                        $eventoFinalizado = $hoy->greaterThan($fechaFinEvento);

                        // Fecha actual para mostrar
                        $fechaEntrega = \Carbon\Carbon::now()->format('d/m/Y');
                        $horaLimite = "23:59";
                    @endphp

                    @if($eventoFinalizado)
                        <div class="alert alert-warning">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Evento Finalizado</h5>
                            <p class="mb-0">El evento <strong>"{{ $evento->nombre }}"</strong> ha finalizado. No se pueden subir proyectos después de la fecha límite.</p>
                            <hr>
                            <p class="mb-0">
                                <strong>Fecha límite:</strong> {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }} a las {{ $horaLimite }}
                            </p>
                        </div>
                    @endif

                    <!-- Información del equipo y proyecto -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Información del Proyecto</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-users me-2"></i>Equipo:</strong> <span class="badge bg-primary">{{ $equipo->nombre }}</span></p>
                                    <p><strong><i class="fas fa-project-diagram me-2"></i>Nombre del Proyecto:</strong> {{ $equipo->nombre_proyecto }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-calendar-day me-2"></i>Fecha de Entrega:</strong> {{ $fechaEntrega }}</p>
                                    <p><strong><i class="fas fa-hourglass-end me-2"></i>Hora Límite:</strong> {{ $horaLimite }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-user-shield me-2"></i>Líder del equipo:</strong> {{ $equipo->lider->nombre }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-users me-2"></i>Miembros:</strong> {{ $equipo->participantes->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción y criterios -->
                    <div class="card mb-4 border-info">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-info"></i>Descripción y Criterios de Evaluación</h5>
                        </div>
                        <div class="card-body">
                            <p class="lead">Este es el apartado destinado a la entrega final del proyecto desarrollado durante el hackatón. Cada equipo deberá subir su propuesta tecnológica cumpliendo con los lineamientos establecidos.</p>

                            <h6 class="mt-4 text-info fw-bold">Criterios de Evaluación:</h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card mb-3 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="badge bg-info me-3 p-2">30%</div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">Innovación y creatividad</h6>
                                                    <p class="text-muted small mb-0">Originalidad y enfoque novedoso de la solución</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="badge bg-info me-3 p-2">30%</div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">Funcionalidad técnica</h6>
                                                    <p class="text-muted small mb-0">Calidad técnica y funcionamiento del proyecto</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="badge bg-info me-3 p-2">20%</div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">Impacto y escalabilidad</h6>
                                                    <p class="text-muted small mb-0">Potencial de impacto y crecimiento</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="badge bg-info me-3 p-2">20%</div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">Claridad en presentación</h6>
                                                    <p class="text-muted small mb-0">Documentación y exposición clara</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reglas del evento -->
                    <div class="card mb-4 border-warning">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2 text-warning"></i>Reglas del Evento</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-light border mb-3">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-1 text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>Cada equipo debe entregar un solo proyecto</strong> en este apartado (el <strong>Líder</strong> es el encargado de subir el proyecto).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-light border mb-3">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-2 text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>El archivo debe estar identificado</strong> con el nombre del equipo y del proyecto.
                                                <br><span class="text-muted small">Ejemplo: <code>{{ str_replace(' ', '', $equipo->nombre) }}_{{ str_replace(' ', '', $equipo->nombre_proyecto) }}.pdf</code></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-light border mb-3">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-3 text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>Formatos permitidos:</strong>
                                                <div class="mt-2">
                                                    <span class="badge bg-secondary me-1">.zip</span>
                                                    <span class="badge bg-secondary me-1">.pdf</span>
                                                    <span class="badge bg-secondary me-1">.pptx</span>
                                                    <span class="text-muted small"> (Máximo 50MB)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-light border mb-3">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-4 text-primary"></i>
                                    </div>
                                            <div>
                                                <strong>La entrega debe realizarse antes de la fecha límite establecida en el hackatón.</strong>
                                                No se aceptarán entregas posteriores a las <strong>23:59</strong> del día de cierre.
                                                <br>
                                                <small class="text-muted">
                                                    Fecha límite: {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }} a las {{ $horaLimite }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-light border mb-3">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-5 text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>El proyecto debe ser original, creado durante el hackatón.</strong> De no ser así, serán sometidos a expulsión.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de calificación (si ya existe proyecto subido) -->
                    @if($equipo->repositorio)
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-star me-2 text-success"></i>Tu Trabajo: Calificación</h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6>Proyecto Subido:</h6>
                                        <p class="mb-2">
                                            <i class="fas fa-file me-2"></i>
                                            <strong>{{ $equipo->repositorio->archivo_nombre }}</strong>
                                            <span class="text-muted small ms-2">
                                                (Subido: {{ \Carbon\Carbon::parse($equipo->repositorio->enviado_en)->format('d/m/Y H:i') }})
                                            </span>
                                        </p>

                                        @if($equipo->repositorio->calificacion_total)
                                            <div class="alert alert-success mt-3">
                                                <h6 class="alert-heading"><i class="fas fa-medal me-2"></i>¡Proyecto Calificado!</h6>
                                                <div class="d-flex align-items-center mt-2">
                                                    <div class="display-6 fw-bold me-3 text-success">
                                                        {{ number_format($equipo->repositorio->calificacion_total, 1) }}/100
                                                    </div>
                                                    <div>
                                                        <div class="progress" style="height: 20px; width: 200px;">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $equipo->repositorio->calificacion_total }}%"
                                                                aria-valuenow="{{ $equipo->repositorio->calificacion_total }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">Evaluado el: {{ \Carbon\Carbon::parse($equipo->repositorio->updated_at)->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-3">
                                                <h6 class="alert-heading"><i class="fas fa-clock me-2"></i>En espera de evaluación</h6>
                                                <p class="mb-0">Tu proyecto ha sido subido exitosamente y está en espera de ser calificado por los jueces.</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-center">
                                        @if($equipo->repositorio->calificacion_total)
                                            @if($equipo->repositorio->calificacion_total >= 90)
                                                <i class="fas fa-trophy fa-4x text-warning"></i>
                                                <p class="mt-2 text-success fw-bold">¡Excelente trabajo!</p>
                                            @elseif($equipo->repositorio->calificacion_total >= 70)
                                                <i class="fas fa-medal fa-4x text-secondary"></i>
                                                <p class="mt-2 text-primary fw-bold">Buen trabajo</p>
                                            @else
                                                <i class="fas fa-award fa-4x text-bronze"></i>
                                                <p class="mt-2 text-bronze fw-bold">Proyecto aceptado</p>
                                            @endif
                                        @else
                                            <i class="fas fa-hourglass-half fa-4x text-info"></i>
                                            <p class="mt-2 text-muted">En evaluación</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Formulario para subir proyecto (solo si evento está activo) -->
                    @if($eventoActivo && !$equipo->repositorio)
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Subir Archivo del Proyecto</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('proyecto.store', $equipo) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                                    @csrf
                                    <input type="hidden" name="equipo_id" value="{{ $equipo->id_equipo }}">

                                    <div class="mb-4">
                                        <label for="archivo" class="form-label fw-bold">
                                            <i class="fas fa-file-upload me-2"></i>Seleccionar archivo
                                        </label>
                                        <input type="file" class="form-control form-control-lg"
                                               id="archivo" name="archivo"
                                               accept=".zip,.pdf,.pptx" required>
                                        <div class="form-text">
                                            Formatos aceptados: ZIP (comprimido), PDF (documentación), PPTX (presentación) - Máximo 50MB
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="descripcion_entrega" class="form-label fw-bold">
                                            <i class="fas fa-comment me-2"></i>Comentarios adicionales (opcional)
                                        </label>
                                        <textarea class="form-control" id="descripcion_entrega"
                                                  name="descripcion_entrega" rows="3"
                                                  placeholder="Agrega cualquier comentario o aclaración sobre tu entrega..."></textarea>
                                    </div>

                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>¡Atención!</strong> Una vez subido el archivo, no podrás modificarlo. Asegúrate de que sea la versión final de tu proyecto.
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="button" class="btn btn-success btn-lg px-4" onclick="confirmUpload()">
                                            <i class="fas fa-upload me-2"></i>Subir Proyecto
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif($equipo->repositorio)
                        <div class="alert alert-info">
                            <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Proyecto ya subido</h5>
                            <p>Ya has subido un proyecto para este equipo. Si necesitas modificarlo, contacta a un administrador.</p>
                            <a href="{{ Storage::url($equipo->repositorio->archivo_path) }}"
                               class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-eye me-1"></i>Ver proyecto subido
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Footer informativo -->
                <div class="card-footer bg-light py-3">
                    <div class="row text-center text-muted small">
                        <div class="col-md-3">
                            <i class="fas fa-user-shield me-1"></i> Líder: {{ $equipo->lider->nombre }}
                        </div>
                        <div class="col-md-3">
                            <i class="fas fa-calendar-alt me-1"></i> Evento: {{ $evento->nombre }}
                        </div>
                        <div class="col-md-3">
                            <i class="fas fa-users me-1"></i> Miembros: {{ $equipo->participantes->count() }}
                        </div>
                        <div class="col-md-3">
                            <i class="fas fa-clock me-1"></i> Hora límite: {{ $horaLimite }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar Entrega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas subir este archivo como la entrega final de tu proyecto?</p>
                <p class="fw-bold text-danger">⚠️ Una vez subido, no podrás modificarlo.</p>
                <div class="alert alert-danger small">
                    <i class="fas fa-ban me-2"></i>
                    Asegúrate de que cumple con todas las reglas antes de confirmar.
                </div>
                <ul class="small">
                    <li>¿El archivo tiene el formato correcto (.zip, .pdf, .pptx)?</li>
                    <li>¿El archivo pesa menos de 50MB?</li>
                    <li>¿El archivo está identificado correctamente?</li>
                    <li>¿Es la versión final del proyecto?</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmUpload">
                    <i class="fas fa-check me-2"></i>Sí, subir proyecto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmUpload() {
    const fileInput = document.getElementById('archivo');
    const file = fileInput.files[0];

    if (!file) {
        alert('Por favor, selecciona un archivo para subir.');
        return;
    }

    // Validación de tamaño de archivo
    const maxSize = 50 * 1024 * 1024; // 50MB
    if (file.size > maxSize) {
        alert('El archivo es demasiado grande. El tamaño máximo permitido es 50MB.');
        return;
    }

    // Validación de extensión
    const allowedExtensions = ['.zip', '.pdf', '.pptx'];
    const fileName = file.name.toLowerCase();
    const isValidExtension = allowedExtensions.some(ext => fileName.endsWith(ext));

    if (!isValidExtension) {
        alert('Formato de archivo no permitido. Solo se aceptan: .zip, .pdf, .pptx');
        return;
    }

    // Mostrar modal de confirmación
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Configurar evento para confirmar envío
    document.getElementById('confirmUpload').addEventListener('click', function() {
        document.getElementById('uploadForm').submit();
    });

    // Mostrar nombre del archivo seleccionado
    document.getElementById('archivo').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'No se eligió ningún archivo';
        const label = e.target.previousElementSibling;
        label.innerHTML = `<i class="fas fa-file-upload me-2"></i>${fileName}`;
    });
});
</script>
</body>
</html>
