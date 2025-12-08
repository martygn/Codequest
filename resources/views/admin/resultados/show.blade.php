<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Resultados Detallados - Administrador</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#007BFF",
                        "background-light": "#F7F8FC",
                        "background-dark": "#121212",
                        "card-light": "#FFFFFF",
                        "card-dark": "#1E1E1E",
                        "text-light": "#111827",
                        "text-dark": "#E5E7EB",
                        "text-secondary-light": "#6B7280",
                        "text-secondary-dark": "#9CA3AF",
                        "border-light": "#E5E7EB",
                        "border-dark": "#374151",
                        "active-light": "#E9F2FF",
                        "active-dark": "#253448",
                        normal: "#3B82F6",
                        moderately: "#DC2626",
                        severely: "#84CC16"
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
<body class="font-display bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-card-light dark:bg-card-dark border-r border-border-light dark:border-border-dark flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
        </div>
        <nav class="flex-grow px-4">
            <ul class="space-y-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">person</span>
                        <span>Jueces</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary text-white font-semibold" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">assessment</span>
                        <span>Resultados</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-border-light dark:border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <div class="p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Encabezado -->
                <div class="mb-8">
                    <a href="{{ route('admin.resultados-panel') }}" class="inline-flex items-center gap-2 text-primary hover:underline mb-4">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Volver a Resultados</span>
                    </a>
                    <h1 class="text-4xl font-bold text-text-light dark:text-white">
                        📊 Resultados - {{ $evento->nombre }}
                    </h1>
                    <p class="text-text-secondary-light dark:text-text-secondary-dark mt-2">📅 {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</p>
                </div>

                <!-- Estadísticas de resumen -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-card-light dark:bg-card-dark rounded-lg p-6 shadow-md border border-border-light dark:border-border-dark">
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-semibold mb-2">Equipos Participantes</p>
                        <p class="text-4xl font-bold text-primary">{{ $ranking->count() }}</p>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-lg p-6 shadow-md border border-border-light dark:border-border-dark">
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-semibold mb-2">Total de Calificaciones</p>
                        <p class="text-4xl font-bold text-green-600">{{ $calificaciones->count() }}</p>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-lg p-6 shadow-md border border-border-light dark:border-border-dark">
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-semibold mb-2">Promedio General</p>
                        <p class="text-4xl font-bold text-purple-600">{{ number_format($calificaciones->avg('puntaje_final') ?? 0, 2) }}</p>
                    </div>
                    <div class="bg-card-light dark:bg-card-dark rounded-lg p-6 shadow-md border border-border-light dark:border-border-dark">
                        <p class="text-text-secondary-light dark:text-text-secondary-dark text-sm font-semibold mb-2">Equipo Ganador</p>
                        <p class="text-xl font-bold text-yellow-600">{{ $ganador['equipo']->nombre ?? 'No asignado' }}</p>
                    </div>
                </div>

                <!-- Ranking principal -->
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md overflow-hidden mb-8 border border-border-light dark:border-border-dark">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white">
                        <h2 class="text-2xl font-bold">🏆 Ranking Completo</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 dark:bg-gray-800 border-b-2 border-border-light dark:border-border-dark">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-text-light dark:text-text-dark">Posición</th>
                                    <th class="px-6 py-3 text-left font-semibold text-text-light dark:text-text-dark">Equipo</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-light dark:text-text-dark">Puntuación Promedio</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-light dark:text-text-dark">Desviación Est.</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-light dark:text-text-dark">Calificaciones</th>
                                    <th class="px-6 py-3 text-center font-semibold text-text-light dark:text-text-dark">Estado</th>
                                    @if (Auth::user()->esAdmin())
                                        <th class="px-6 py-3 text-center font-semibold text-text-light dark:text-text-dark">Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ranking as $index => $item)
                                    <tr class="border-b border-border-light dark:border-border-dark hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                        <td class="px-6 py-4 font-bold text-primary">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-text-light dark:text-white">{{ $item['equipo']->nombre }}</p>
                                            <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">Líder: {{ $item['equipo']->lider->nombre }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full font-bold">
                                                {{ number_format($item['puntaje_promedio'], 2) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-text-light dark:text-text-dark">{{ number_format($item['desviacion_estandar'], 2) }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                                                {{ $item['calificaciones_count'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item['ganador'])
                                                <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full font-semibold">
                                                    🏆 GANADOR
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full">
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
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 font-semibold transition">
                                                            Marcar como ganador
                                                        </button>
                                                    @else
                                                        <input type="hidden" name="equipo_id" value="">
                                                        <button type="submit" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 font-semibold transition">
                                                            Desmarcar ganador
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-text-secondary-light dark:text-text-secondary-dark">
                                            No hay equipos con calificaciones
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabla de calificaciones individuales -->
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md overflow-hidden mb-8 border border-border-light dark:border-border-dark">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 text-white">
                        <h2 class="text-2xl font-bold">📋 Calificaciones por Juez</h2>
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
                <div class="mt-8 flex gap-4">
                    <a href="{{ route('admin.resultados.exportar', $evento->id_evento) }}" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-center">
                        📄 Exportar a PDF
                    </a>
                    @if ($ganador)
                        <a href="{{ route('admin.resultados.constancia', $evento->id_evento) }}" class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition text-center">
                            🎖️ Generar Constancia
                        </a>
                    @endif
                    <a href="{{ route('admin.resultados.index') }}" class="flex-1 px-6 py-3 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-semibold rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 transition text-center">
                        ⬅️ Volver
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>