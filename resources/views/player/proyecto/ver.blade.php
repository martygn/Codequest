<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $repositorio->equipo->nombre_proyecto }} - CodeQuest</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

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
                    },
                    fontFamily: { sans: ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body, html { margin:0; padding:0; height:100%; background:#0A192F; }
    </style>
</head>
<body class="bg-background-dark text-text-dark font-sans">

<div class="flex flex-col h-screen">

    <!-- Header fijo con botón descargar y volver -->
    <header class="bg-card-dark border-b border-border-dark px-6 py-4 flex items-center justify-between shadow-xl z-10">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-primary hover:text-white transition">
                <span class="material-symbols-outlined text-3xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold">{{ $repositorio->equipo->nombre_proyecto }}</h1>
                <p class="text-text-secondary-dark text-sm">Equipo: {{ $repositorio->equipo->nombre }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            @if($repositorio->calificacion_total)
                <div class="text-right">
                    <div class="text-4xl font-bold text-primary">{{ $repositorio->calificacion_total }}</div>
                    <p class="text-text-secondary-dark text-sm">/100 puntos</p>
                </div>
            @else
                <span class="px-5 py-2 bg-yellow-500/10 text-yellow-400 border border-yellow-500/30 rounded-xl font-bold">
                    En espera de evaluación
                </span>
            @endif

            <a href="{{ route('proyectos.download', $repositorio) }}"
               class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold hover:opacity-90 transition-all shadow-lg">
                <span class="material-symbols-outlined text-xl">download</span>
                Descargar Proyecto
            </a>
        </div>
    </header>

    <!-- Visor del archivo -->
    <div class="flex-1 bg-background-dark">
        @php
            $extension = strtolower(pathinfo($repositorio->archivo_nombre, PATHINFO_EXTENSION));
        @endphp

        @if($extension === 'pdf')
            <iframe src="{{ Storage::disk('r2')->url($repositorio->archivo_path) }}"
                    class="w-full h-full border-0"
                    frameborder="0"></iframe>

        @elseif(in_array($extension, ['jpg','jpeg','png','gif','webp']))
            <div class="flex items-center justify-center h-full p-8">
                <img src="{{ Storage::disk('r2')->url($repositorio->archivo_path) }}"
                     alt="{{ $repositorio->archivo_nombre }}"
                     class="max-w-full max-h-full rounded-xl shadow-2xl border border-border-dark">
            </div>

        @else
            <div class="flex flex-col items-center justify-center h-full text-center p-8">
                <span class="material-symbols-outlined text-9xl text-text-secondary-dark opacity-30 mb-8">description</span>
                <p class="text-2xl font-bold text-text-dark mb-4">Archivo: {{ $repositorio->archivo_nombre }}</p>
                <p class="text-text-secondary-dark mb-8 max-w-md">
                    Este tipo de archivo no se puede previsualizar directamente.
                </p>
                <a href="{{ route('proyectos.download', $repositorio) }}"
                   class="inline-flex items-center gap-3 px-10 py-5 bg-primary text-background-dark rounded-2xl font-bold text-2xl hover:shadow-2xl hover:shadow-primary/40 transition-all">
                    <span class="material-symbols-outlined text-3xl">download</span>
                    Descargar {{ $repositorio->archivo_nombre }}
                </a>
            </div>
        @endif
    </div>
</div>

</body>
</html>