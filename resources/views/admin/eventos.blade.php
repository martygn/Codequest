<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Eventos - CodeQuest</title>
    
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.eventos') }}">
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
                    <h2 class="text-3xl font-bold text-text-dark">Eventos</h2>
                    <p class="text-text-secondary-dark text-sm mt-1">Gestiona las competencias y hackathons.</p>
                </div>
                <a href="{{ route('admin.eventos.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-background-dark rounded-lg font-bold hover:bg-opacity-90 hover:shadow-[0_0_15px_rgba(100,255,218,0.4)] transition-all duration-300">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    Nuevo evento
                </a>
            </header>

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                
                <div class="relative w-full max-w-md">
                    <form method="GET" action="{{ route('admin.eventos') }}" class="flex items-center">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary-dark">search</span>
                        <input name="search" value="{{ $search ?? request('search') }}" 
                               class="w-full pl-10 pr-4 py-2.5 bg-card-dark border border-border-dark text-text-dark rounded-lg focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/50 outline-none transition-all" 
                               placeholder="Buscar por nombre..." type="text"/>
                        <input type="hidden" name="status" value="{{ $status ?? 'pendientes' }}" />
                    </form>
                </div>

                <nav class="flex space-x-1 bg-card-dark p-1 rounded-lg border border-border-dark">
                    @php $currentStatus = $status ?? 'pendientes'; @endphp
                    
                    <a href="{{ route('admin.eventos', ['status' => 'todos']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $currentStatus === 'todos' ? 'bg-primary text-background-dark shadow-sm' : 'text-text-secondary-dark hover:text-text-dark hover:bg-white/5' }}">
                        Todos
                    </a>
                    <a href="{{ route('admin.eventos', ['status' => 'pendientes']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $currentStatus === 'pendientes' ? 'bg-primary text-background-dark shadow-sm' : 'text-text-secondary-dark hover:text-text-dark hover:bg-white/5' }}">
                        Pendientes
                    </a>
                    <a href="{{ route('admin.eventos', ['status' => 'publicados']) }}" 
                       class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $currentStatus === 'publicados' ? 'bg-primary text-background-dark shadow-sm' : 'text-text-secondary-dark hover:text-text-dark hover:bg-white/5' }}">
                        Publicados
                    </a>
                </nav>
            </div>

            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0D1B2A] border-b border-border-dark">
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider">Nombre del Evento</th>
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider">Fecha Inicio</th>
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider text-center">Estado</th>
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-dark">
                            @foreach($eventos ?? [] as $evento)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-4 font-medium text-text-dark">{{ $evento->nombre }}</td>
                                <td class="p-4 text-text-secondary-dark text-sm">{{ $evento->fecha_inicio }}</td>
                                <td class="p-4 text-center">
                                    @php
                                        $estado = $evento->estado ?? 'pendiente';
                                        $badgeClass = match($estado) {
                                            'publicado' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                            'pendiente' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                            default => 'bg-gray-500/10 text-gray-400 border-gray-500/20'
                                        };
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                        {{ ucfirst($estado) }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.eventos.show', $evento->id_evento) }}" class="text-text-secondary-dark hover:text-primary transition-colors text-sm font-medium flex items-center gap-1">
                                            <span class="material-symbols-outlined text-lg">visibility</span> Revisar
                                        </a>

                                        @if(auth()->user() && auth()->user()->esAdmin())
                                        <form method="POST" action="{{ route('admin.eventos.update-status', $evento->id_evento) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="estado" class="bg-background-dark border border-border-dark text-xs rounded text-text-secondary-dark focus:border-primary focus:ring-1 focus:ring-primary outline-none py-1 pl-2 pr-6">
                                                <option value="pendiente" {{ ($evento->estado ?? 'pendiente') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="publicado" {{ ($evento->estado ?? 'pendiente') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                                            </select>
                                            <button type="submit" class="text-primary hover:text-white bg-primary/10 hover:bg-primary/20 p-1.5 rounded transition-colors" title="Guardar cambio">
                                                <span class="material-symbols-outlined text-lg">save</span>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(count($eventos ?? []) == 0)
                            <tr>
                                <td colspan="4" class="p-8 text-center text-text-secondary-dark">
                                    No se encontraron eventos en esta sección.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(method_exists($eventos, 'links') && $eventos->hasPages())
                <div class="px-4 py-3 border-t border-border-dark bg-card-dark">
                    <div class="text-text-secondary-dark">
                        {{ $eventos->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

</body>
</html>