<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $equipo->nombre }} - Panel Admin</title>
    
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
        
        <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between shadow-xl z-20">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
            
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        
                </div>

                <nav class="space-y-1">
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">gavel</span>
                        <span>Jueces</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <span>Resultados</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>
            
            <div class="pt-4 border-t border-border-dark">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-text-secondary-dark hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-background-dark p-8 relative">
            
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-5xl mx-auto relative z-10">
                
                <div class="mb-8">
                    <a href="{{ route('admin.equipos') }}" class="text-primary hover:text-white flex items-center gap-2 mb-4 transition-colors w-fit group text-sm font-medium">
                        <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                        Volver a Equipos
                    </a>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mt-4">{{ $equipo->nombre }}</h1>
                    <div class="mt-4 flex items-center gap-4">
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                            {{ $equipo->estado === 'aprobado' ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300' :
                               ($equipo->estado === 'rechazado' ? 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300' :
                               'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300') }}">
                            {{ ucfirst($equipo->estado) }}
                        </span>
                    </div>
                </div>

                @if($equipo->banner)
                <div class="mb-10 rounded-xl overflow-hidden shadow-lg border border-border-dark h-64 md:h-80 relative group">
                    <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent opacity-60"></div>
                    <img src="{{ Storage::url($equipo->banner) }}" alt="{{ $equipo->nombre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                            <h3 class="text-xl font-bold text-text-dark mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">info</span> Información General
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4">
                                <div>
                                    <p class="text-xs font-mono text-primary uppercase mb-1">Nombre del Proyecto</p>
                                    <p class="text-lg text-text-dark font-medium">{{ $equipo->nombre_proyecto }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-mono text-primary uppercase mb-1">Evento</p>
                                    <p class="text-lg text-text-dark font-medium">{{ $equipo->evento->nombre ?? 'Sin evento' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-mono text-primary uppercase mb-1">Fecha de Creación</p>
                                    <p class="text-text-secondary-dark">{{ $equipo->created_at->format('d/m/y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-mono text-primary uppercase mb-1">Miembros</p>
                                    <p class="text-text-secondary-dark">{{ count($equipo->participantes) }} Integrantes</p>
                                </div>
                            </div>
                        </section>

                        @if($equipo->descripcion)
                        <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                            <h3 class="text-xl font-bold text-text-dark mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">description</span> Descripción
                            </h3>
                            <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                                {{ $equipo->descripcion }}
                            </p>
                        </section>
                        @endif
                    </div>

                    <!-- Participantes -->
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                        <h3 class="text-xl font-bold text-text-dark mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">group</span>
                            Miembros del Equipo ({{ count($equipo->participantes) }})
                        </h3>

                        @if(count($equipo->participantes) > 0)
                            <div class="space-y-4">
                                @foreach($equipo->participantes as $participante)
                                <div class="group flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors border border-transparent hover:border-border-dark">
                                    <div class="w-10 h-10 rounded-full bg-border-dark flex items-center justify-center text-primary font-bold text-sm shrink-0 border border-primary/20">
                                        {{ strtoupper(substr($participante->nombre, 0, 2)) }}
                                    </div>

                                    <div class="overflow-hidden flex-1">
                                        <p class="text-sm font-bold text-text-dark truncate">{{ $participante->nombre }}</p>
                                        <p class="text-xs text-text-secondary-dark truncate mb-1 opacity-70">{{ $participante->correo ?? $participante->email ?? 'Sin correo' }}</p>
                                        <span class="inline-block text-[10px] uppercase font-mono tracking-wider text-primary border border-primary/30 px-1.5 rounded">
                                            {{ ucfirst($participante->pivot->posicion ?? 'Miembro') }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-text-secondary-dark">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-30">group_off</span>
                                <p class="text-sm">No hay miembros registrados</p>
                            </div>
                        @endif
                    </section>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script>
        // Script simple para ocultar imágenes rotas sin usar lógica compleja
        document.addEventListener('DOMContentLoaded', function() {
            var images = document.querySelectorAll('img');
            images.forEach(function(img) {
                img.onerror = function() {
                    this.style.display = 'none';
                };
            });
        });
    </script>
</body>
</html>