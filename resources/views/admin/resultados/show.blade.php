<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Resultados - CodeQuest</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
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
                        display: ["Roboto", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.75rem",
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
            'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="font-display bg-background-dark text-text-dark">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-card-dark border-r border-border-dark flex flex-col shadow-xl z-20">
        <div class="p-6 flex items-center gap-3">
            <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>

        <nav class="flex-grow px-4 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">gavel</span>
                        <span>Jueces</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <span>Resultados</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-background-dark">
        <div class="p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Encabezado -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-text-dark">
                        📊 Resultados - {{ $evento->nombre }}
                    </h1>
                    <p class="text-text-secondary-dark mt-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">calendar_today</span>
                        {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                    </p>
                </div>

                <!-- Estadísticas de resumen -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-card-dark rounded-lg p-6 border border-border-dark hover:border-primary/50 transition-all duration-200">
                        <p class="text-text-secondary-dark text-sm font-semibold mb-2">Equipos Participantes</p>
                        <p class="text-4xl font-bold text-primary">{{ $ranking->count() }}</p>
                    </div>
                    <div class="bg-card-dark rounded-lg p-6 border border-border-dark hover:border-primary/50 transition-all duration-200">
                        <p class="text-text-secondary-dark text-sm font-semibold mb-2">Total de Calificaciones</p>
                        <p class="text-4xl font-bold text-green-400">{{ $calificaciones->count() }}</p>
                    </div>
                    <div class="bg-card-dark rounded-lg p-6 border border-border-dark hover:border-primary/50 transition-all duration-200">
                        <p class="text-text-secondary-dark text-sm font-semibold mb-2">Promedio General</p>
                        <p class="text-4xl font-bold text-purple-400">{{ number_format($calificaciones->avg('puntaje_final') ?? 0, 2) }}</p>
                    </div>
                    <div class="bg-card-dark rounded-lg p-6 border border-border-dark hover:border-primary/50 transition-all duration-200">
                        <p class="text-text-secondary-dark text-sm font-semibold mb-2">Equipo Ganador</p>
                        <p class="text-xl font-bold text-yellow-400">{{ $ganador['equipo']->nombre ?? 'No asignado' }}</p>
                    </div>
                </div>

                <!-- Ranking principal -->
                <div class="bg-card-dark rounded-lg overflow-hidden mb-8 border border-border-dark">
                    <div class="bg-gradient-to-r from-primary/20 to-purple-500/20 px-6 py-4 border-b border-border-dark">
                        <h2 class="text-2xl font-bold text-text-dark flex items-center gap-2">
                            <span class="material-symbols-outlined text-yellow-400">emoji_events</span>
                            Ranking Completo
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-background-dark border-b-2 border-border-dark">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-text-dark">Posición</th>
                                    <th class="px-6 py-3 text-left font-semibold text-text-dark">Equipo</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-dark">Puntuación Promedio</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-dark">Desviación Est.</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-dark">Calificaciones</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-dark">Estado</th>
                                    @if (Auth::user()->esAdmin())
                                        <th class="px-6 py-3 text-center font-semibold text-text-dark">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ranking as $index => $item)
                                    <tr class="border-b border-border-dark hover:bg-white/5 transition">
                                        <td class="px-6 py-4 font-bold text-primary">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-text-dark">{{ $item['equipo']->nombre }}</p>
                                            <p class="text-sm text-text-secondary-dark">Líder: {{ $item['equipo']->lider->nombre }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-primary/20 text-primary rounded-full font-bold">
                                                {{ number_format($item['puntaje_promedio'], 2) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-text-dark">{{ number_format($item['desviacion_estandar'], 2) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-green-500/20 text-green-400 rounded-full">
                                                {{ $item['calificaciones_count'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item['ganador'])
                                                <span class="inline-block px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full font-semibold">
                                                    🏆 GANADOR
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-gray-500/20 text-gray-400 rounded-full">
                                                    Participante
                                                </span>
                                            @endif
                                        </td>
                                        @if (Auth::user()->esAdmin())
                                            <td class="px-6 py-4 text-center">
                                                <form method="POST" action="{{ route('admin.resultados.marcar-ganador', $evento->id_evento) }}" class="inline">
                                                    @csrf
                                                    @if (!$item['ganador'])
                                                        <input type="hidden" name="equipo_id" value="{{ $item['equipo']->id_equipo }}">
                                                        <button type="submit" class="text-primary hover:text-primary/80 font-semibold transition">
                                                            Marcar como ganador
                                                        </button>
                                                    @else
                                                        <input type="hidden" name="equipo_id" value="">
                                                        <button type="submit" class="text-text-secondary-dark hover:text-text-dark font-semibold transition">
                                                            Desmarcar ganador
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-text-secondary-dark">
                                            No hay equipos con calificaciones
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabla de calificaciones individuales -->
                <div class="bg-card-dark rounded-lg overflow-hidden mb-8 border border-border-dark">
                    <div class="bg-gradient-to-r from-purple-500/20 to-pink-500/20 px-6 py-4 border-b border-border-dark">
                        <h2 class="text-2xl font-bold text-text-dark flex items-center gap-2">
                            <span class="material-symbols-outlined text-purple-400">assignment</span>
                            Calificaciones por Juez
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-800 border-b-2 border-border-light dark:border-border-dark">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-text-light dark:text-text-dark">Equipo</th>
                                    <th class="px-4 py-3 text-left font-semibold text-text-light dark:text-text-dark">Juez</th>
                                    <th class="px-4 py-3 text-center font-semibold text-text-light dark:text-text-dark">🎨 Creatividad</th>
                                    <th class="px-4 py-3 text-center font-semibold text-text-light dark:text-text-dark">⚙️ Funcionalidad</th>
                                    <th class="px-4 py-3 text-center font-semibold text-text-light dark:text-text-dark">🎯 Diseño</th>
                                    <th class="px-4 py-3 text-center font-semibold text-text-light dark:text-text-dark">🎤 Presentación</th>
                                    <th class="px-4 py-3 text-center font-semibold text-text-light dark:text-text-dark">📚 Documentación</th>
                                    <th class="px-4 py-3 text-center font-semibold text-text-light dark:text-text-dark">Promedio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($calificaciones->sortBy('equipo_id') as $calificacion)
                                    <tr class="border-b border-border-light dark:border-border-dark hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                        <td class="px-4 py-3 font-semibold text-text-light dark:text-text-dark">{{ $calificacion->equipo->nombre }}</td>
                                        <td class="px-4 py-3 text-text-secondary-light dark:text-text-secondary-dark">{{ $calificacion->juez->nombre }}</td>
                                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded font-semibold">{{ $calificacion->puntaje_creatividad }}</span></td>
                                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded font-semibold">{{ $calificacion->puntaje_funcionalidad }}</span></td>
                                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded font-semibold">{{ $calificacion->puntaje_diseño }}</span></td>
                                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 rounded font-semibold">{{ $calificacion->puntaje_presentacion }}</span></td>
                                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded font-semibold">{{ $calificacion->puntaje_documentacion }}</span></td>
                                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 text-gray-900 dark:text-gray-100 rounded font-bold">{{ number_format($calificacion->puntaje_final, 2) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-text-secondary-light dark:text-text-secondary-dark">
                                            No hay calificaciones registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Opciones de admin -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.resultados.exportar', $evento->id_evento) }}" target="_blank" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">picture_as_pdf</span>
                        <span>Exportar Resultados</span>
                    </a>
                    @if ($ganador)
                        <a href="{{ route('admin.resultados.constancia', $evento->id_evento) }}?preview=1" target="_blank" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition text-center flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">visibility</span>
                            <span>Ver Constancia</span>
                        </a>
                        <a href="{{ route('admin.resultados.constancia', $evento->id_evento) }}" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition text-center flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">download</span>
                            <span>Descargar PDF</span>
                        </a>
                        <button onclick="openEmailModal()" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition text-center flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">forward_to_inbox</span>
                            <span>Enviar por Correo</span>
                        </button>
                    @endif
                </div>

                <!-- Modal de confirmación de envío de correo -->
                @if ($ganador)
                    <div id="emailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                        <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-2xl max-w-md w-full border border-border-light dark:border-border-dark">
                            <!-- Header del modal -->
                            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 rounded-t-lg">
                                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                    <span class="material-symbols-outlined">forward_to_inbox</span>
                                    Enviar Constancia por Correo
                                </h3>
                            </div>

                            <!-- Contenido del modal -->
                            <div class="p-6">
                                <div class="mb-6">
                                    <p class="text-text-light dark:text-text-dark mb-4">
                                        ¿Estás seguro de que deseas enviar la constancia del equipo ganador por correo electrónico?
                                    </p>

                                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 space-y-2">
                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">workspace_premium</span>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Equipo Ganador</p>
                                                <p class="text-sm text-blue-800 dark:text-blue-200">{{ $ganador['equipo']->nombre }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">person</span>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Líder del Equipo</p>
                                                <p class="text-sm text-blue-800 dark:text-blue-200">{{ $ganador['equipo']->lider->nombre_completo ?? 'No especificado' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-2">
                                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">mail</span>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Correo Electrónico</p>
                                                <p class="text-sm text-blue-800 dark:text-blue-200 break-all">{{ $ganador['equipo']->lider->correo ?? 'No especificado' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-2 mt-3 pt-3 border-t border-blue-200 dark:border-blue-800">
                                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">emoji_events</span>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Puntuación Final</p>
                                                <p class="text-sm text-blue-800 dark:text-blue-200">{{ number_format($ganador['puntaje_promedio'], 2) }}/10</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="flex gap-3">
                                    <button onclick="closeEmailModal()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                        Cancelar
                                    </button>
                                    <a href="{{ route('admin.resultados.constancia', $evento->id_evento) }}?enviar_correo=1" class="flex-1 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition text-center flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-lg">send</span>
                                        Enviar Ahora
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openEmailModal() {
                            document.getElementById('emailModal').classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }

                        function closeEmailModal() {
                            document.getElementById('emailModal').classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }

                        // Cerrar modal al hacer clic fuera de él
                        document.getElementById('emailModal')?.addEventListener('click', function(e) {
                            if (e.target === this) {
                                closeEmailModal();
                            }
                        });

                        // Cerrar modal con tecla ESC
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                closeEmailModal();
                            }
                        });
                    </script>
                @endif
            </div>
        </div>
    </main>
</div>
</body>
</html>