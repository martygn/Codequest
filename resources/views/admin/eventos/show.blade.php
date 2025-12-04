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
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
                <nav class="mt-8 space-y-2">
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined filled">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-4xl">
                <div class="mb-8">
                    <a href="{{ route('admin.eventos') }}" class="text-primary hover:underline flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Volver a Eventos
                    </a>
                    <h1 class="text-4xl font-bold text-slate-900 dark:text-white mt-4">{{ $evento->nombre }}</h1>
                    <div class="mt-4 flex items-center gap-4">
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full 
                            {{ $evento->estado === 'publicado' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' }}">
                            {{ ucfirst($evento->estado) }}
                        </span>
                    </div>
                </div>

                @if($evento->foto)
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-96 object-cover">
                </div>
                @endif

                <div class="space-y-8">
                    <!-- Descripción -->
                    <section class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Descripción</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                            {{ $evento->descripcion ?? 'Sin descripción disponible' }}
                        </p>
                    </section>

                    <!-- Reglas -->
                    <section class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Reglas</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                            {{ $evento->reglas ?? 'Sin reglas especificadas' }}
                        </p>
                    </section>

                    <!-- Premios -->
                    <section class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Premios</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                            {{ $evento->premios ?? 'Sin premios especificados' }}
                        </p>
                    </section>

                    <!-- Otra Información -->
                    @if($evento->otra_informacion)
                    <section class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Información Adicional</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                            {{ $evento->otra_informacion }}
                        </p>
                    </section>
                    @endif

                    <!-- Fechas Importantes -->
                    <section class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Fechas Importantes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Inicio del Evento</p>
                                <p class="text-slate-900 dark:text-white font-semibold text-lg">
                                    {{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Fin del Evento</p>
                                <p class="text-slate-900 dark:text-white font-semibold text-lg">
                                    {{ \Carbon\Carbon::parse($evento->fecha_fin)->translatedFormat('d \d\e F \d\e Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Equipos Participantes -->
                    <section class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Equipos Participantes ({{ count($evento->equipos) }})</h3>
                        
                        @if(count($evento->equipos) > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="border-b border-slate-200 dark:border-slate-700">
                                        <tr>
                                            <th class="text-left p-3 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Nombre del Equipo</th>
                                            <th class="text-left p-3 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Proyecto</th>
                                            <th class="text-left p-3 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Miembros</th>
                                            <th class="text-left p-3 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($evento->equipos as $equipo)
                                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                            <td class="p-3 text-slate-900 dark:text-white font-semibold">{{ $equipo->nombre }}</td>
                                            <td class="p-3 text-slate-600 dark:text-slate-400">{{ $equipo->nombre_proyecto }}</td>
                                            <td class="p-3 text-slate-600 dark:text-slate-400">{{ count($equipo->participantes) }}</td>
                                            <td class="p-3">
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                                    {{ $equipo->estado === 'aprobado' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                                       ($equipo->estado === 'rechazado' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 
                                                       'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200') }}">
                                                    {{ ucfirst($equipo->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-slate-500 dark:text-slate-400 text-center py-8">No hay equipos participantes en este evento</p>
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
