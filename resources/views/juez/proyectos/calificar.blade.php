<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Calificar Proyecto - CodeQuest</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        // PALETA "DARK TECH"
                        primary: "#64FFDA", // Turquesa
                        "background-dark": "#0A192F",  // Azul Muy Oscuro
                        "card-dark": "#112240",        // Azul Profundo
                        "text-dark": "#CCD6F6",        // Azul Claro
                        "text-secondary-dark": "#8892B0", // Gris Azulado
                        "border-dark": "#233554",      // Bordes
                        "active-dark": "rgba(100, 255, 218, 0.1)", // Hover activo
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
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Scrollbar oscura para que combine */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0A192F; }
        ::-webkit-scrollbar-thumb { background: #233554; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64FFDA; }

        /* Custom range slider styling */
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
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #64FFDA;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
            border: none;
        }
    </style>
</head>
<body class="bg-background-dark font-display text-text-dark antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between shadow-xl z-20">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
                    <div>
                        <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
                        <p class="text-xs text-text-secondary-dark mt-1">Panel del Juez</p>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Constancias</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="pt-6 border-t border-border-dark">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 overflow-y-auto bg-background-dark p-8 relative">

            <!-- Efecto de fondo -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto relative z-10">

                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center gap-2 text-sm">
                        <li><a href="{{ route('juez.panel') }}" class="text-text-secondary-dark hover:text-primary transition-colors">Panel</a></li>
                        <li class="text-text-secondary-dark">/</li>
                        <li><a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}" class="text-text-secondary-dark hover:text-primary transition-colors">Ver Proyecto</a></li>
                        <li class="text-text-secondary-dark">/</li>
                        <li class="text-primary">Calificar</li>
                    </ol>
                </nav>

                <!-- Header -->
                <div class="mb-8 bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-text-dark">Calificar Proyecto</h1>
                            <p class="text-text-secondary-dark mt-2">{{ $repositorio->equipo->nombre }} - {{ $repositorio->equipo->nombre_proyecto }}</p>
                        </div>
                        <a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}" class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition-all">
                            <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
                            Volver al proyecto
                        </a>
                    </div>
                </div>

                @if($detalleCalificacion && $detalleCalificacion['calificado_por'] == auth()->id())
                <div class="mb-6 bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl flex items-center gap-2">
                    <span class="material-symbols-outlined">info</span>
                    <span><strong>Ya has calificado este proyecto.</strong> Puedes editar tu calificación a continuación.</span>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Formulario de calificación -->
                    <div class="lg:col-span-2 space-y-6">
                        <form action="{{ route('proyecto.juez.guardar-calificacion', $repositorio) }}" method="POST">
                            @csrf

                            <!-- Criterios de Evaluación -->
                            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden mb-6">
                                <div class="px-6 py-4 border-b border-border-dark">
                                    <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary">star</span>
                                        Criterios de Evaluación
                                    </h3>
                                </div>
                                <div class="p-6 space-y-6">

                                    <!-- Innovación -->
                                    <div class="border-l-4 border-red-500 pl-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="text-lg font-bold text-red-400">Innovación y creatividad</h4>
                                            <div class="text-2xl font-bold text-red-400" id="valorInnovacion">
                                                {{ $detalleCalificacion['innovacion'] ?? 0 }}
                                            </div>
                                        </div>
                                        <p class="text-text-secondary-dark text-sm mb-3">Originalidad y enfoque novedoso de la solución (0-30 puntos)</p>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-text-secondary-dark">0</span>
                                            <input type="range" id="puntaje_innovacion" name="puntaje_innovacion"
                                                   min="0" max="30" step="0.5"
                                                   value="{{ $detalleCalificacion['innovacion'] ?? 15 }}"
                                                   class="flex-1"
                                                   oninput="actualizarValor('innovacion', this.value); calcularTotal();">
                                            <span class="text-xs text-text-secondary-dark">30</span>
                                        </div>
                                    </div>

                                    <!-- Funcionalidad -->
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="text-lg font-bold text-green-400">Funcionalidad técnica</h4>
                                            <div class="text-2xl font-bold text-green-400" id="valorFuncionalidad">
                                                {{ $detalleCalificacion['funcionalidad'] ?? 0 }}
                                            </div>
                                        </div>
                                        <p class="text-text-secondary-dark text-sm mb-3">Calidad técnica y funcionamiento del proyecto (0-30 puntos)</p>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-text-secondary-dark">0</span>
                                            <input type="range" id="puntaje_funcionalidad" name="puntaje_funcionalidad"
                                                   min="0" max="30" step="0.5"
                                                   value="{{ $detalleCalificacion['funcionalidad'] ?? 15 }}"
                                                   class="flex-1"
                                                   oninput="actualizarValor('funcionalidad', this.value); calcularTotal();">
                                            <span class="text-xs text-text-secondary-dark">30</span>
                                        </div>
                                    </div>

                                    <!-- Impacto -->
                                    <div class="border-l-4 border-yellow-500 pl-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="text-lg font-bold text-yellow-400">Impacto y escalabilidad</h4>
                                            <div class="text-2xl font-bold text-yellow-400" id="valorImpacto">
                                                {{ $detalleCalificacion['impacto'] ?? 0 }}
                                            </div>
                                        </div>
                                        <p class="text-text-secondary-dark text-sm mb-3">Potencial de impacto y crecimiento (0-20 puntos)</p>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-text-secondary-dark">0</span>
                                            <input type="range" id="puntaje_impacto" name="puntaje_impacto"
                                                   min="0" max="20" step="0.5"
                                                   value="{{ $detalleCalificacion['impacto'] ?? 10 }}"
                                                   class="flex-1"
                                                   oninput="actualizarValor('impacto', this.value); calcularTotal();">
                                            <span class="text-xs text-text-secondary-dark">20</span>
                                        </div>
                                    </div>

                                    <!-- Presentación -->
                                    <div class="border-l-4 border-cyan-500 pl-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="text-lg font-bold text-cyan-400">Claridad en presentación</h4>
                                            <div class="text-2xl font-bold text-cyan-400" id="valorPresentacion">
                                                {{ $detalleCalificacion['presentacion'] ?? 0 }}
                                            </div>
                                        </div>
                                        <p class="text-text-secondary-dark text-sm mb-3">Documentación y exposición clara (0-20 puntos)</p>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-text-secondary-dark">0</span>
                                            <input type="range" id="puntaje_presentacion" name="puntaje_presentacion"
                                                   min="0" max="20" step="0.5"
                                                   value="{{ $detalleCalificacion['presentacion'] ?? 10 }}"
                                                   class="flex-1"
                                                   oninput="actualizarValor('presentacion', this.value); calcularTotal();">
                                            <span class="text-xs text-text-secondary-dark">20</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Comentarios -->
                            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden mb-6">
                                <div class="px-6 py-4 border-b border-border-dark">
                                    <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary">comment</span>
                                        Comentarios
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <label for="comentarios" class="block text-xs font-mono text-primary uppercase mb-3">Comentarios para el equipo (opcional)</label>
                                    <textarea class="w-full px-4 py-3 bg-background-dark border border-border-dark text-text-dark rounded-lg focus:outline-none focus:border-primary transition-colors placeholder-text-secondary-dark"
                                              id="comentarios" name="comentarios" rows="4"
                                              placeholder="Proporciona retroalimentación constructiva sobre el proyecto...">{{ $detalleCalificacion['comentarios'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full py-4 bg-primary text-background-dark font-bold text-lg rounded-lg hover:bg-primary/90 transition-all shadow-lg flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">save</span>
                                {{ $detalleCalificacion ? 'Actualizar Calificación' : 'Guardar Calificación' }}
                            </button>

                        </form>
                    </div>

                    <!-- Panel de resumen -->
                    <div class="lg:col-span-1">
                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden sticky top-8">
                            <div class="px-6 py-4 border-b border-border-dark">
                                <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">bar_chart</span>
                                    Resumen de Calificación
                                </h3>
                            </div>
                            <div class="p-6">

                                <!-- Puntuación total -->
                                <div class="text-center mb-6">
                                    <div class="text-5xl font-bold text-primary mb-2" id="puntajeTotal">
                                        {{ $detalleCalificacion ? $repositorio->calificacion_total : '0' }}
                                    </div>
                                    <div class="w-full bg-border-dark rounded-full h-3 mb-2">
                                        <div class="bg-primary h-3 rounded-full transition-all" id="progressBar"
                                             style="width: {{ $detalleCalificacion ? $repositorio->calificacion_total : 0 }}%"></div>
                                    </div>
                                    <p class="text-text-secondary-dark text-sm">Puntuación total /100</p>
                                </div>

                                <!-- Desglose -->
                                <div class="mb-6">
                                    <h4 class="text-xs font-mono text-primary uppercase mb-3">Desglose por criterio</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center py-2 border-b border-border-dark">
                                            <span class="text-red-400 text-sm">Innovación</span>
                                            <span class="font-bold text-text-dark" id="desgloseInnovacion">{{ $detalleCalificacion['innovacion'] ?? 0 }}/30</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-border-dark">
                                            <span class="text-green-400 text-sm">Funcionalidad</span>
                                            <span class="font-bold text-text-dark" id="desgloseFuncionalidad">{{ $detalleCalificacion['funcionalidad'] ?? 0 }}/30</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2 border-b border-border-dark">
                                            <span class="text-yellow-400 text-sm">Impacto</span>
                                            <span class="font-bold text-text-dark" id="desgloseImpacto">{{ $detalleCalificacion['impacto'] ?? 0 }}/20</span>
                                        </div>
                                        <div class="flex justify-between items-center py-2">
                                            <span class="text-cyan-400 text-sm">Presentación</span>
                                            <span class="font-bold text-text-dark" id="desglosePresentacion">{{ $detalleCalificacion['presentacion'] ?? 0 }}/20</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información del proyecto -->
                                <div class="pt-4 border-t border-border-dark">
                                    <h4 class="text-xs font-mono text-primary uppercase mb-3">Información del proyecto</h4>
                                    <div class="space-y-2 text-sm">
                                        <p><span class="text-text-secondary-dark">Equipo:</span> <span class="text-text-dark font-medium">{{ $repositorio->equipo->nombre }}</span></p>
                                        <p><span class="text-text-secondary-dark">Proyecto:</span> <span class="text-text-dark font-medium">{{ $repositorio->equipo->nombre_proyecto }}</span></p>
                                        <p><span class="text-text-secondary-dark">Archivo:</span> <span class="text-text-dark font-medium">{{ $repositorio->archivo_nombre }}</span></p>
                                    </div>
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
