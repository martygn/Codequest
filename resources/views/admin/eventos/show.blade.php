<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $evento->nombre }} - Panel Admin</title>
    
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

        <div class="relative z-10 max-w-5xl mx-auto">
            
            <div class="mb-8">
                <a href="{{ route('admin.eventos') }}" class="text-primary hover:text-white flex items-center gap-2 mb-4 transition-colors w-fit group text-sm font-medium">
                    <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Volver a Eventos
                </a>
                <h1 class="text-4xl font-bold text-text-dark mt-4">{{ $evento->nombre }}</h1>
                <div class="mt-4 flex items-center gap-4">
                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full
                        {{ $evento->estado === 'publicado' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' }}">
                        {{ ucfirst($evento->estado) }}
                    </span>
                </div>
            </div>

            @if($evento->foto)
            <div class="mb-10 rounded-xl overflow-hidden shadow-lg border border-border-dark h-64 md:h-80 relative group">
                <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent opacity-60"></div>
                <img src="{{ Storage::url($evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            </div>
            @endif

            <div class="space-y-8">
                <!-- Descripción -->
                <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                    <h3 class="text-xl font-bold text-text-dark mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">description</span> Descripción
                    </h3>
                    <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                        {{ $evento->descripcion ?? 'Sin descripción disponible' }}
                    </p>
                </section>

                <!-- Reglas -->
                <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                    <h3 class="text-xl font-bold text-text-dark mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">rule</span> Reglas
                    </h3>
                    <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                        {{ $evento->reglas ?? 'Sin reglas especificadas' }}
                    </p>
                </section>

                <!-- Premios -->
                <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                    <h3 class="text-xl font-bold text-text-dark mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">emoji_events</span> Premios
                    </h3>
                    <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                        {{ $evento->premios ?? 'Sin premios especificados' }}
                    </p>
                </section>

                <!-- Otra Información -->
                @if($evento->otra_informacion)
                <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                    <h3 class="text-xl font-bold text-text-dark mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span> Información Adicional
                    </h3>
                    <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                        {{ $evento->otra_informacion }}
                    </p>
                </section>
                @endif

                <!-- Fechas Importantes -->
                <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                    <h3 class="text-xl font-bold text-text-dark mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">schedule</span> Fechas Importantes
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-mono text-primary uppercase mb-1 tracking-wide">Inicio del Evento</p>
                            <p class="text-text-dark font-semibold text-lg">
                                {{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-mono text-primary uppercase mb-1 tracking-wide">Fin del Evento</p>
                            <p class="text-text-dark font-semibold text-lg">
                                {{ \Carbon\Carbon::parse($evento->fecha_fin)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Equipos Participantes -->
                <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 md:p-8">
                    <h3 class="text-xl font-bold text-text-dark mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">groups</span> Equipos Participantes ({{ count($evento->equipos) }})
                    </h3>
                    
                    @if(count($evento->equipos) > 0)
                        <div class="overflow-x-auto rounded-lg border border-border-dark">
                            <table class="w-full">
                                <thead class="bg-[#0D1B2A] border-b border-border-dark">
                                    <tr>
                                        <th class="text-left p-4 text-xs font-mono text-primary uppercase tracking-wider">Nombre del Equipo</th>
                                        <th class="text-left p-4 text-xs font-mono text-primary uppercase tracking-wider">Proyecto</th>
                                        <th class="text-left p-4 text-xs font-mono text-primary uppercase tracking-wider">Miembros</th>
                                        <th class="text-left p-4 text-xs font-mono text-primary uppercase tracking-wider">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-dark">
                                    @foreach($evento->equipos as $equipo)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="p-4 text-text-dark font-semibold">{{ $equipo->nombre }}</td>
                                        <td class="p-4 text-text-secondary-dark">{{ $equipo->nombre_proyecto }}</td>
                                        <td class="p-4 text-text-secondary-dark">{{ count($equipo->participantes) }}</td>
                                        <td class="p-4">
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full border
                                                {{ $equipo->estado === 'aprobado' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                                                   ($equipo->estado === 'rechazado' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 
                                                   'bg-yellow-500/10 text-yellow-400 border-yellow-500/20') }}">
                                                {{ ucfirst($equipo->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12">
                            <span class="material-symbols-outlined text-5xl text-text-secondary-dark mb-3 opacity-50">people_outline</span>
                            <p class="text-text-secondary-dark">No hay equipos participantes en este evento</p>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </main>
</div>

<script>
    if (document.readyElement === undefined) {
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                });
            });
        });
    }
</script>
</body>
</html>
