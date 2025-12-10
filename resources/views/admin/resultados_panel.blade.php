<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Resultados - CodeQuest</title>
    
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
            
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-text-dark">📊 Resultados Detallados</h1>
                <p class="text-text-secondary-dark text-sm mt-1">Consulta los puntajes finales y ganadores de cada evento.</p>
            </header>

            @if ($resultados->count() > 0)
                <div class="space-y-10">
                    @foreach ($resultados as $resultado)
                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                            
                            <div class="bg-[#0D1B2A] border-b border-border-dark px-6 py-5 flex justify-between items-center">
                                <div>
                                    <h2 class="text-2xl font-bold text-primary">{{ $resultado['evento']->nombre }}</h2>
                                    <div class="flex items-center gap-2 mt-1 text-sm text-text-secondary-dark">
                                        <span class="material-symbols-outlined text-base">event</span>
                                        {{ $resultado['evento']->fecha_inicio->format('d/m/Y') }} - {{ $resultado['evento']->fecha_fin->format('d/m/Y') }}
                                    </div>
                                </div>
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold border border-primary/20">FINALIZADO</span>
                            </div>

                            <div class="p-6">
                                @if ($resultado['ranking']->count() >= 1)
                                    <div class="mb-10">
                                        <h3 class="text-lg font-bold text-text-dark mb-6 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-yellow-400">emoji_events</span> Top 3 Proyectos
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            @foreach ($resultado['ranking']->take(3) as $index => $item)
                                                @php
                                                    $estilos = [
                                                        ['border' => 'border-yellow-500/50', 'bg' => 'bg-yellow-500/10', 'text' => 'text-yellow-400', 'icon' => '🥇'],
                                                        ['border' => 'border-gray-400/50', 'bg' => 'bg-gray-400/10', 'text' => 'text-gray-300', 'icon' => '🥈'],
                                                        ['border' => 'border-orange-500/50', 'bg' => 'bg-orange-500/10', 'text' => 'text-orange-400', 'icon' => '🥉'],
                                                    ];
                                                    $style = $estilos[$index] ?? $estilos[0];
                                                @endphp
                                                <div class="relative bg-card-dark rounded-xl p-6 border {{ $style['border'] }} shadow-lg flex flex-col items-center text-center transform hover:-translate-y-1 transition-transform duration-300">
                                                    <div class="text-4xl mb-3">{{ $style['icon'] }}</div>
                                                    <h4 class="text-xl font-bold text-text-dark mb-1">{{ $item['equipo']->nombre }}</h4>
                                                    <p class="text-3xl font-mono font-bold {{ $style['text'] }}">{{ $item['puntaje_total'] }}</p>
                                                    <p class="text-xs text-text-secondary-dark mt-2">/100 puntos</p>
                                                    <div class="text-xs text-text-secondary-dark mt-3 space-y-1 w-full">
                                                        <div class="flex justify-between">
                                                            <span>Innovación:</span>
                                                            <span class="text-primary">{{ $item['detalles']['innovacion'] ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex justify-between">
                                                            <span>Funcionalidad:</span>
                                                            <span class="text-primary">{{ $item['detalles']['funcionalidad'] ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex justify-between">
                                                            <span>Impacto:</span>
                                                            <span class="text-primary">{{ $item['detalles']['impacto'] ?? '-' }}</span>
                                                        </div>
                                                        <div class="flex justify-between">
                                                            <span>Presentación:</span>
                                                            <span class="text-primary">{{ $item['detalles']['presentacion'] ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="overflow-x-auto rounded-lg border border-border-dark">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-[#0D1B2A] border-b border-border-dark">
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider">Posición</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider">Equipo</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Puntuación</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Innovación</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Funcionalidad</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Impacto</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Presentación</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Calificado</th>
                                                <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-right">Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border-dark">
                                            @foreach ($resultado['ranking'] as $index => $item)
                                                <tr class="hover:bg-white/5 transition-colors">
                                                    <td class="px-6 py-4 font-bold text-text-secondary-dark">#{{ $index + 1 }}</td>
                                                    <td class="px-6 py-4 font-medium text-text-dark">{{ $item['equipo']->nombre }}</td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary font-bold rounded-lg border border-primary/20">
                                                            {{ $item['puntaje_total'] }}/100
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center text-text-secondary-dark text-sm">{{ $item['detalles']['innovacion'] ?? '-' }}/30</td>
                                                    <td class="px-6 py-4 text-center text-text-secondary-dark text-sm">{{ $item['detalles']['funcionalidad'] ?? '-' }}/30</td>
                                                    <td class="px-6 py-4 text-center text-text-secondary-dark text-sm">{{ $item['detalles']['impacto'] ?? '-' }}/20</td>
                                                    <td class="px-6 py-4 text-center text-text-secondary-dark text-sm">{{ $item['detalles']['presentacion'] ?? '-' }}/20</td>
                                                    <td class="px-6 py-4 text-center text-xs text-text-secondary-dark">
                                                        {{ isset($item['calificado_en']) ? \Carbon\Carbon::parse($item['calificado_en'])->format('d/m/Y H:i') : 'Sin fecha' }}
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        @if (!empty($item['detalles']['comentarios']))
                                                            <button class="text-text-secondary-dark hover:text-primary transition-colors text-sm font-medium" onclick="alert('{{ addslashes($item['detalles']['comentarios']) }}')">
                                                                Ver comentario →
                                                            </button>
                                                        @else
                                                            <span class="text-xs text-text-secondary-dark">-</span>
                                                        @endif
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
                <div class="flex flex-col items-center justify-center py-20 bg-card-dark border border-dashed border-border-dark rounded-xl">
                    <span class="material-symbols-outlined text-6xl text-text-secondary-dark mb-4 opacity-50">inbox</span>
                    <h3 class="text-xl font-bold text-text-dark">No hay resultados disponibles</h3>
                    <p class="text-text-secondary-dark mt-2">Los eventos aparecerán aquí una vez que tengan calificaciones registradas.</p>
                </div>
            @endif

        </div>
    </main>
</div>

</body>
</html>