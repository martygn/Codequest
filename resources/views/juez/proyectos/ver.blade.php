<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ver Proyecto - {{ $repositorio->equipo->nombre_proyecto }} - CodeQuest</title>

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
                    fontFamily: { display: ["Inter", "sans-serif"] },
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
                <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="#">
                    <span class="material-symbols-outlined">visibility</span>
                    <span>Ver Proyecto</span>
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
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10">

            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center gap-2 text-sm">
                    <li><a href="{{ route('juez.panel') }}" class="text-text-secondary-dark hover:text-primary transition-colors">Panel</a></li>
                    <li class="text-text-secondary-dark">/</li>
                    <li class="text-primary">Ver Proyecto</li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8 bg-gradient-to-r from-primary/20 to-primary/5 rounded-2xl p-8 border border-primary/20">
                <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-text-dark mb-3">{{ $repositorio->equipo->nombre_proyecto }}</h1>
                        <p class="text-xl text-text-secondary-dark">Equipo: <strong class="text-primary">{{ $repositorio->equipo->nombre }}</strong></p>
                        <p class="text-text-secondary-dark mt-2">
                            Entregado el {{ $repositorio->enviado_en->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        @if($repositorio->calificacion_total)
                            <div class="text-6xl font-bold text-primary">{{ $repositorio->calificacion_total }}</div>
                            <p class="text-lg text-text-secondary-dark">/100 puntos</p>
                        @else
                            <span class="px-8 py-4 text-2xl font-bold rounded-2xl bg-yellow-500/10 text-yellow-400 border-2 border-yellow-500/30">
                                Sin calificar
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Visor del archivo -->
                <div class="lg:col-span-2">
                    <div class="bg-card-dark rounded-2xl shadow-2xl border border-border-dark overflow-hidden">
                        <div class="bg-gradient-to-r from-primary/10 to-transparent px-6 py-4 border-b border-border-dark flex justify-between items-center">
                            <h3 class="text-xl font-bold flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">description</span>
                                Archivo del Proyecto
                            </h3>
                            <div class="flex gap-3">
                                <a href="{{ Storage::disk('r2')->url($repositorio->archivo_path) }}" target="_blank"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary/10 hover:bg-primary/20 rounded-xl border border-primary/30 text-primary font-bold transition">
                                    <span class="material-symbols-outlined">open_in_new</span>
                                    Abrir en nueva pestaña
                                </a>
                                <a href="{{ route('proyectos.download', $repositorio) }}"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500/10 hover:bg-blue-500/20 rounded-xl border border-blue-500/30 text-blue-400 font-bold transition">
                                    <span class="material-symbols-outlined">download</span>
                                    Descargar
                                </a>
                            </div>
                        </div>

                        <div class="p-6 bg-background-dark/30">
                            @php
                                $extension = strtolower(pathinfo($repositorio->archivo_nombre, PATHINFO_EXTENSION));
                            @endphp

                            @if($extension === 'pdf')
                                <iframe src="{{ Storage::disk('r2')->url($repositorio->archivo_path) }}"
                                        class="w-full h-96 lg:h-screen min-h-96 rounded-xl border border-border-dark shadow-inner"
                                        frameborder="0"></iframe>

                            @elseif(in_array($extension, ['jpg','jpeg','png','gif','webp']))
                                <img src="{{ Storage::disk('r2')->url($repositorio->archivo_path) }}"
                                     alt="{{ $repositorio->archivo_nombre }}"
                                     class="w-full rounded-xl border border-border-dark">

                            @else
                                <div class="text-center py-24">
                                    <span class="material-symbols-outlined text-9xl text-text-secondary-dark opacity-20 mb-6 block">archive</span>
                                    <p class="text-2xl font-bold text-text-dark mb-3">Archivo .{{ $extension }}</p>
                                    <p class="text-text-secondary-dark mb-8">Este tipo de archivo no se puede previsualizar en el navegador</p>
                                    <a href="{{ route('proyectos.download', $repositorio) }}"
                                       class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-background-dark rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-primary/30 transition-all">
                                        <span class="material-symbols-outlined text-3xl">download</span>
                                        Descargar {{ $repositorio->archivo_nombre }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mt-8 bg-card-dark rounded-2xl p-8 border border-border-dark">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">notes</span>
                            Descripción del Proyecto
                        </h3>
                        @if($repositorio->descripcion)
                            <p class="text-text-dark leading-relaxed whitespace-pre-wrap">{{ $repositorio->descripcion }}</p>
                        @else
                            <p class="text-text-secondary-dark italic">El equipo no proporcionó descripción adicional.</p>
                        @endif
                    </div>
                </div>

                <!-- Panel lateral -->
                <div class="space-y-6">

                    <!-- Botón Calificar -->
                    <a href="{{ route('proyecto.juez.calificar-juez', $repositorio) }}"
                       class="block w-full text-center py-6 px-8 rounded-2xl font-bold text-2xl transition-all transform hover:scale-105 shadow-2xl
                              {{ $repositorio->calificacion_total ? 'bg-yellow-600 hover:bg-yellow-700 text-white' : 'bg-primary hover:bg-primary/90 text-background-dark' }}">
                        <span class="material-symbols-outlined text-4xl mb-3 block">rate_review</span>
                        {{ $repositorio->calificacion_total ? 'Editar Calificación' : 'Calificar Proyecto' }}
                    </a>

                    <!-- Info del archivo -->
                    <div class="bg-card-dark rounded-2xl p-6 border border-border-dark">
                        <h4 class="font-bold text-primary mb-4">Información del archivo</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between"><span class="text-text-secondary-dark">Nombre</span><span class="font-medium">{{ $repositorio->archivo_nombre }}</span></div>
                            <div class="flex justify-between"><span class="text-text-secondary-dark">Tamaño</span><span>{{ number_format($repositorio->archivo_tamaño / 1024 / 1024, 2) }} MB</span></div>
                            <div class="flex justify-between"><span class="text-text-secondary-dark">Tipo</span><span class="uppercase font-mono">{{ $extension }}</span></div>
                            <div class="flex justify-between"><span class="text-text-secondary-dark">Subido</span><span>{{ $repositorio->enviado_en->diffForHumans() }}</span></div>
                        </div>
                    </div>

                    <!-- Miembros -->
                    <div class="bg-card-dark rounded-2xl p-6 border border-border-dark">
                        <h4 class="font-bold text-primary mb-4">Miembros del equipo</h4>
                        <div class="space-y-3">
                            @foreach($repositorio->equipo->participantes as $miembro)
                                <div class="flex items-center gap-4 p-4 rounded-xl bg-background-dark/50 border border-border-dark">
                                    <div class="w-12 h-12 rounded-full bg-primary/20 border-2 border-primary/40 flex items-center justify-center text-primary font-bold text-lg">
                                        {{ substr($miembro->nombre, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $miembro->nombre }}</p>
                                        <p class="text-xs text-text-secondary-dark">{{ $miembro->correo }}</p>
                                    </div>
                                    @if($miembro->id == $repositorio->equipo->id_lider)
                                        <span class="px-3 py-1 text-xs font-bold bg-primary/20 text-primary rounded-lg">Líder</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('juez.panel') }}"
                       class="w-full text-center py-4 px-6 rounded-xl bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition-all font-medium">
                        <span class="material-symbols-outlined mr-2">arrow_back</span>
                        Volver al panel
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>