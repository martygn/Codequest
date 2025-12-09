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
                        primary: "#3b82f6",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
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
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex h-screen">
    <!-- Sidebar del Juez -->
    <aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
            <nav class="mt-8 space-y-2">
                <a class="flex items-center gap-3 px-4 py-2 text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold" href="{{ route('juez.panel') }}">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <span>Eventos</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('juez.constancias') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Historial de Constancias</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('juez.configuracion') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Configuración</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
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
                <a href="{{ route('juez.panel') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                    ← Volver al Panel
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Calificar Equipo</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Evento: <strong>{{ $evento->nombre }}</strong> |
                    Equipo: <strong>{{ $equipo->nombre }}</strong>
                </p>
            </div>

    <!-- Información del equipo -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">👥 Información del Equipo</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-600 dark:text-gray-400">Líder:</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $equipo->lider->nombre_completo ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400">Cantidad de miembros:</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $equipo->participantes->count() }}</p>
            </div>
        </div>
    </div>

    @if($proyecto && $proyecto->archivo_path)
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <h3 class="font-semibold text-blue-700 mb-2">📁 Proyecto del equipo:</h3>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <div>
                <p class="font-medium text-gray-900">{{ $proyecto->archivo_nombre }}</p>
                <p class="text-sm text-gray-600">
                    Subido el: {{ $proyecto->enviado_en->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('proyectos.download', $proyecto) }}"
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
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
    <form action="{{ route('calificaciones.store', $equipo->id_equipo) }}" method="POST" class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-8 border border-gray-200 dark:border-slate-800">
        @csrf

        <div class="space-y-8">
            <!-- Creatividad -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_creatividad" class="block text-sm font-semibold text-gray-900 dark:text-white">
                        🎨 Creatividad e Innovación
                    </label>
                    <span id="valor_creatividad" class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_creatividad"
                       name="puntaje_creatividad"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) }}"
                       class="w-full h-2 bg-blue-200 dark:bg-blue-800 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('creatividad')">
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Nada creativo</span>
                    <span>Muy creativo</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">¿Qué tan innovador y creativo es el proyecto?</p>
            </div>

            <!-- Funcionalidad -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_funcionalidad" class="block text-sm font-semibold text-gray-900 dark:text-white">
                        ⚙️ Funcionalidad
                    </label>
                    <span id="valor_funcionalidad" class="text-2xl font-bold text-green-600 dark:text-green-400">{{ old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_funcionalidad"
                       name="puntaje_funcionalidad"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) }}"
                       class="w-full h-2 bg-green-200 dark:bg-green-800 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('funcionalidad')">
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>No funciona</span>
                    <span>Funciona perfectamente</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">¿El proyecto cumple con los requisitos y funciona correctamente?</p>
            </div>

            <!-- Diseño -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_diseño" class="block text-sm font-semibold text-gray-900 dark:text-white">
                        🎯 Diseño y UX
                    </label>
                    <span id="valor_diseño" class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_diseño"
                       name="puntaje_diseño"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) }}"
                       class="w-full h-2 bg-purple-200 dark:bg-purple-800 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('diseño')">
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>Diseño pobre</span>
                    <span>Diseño excelente</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">¿La interfaz es atractiva, intuitiva y fácil de usar?</p>
            </div>

            <!-- Presentación -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_presentacion" class="block text-sm font-semibold text-gray-900 dark:text-white">
                        🎤 Presentación
                    </label>
                    <span id="valor_presentacion" class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_presentacion"
                       name="puntaje_presentacion"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) }}"
                       class="w-full h-2 bg-orange-200 dark:bg-orange-800 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('presentacion')">
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>Mala presentación</span>
                    <span>Presentación excelente</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">¿La presentación fue clara, organizada y convincente?</p>
            </div>

            <!-- Documentación -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_documentacion" class="block text-sm font-semibold text-gray-900 dark:text-white">
                        📚 Documentación
                    </label>
                    <span id="valor_documentacion" class="text-2xl font-bold text-red-600 dark:text-red-400">{{ old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5) }}</span>
                </div>
                <input type="range"
                       id="puntaje_documentacion"
                       name="puntaje_documentacion"
                       min="1"
                       max="10"
                       value="{{ old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5) }}"
                       class="w-full h-2 bg-red-200 dark:bg-red-800 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('documentacion')">
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>Sin documentación</span>
                    <span>Muy bien documentado</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">¿El código y proyecto están bien documentados?</p>
            </div>

            <!-- Puntuación Final -->
            <div class="bg-gradient-to-r from-blue-50 dark:from-blue-900/20 to-purple-50 dark:to-purple-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">📊 Puntuación Final</h3>
                <div class="text-4xl font-bold text-blue-600 dark:text-blue-400" id="puntaje_final">
                    {{ number_format((old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) +
                                      old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) +
                                      old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) +
                                      old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) +
                                      old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5)) / 5, 2) }}
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    💬 Observaciones (opcional)
                </label>
                <textarea id="observaciones"
                          name="observaciones"
                          rows="4"
                          placeholder="Añade tus observaciones sobre el proyecto..."
                          class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('observaciones', $calificacion->observaciones ?? '') }}</textarea>
            </div>

            <!-- Recomendaciones -->
            <div>
                <label for="recomendaciones" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    💡 Recomendaciones (opcional)
                </label>
                <textarea id="recomendaciones"
                          name="recomendaciones"
                          rows="4"
                          placeholder="Sugiere mejoras y recomendaciones..."
                          class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('recomendaciones', $calificacion->recomendaciones ?? '') }}</textarea>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-8">
            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                @if(isset($calificacion) && $calificacion->id)
                    ✏️ Actualizar Calificación
                @else
                    📤 Enviar Calificación
                @endif
            </button>
            <a href="{{ route('juez.panel') }}" class="flex-1 px-6 py-3 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 transition text-center">
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
