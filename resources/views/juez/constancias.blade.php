<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Historial de Constancias - CodeQuest</title>

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

        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between shadow-xl z-20">
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
                    <div>
                        <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
                        <p class="text-xs text-text-secondary-dark mt-1">Panel del Juez</p>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Constancias</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.configuracion') }}">
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

            <div class="max-w-7xl mx-auto relative z-10">

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-text-dark">Historial de Constancias</h1>
                    <p class="text-text-secondary-dark mt-2">Descarga y revisa todas las constancias generadas</p>
                </div>

                <!-- Constancias Card -->
                <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                    <div class="px-6 py-4 border-b border-border-dark">
                        <h3 class="text-lg font-bold text-text-dark">Historial de Constancias Enviadas</h3>
                        <p class="text-sm text-text-secondary-dark">Total: {{ count($constancias) }} constancia(s)</p>
                    </div>

                    @if(count($constancias) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-background-dark">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Evento</th>
                                        <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Equipo Ganador</th>
                                        <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Líder del Equipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Fecha de Envío</th>
                                        <th class="px-6 py-3 text-left text-xs font-mono text-primary uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-dark">
                                    @foreach($constancias as $constancia)
                                    <tr class="hover:bg-active-dark transition-colors">
                                        <td class="px-6 py-4 text-sm text-text-dark">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary text-lg">event</span>
                                                {{ $constancia->evento->nombre }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-text-dark">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary text-lg">groups</span>
                                                {{ $constancia->equipo->nombre }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-text-secondary-dark">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary text-lg">person</span>
                                                {{ $constancia->equipo->lider->nombre_completo ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-text-secondary-dark">
                                            {{ $constancia->fecha_envio->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($constancia->ruta_pdf)
                                                <a href="{{ route('juez.constancia.descargar', $constancia) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary rounded-lg text-primary hover:bg-primary/20 transition-colors font-medium">
                                                    <span class="material-symbols-outlined text-lg">download</span>
                                                    Descargar
                                                </a>
                                            @else
                                                <span class="text-text-secondary-dark text-xs">No disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <span class="material-symbols-outlined text-6xl text-text-secondary-dark opacity-30 mb-4 block">description</span>
                            <h3 class="text-lg font-medium text-text-dark mb-2">No hay constancias generadas aún</h3>
                            <p class="text-text-secondary-dark">Las constancias aparecerán aquí una vez que selecciones un equipo ganador.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>
