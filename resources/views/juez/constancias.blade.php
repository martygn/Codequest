<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Historial de Constancias - CodeQuest</title>
    
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

             <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-12 w-auto">
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>
        
        <nav class="flex-grow px-4 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Evento Asignado</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Historial Constancias</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.configuracion') }}">
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
                <h2 class="text-3xl font-bold text-text-dark">Historial de Constancias</h2>
                <p class="text-text-secondary-dark text-sm mt-1">Descarga y revisa todas las constancias generadas por tus evaluaciones.</p>
            </header>

            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                
                <div class="p-6 border-b border-border-dark flex justify-between items-center bg-[#0D1B2A]">
                    <div>
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">history_edu</span>
                            Constancias Emitidas
                        </h3>
                    </div>
                    <span class="text-xs font-mono text-primary bg-primary/10 px-3 py-1 rounded border border-primary/20">
                        Total: {{ count($constancias) }}
                    </span>
                </div>

                @if(count($constancias) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#0A192F]/50 border-b border-border-dark">
                                    <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider">Evento</th>
                                    <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider">Equipo Ganador</th>
                                    <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider">Fecha Emisión</th>
                                    <th class="px-6 py-4 text-xs font-mono text-primary uppercase tracking-wider text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-dark">
                                {{-- Aquí iterarías tus constancias --}}
                                @foreach($constancias as $constancia)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-6 py-4 font-medium text-text-dark">
                                        {{ $constancia->evento->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-text-secondary-dark">
                                        {{ $constancia->equipo->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-text-secondary-dark font-mono text-xs">
                                        {{ $constancia->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="#" class="text-primary hover:text-white transition-colors text-sm font-medium flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined">download</span> Descargar
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <div class="w-20 h-20 bg-background-dark rounded-full flex items-center justify-center mx-auto mb-4 border border-border-dark">
                            <span class="material-symbols-outlined text-4xl text-text-secondary-dark opacity-50">folder_off</span>
                        </div>
                        <h4 class="text-xl font-bold text-text-dark mb-2">No hay constancias generadas</h4>
                        <p class="text-text-secondary-dark text-sm max-w-md mx-auto">
                            Las constancias aparecerán aquí una vez que finalices la evaluación de un evento y selecciones un equipo ganador.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </main>
</div>

</body>
</html>