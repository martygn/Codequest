<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Panel del Juez - CodeQuest</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#2998FF",
                        "background-light": "#F8FAFC",
                        "background-dark": "#18181B",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">CodeQuest</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Panel del Juez</p>

                <nav class="mt-8 space-y-2">
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 rounded font-semibold" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Constancias</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('juez.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>

            <!-- Usuario -->
            <div class="pt-6 border-t border-gray-200 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                        {{ substr($juez->nombre, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $juez->nombre }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Juez</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 overflow-y-auto bg-white dark:bg-zinc-900 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Panel de Evaluación</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Evalúa los equipos asignados en los eventos</p>
            </div>

            <!-- Selector de Evento -->
            @if($eventosAsignados->count() > 0)
            <div class="mb-6">
                <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-blue-800 dark:text-blue-300 mb-2">Evento Activo</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($eventosAsignados as $eventoItem)
                        <a href="{{ route('juez.panel', ['evento' => $eventoItem->id_evento]) }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $evento && $evento->id_evento == $eventoItem->id_evento ? 'bg-primary text-white' : 'bg-white dark:bg-zinc-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700' }}">
                            {{ $eventoItem->nombre }}
                            @if($eventoItem->id_evento == $evento->id_evento)
                            <span class="ml-1">✓</span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($evento)
            <!-- Información del Evento -->
            <div class="mb-8 bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $evento->nombre }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $evento->descripcion }}</p>

                        <div class="mt-4 flex items-center gap-6 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-gray-400">event</span>
                                <span class="text-gray-600 dark:text-gray-400">
                                    Inicia: {{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-gray-400">event_available</span>
                                <span class="text-gray-600 dark:text-gray-400">
                                    Finaliza: {{ \Carbon\Carbon::parse($evento->fecha_fin)->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $evento->estado === 'publicado' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300' }}">
                            {{ ucfirst($evento->estado) }}
                        </span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $equipos->count() }} equipos asignados</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de Equipos -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Equipos para Evaluar</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Haz clic en "Ver Proyecto" para revisar y calificar</p>
                </div>

                @if($equipos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-zinc-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Equipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Proyecto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Miembros</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Calificación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                            @foreach($equipos as $equipo)
                            @php
                                // Determinar si el juez ya calificó este proyecto
                                $yaCalificado = false;
                                if($equipo->repositorio && $equipo->repositorio->calificacion_detalle) {
                                    $detalle = json_decode($equipo->repositorio->calificacion_detalle, true);
                                    if(isset($detalle['calificado_por']) && $detalle['calificado_por'] == $juez->id) {
                                        $yaCalificado = true;
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition">
                                <!-- Nombre del Equipo -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold mr-3">
                                            {{ substr($equipo->nombre, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $equipo->nombre }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $equipo->nombre_proyecto }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Columna de Proyecto -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if($equipo->repositorio && $equipo->repositorio->estado === 'enviado')
                                        <a href="{{ route('proyecto.juez.ver-juez', $equipo->repositorio) }}"
                                           class="text-blue-600 hover:text-blue-900 hover:underline">
                                            Ver Proyecto
                                            @if($equipo->repositorio->calificacion_total)
                                                <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                                    ✓ Calificado
                                                </span>
                                            @else
                                                <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                                    Pendiente
                                                </span>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-gray-400">No entregado</span>
                                    @endif
                                </td>

                                <!-- Estado del Equipo -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $equipo->estado === 'aprobado' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' :
                                           ($equipo->estado === 'rechazado' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' :
                                           'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300') }}">
                                        {{ ucfirst($equipo->estado) }}
                                    </span>
                                </td>

                                <!-- Miembros -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex -space-x-2">
                                        @foreach($equipo->participantes->take(3) as $participante)
                                        <div class="h-8 w-8 rounded-full border-2 border-white dark:border-zinc-800 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-700 dark:text-gray-300"
                                             title="{{ $participante->nombre }}">
                                            {{ substr($participante->nombre, 0, 1) }}
                                        </div>
                                        @endforeach
                                        @if($equipo->participantes->count() > 3)
                                        <div class="h-8 w-8 rounded-full border-2 border-white dark:border-zinc-800 bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-xs font-bold text-gray-700 dark:text-gray-300">
                                            +{{ $equipo->participantes->count() - 3 }}
                                        </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Calificación -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($equipo->repositorio && $equipo->repositorio->calificacion_total)
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $equipo->repositorio->calificacion_total }}%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $equipo->repositorio->calificacion_total }}/100</span>
                                    </div>
                                    @else
                                    <span class="text-sm text-gray-400 dark:text-gray-500">Sin calificar</span>
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($equipo->repositorio && $equipo->repositorio->estado === 'enviado')
                                        <a href="{{ route('proyecto.juez.calificar-juez', $equipo->repositorio) }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white {{ $yaCalificado ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-primary hover:bg-blue-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                                            <span class="material-symbols-outlined text-sm mr-1">rate_review</span>
                                            {{ $yaCalificado ? 'Editar Calificación' : 'Calificar Proyecto' }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">Esperando proyecto</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-12 text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-500 mb-4">group_remove</span>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay equipos asignados</h3>
                    <p class="text-gray-500 dark:text-gray-400">Este evento aún no tiene equipos aprobados para evaluar.</p>
                </div>
                @endif
            </div>

            <!-- Estadísticas -->
            @if($equipos->count() > 0)
            @php
                // Calcular estadísticas
                $proyectosCalificados = 0;
                $proyectosPendientes = 0;
                foreach($equipos as $equipo) {
                    if($equipo->repositorio && $equipo->repositorio->estado === 'enviado') {
                        $yaCalificado = false;
                        if($equipo->repositorio->calificacion_detalle) {
                            $detalle = json_decode($equipo->repositorio->calificacion_detalle, true);
                            if(isset($detalle['calificado_por']) && $detalle['calificado_por'] == $juez->id) {
                                $yaCalificado = true;
                                $proyectosCalificados++;
                            }
                        }
                        if(!$yaCalificado) {
                            $proyectosPendientes++;
                        }
                    }
                }
            @endphp
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mr-4">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-300">groups</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Equipos Totales</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $equipos->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center mr-4">
                            <span class="material-symbols-outlined text-green-600 dark:text-green-300">check_circle</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Proyectos calificados por ti</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $proyectosCalificados }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                    <div class="flex items-center">
                        <div class="h-12 w-12 rounded-full bg-yellow-100 dark:bg-yellow-900/50 flex items-center justify-center mr-4">
                            <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-300">pending</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Proyectos pendientes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $proyectosPendientes }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @else
            <!-- Sin evento seleccionado -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-500 mb-4">calendar_today</span>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No hay evento seleccionado</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Selecciona un evento de la lista para comenzar a evaluar equipos.</p>

                @if($eventosAsignados->count() === 0)
                <div class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                    <span class="material-symbols-outlined mr-2">warning</span>
                    No tienes eventos asignados
                </div>
                @endif
            </div>
            @endif
        </main>
    </div>
</body>
</html>
