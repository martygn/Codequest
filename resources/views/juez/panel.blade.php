<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Panel de Juez - CodeQuest</title>
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
    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
            <nav class="mt-8 space-y-2">
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('juez.panel') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold' : 'text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" href="{{ route('juez.panel') }}">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <span>Eventos</span>
                </a>
                @forelse($eventosAsignados as $ev)
                    @if($eventosAsignados->count() > 1)
                        <a href="{{ route('juez.panel', ['evento' => $ev->id_evento]) }}" class="flex items-center gap-3 px-4 py-2 ml-3 text-sm {{ $evento && $evento->id_evento === $ev->id_evento ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold' : 'text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}">
                            <span class="material-symbols-outlined text-base">{{ $evento && $evento->id_evento === $ev->id_evento ? 'radio_button_checked' : 'radio_button_unchecked' }}</span>
                            <span class="truncate">{{ $ev->nombre }}</span>
                        </a>
                    @endif
                @empty
                @endforelse
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('juez.constancias') ? 'text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold' : 'text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" href="{{ route('juez.constancias') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Historial de Constancias</span>
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
        <div class="max-w-7xl mx-auto">
            <header class="mb-8">
                <h2 class="text-4xl font-bold text-slate-900 dark:text-white">Panel de Juez</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Bienvenido, {{ $juez->nombre_completo }}</p>
            </header>

            @if($evento)
                <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8">
                    <h3 class="text-2xl font-semibold text-slate-900 dark:text-white mb-4">Evento Asignado</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Nombre del Evento</label>
                            <p class="text-slate-900 dark:text-white font-semibold mt-1">{{ $evento->nombre }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Descripción</label>
                            <p class="text-slate-700 dark:text-slate-300 mt-1">{{ $evento->descripcion ?? 'Sin descripción' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Fecha de Inicio</label>
                            <p class="text-slate-900 dark:text-white font-semibold mt-1">{{ $evento->fecha_inicio->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-600 dark:text-slate-400">Fecha de Fin</label>
                            <p class="text-slate-900 dark:text-white font-semibold mt-1">{{ $evento->fecha_fin->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                    <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-2xl font-semibold text-slate-900 dark:text-white">Equipos a Evaluar</h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">Total: {{ $equipos->count() }} equipo(s)</p>
                    </div>

                    @if($equipos->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Nombre del Equipo</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Proyecto</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Líder</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Miembros</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Estado</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-400">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipos as $equipo)
                                    <tr class="border-b border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                        <td class="px-6 py-4 text-slate-900 dark:text-white font-medium">{{ $equipo->nombre }}</td>
                                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">{{ $equipo->nombre_proyecto ?? '-' }}</td>
                                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">{{ $equipo->lider->nombre_completo ?? '-' }}</td>
                                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">{{ $equipo->participantes->count() }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full 
                                                {{ $equipo->estado === 'aprobado' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 
                                                   ($equipo->estado === 'rechazado' ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : 
                                                   'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300') }}">
                                                {{ $equipo->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $calificacion = $equipo->calificaciones?->firstWhere('juez_id', $juez->id);
                                            @endphp
                                            @if($calificacion)
                                                <a href="{{ route('calificaciones.show', ['equipo' => $equipo->id_equipo]) }}" class="text-primary hover:underline font-medium">Editar Puntuación</a>
                                            @else
                                                <a href="{{ route('calificaciones.show', ['equipo' => $equipo->id_equipo]) }}" class="text-primary hover:underline font-medium">Calificar</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-6 text-center text-slate-500 dark:text-slate-400">
                            <p>No hay equipos asignados para este evento.</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-yellow-600 dark:text-yellow-400 mx-auto block mb-4">info</span>
                    <h3 class="text-xl font-semibold text-yellow-800 dark:text-yellow-300 mb-2">Sin evento asignado</h3>
                    <p class="text-yellow-700 dark:text-yellow-400">
                        Aún no se te ha asignado ningún evento. Contacta al administrador.
                    </p>
                </div>
            @endif
        </div>
    </main>
</div>

</body>
</html>
