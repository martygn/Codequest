<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Ver Proyecto - CodeQuest</title>

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
                    <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.constancias') }}">
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

                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center gap-2 text-sm">
                        <li><a href="{{ route('juez.panel') }}" class="text-text-secondary-dark hover:text-primary transition-colors">Panel</a></li>
                        <li class="text-text-secondary-dark">/</li>
                        <li><a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}" class="text-text-secondary-dark hover:text-primary transition-colors">Proyectos</a></li>
                        <li class="text-text-secondary-dark">/</li>
                        <li class="text-primary">Ver Proyecto</li>
                    </ol>
                </nav>

                <!-- Header -->
                <div class="mb-8 bg-card-dark rounded-xl shadow-lg border border-border-dark p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-text-dark">{{ $repositorio->equipo->nombre_proyecto }}</h1>
                            <p class="text-text-secondary-dark mt-2">Equipo: {{ $repositorio->equipo->nombre }}</p>
                        </div>
                        <div>
                            @if($repositorio->calificacion_total)
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-lg font-bold bg-primary/10 text-primary border border-primary/30">
                                    {{ $repositorio->calificacion_total }}/100
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-lg font-bold bg-yellow-500/10 text-yellow-400 border border-yellow-500/30">
                                    Sin calificar
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Información principal -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Archivo del proyecto -->
                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                            <div class="px-6 py-4 border-b border-border-dark">
                                <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">folder</span>
                                    Archivo del Proyecto
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="text-center p-8 border border-border-dark rounded-xl bg-background-dark">
                                    @php
                                        $extension = pathinfo($repositorio->archivo_nombre, PATHINFO_EXTENSION);
                                        $iconColor = $extension === 'pdf' ? 'text-red-400' :
                                                    ($extension === 'zip' ? 'text-yellow-400' : 'text-blue-400');
                                        $icon = $extension === 'pdf' ? 'picture_as_pdf' :
                                               ($extension === 'zip' ? 'folder_zip' : 'description');
                                    @endphp
                                    <span class="material-symbols-outlined text-6xl {{ $iconColor }} mb-4 block">{{ $icon }}</span>
                                    <h4 class="text-xl font-bold text-text-dark mb-2">{{ $repositorio->archivo_nombre }}</h4>
                                    <div class="flex items-center justify-center gap-6 text-sm text-text-secondary-dark mb-4">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-base">storage</span>
                                            <span>{{ number_format($repositorio->archivo_tamaño / 1024, 1) }} KB</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-base">schedule</span>
                                            <span>{{ $repositorio->enviado_en->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ Storage::url($repositorio->archivo_path) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg bg-primary text-background-dark hover:bg-primary/90 transition-all shadow-lg">
                                            <span class="material-symbols-outlined text-sm mr-2">visibility</span>
                                            Ver Archivo
                                        </a>
                                        <a href="{{ route('proyectos.download', $repositorio) }}"
                                           class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-lg bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition-all">
                                            <span class="material-symbols-outlined text-sm mr-2">download</span>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                            <div class="px-6 py-4 border-b border-border-dark">
                                <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">description</span>
                                    Descripción del Proyecto
                                </h3>
                            </div>
                            <div class="p-6">
                                @if($repositorio->descripcion)
                                    <p class="text-text-secondary-dark">{{ $repositorio->descripcion }}</p>
                                @else
                                    <p class="text-text-secondary-dark italic">El equipo no proporcionó una descripción adicional.</p>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Información lateral -->
                    <div class="lg:col-span-1 space-y-6">

                        <!-- Información del equipo -->
                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                            <div class="px-6 py-4 border-b border-border-dark">
                                <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">group</span>
                                    Equipo
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="mb-4">
                                    <h4 class="text-xs font-mono text-primary uppercase mb-2">Nombre del equipo</h4>
                                    <p class="text-text-dark font-medium">{{ $repositorio->equipo->nombre }}</p>
                                </div>

                                <div>
                                    <h4 class="text-xs font-mono text-primary uppercase mb-3">Integrantes</h4>
                                    <div class="space-y-2">
                                        @foreach($repositorio->equipo->participantes as $miembro)
                                        <div class="flex items-center gap-3 p-3 rounded-lg bg-background-dark border border-border-dark">
                                            <div class="h-10 w-10 rounded-full bg-border-dark border border-primary/20 flex items-center justify-center text-primary font-bold">
                                                {{ substr($miembro->nombre, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-text-dark">{{ $miembro->nombre }}</p>
                                                <p class="text-xs text-text-secondary-dark">{{ $miembro->correo }}</p>
                                            </div>
                                            @if($miembro->id == $repositorio->equipo->id_lider)
                                                <span class="px-2 py-1 text-xs font-bold rounded-lg bg-yellow-500/10 text-yellow-400 border border-yellow-500/30">Líder</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                            <div class="px-6 py-4 border-b border-border-dark">
                                <h3 class="text-lg font-bold text-text-dark flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">settings</span>
                                    Acciones
                                </h3>
                            </div>
                            <div class="p-6 space-y-3">
                                <a href="{{ route('proyecto.juez.calificar-juez', $repositorio) }}"
                                   class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-bold rounded-lg bg-primary text-background-dark hover:bg-primary/90 transition-all shadow-lg">
                                    <span class="material-symbols-outlined text-sm mr-2">star</span>
                                    {{ $repositorio->calificacion_total ? 'Editar Calificación' : 'Calificar Proyecto' }}
                                </a>
                                <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}"
                                   class="w-full inline-flex items-center justify-center px-4 py-3 text-sm font-bold rounded-lg bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition-all">
                                    <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
                                    Volver a la lista
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </main>
    </div>

</body>
</html>