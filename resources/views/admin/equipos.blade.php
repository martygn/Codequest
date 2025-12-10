<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Equipos - CodeQuest</title>
    
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.equipos') }}">
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.resultados-panel') }}">
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
            
            <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-text-dark">Equipos</h2>
                    <p class="text-text-secondary-dark text-sm mt-1">Gestiona los equipos inscritos y sus proyectos.</p>
                </div>
            </header>

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="relative w-full max-w-md">
                    <form method="GET" action="{{ route('admin.equipos') }}" class="flex items-center">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary-dark">search</span>
                        <input name="search" value="{{ $search ?? request('search') }}" 
                               class="w-full pl-10 pr-4 py-2.5 bg-card-dark border border-border-dark text-text-dark rounded-lg focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/50 outline-none transition-all" 
                               placeholder="Buscar equipos..." type="text"/>
                    </form>
                </div>

                <div class="flex gap-2 border-b border-border-dark w-full md:w-auto">
                    <button class="px-4 py-2 text-sm font-medium border-b-2 border-primary text-primary">Todos los equipos</button>
                </div>
            </div>

            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border-dark">
                        <thead>
                            <tr class="bg-[#0D1B2A]">
                                <th class="px-6 py-4 text-left text-xs font-mono text-primary uppercase tracking-wider">Nombre del equipo</th>
                                <th class="px-6 py-4 text-left text-xs font-mono text-primary uppercase tracking-wider">Proyecto</th>
                                <th class="px-6 py-4 text-left text-xs font-mono text-primary uppercase tracking-wider">Miembros</th>
                                <th class="px-6 py-4 text-left text-xs font-mono text-primary uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-left text-xs font-mono text-primary uppercase tracking-wider">Registro</th>
                                <th class="px-6 py-4 text-left text-xs font-mono text-primary uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-dark bg-card-dark">
                            @forelse($equipos ?? [] as $equipo)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-text-dark">{{ $equipo->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-text-secondary-dark">{{ $equipo->nombre_proyecto ?: 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-text-secondary-dark">
                                    <span class="bg-white/5 px-2 py-1 rounded text-xs">{{ $equipo->participantes()->count() }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $badgeClass = match($equipo->estado) {
                                            'aprobado' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                            'rechazado' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                            default => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                        {{ ucfirst($equipo->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-text-secondary-dark font-mono text-xs">
                                    {{ $equipo->created_at->format('d/m/y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('admin.equipos.show', $equipo->id_equipo) }}" class="text-primary hover:text-white transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-lg">visibility</span> Ver
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center px-6 py-8 text-text-secondary-dark">
                                    No hay equipos disponibles
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($equipos, 'links') && $equipos->hasPages())
                <div class="px-4 py-3 border-t border-border-dark bg-card-dark text-text-secondary-dark">
                    {{ $equipos->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

</body>
</html>