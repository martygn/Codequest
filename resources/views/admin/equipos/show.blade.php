<!DOCTYPE html>
<html lang="es">
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
                        primary: "#2998FF",
                        "background-light": "#F8FAFC",
                        "background-dark": "#18181B",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">CodeQuest</h1>
                <nav class="mt-8 space-y-2">
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 rounded font-semibold" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('admin.jueces') }}">
<span class="material-symbols-outlined text-xl">gavel</span>
<span class="font-medium">Jueces</span>
</a>

                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <span>Resultados</span>
                        </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-white dark:bg-zinc-900 p-8">
            <div class="max-w-4xl">
                <div class="mb-8">
                    <a href="{{ route('admin.equipos') }}" class="text-primary hover:underline flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
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
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg h-96">
                    <img src="{{ Storage::url($equipo->banner) }}" alt="{{ $equipo->nombre }}" class="w-full h-full object-cover">
                </div>
                @endif

                <div class="space-y-8">
                    <!-- Información General -->
                    <section class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Información General</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Nombre del Proyecto</p>
                                <p class="text-gray-900 dark:text-white font-semibold">{{ $equipo->nombre_proyecto }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Evento</p>
                                <p class="text-gray-900 dark:text-white font-semibold">{{ $equipo->evento->nombre ?? 'Sin evento' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Fecha de Creación</p>
                                <p class="text-gray-900 dark:text-white font-semibold">{{ $equipo->created_at->translatedFormat('d \d\e F \d\e Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Número de Miembros</p>
                                <p class="text-gray-900 dark:text-white font-semibold">{{ count($equipo->participantes) }}</p>
                            </div>
                        </div>
                    </section>

                    <!-- Descripción -->
                    @if($equipo->descripcion)
                    <section class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Descripción</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">
                            {{ $equipo->descripcion }}
                        </p>
                    </section>
                    @endif

                    <!-- Participantes -->
                    <section class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Miembros del Equipo ({{ count($equipo->participantes) }})</h3>

                        @if(count($equipo->participantes) > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="border-b border-gray-200 dark:border-zinc-700">
                                        <tr>
                                            <th class="text-left p-3 text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Nombre</th>
                                            <th class="text-left p-3 text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Email</th>
                                            <th class="text-left p-3 text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Posición</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($equipo->participantes as $participante)
                                        <tr class="border-b border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition">
                                            <td class="p-3 text-gray-900 dark:text-white font-semibold">{{ $participante->nombre }}</td>
                                            <td class="p-3 text-gray-600 dark:text-gray-400">{{ $participante->email }}</td>
                                            <td class="p-3 text-gray-600 dark:text-gray-400">{{ ucfirst($participante->pivot->posicion) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">No hay miembros en este equipo</p>
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
