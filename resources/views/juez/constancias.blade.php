<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Historial de Constancias - CodeQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#64FFDA",
                        "card-dark": "#112240",
                        "text-dark": "#CCD6F6",
                        "text-secondary-dark": "#8892B0",
                        "border-dark": "#233554",
                        "active-dark": "rgba(100, 255, 218, 0.1)",
                        "background-dark": "#0A192F",
                        "background-dark": "#0A192F",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between">
        <div>
            <h1 class="text-2xl font-bold text-text-dark">CodeQuest</h1>
            <nav class="mt-8 space-y-2">
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('juez.panel') ? 'text-text-dark bg-slate-100 dark:bg-slate-800 rounded font-semibold' : 'text-text-secondary-dark rounded hover:bg-border-dark hover:text-primary transition-colors' }}" href="{{ route('juez.panel') }}">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <span>Evento Asignado</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('juez.constancias') ? 'text-text-dark bg-slate-100 dark:bg-slate-800 rounded font-semibold' : 'text-text-secondary-dark rounded hover:bg-border-dark hover:text-primary transition-colors' }}" href="{{ route('juez.constancias') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Historial de Constancias</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('juez.configuracion') ? 'text-text-dark bg-slate-100 dark:bg-slate-800 rounded font-semibold' : 'text-text-secondary-dark rounded hover:bg-border-dark hover:text-primary transition-colors' }}" href="{{ route('juez.configuracion') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Configuración</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:bg-border-dark hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-7xl mx-auto">
            <header class="mb-8">
                <h2 class="text-4xl font-bold text-text-dark">Historial de Constancias</h2>
                <p class="text-text-secondary-dark mt-1">Descarga y revisa todas las constancias generadas</p>
            </header>

            <div class="bg-card-dark rounded-lg shadow-sm border border-border-dark">
                <div class="p-6 border-b border-border-dark">
                    <h3 class="text-2xl font-semibold text-text-dark">Constancias</h3>
                    <p class="text-text-secondary-dark mt-1">Total: {{ count($constancias) }} constancia(s)</p>
                </div>

                @if(count($constancias) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-b border-border-dark bg-slate-50 dark:bg-slate-800/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-text-secondary-dark">Evento</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-text-secondary-dark">Equipo Ganador</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-text-secondary-dark">Fecha</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-text-secondary-dark">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Las constancias se cargarán aquí cuando se implemente la BD --}}
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-700 mx-auto block mb-4">description</span>
                        <p class="text-text-secondary-dark text-lg">No hay constancias generadas aún.</p>
                        <p class="text-slate-400 dark:text-slate-500 mt-1">Las constancias aparecerán aquí una vez que selecciones un equipo ganador.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>

</body>
</html>
