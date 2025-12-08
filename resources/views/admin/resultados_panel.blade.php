<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Resultados - Administrador</title>
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
                    <h1 class="text-4xl font-bold text-text-light dark:text-white">
                        📊 Resultados de Eventos
                    </h1>
                    <p class="text-text-secondary-light dark:text-text-secondary-dark mt-2">Administra y visualiza los resultados de todos los eventos</p>
                </div>

                <!-- Eventos con calificaciones -->
                @if ($resultados->count() > 0)
                    <div class="space-y-8">
                        @foreach ($resultados as $resultado)
                            <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md overflow-hidden border border-border-light dark:border-border-dark">
                                <!-- Encabezado del evento -->
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white">
                                    <h2 class="text-2xl font-bold">{{ $resultado['evento']->nombre }}</h2>
                                    <p class="text-blue-100 mt-1">📅 {{ $resultado['evento']->fecha_inicio->format('d/m/Y') }} - {{ $resultado['evento']->fecha_fin->format('d/m/Y') }}</p>
                                </div>

                                <!-- Contenido -->
                                <div class="p-6">
                                    <!-- Top 3 -->
                                    @if ($resultado['ranking']->count() >= 3)
                                        <div class="mb-8">
                                            <h3 class="text-xl font-bold text-text-light dark:text-white mb-4">🥇 Top 3 Ganadores</h3>
                                            <div class="grid grid-cols-3 gap-4">
                                                @foreach ($resultado['ranking']->take(3) as $index => $item)
                                                    @php
                                                        $medallasColor = [
                                                            ['bg' => 'from-yellow-400 to-yellow-500', 'border' => 'yellow', 'medal' => '🥇'],
                                                            ['bg' => 'from-gray-400 to-gray-500', 'border' => 'gray', 'medal' => '🥈'],
                                                            ['bg' => 'from-orange-400 to-orange-500', 'border' => 'orange', 'medal' => '🥉'],
                                                        ];
                                                        $color = $medallasColor[$index];
                                                    @endphp
                                                    <div class="bg-gradient-to-b {{ $color['bg'] }} rounded-lg p-4 text-white text-center shadow-md">
                                                        <p class="text-4xl mb-2">{{ $color['medal'] }}</p>
                                                        <p class="font-bold text-lg">{{ $item['equipo']->nombre }}</p>
                                                        <p class="text-2xl font-bold mt-2">{{ number_format($item['puntaje_promedio'], 2) }}</p>
                                                        <p class="text-sm opacity-90">{{ $item['calificaciones_count'] }} jueces</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Ranking completo -->
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 dark:bg-gray-800 border-b-2 border-border-light dark:border-border-dark">
                                                <tr>
                                                    <th class="px-4 py-2 text-left font-semibold text-text-light dark:text-text-dark">Posición</th>
                                                    <th class="px-4 py-2 text-left font-semibold text-text-light dark:text-text-dark">Equipo</th>
                                                    <th class="px-4 py-2 text-center font-semibold text-text-light dark:text-text-dark">Puntuación</th>
                                                    <th class="px-4 py-2 text-center font-semibold text-text-light dark:text-text-dark">Jueces</th>
                                                    <th class="px-4 py-2 text-center font-semibold text-text-light dark:text-text-dark">Estado</th>
                                                    <th class="px-4 py-2 text-center font-semibold text-text-light dark:text-text-dark">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resultado['ranking'] as $index => $item)
                                                    <tr class="border-b border-border-light dark:border-border-dark hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                                        <td class="px-4 py-3 font-bold text-primary">#{{ $index + 1 }}</td>
                                                        <td class="px-4 py-3 font-semibold text-text-light dark:text-white">{{ $item['equipo']->nombre }}</td>
                                                        <td class="px-4 py-3 text-center">
                                                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full font-bold">{{ number_format($item['puntaje_promedio'], 2) }}</span>
                                                        </td>
                                                        <td class="px-4 py-3 text-center">{{ $item['calificaciones_count'] }}</td>
                                                        <td class="px-4 py-3 text-center">
                                                            @if ($item['ganador'])
                                                                <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-xs font-bold">🏆 GANADOR</span>
                                                            @else
                                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-xs">Participante</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-3 text-center">
                                                            <a href="{{ route('admin.resultados.show', $resultado['evento']->id_evento) }}" class="text-primary hover:underline font-semibold">
                                                                Ver Detalles
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Sin resultados -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-lg p-12 text-center">
                        <p class="text-4xl mb-4">📭</p>
                        <p class="text-xl text-gray-700 dark:text-gray-300">No hay eventos con calificaciones aún</p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Los resultados aparecerán aquí cuando se registren calificaciones de jueces</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
</body>
</html>
