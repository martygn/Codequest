<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $evento->nombre }} - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#64FFDA",
                        "background-dark": "#0A192F",
                        "card-dark": "#112240",
                        "text-dark": "#CCD6F6",
                        "text-secondary-dark": "#8892B0",
                        "border-dark": "#233554",
                        "active-dark": "rgba(100, 255, 218, 0.1)",
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
                    <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-12 w-auto">
                    <h1 class="text-xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
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
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="pt-6 border-t border-border-dark">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 overflow-y-auto bg-background-dark p-8 relative">

            <!-- Efecto de fondo -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-5xl mx-auto relative z-10">

                <!-- Header con botón de regreso -->
                <div class="mb-8">
                    <a href="{{ route('admin.eventos') }}" class="inline-flex items-center gap-2 text-primary hover:text-[#52d6b3] font-medium transition-colors mb-4">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Volver a Eventos
                    </a>
                    <div class="flex items-center justify-between">
                        <h1 class="text-4xl font-bold text-text-dark">{{ $evento->nombre }}</h1>
                        <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-xl 
                            {{ $evento->estado === 'publicado' ? 'bg-green-500/10 text-green-400 border border-green-500/30' : 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30' }}">
                            {{ ucfirst($evento->estado) }}
                        </span>
                    </div>
                </div>

                <!-- Foto del evento -->
                @if($evento->foto)
                <div class="mb-8 rounded-xl overflow-hidden shadow-2xl border border-border-dark">
                    <img src="{{ Storage::url($evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-96 object-cover">
                </div>
                @endif

                <div class="space-y-8">
                    <!-- Descripción -->
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                        <div class="px-8 py-6 border-b border-border-dark">
                            <h3 class="text-xl font-bold text-text-dark flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">description</span>
                                Descripción
                            </h3>
                        </div>
                        <div class="px-8 py-6">
                            <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                                {{ $evento->descripcion ?? 'Sin descripción disponible' }}
                            </p>
                        </div>
                    </div>

                    <!-- Reglas -->
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                        <div class="px-8 py-6 border-b border-border-dark">
                            <h3 class="text-xl font-bold text-text-dark flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">gavel</span>
                                Reglas
                            </h3>
                        </div>
                        <div class="px-8 py-6">
                            <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                                {{ $evento->reglas ?? 'Sin reglas especificadas' }}
                            </p>
                        </div>
                    </div>

                    <!-- Premios -->
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                        <div class="px-8 py-6 border-b border-border-dark">
                            <h3 class="text-xl font-bold text-text-dark flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">emoji_events</span>
                                Premios
                            </h3>
                        </div>
                        <div class="px-8 py-6">
                            <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                                {{ $evento->premios ?? 'Sin premios especificados' }}
                            </p>
                        </div>
                    </div>

                    <!-- Otra Información -->
                    @if($evento->otra_informacion)
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                        <div class="px-8 py-6 border-b border-border-dark">
                            <h3 class="text-xl font-bold text-text-dark flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">info</span>
                                Información Adicional
                            </h3>
                        </div>
                        <div class="px-8 py-6">
                            <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line">
                                {{ $evento->otra_informacion }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Fechas Importantes -->
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                        <div class="px-8 py-6 border-b border-border-dark">
                            <h3 class="text-xl font-bold text-text-dark flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">schedule</span>
                                Fechas Importantes
                            </h3>
                        </div>
                        <div class="px-8 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <p class="text-xs font-bold text-text-secondary-dark uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-lg">play_circle</span>
                                        Inicio del Evento
                                    </p>
                                    <p class="text-text-dark font-semibold text-lg">
                                        {{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-text-secondary-dark uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-lg">stop_circle</span>
                                        Fin del Evento
                                    </p>
                                    <p class="text-text-dark font-semibold text-lg">
                                        {{ \Carbon\Carbon::parse($evento->fecha_fin)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipos Participantes -->
                    <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                        <div class="px-8 py-6 border-b border-border-dark">
                            <h3 class="text-xl font-bold text-text-dark flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">group</span>
                                Equipos Participantes <span class="text-text-secondary-dark text-lg font-normal">({{ count($evento->equipos) }})</span>
                            </h3>
                        </div>
                        <div class="px-8 py-6">
                            @if(count($evento->equipos) > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-border-dark">
                                                <th class="text-left px-4 py-3 text-xs font-bold text-primary uppercase tracking-wider">Nombre del Equipo</th>
                                                <th class="text-left px-4 py-3 text-xs font-bold text-primary uppercase tracking-wider">Proyecto</th>
                                                <th class="text-left px-4 py-3 text-xs font-bold text-primary uppercase tracking-wider">Miembros</th>
                                                <th class="text-left px-4 py-3 text-xs font-bold text-primary uppercase tracking-wider">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border-dark">
                                            @foreach($evento->equipos as $equipo)
                                            <tr class="hover:bg-active-dark transition-colors">
                                                <td class="px-4 py-4 text-text-dark font-semibold">{{ $equipo->nombre }}</td>
                                                <td class="px-4 py-4 text-text-secondary-dark">{{ $equipo->nombre_proyecto }}</td>
                                                <td class="px-4 py-4 text-text-secondary-dark text-center">{{ count($equipo->participantes) }}/4</td>
                                                <td class="px-4 py-4">
                                                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-lg
                                                        {{ $equipo->estado === 'aprobado' ? 'bg-green-500/10 text-green-400 border border-green-500/30' : 
                                                           ($equipo->estado === 'rechazado' ? 'bg-red-500/10 text-red-400 border border-red-500/30' : 
                                                           'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30') }}">
                                                        {{ ucfirst($equipo->estado) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <span class="material-symbols-outlined text-6xl text-text-secondary-dark opacity-30 block mb-4">group</span>
                                    <p class="text-text-secondary-dark">No hay equipos participantes en este evento</p>
                                </div>
                            @endif
                        </div>
                    </div>
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

