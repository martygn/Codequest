<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Proyecto - {{ $repositorio->equipo->nombre_proyecto }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#64FFDA", // Turquesa
                        "background-dark": "#0A192F",
                        "card-dark": "#112240",
                        "text-main": "#CCD6F6",
                        "text-muted": "#8892B0",
                        "border-dark": "#233554",
                    },
                    fontFamily: {
                        display: ["Roboto", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0A192F; }
        ::-webkit-scrollbar-thumb { background: #233554; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64FFDA; }
    </style>
</head>
<body class="font-display bg-background-dark text-text-main antialiased min-h-screen flex flex-col">

    <nav class="bg-card-dark border-b border-border-dark py-4 px-6 shadow-lg z-20 sticky top-0">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                    <span class="material-symbols-outlined">rate_review</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">Evaluación de Proyecto</span>
            </div>
            <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}" class="text-text-muted hover:text-primary transition-colors text-sm flex items-center gap-1 font-medium">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Volver a la lista
            </a>
        </div>
    </nav>

    <main class="flex-1 p-6 md:p-10 relative">
        
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 text-sm font-mono text-text-muted">
                <span class="text-primary">Panel Juez</span>
                <span class="mx-2">/</span>
                <span>Proyectos</span>
                <span class="mx-2">/</span>
                <span class="text-white font-bold">{{ $repositorio->equipo->nombre_proyecto }}</span>
            </div>

            <div class="bg-gradient-to-r from-[#112240] to-[#0D1B2A] rounded-2xl p-8 border border-border-dark shadow-2xl mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $repositorio->equipo->nombre_proyecto }}</h1>
                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary border border-primary/20 text-xs font-bold uppercase tracking-wider">
                                {{ $repositorio->equipo->nombre }}
                            </span>
                        </div>
                        <p class="text-text-muted flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-base">event</span>
                            Evento: {{ $repositorio->equipo->evento->nombre ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-xs text-text-muted uppercase tracking-wider mb-1">Calificación Actual</p>
                            @if($repositorio->calificacion_total)
                                <span class="text-3xl font-bold text-primary font-mono">{{ $repositorio->calificacion_total }}/100</span>
                            @else
                                <span class="text-xl font-bold text-yellow-400 font-mono">Sin Calificar</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">

                    <div class="bg-card-dark rounded-xl border border-border-dark overflow-hidden shadow-lg">
                        <div class="px-6 py-4 border-b border-border-dark bg-[#0D1B2A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">folder_zip</span>
                            <h3 class="font-bold text-white">Entregable</h3>
                        </div>
                        <div class="p-8">
                            <div class="border-2 border-dashed border-border-dark rounded-xl p-8 text-center bg-background-dark/50 hover:bg-background-dark hover:border-primary/50 transition-all group">
                                @php
                                    $extension = pathinfo($repositorio->archivo_nombre, PATHINFO_EXTENSION);
                                    $icon = match($extension) {
                                        'pdf' => 'picture_as_pdf',
                                        'zip', 'rar' => 'folder_zip',
                                        default => 'description'
                                    };
                                    $iconColor = match($extension) {
                                        'pdf' => 'text-red-400',
                                        'zip', 'rar' => 'text-yellow-400',
                                        default => 'text-blue-400'
                                    };
                                @endphp
                                
                                <span class="material-symbols-outlined text-6xl mb-4 {{ $iconColor }} group-hover:scale-110 transition-transform">{{ $icon }}</span>
                                
                                <h4 class="text-lg font-bold text-white mb-2">{{ $repositorio->archivo_nombre }}</h4>
                                
                                <div class="text-sm text-text-muted mb-6 flex justify-center gap-4">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">hard_drive</span> {{ number_format($repositorio->archivo_tamaño / 1024, 1) }} KB</span>
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-base">calendar_today</span> {{ $repositorio->enviado_en->format('d/m/Y H:i') }}</span>
                                </div>

                                <div class="flex justify-center gap-4">
                                    <a href="{{ Storage::url($repositorio->archivo_path) }}" target="_blank"
                                       class="px-6 py-2.5 bg-primary/10 text-primary border border-primary/30 rounded-lg font-bold hover:bg-primary hover:text-background-dark transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined">visibility</span> Ver Archivo
                                    </a>
                                    <a href="{{ route('proyectos.download', $repositorio) }}"
                                       class="px-6 py-2.5 bg-background-dark text-text-main border border-border-dark rounded-lg font-bold hover:bg-white/5 hover:text-white transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined">download</span> Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-card-dark rounded-xl border border-border-dark overflow-hidden shadow-lg">
                        <div class="px-6 py-4 border-b border-border-dark bg-[#0D1B2A] flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">description</span>
                            <h3 class="font-bold text-white">Descripción del Proyecto</h3>
                        </div>
                        <div class="p-6">
                            @if($repositorio->descripcion)
                                <p class="text-text-muted leading-relaxed whitespace-pre-line">{{ $repositorio->descripcion }}</p>
                            @else
                                <p class="text-text-muted/50 italic flex items-center gap-2">
                                    <span class="material-symbols-outlined">info</span> El equipo no proporcionó una descripción adicional.
                                </p>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-8">

                    <div class="bg-card-dark rounded-xl border border-border-dark overflow-hidden shadow-lg">
                        <div class="px-6 py-4 border-b border-border-dark bg-[#0D1B2A]">
                            <h3 class="font-bold text-white">Equipo</h3>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xs font-mono text-primary uppercase mb-4">Integrantes</h4>
                            <div class="space-y-4">
                                @foreach($repositorio->equipo->participantes as $miembro)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-background-dark border border-border-dark flex items-center justify-center text-primary font-bold shadow-inner">
                                            {{ substr($miembro->nombre, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-white truncate">{{ $miembro->nombre }}</p>
                                            <p class="text-xs text-text-muted truncate">{{ $miembro->correo }}</p>
                                        </div>
                                        @if($miembro->id == $repositorio->equipo->id_lider)
                                            <span class="text-xs bg-yellow-500/10 text-yellow-400 px-2 py-0.5 rounded border border-yellow-500/20" title="Líder">Líder</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-card-dark rounded-xl border border-border-dark overflow-hidden shadow-lg sticky top-24">
                        <div class="px-6 py-4 border-b border-border-dark bg-[#0D1B2A]">
                            <h3 class="font-bold text-white">Acciones</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="{{ route('proyecto.juez.calificar-juez', $repositorio) }}"
                               class="w-full flex justify-center items-center gap-2 py-3 rounded-lg font-bold transition-all transform hover:-translate-y-0.5 shadow-lg 
                               {{ $repositorio->calificacion_total ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/30 hover:bg-yellow-500 hover:text-black' : 'bg-primary text-background-dark hover:bg-opacity-90' }}">
                                <span class="material-symbols-outlined">grade</span>
                                {{ $repositorio->calificacion_total ? 'Editar Calificación' : 'Calificar Proyecto' }}
                            </a>
                            
                            <a href="{{ route('proyecto.juez.listar-juez', $repositorio->evento_id) }}"
                               class="w-full flex justify-center items-center gap-2 py-3 rounded-lg border border-border-dark text-text-muted hover:text-white hover:bg-white/5 transition-all">
                                Cancelar
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

</body>
</html>