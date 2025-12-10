<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Proyecto - {{ $repositorio->equipo->nombre_proyecto }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    
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
                        display: ["Roboto", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        /* Custom range input styling */
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 6px;
            background: #233554;
            border-radius: 5px;
            outline: none;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #64FFDA;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.3);
        }
        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.2);
            box-shadow: 0 0 15px rgba(100, 255, 218, 0.6);
        }
        /* Scrollbar oscura */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0A192F; }
        ::-webkit-scrollbar-thumb { background: #233554; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64FFDA; }
    </style>
</head>
<body class="font-display bg-background-dark text-text-dark antialiased">

<div class="flex h-screen overflow-hidden">
    
    <aside class="w-64 bg-card-dark border-r border-border-dark flex flex-col shadow-xl z-20">
        <div class="p-6 flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-primary/10 flex items-center justify-center text-primary font-bold">CQ</div>
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>
        
        <nav class="flex-grow px-4 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Evento Asignado</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Historial Constancias</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="p-4 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-red-400 hover:bg-red-500/10 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto bg-background-dark relative">
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto">

            <nav class="flex items-center text-sm text-text-secondary-dark mb-6">
                <a href="{{ route('juez.panel') }}" class="hover:text-primary transition-colors">Panel</a>
                <span class="mx-2 text-border-dark">/</span>
                <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}" class="hover:text-primary transition-colors">Proyectos</a>
                <span class="mx-2 text-border-dark">/</span>
                <a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}" class="hover:text-primary transition-colors">Ver Proyecto</a>
                <span class="mx-2 text-border-dark">/</span>
                <span class="text-primary font-bold">Calificar</span>
            </nav>

            <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-text-dark tracking-tight mb-1">Calificar Proyecto</h2>
                    <p class="text-text-secondary-dark">
                        Evaluando: <span class="text-primary font-bold">{{ $repositorio->equipo->nombre_proyecto }}</span> 
                        <span class="mx-1 opacity-50">|</span> 
                        Equipo: {{ $repositorio->equipo->nombre }}
                    </p>
                </div>
                <a href="{{ route('proyecto.juez.ver-juez', $repositorio) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 border border-border-dark rounded-lg text-text-secondary-dark hover:text-primary hover:border-primary transition-all text-sm font-bold bg-card-dark">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Volver al proyecto
                </a>
            </header>

            @if($detalleCalificacion && isset($detalleCalificacion['calificado_por']) && $detalleCalificacion['calificado_por'] == auth()->id())
            <div class="mb-8 bg-blue-500/10 border border-blue-500/30 text-blue-300 px-4 py-3 rounded-xl flex items-start gap-3 shadow-lg">
                <span class="material-symbols-outlined text-xl mt-0.5">info</span>
                <div>
                    <p class="font-bold text-sm">Ya has calificado este proyecto.</p>
                    <p class="text-xs opacity-80">Puedes actualizar tu evaluación a continuación.</p>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <form action="{{ route('proyecto.juez.guardar-calificacion', $repositorio) }}" method="POST">
                        @csrf

                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8 mb-8 space-y-8">
                            <div class="flex items-center gap-2 border-b border-border-dark pb-4">
                                <span class="material-symbols-outlined text-primary text-2xl">star</span>
                                <h3 class="text-xl font-bold text-text-dark">Criterios de Evaluación</h3>
                            </div>

                            <div class="pl-4 border-l-2 border-red-500">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-bold text-red-400">Innovación y creatividad</h4>
                                    <span class="text-2xl font-bold text-red-400 font-mono" id="valorInnovacion">{{ $detalleCalificacion['innovacion'] ?? 0 }}</span>
                                </div>
                                <p class="text-text-secondary-dark text-xs mb-4">Originalidad y enfoque novedoso (0-30 pts)</p>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">0</span>
                                    <input type="range" id="puntaje_innovacion" name="puntaje_innovacion" min="0" max="30" step="0.5"
                                           value="{{ $detalleCalificacion['innovacion'] ?? 15 }}"
                                           oninput="actualizarValor('innovacion', this.value); calcularTotal();">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">30</span>
                                </div>
                            </div>

                            <div class="pl-4 border-l-2 border-green-500">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-bold text-green-400">Funcionalidad técnica</h4>
                                    <span class="text-2xl font-bold text-green-400 font-mono" id="valorFuncionalidad">{{ $detalleCalificacion['funcionalidad'] ?? 0 }}</span>
                                </div>
                                <p class="text-text-secondary-dark text-xs mb-4">Calidad técnica y funcionamiento (0-30 pts)</p>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">0</span>
                                    <input type="range" id="puntaje_funcionalidad" name="puntaje_funcionalidad" min="0" max="30" step="0.5"
                                           value="{{ $detalleCalificacion['funcionalidad'] ?? 15 }}"
                                           oninput="actualizarValor('funcionalidad', this.value); calcularTotal();">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">30</span>
                                </div>
                            </div>

                            <div class="pl-4 border-l-2 border-yellow-500">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-bold text-yellow-400">Impacto y escalabilidad</h4>
                                    <span class="text-2xl font-bold text-yellow-400 font-mono" id="valorImpacto">{{ $detalleCalificacion['impacto'] ?? 0 }}</span>
                                </div>
                                <p class="text-text-secondary-dark text-xs mb-4">Potencial de impacto y crecimiento (0-20 pts)</p>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">0</span>
                                    <input type="range" id="puntaje_impacto" name="puntaje_impacto" min="0" max="20" step="0.5"
                                           value="{{ $detalleCalificacion['impacto'] ?? 10 }}"
                                           oninput="actualizarValor('impacto', this.value); calcularTotal();">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">20</span>
                                </div>
                            </div>

                            <div class="pl-4 border-l-2 border-cyan-500">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-bold text-cyan-400">Claridad en presentación</h4>
                                    <span class="text-2xl font-bold text-cyan-400 font-mono" id="valorPresentacion">{{ $detalleCalificacion['presentacion'] ?? 0 }}</span>
                                </div>
                                <p class="text-text-secondary-dark text-xs mb-4">Documentación y exposición clara (0-20 pts)</p>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">0</span>
                                    <input type="range" id="puntaje_presentacion" name="puntaje_presentacion" min="0" max="20" step="0.5"
                                           value="{{ $detalleCalificacion['presentacion'] ?? 10 }}"
                                           oninput="actualizarValor('presentacion', this.value); calcularTotal();">
                                    <span class="text-xs font-mono text-text-secondary-dark w-4">20</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 mb-8">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="material-symbols-outlined text-primary">comment</span>
                                <h3 class="text-lg font-bold text-text-dark">Comentarios</h3>
                            </div>
                            <label for="comentarios" class="block text-xs font-bold text-text-secondary-dark mb-2 uppercase tracking-wide">Retroalimentación (Opcional)</label>
                            <textarea id="comentarios" name="comentarios" rows="4" placeholder="Escribe tus observaciones constructivas aquí..."
                                class="w-full bg-background-dark border border-border-dark rounded-lg p-4 text-text-dark focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none placeholder-text-secondary-dark/30 text-sm">{{ $detalleCalificacion['comentarios'] ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-4 bg-primary text-background-dark font-bold rounded-xl hover:bg-opacity-90 shadow-[0_0_20px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 uppercase tracking-wide text-sm">
                            <span class="material-symbols-outlined text-lg">save</span>
                            {{ isset($detalleCalificacion) ? 'Actualizar Calificación' : 'Guardar Calificación' }}
                        </button>

                    </form>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 sticky top-6">
                        <div class="flex items-center gap-2 mb-6 border-b border-border-dark pb-4">
                            <span class="material-symbols-outlined text-primary">analytics</span>
                            <h3 class="text-lg font-bold text-text-dark">Resumen</h3>
                        </div>

                        <div class="text-center mb-8 bg-background-dark p-6 rounded-xl border border-border-dark relative overflow-hidden">
                            <div class="absolute inset-0 bg-primary/5"></div>
                            <div class="text-5xl font-bold text-primary font-mono mb-2 relative z-10" id="puntajeTotal">
                                {{ isset($detalleCalificacion) ? $repositorio->calificacion_total : '0.0' }}
                            </div>
                            <div class="w-full bg-border-dark rounded-full h-2 mb-2 overflow-hidden relative z-10">
                                <div class="bg-primary h-full rounded-full transition-all duration-500" id="progressBar" style="width: {{ isset($detalleCalificacion) ? $repositorio->calificacion_total : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-text-secondary-dark uppercase tracking-wider relative z-10">Puntuación Total</p>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center pb-2 border-b border-border-dark/50">
                                <span class="text-red-400 font-medium">Innovación</span>
                                <span class="font-mono text-text-dark" id="desgloseInnovacion">{{ $detalleCalificacion['innovacion'] ?? 0 }}/30</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-border-dark/50">
                                <span class="text-green-400 font-medium">Funcionalidad</span>
                                <span class="font-mono text-text-dark" id="desgloseFuncionalidad">{{ $detalleCalificacion['funcionalidad'] ?? 0 }}/30</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-border-dark/50">
                                <span class="text-yellow-400 font-medium">Impacto</span>
                                <span class="font-mono text-text-dark" id="desgloseImpacto">{{ $detalleCalificacion['impacto'] ?? 0 }}/20</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-border-dark/50">
                                <span class="text-cyan-400 font-medium">Presentación</span>
                                <span class="font-mono text-text-dark" id="desglosePresentacion">{{ $detalleCalificacion['presentacion'] ?? 0 }}/20</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-border-dark">
                            <h4 class="font-bold text-text-dark text-xs uppercase tracking-wide mb-3">Detalles del Proyecto</h4>
                            <ul class="space-y-2 text-xs text-text-secondary-dark">
                                <li><strong class="text-primary">Equipo:</strong> {{ $repositorio->equipo->nombre }}</li>
                                <li><strong class="text-primary">Proyecto:</strong> {{ $repositorio->equipo->nombre_proyecto }}</li>
                                <li class="truncate" title="{{ $repositorio->archivo_nombre }}"><strong class="text-primary">Archivo:</strong> {{ $repositorio->archivo_nombre }}</li>
                            </ul>
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
        const elValor = document.getElementById(`valor${criterio.charAt(0).toUpperCase() + criterio.slice(1)}`);
        const elDesglose = document.getElementById(`desglose${criterio.charAt(0).toUpperCase() + criterio.slice(1)}`);
        
        if(elValor) elValor.textContent = valorFormateado;
        
        const maxValor = (criterio === 'innovacion' || criterio === 'funcionalidad') ? '30' : '20';
        if(elDesglose) elDesglose.textContent = valorFormateado + '/' + maxValor;
    }

    function calcularTotal() {
        const innovacion = parseFloat(document.getElementById('puntaje_innovacion').value) || 0;
        const funcionalidad = parseFloat(document.getElementById('puntaje_funcionalidad').value) || 0;
        const impacto = parseFloat(document.getElementById('puntaje_impacto').value) || 0;
        const presentacion = parseFloat(document.getElementById('puntaje_presentacion').value) || 0;

        const total = innovacion + funcionalidad + impacto + presentacion;

        const elTotal = document.getElementById('puntajeTotal');
        const elBarra = document.getElementById('progressBar');

        if(elTotal) elTotal.textContent = total.toFixed(1);
        if(elBarra) elBarra.style.width = total + '%';
    }

    // Inicializar valores al cargar
    document.addEventListener('DOMContentLoaded', function() {
        // Asegura que los valores visuales coincidan con los inputs si el navegador guardó el estado
        ['innovacion', 'funcionalidad', 'impacto', 'presentacion'].forEach(criterio => {
            const input = document.getElementById(`puntaje_${criterio}`);
            if(input) {
                actualizarValor(criterio, input.value);
            }
        });
        calcularTotal();
    });
</script>

</body>
</html>