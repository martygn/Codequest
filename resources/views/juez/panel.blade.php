<!DOCTYPE html>
<html lang="es" class="dark">
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

            <!-- Usuario -->
            <div class="pt-6 border-t border-border-dark">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-border-dark border border-primary/20 flex items-center justify-center text-primary font-bold">
                        {{ substr($juez->nombre, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-dark">{{ $juez->nombre }}</p>
                        <p class="text-xs text-text-secondary-dark">Juez</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 overflow-y-auto bg-background-dark p-8 relative">

            <!-- Efecto de fondo -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto relative z-10">

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-text-dark">Panel de Evaluación</h1>
                    <p class="text-text-secondary-dark mt-2">Evalúa los equipos asignados en los eventos</p>
                </div>

                <!-- Selector de Evento -->
                @if($eventosAsignados->count() > 0)
                <div class="mb-6">
                    <div class="bg-primary/5 border border-primary/20 rounded-xl p-4">
                        <label class="block text-xs font-mono text-primary uppercase mb-3">Evento Activo</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($eventosAsignados as $eventoItem)
                            <a href="{{ route('juez.panel', ['evento' => $eventoItem->id_evento]) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $evento && $evento->id_evento == $eventoItem->id_evento ? 'bg-primary text-background-dark' : 'bg-card-dark text-text-secondary-dark border border-border-dark hover:text-primary hover:border-primary' }}">
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
                <div class="mb-8 bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-text-dark">{{ $evento->nombre }}</h2>
                            <p class="text-text-secondary-dark mt-1">{{ $evento->descripcion }}</p>

                            <div class="mt-4 flex items-center gap-6 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-base">event</span>
                                    <span class="text-text-secondary-dark">
                                        Inicia: {{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('d M Y, H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-base">event_available</span>
                                    <span class="text-text-secondary-dark">
                                        Finaliza: {{ \Carbon\Carbon::parse($evento->fecha_fin)->translatedFormat('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium
                                {{ $evento->estado === 'publicado' ? 'bg-green-500/10 text-green-400 border border-green-500/30' : 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30' }}">
                                {{ ucfirst($evento->estado) }}
                            </span>
                            <p class="text-xs text-text-secondary-dark mt-2">{{ $equipos->count() }} equipos asignados</p>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Equipos -->
                <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                    <div class="px-6 py-4 border-b border-border-dark">
                        <h3 class="text-lg font-bold text-text-dark">Equipos para Evaluar</h3>
                        <p class="text-sm text-text-secondary-dark">Haz clic en "Ver Proyecto" para revisar y calificar</p>
                    </div>

                    @if($equipos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-background-dark">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Equipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Miembros</th>
                                    <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Calificación</th>
                                    <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-dark">
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
                                <tr class="hover:bg-white/5 transition">
                                    <!-- Nombre del Equipo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-border-dark flex items-center justify-center text-primary font-bold text-sm mr-3 border border-primary/20">
                                                {{ substr($equipo->nombre, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-text-dark">{{ $equipo->nombre }}</p>
                                                <p class="text-xs text-text-secondary-dark">{{ $equipo->nombre_proyecto }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Columna de Proyecto -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary-dark">
                                        @if($equipo->repositorio && $equipo->repositorio->estado === 'enviado')
                                            <a href="{{ route('proyecto.juez.ver-juez', $equipo->repositorio) }}"
                                               class="text-primary hover:text-white hover:underline transition-colors">
                                                Ver Proyecto
                                                @if($equipo->repositorio->calificacion_total)
                                                    <span class="ml-2 px-2 py-1 text-xs bg-green-500/10 text-green-400 border border-green-500/30 rounded-lg">
                                                        ✓ Calificado
                                                    </span>
                                                @else
                                                    <span class="ml-2 px-2 py-1 text-xs bg-yellow-500/10 text-yellow-400 border border-yellow-500/30 rounded-lg">
                                                        Pendiente
                                                    </span>
                                                @endif
                                            </a>
                                        @else
                                            <span class="text-text-secondary-dark opacity-50">No entregado</span>
                                        @endif
                                    </td>

                                    <!-- Estado del Equipo -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium
                                            {{ $equipo->estado === 'aprobado' ? 'bg-green-500/10 text-green-400 border border-green-500/30' :
                                               ($equipo->estado === 'rechazado' ? 'bg-red-500/10 text-red-400 border border-red-500/30' :
                                               'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30') }}">
                                            {{ ucfirst($equipo->estado) }}
                                        </span>
                                    </td>

                                    <!-- Miembros -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary-dark">
                                        <div class="flex -space-x-2">
                                            @foreach($equipo->participantes->take(3) as $participante)
                                            <div class="h-8 w-8 rounded-full border-2 border-card-dark bg-border-dark flex items-center justify-center text-xs font-bold text-primary"
                                                 title="{{ $participante->nombre }}">
                                                {{ substr($participante->nombre, 0, 1) }}
                                            </div>
                                            @endforeach
                                            @if($equipo->participantes->count() > 3)
                                            <div class="h-8 w-8 rounded-full border-2 border-card-dark bg-background-dark flex items-center justify-center text-xs font-bold text-text-secondary-dark">
                                                +{{ $equipo->participantes->count() - 3 }}
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Calificación -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($equipo->repositorio && $equipo->repositorio->calificacion_total)
                                        <div class="flex items-center">
                                            <div class="w-24 bg-border-dark rounded-full h-2 mr-3">
                                                <div class="bg-primary h-2 rounded-full" style="width: {{ $equipo->repositorio->calificacion_total }}%"></div>
                                            </div>
                                            <span class="text-sm font-semibold text-text-dark">{{ $equipo->repositorio->calificacion_total }}/100</span>
                                        </div>
                                        @else
                                        <span class="text-sm text-text-secondary-dark opacity-50">Sin calificar</span>
                                        @endif
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($equipo->repositorio && $equipo->repositorio->estado === 'enviado')
                                            <a href="{{ route('proyecto.juez.calificar-juez', $equipo->repositorio) }}"
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-lg {{ $yaCalificado ? 'bg-yellow-600 hover:bg-yellow-700 text-white' : 'bg-primary hover:bg-primary/90 text-background-dark' }} transition-all shadow-lg">
                                                <span class="material-symbols-outlined text-sm mr-1">rate_review</span>
                                                {{ $yaCalificado ? 'Editar Calificación' : 'Calificar Proyecto' }}
                                            </a>
                                        @else
                                            <span class="text-text-secondary-dark opacity-50">Esperando proyecto</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="px-6 py-12 text-center">
                        <span class="material-symbols-outlined text-4xl text-text-secondary-dark opacity-30 mb-4">group_remove</span>
                        <h3 class="text-lg font-medium text-text-dark mb-2">No hay equipos asignados</h3>
                        <p class="text-text-secondary-dark">Este evento aún no tiene equipos aprobados para evaluar.</p>
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
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center mr-4">
                                <span class="material-symbols-outlined text-primary">groups</span>
                            </div>
                            <div>
                                <p class="text-xs font-mono text-primary uppercase">Equipos Totales</p>
                                <p class="text-2xl font-bold text-text-dark">{{ $equipos->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-full bg-green-500/10 border border-green-500/30 flex items-center justify-center mr-4">
                                <span class="material-symbols-outlined text-green-400">check_circle</span>
                            </div>
                            <div>
                                <p class="text-xs font-mono text-green-400 uppercase">Calificados por ti</p>
                                <p class="text-2xl font-bold text-text-dark">{{ $proyectosCalificados }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-full bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center mr-4">
                                <span class="material-symbols-outlined text-yellow-400">pending</span>
                            </div>
                            <div>
                                <p class="text-xs font-mono text-yellow-400 uppercase">Proyectos pendientes</p>
                                <p class="text-2xl font-bold text-text-dark">{{ $proyectosPendientes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @else
                <!-- Sin evento seleccionado -->
                <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-text-secondary-dark opacity-30 mb-4">calendar_today</span>
                    <h3 class="text-xl font-medium text-text-dark mb-2">No hay evento seleccionado</h3>
                    <p class="text-text-secondary-dark mb-6">Selecciona un evento de la lista para comenzar a evaluar equipos.</p>

                    @if($eventosAsignados->count() === 0)
                    <div class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg text-white bg-yellow-600 hover:bg-yellow-700 shadow-lg transition-all">
                        <span class="material-symbols-outlined mr-2">warning</span>
                        No tienes eventos asignados
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </main>
    </div>

</body>
</html>
