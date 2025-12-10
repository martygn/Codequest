<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Calificar Equipo - CodeQuest</title>
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
                        "card-dark": "#112240",
                        "text-dark": "#CCD6F6",
                        "text-secondary-dark": "#8892B0",
                        "border-dark": "#233554",
                        "active-dark": "rgba(100, 255, 218, 0.1)",
                        "background-dark": "#0A192F",
                        "background-dark": "#0A192F",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
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
    </style>
</head>
<body class="font-display bg-background-dark text-text-secondary-dark">
<div class="flex h-screen">
    <!-- Sidebar del Juez -->
    <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between">
        <div>
            <h1 class="text-2xl font-bold text-text-dark">CodeQuest</h1>
            <nav class="mt-8 space-y-2">
                <a class="flex items-center gap-3 px-4 py-2 text-text-dark bg-active-dark text-primary border-l-2 border-primary rounded font-semibold" href="{{ route('juez.panel') }}">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <span>Eventos</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-text-secondary-dark rounded hover:bg-border-dark hover:text-primary transition-colors" href="{{ route('juez.constancias') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Historial de Constancias</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-text-secondary-dark rounded hover:bg-border-dark hover:text-primary transition-colors" href="{{ route('juez.configuracion') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Configuración</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:bg-border-dark hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="mb-8">
                <a href="{{ route('juez.panel') }}" class="text-[#64FFDA] hover:opacity-80 mb-4 inline-block transition">
                    ← Volver al Panel
                </a>
                <h1 class="text-3xl font-bold text-white">Calificar Equipo</h1>
                <p class="text-[#8892B0] mt-2">
                    Evento: <strong class="text-white">{{ $evento->nombre }}</strong> |
                    Equipo: <strong class="text-white">{{ $equipo->nombre }}</strong>
                </p>
            </div>

    <!-- Información del equipo -->
    <div class="bg-[#1A3A52] border border-[#233554] rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-white mb-3">👥 Información del Equipo</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-[#8892B0]">Líder:</p>
                <p class="font-semibold text-white">{{ $equipo->lider->nombre_completo ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[#8892B0]">Cantidad de miembros:</p>
                <p class="font-semibold text-white">{{ $equipo->participantes->count() }}</p>
            </div>
        </div>
    </div>

    @if($proyecto && $proyecto->archivo_path)
<div class="mb-6 p-4 bg-[#1A3A52] border border-[#233554] rounded-lg">
    <h3 class="font-semibold text-[#64FFDA] mb-2">📁 Proyecto del equipo:</h3>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-8 h-8 text-[#64FFDA] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <div>
                <p class="font-medium text-white">{{ $proyecto->archivo_nombre }}</p>
                <p class="text-sm text-[#8892B0]">
                    Subido el: {{ $proyecto->enviado_en->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('proyectos.download', $proyecto) }}"
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-[#64FFDA] text-[#0A192F] rounded-lg hover:opacity-80 transition text-sm font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Descargar Proyecto
            </a>
        </div>
    </div>
</div>
@endif

    <!-- Formulario de calificación -->
    <form action="{{ route('calificaciones.store', $equipo->id_equipo) }}" method="POST" class="bg-card-dark rounded-lg shadow-md p-8 border border-[#233554]">
        @csrf

        <div class="space-y-8">
            <!-- Creatividad -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_creatividad" class="block text-sm font-semibold text-white">
                        🎨 Creatividad e Innovación
                    </label>
                    <span id="valor_creatividad" class="text-2xl font-bold text-[#64FFDA]">{{ old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_creatividad"
                       name="puntaje_creatividad"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) }}"
                       class="w-full h-2 bg-[#233554] rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('creatividad')">
                <div class="flex justify-between text-xs text-[#8892B0] mt-2">
                    <span>Nada creativo</span>
                    <span>Muy creativo</span>
                </div>
                <p class="text-sm text-[#8892B0] mt-2">¿Qué tan innovador y creativo es el proyecto?</p>
            </div>

            <!-- Funcionalidad -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_funcionalidad" class="block text-sm font-semibold text-white">
                        ⚙️ Funcionalidad
                    </label>
                    <span id="valor_funcionalidad" class="text-2xl font-bold text-[#64FFDA]">{{ old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_funcionalidad"
                       name="puntaje_funcionalidad"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) }}"
                       class="w-full h-2 bg-[#233554] rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('funcionalidad')">
                <div class="flex justify-between text-xs text-[#8892B0] mt-2">
                    <span>No funciona</span>
                    <span>Funciona perfectamente</span>
                </div>
                <p class="text-sm text-[#8892B0] mt-2">¿El proyecto cumple con los requisitos y funciona correctamente?</p>
            </div>

            <!-- Diseño -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_diseño" class="block text-sm font-semibold text-white">
                        🎯 Diseño y UX
                    </label>
                    <span id="valor_diseño" class="text-2xl font-bold text-[#64FFDA]">{{ old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_diseño"
                       name="puntaje_diseño"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) }}"
                       class="w-full h-2 bg-[#233554] rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('diseño')">
                <div class="flex justify-between text-xs text-[#8892B0] mt-2">
                    <span>Diseño pobre</span>
                    <span>Diseño excelente</span>
                </div>
                <p class="text-sm text-[#8892B0] mt-2">¿La interfaz es atractiva, intuitiva y fácil de usar?</p>
            </div>

            <!-- Presentación -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_presentacion" class="block text-sm font-semibold text-white">
                        🎤 Presentación
                    </label>
                    <span id="valor_presentacion" class="text-2xl font-bold text-[#64FFDA]">{{ old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_presentacion"
                       name="puntaje_presentacion"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) }}"
                       class="w-full h-2 bg-[#233554] rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('presentacion')">
                <div class="flex justify-between text-xs text-[#8892B0] mt-2">
                    <span>Mala presentación</span>
                    <span>Presentación excelente</span>
                </div>
                <p class="text-sm text-[#8892B0] mt-2">¿La presentación fue clara, organizada y convincente?</p>
            </div>

            <!-- Documentación -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_documentacion" class="block text-sm font-semibold text-white">
                        📚 Documentación
                    </label>
                    <span id="valor_documentacion" class="text-2xl font-bold text-[#64FFDA]">{{ old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_documentacion"
                       name="puntaje_documentacion"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5) }}"
                       class="w-full h-2 bg-[#233554] rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('documentacion')">
                <div class="flex justify-between text-xs text-[#8892B0] mt-2">
                    <span>Sin documentación</span>
                    <span>Muy bien documentado</span>
                </div>
                <p class="text-sm text-[#8892B0] mt-2">¿El código y proyecto están bien documentados?</p>
            </div>

            <!-- Puntuación Final -->
            <div class="bg-[#1A3A52] border-2 border-[#233554] rounded-lg p-6">
                <h3 class="text-lg font-bold text-white mb-2">📊 Puntuación Final</h3>
                <div class="text-4xl font-bold text-[#64FFDA]" id="puntaje_final">
                    {{ number_format((old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) +
                                      old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) +
                                      old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) +
                                      old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) +
                                      old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5)) / 5, 2) }}
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-sm font-semibold text-white mb-2">
                    💬 Observaciones (opcional)
                </label>
                <textarea id="observaciones"
                          name="observaciones"
                          rows="4"
                          placeholder="Añade tus observaciones sobre el proyecto..."
                          class="w-full px-4 py-2 border border-[#233554] rounded-lg bg-[#0A192F] text-white focus:ring-2 focus:ring-[#64FFDA] focus:border-transparent">{{ old('observaciones', $calificacion->observaciones ?? '') }}</textarea>
            </div>

            <!-- Recomendaciones -->
            <div>
                <label for="recomendaciones" class="block text-sm font-semibold text-white mb-2">
                    💡 Recomendaciones (opcional)
                </label>
                <textarea id="recomendaciones"
                          name="recomendaciones"
                          rows="4"
                          placeholder="Sugiere mejoras y recomendaciones..."
                          class="w-full px-4 py-2 border border-[#233554] rounded-lg bg-[#0A192F] text-white focus:ring-2 focus:ring-[#64FFDA] focus:border-transparent">{{ old('recomendaciones', $calificacion->recomendaciones ?? '') }}</textarea>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-8">
            <button type="submit" class="flex-1 px-6 py-3 bg-[#64FFDA] text-[#0A192F] font-semibold rounded-lg hover:opacity-80 transition">
                @if(isset($calificacion) && $calificacion->id)
                    ✏️ Actualizar Calificación
                @else
                    📤 Enviar Calificación
                @endif
            </button>
            <a href="{{ route('juez.panel') }}" class="flex-1 px-6 py-3 bg-[#233554] text-[#8892B0] font-semibold rounded-lg hover:bg-[#364B63] transition text-center">
                ❌ Cancelar
            </a>
        </div>
    </form>
        </div>
    </main>
</div>

<script>
function actualizarValor(campo) {
    const valores = {
        'creatividad': 'puntaje_creatividad',
        'funcionalidad': 'puntaje_funcionalidad',
        'diseño': 'puntaje_diseño',
        'presentacion': 'puntaje_presentacion',
        'documentacion': 'puntaje_documentacion'
    };

    const input = document.getElementById(valores[campo]);
    const display = document.getElementById(`valor_${campo}`);
    display.textContent = input.value;

    calcularPromedio();
}

function calcularPromedio() {
    const creatividad = parseInt(document.getElementById('puntaje_creatividad').value) || 0;
    const funcionalidad = parseInt(document.getElementById('puntaje_funcionalidad').value) || 0;
    const diseño = parseInt(document.getElementById('puntaje_diseño').value) || 0;
    const presentacion = parseInt(document.getElementById('puntaje_presentacion').value) || 0;
    const documentacion = parseInt(document.getElementById('puntaje_documentacion').value) || 0;

    const promedio = (creatividad + funcionalidad + diseño + presentacion + documentacion) / 5;

    document.getElementById('puntaje_final').textContent = promedio.toFixed(2);
}

// Calcular promedio inicial al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    calcularPromedio();
});
</script>
</body>
</html>
