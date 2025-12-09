<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Proyecto - Juez</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#64FFDA",
                        "background-dark": "#0A192F",
                        "card-dark": "#112240",
                        "text-dark": "#CCD6F6",
                        "text-secondary-dark": "#8892B0",
                        "border-dark": "#233554",
                        "active-dark": "rgba(100, 255, 218, 0.1)",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }

        /* Custom range input styling */
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: #233554;
            border-radius: 5px;
            outline: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #64FFDA;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #64FFDA;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        input[type="range"]::-moz-range-thumb:hover {
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }
    </style>
</head>
<body class="font-display bg-background-dark text-text-secondary-dark">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between shadow-xl">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-12 w-auto">
                    <div>
                        <h1 class="text-2xl font-bold text-text-dark">CodeQuest</h1>
                        <p class="text-xs text-text-secondary-dark">Panel del Juez</p>
                    </div>
                </div>

                <nav class="mt-8 space-y-2">
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:bg-border-dark hover:text-primary transition" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:bg-border-dark hover:text-primary transition" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Constancias</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:bg-border-dark hover:text-primary transition" href="{{ route('juez.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>

            <!-- Usuario -->
            <div class="pt-6 border-t border-border-dark">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-background-dark font-bold">
                        {{ substr(auth()->user()->nombre, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-dark">{{ auth()->user()->nombre }}</p>
                        <p class="text-xs text-text-secondary-dark">Juez</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                <!-- Navegación -->
                <nav class="mb-6 flex items-center text-sm">
                    <a href="{{ route('juez.panel') }}" class="text-primary hover:text-primary/80 transition">Panel</a>
                    <span class="mx-2 text-border-dark">/</span>
                    <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}" class="text-primary hover:text-primary/80 transition">Proyectos</a>
                    <span class="mx-2 text-border-dark">/</span>
                    <a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}" class="text-primary hover:text-primary/80 transition">Ver Proyecto</a>
                    <span class="mx-2 text-border-dark">/</span>
                    <span class="text-text-secondary-dark">Calificar</span>
                </nav>

                <!-- Header -->
                <header class="mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-4xl font-bold text-text-dark mb-2">Calificar Proyecto</h2>
                        <p class="text-text-secondary-dark">
                            <span class="font-semibold text-primary">{{ $repositorio->equipo->nombre }}</span> -
                            {{ $repositorio->equipo->nombre_proyecto }}
                        </p>
                    </div>
                    <a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}"
                       class="px-4 py-2 bg-card-dark border border-border-dark text-primary rounded-lg hover:bg-border-dark transition font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        Volver al proyecto
                    </a>
                </header>

                @if($detalleCalificacion && $detalleCalificacion['calificado_por'] == auth()->id())
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4 mb-6 flex items-start gap-3">
                    <span class="material-symbols-outlined text-blue-400 text-2xl">info</span>
                    <div>
                        <p class="text-blue-400 font-semibold">Ya has calificado este proyecto.</p>
                        <p class="text-blue-300/70 text-sm">Puedes editar tu calificación a continuación.</p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Formulario de calificación -->
                    <div class="lg:col-span-2">
                        <form action="{{ route('proyecto.juez.guardar-calificacion', $repositorio) }}" method="POST">
                            @csrf

                            <!-- Criterios de Evaluación -->
                            <div class="bg-card-dark rounded-lg shadow-xl border border-border-dark p-6 mb-6">
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="material-symbols-outlined text-primary text-2xl">star</span>
                                    <h3 class="text-2xl font-bold text-text-dark">Criterios de Evaluación</h3>
                                </div>

                                <!-- Innovación -->
                                <div class="border-l-4 border-red-500 pl-4 mb-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-xl font-semibold text-red-400">Innovación y creatividad</h4>
                                        <div class="text-3xl font-bold text-red-400" id="valorInnovacion">
                                            {{ $detalleCalificacion['innovacion'] ?? 0 }}
                                        </div>
                                    </div>
                                    <p class="text-text-secondary-dark mb-4 text-sm">Originalidad y enfoque novedoso de la solución (0-30 puntos)</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-text-secondary-dark text-sm">0</span>
                                        <input type="range" id="puntaje_innovacion" name="puntaje_innovacion"
                                               min="0" max="30" step="0.5"
                                               value="{{ $detalleCalificacion['innovacion'] ?? 15 }}"
                                               class="flex-grow-1"
                                               oninput="actualizarValor('innovacion', this.value); calcularTotal();">
                                        <span class="text-text-secondary-dark text-sm">30</span>
                                    </div>
                                </div>

                                <!-- Funcionalidad -->
                                <div class="border-l-4 border-green-500 pl-4 mb-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-xl font-semibold text-green-400">Funcionalidad técnica</h4>
                                        <div class="text-3xl font-bold text-green-400" id="valorFuncionalidad">
                                            {{ $detalleCalificacion['funcionalidad'] ?? 0 }}
                                        </div>
                                    </div>
                                    <p class="text-text-secondary-dark mb-4 text-sm">Calidad técnica y funcionamiento del proyecto (0-30 puntos)</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-text-secondary-dark text-sm">0</span>
                                        <input type="range" id="puntaje_funcionalidad" name="puntaje_funcionalidad"
                                               min="0" max="30" step="0.5"
                                               value="{{ $detalleCalificacion['funcionalidad'] ?? 15 }}"
                                               class="flex-grow-1"
                                               oninput="actualizarValor('funcionalidad', this.value); calcularTotal();">
                                        <span class="text-text-secondary-dark text-sm">30</span>
                                    </div>
                                </div>

                                <!-- Impacto -->
                                <div class="border-l-4 border-yellow-500 pl-4 mb-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-xl font-semibold text-yellow-400">Impacto y escalabilidad</h4>
                                        <div class="text-3xl font-bold text-yellow-400" id="valorImpacto">
                                            {{ $detalleCalificacion['impacto'] ?? 0 }}
                                        </div>
                                    </div>
                                    <p class="text-text-secondary-dark mb-4 text-sm">Potencial de impacto y crecimiento (0-20 puntos)</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-text-secondary-dark text-sm">0</span>
                                        <input type="range" id="puntaje_impacto" name="puntaje_impacto"
                                               min="0" max="20" step="0.5"
                                               value="{{ $detalleCalificacion['impacto'] ?? 10 }}"
                                               class="flex-grow-1"
                                               oninput="actualizarValor('impacto', this.value); calcularTotal();">
                                        <span class="text-text-secondary-dark text-sm">20</span>
                                    </div>
                                </div>

                                <!-- Presentación -->
                                <div class="border-l-4 border-cyan-500 pl-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-xl font-semibold text-cyan-400">Claridad en presentación</h4>
                                        <div class="text-3xl font-bold text-cyan-400" id="valorPresentacion">
                                            {{ $detalleCalificacion['presentacion'] ?? 0 }}
                                        </div>
                                    </div>
                                    <p class="text-text-secondary-dark mb-4 text-sm">Documentación y exposición clara (0-20 puntos)</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-text-secondary-dark text-sm">0</span>
                                        <input type="range" id="puntaje_presentacion" name="puntaje_presentacion"
                                               min="0" max="20" step="0.5"
                                               value="{{ $detalleCalificacion['presentacion'] ?? 10 }}"
                                               class="flex-grow-1"
                                               oninput="actualizarValor('presentacion', this.value); calcularTotal();">
                                        <span class="text-text-secondary-dark text-sm">20</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Comentarios -->
                            <div class="bg-card-dark rounded-lg shadow-xl border border-border-dark p-6 mb-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="material-symbols-outlined text-primary text-2xl">comment</span>
                                    <h3 class="text-2xl font-bold text-text-dark">Comentarios</h3>
                                </div>
                                <div>
                                    <label for="comentarios" class="block text-sm font-semibold text-text-dark mb-2">
                                        Comentarios para el equipo (opcional)
                                    </label>
                                    <textarea class="w-full px-4 py-3 bg-background-dark border border-border-dark rounded-lg text-text-dark placeholder-text-secondary-dark focus:outline-none focus:border-primary resize-none"
                                              id="comentarios"
                                              name="comentarios"
                                              rows="4"
                                              placeholder="Proporciona retroalimentación constructiva sobre el proyecto...">{{ $detalleCalificacion['comentarios'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <!-- Botón Guardar -->
                            <button type="submit" class="w-full px-6 py-4 bg-primary text-background-dark rounded-lg hover:bg-primary/80 transition font-bold text-lg flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-2xl">save</span>
                                {{ $detalleCalificacion ? 'Actualizar Calificación' : 'Guardar Calificación' }}
                            </button>
                        </form>
                    </div>

                    <!-- Panel de resumen -->
                    <div class="lg:col-span-1">
                        <div class="bg-card-dark rounded-lg shadow-xl border border-border-dark p-6 sticky top-8">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="material-symbols-outlined text-primary text-2xl">list</span>
                                <h3 class="text-xl font-bold text-text-dark">Resumen de Calificación</h3>
                            </div>

                            <!-- Puntuación total -->
                            <div class="text-center mb-6 p-6 bg-background-dark rounded-lg border border-border-dark">
                                <div class="text-6xl font-bold text-primary mb-2" id="puntajeTotal">
                                    {{ $detalleCalificacion ? $repositorio->calificacion_total : '0.0' }}
                                </div>
                                <div class="w-full bg-border-dark rounded-full h-3 mb-2 overflow-hidden">
                                    <div class="bg-primary h-full rounded-full transition-all duration-300" id="progressBar"
                                         style="width: {{ $detalleCalificacion ? $repositorio->calificacion_total : 0 }}%"></div>
                                </div>
                                <p class="text-text-secondary-dark text-sm">Puntuación total /100</p>
                            </div>

                            <!-- Desglose -->
                            <div class="mb-6">
                                <h4 class="font-bold text-text-dark mb-3">Desglose por criterio:</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center pb-2 border-b border-border-dark">
                                        <span class="text-red-400">Innovación</span>
                                        <span class="font-bold text-text-dark" id="desgloseInnovacion">{{ $detalleCalificacion['innovacion'] ?? 0 }}/30</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-2 border-b border-border-dark">
                                        <span class="text-green-400">Funcionalidad</span>
                                        <span class="font-bold text-text-dark" id="desgloseFuncionalidad">{{ $detalleCalificacion['funcionalidad'] ?? 0 }}/30</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-2 border-b border-border-dark">
                                        <span class="text-yellow-400">Impacto</span>
                                        <span class="font-bold text-text-dark" id="desgloseImpacto">{{ $detalleCalificacion['impacto'] ?? 0 }}/20</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-2 border-b border-border-dark">
                                        <span class="text-cyan-400">Presentación</span>
                                        <span class="font-bold text-text-dark" id="desglosePresentacion">{{ $detalleCalificacion['presentacion'] ?? 0 }}/20</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del proyecto -->
                            <div class="pt-4 border-t border-border-dark">
                                <h4 class="font-bold text-text-dark mb-3">Información del proyecto:</h4>
                                <div class="space-y-2 text-sm">
                                    <p class="text-text-secondary-dark"><strong class="text-text-dark">Equipo:</strong> {{ $repositorio->equipo->nombre }}</p>
                                    <p class="text-text-secondary-dark"><strong class="text-text-dark">Proyecto:</strong> {{ $repositorio->equipo->nombre_proyecto }}</p>
                                    <p class="text-text-secondary-dark"><strong class="text-text-dark">Archivo:</strong> {{ $repositorio->archivo_nombre }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function actualizarValor(criterio, valor) {
            const valorFormateado = parseFloat(valor).toFixed(1);
            document.getElementById(`valor${criterio.charAt(0).toUpperCase() + criterio.slice(1)}`).textContent = valorFormateado;
            const maxValor = (criterio === 'innovacion' || criterio === 'funcionalidad') ? '30' : '20';
            document.getElementById(`desglose${criterio.charAt(0).toUpperCase() + criterio.slice(1)}`).textContent = valorFormateado + '/' + maxValor;
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
