<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Jueces - CodeQuest</title>
    
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.jueces') }}">
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
                    <h2 class="text-3xl font-bold text-text-dark">Jueces</h2>
                    <p class="text-text-secondary-dark text-sm mt-1">Gestiona los jueces y sus asignaciones.</p>
                </div>
                <a href="{{ route('admin.jueces.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-background-dark rounded-lg font-bold hover:bg-opacity-90 hover:shadow-[0_0_15px_rgba(100,255,218,0.4)] transition-all duration-300">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    Nuevo juez
                </a>
            </header>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg flex items-center gap-3 animate-fade-in-up">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0D1B2A] border-b border-border-dark">
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider">Nombre</th>
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider">Correo</th>
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider">Asignaciones</th>
                                <th class="p-4 text-xs font-mono text-primary uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-dark">
                            @forelse($jueces as $j)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="p-4 font-medium text-text-dark">{{ $j->nombre }} {{ $j->apellido_paterno }}</td>
                                <td class="p-4 text-text-secondary-dark text-sm">{{ $j->correo }}</td>
                                <td class="p-4">
                                    <?php
                                        // Mantuve tu lógica PHP intacta
                                        $asigs = \DB::table('juez_evento')
                                            ->where('usuario_id', $j->id)
                                            ->join('eventos', 'juez_evento.evento_id', '=', 'eventos.id_evento')
                                            ->pluck('eventos.nombre');
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full 
                                        {{ $asigs->count() > 0 ? 'bg-primary/10 text-primary border border-primary/20' : 'bg-white/5 text-text-secondary-dark border border-white/10' }}">
                                        {{ $asigs->count() > 0 ? $asigs->count() . ' evento(s)' : 'Sin asignaciones' }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('admin.jueces.asignar-eventos', $j->id) }}" class="text-text-secondary-dark hover:text-primary transition-colors text-sm font-medium inline-flex items-center gap-1 group-hover:underline decoration-primary underline-offset-4">
                                        <span class="material-symbols-outlined text-lg">assignment_ind</span> Asignar
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-text-secondary-dark">
                                    <div class="flex flex-col items-center">
                                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">gavel</span>
                                        No hay jueces registrados en el sistema.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($jueces, 'links') && $jueces->hasPages())
                <div class="px-4 py-3 border-t border-border-dark bg-card-dark">
                    <div class="text-text-secondary-dark">
                        {{ $jueces->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

</body>
</html>