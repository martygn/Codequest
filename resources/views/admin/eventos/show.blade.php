<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $evento->nombre }} - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#64FFDA",
                        "background-dark": "#0A192F",
                        "card-dark": "#112240",
                        "text-dark": "#CCD6F6",
                        "text-secondary-dark": "#8892B0",
                        "border-dark": "#233554",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="font-display bg-background-dark text-text-dark">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between shadow-xl z-20">
            <div>
                <h1 class="text-2xl font-bold text-primary mb-8">CodeQuest</h1>
                <nav class="space-y-2">
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-primary bg-primary/10 rounded-lg font-semibold shadow-sm" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">emoji_events</span>
                        <span>Resultados</span>
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

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <a href="{{ route('admin.eventos') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 transition-colors mb-6">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        <span class="font-semibold">Volver a Eventos</span>
                    </a>

                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-text-dark mb-4">{{ $evento->nombre }}</h1>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg
                                    {{ $evento->estado === 'publicado' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' }}">
                                    <span class="material-symbols-outlined text-base mr-2">
                                        {{ $evento->estado === 'publicado' ? 'check_circle' : 'pending' }}
                                    </span>
                                    {{ ucfirst($evento->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Image -->
                @if($evento->foto)
                <div class="mb-8 rounded-xl overflow-hidden shadow-2xl border border-border-dark">
                    <img src="{{ Storage::url($evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-96 object-cover">
                </div>
                @endif

                <div class="space-y-6">
                    <!-- Descripción -->
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 hover:border-primary/30 transition-all">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-2xl">description</span>
                            <h3 class="text-xl font-bold text-text-dark">Descripción</h3>
                        </div>
                        <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line pl-9">
                            {{ $evento->descripcion ?? 'Sin descripción disponible' }}
                        </p>
                    </section>

                    <!-- Reglas -->
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 hover:border-primary/30 transition-all">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-2xl">rule</span>
                            <h3 class="text-xl font-bold text-text-dark">Reglas</h3>
                        </div>
                        <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line pl-9">
                            {{ $evento->reglas ?? 'Sin reglas especificadas' }}
                        </p>
                    </section>

                    <!-- Premios -->
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 hover:border-primary/30 transition-all">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-2xl">emoji_events</span>
                            <h3 class="text-xl font-bold text-text-dark">Premios</h3>
                        </div>
                        <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line pl-9">
                            {{ $evento->premios ?? 'Sin premios especificados' }}
                        </p>
                    </section>

                    <!-- Otra Información -->
                    @if($evento->otra_informacion)
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 hover:border-primary/30 transition-all">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-2xl">info</span>
                            <h3 class="text-xl font-bold text-text-dark">Información Adicional</h3>
                        </div>
                        <p class="text-text-secondary-dark leading-relaxed whitespace-pre-line pl-9">
                            {{ $evento->otra_informacion }}
                        </p>
                    </section>
                    @endif

                    <!-- Fechas Importantes -->
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 hover:border-primary/30 transition-all">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-primary text-2xl">schedule</span>
                            <h3 class="text-xl font-bold text-text-dark">Fechas Importantes</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-9">
                            <div class="bg-background-dark rounded-lg p-4 border border-border-dark">
                                <p class="text-xs font-bold text-text-secondary-dark uppercase tracking-wide mb-2 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-green-400">play_circle</span>
                                    Inicio del Evento
                                </p>
                                <p class="text-text-dark font-semibold text-lg">
                                    {{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                                </p>
                            </div>
                            <div class="bg-background-dark rounded-lg p-4 border border-border-dark">
                                <p class="text-xs font-bold text-text-secondary-dark uppercase tracking-wide mb-2 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-red-400">stop_circle</span>
                                    Fin del Evento
                                </p>
                                <p class="text-text-dark font-semibold text-lg">
                                    {{ \Carbon\Carbon::parse($evento->fecha_fin)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Equipos Participantes -->
                    <section class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-6 hover:border-primary/30 transition-all">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-2xl">groups</span>
                                <h3 class="text-xl font-bold text-text-dark">Equipos Participantes</h3>
                            </div>
                            <span class="px-4 py-2 bg-primary/20 text-primary rounded-lg font-bold border border-primary/30">
                                {{ count($evento->equipos) }} equipos
                            </span>
                        </div>

                        @if(count($evento->equipos) > 0)
                            <div class="overflow-x-auto rounded-lg border border-border-dark">
                                <table class="w-full">
                                    <thead class="bg-background-dark">
                                        <tr>
                                            <th class="text-left p-4 text-xs font-bold text-text-secondary-dark uppercase tracking-wider">
                                                <span class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">badge</span>
                                                    Nombre del Equipo
                                                </span>
                                            </th>
                                            <th class="text-left p-4 text-xs font-bold text-text-secondary-dark uppercase tracking-wider">
                                                <span class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">folder</span>
                                                    Proyecto
                                                </span>
                                            </th>
                                            <th class="text-left p-4 text-xs font-bold text-text-secondary-dark uppercase tracking-wider">
                                                <span class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">group</span>
                                                    Miembros
                                                </span>
                                            </th>
                                            <th class="text-left p-4 text-xs font-bold text-text-secondary-dark uppercase tracking-wider">
                                                <span class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm"></span>
                                                    Estado
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border-dark">
                                        @foreach($evento->equipos as $equipo)
                                        <tr class="hover:bg-background-dark/50 transition-colors">
                                            <td class="p-4 text-text-dark font-semibold">{{ $equipo->nombre }}</td>
                                            <td class="p-4 text-text-secondary-dark">{{ $equipo->nombre_proyecto }}</td>
                                            <td class="p-4 text-text-secondary-dark">
                                                <span class="inline-flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-sm">person</span>
                                                    {{ count($equipo->participantes) }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded-lg
                                                    {{ $equipo->estado === 'aprobado' ? 'bg-green-500/20 text-green-400 border border-green-500/30' :
                                                       ($equipo->estado === 'rechazado' ? 'bg-red-500/20 text-red-400 border border-red-500/30' :
                                                       'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30') }}">
                                                    <span class="material-symbols-outlined text-sm">
                                                        {{ $equipo->estado === 'aprobado' ? 'check_circle' :
                                                           ($equipo->estado === 'rechazado' ? 'cancel' : 'pending') }}
                                                    </span>
                                                    {{ ucfirst($equipo->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12 bg-background-dark rounded-lg border border-border-dark">
                                <span class="material-symbols-outlined text-6xl text-text-secondary-dark mb-4 block opacity-50">group_off</span>
                                <p class="text-text-secondary-dark text-lg">No hay equipos participantes en este evento</p>
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
