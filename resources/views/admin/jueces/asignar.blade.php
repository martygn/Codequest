<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Asignar Eventos a Juez - CodeQuest</title>
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
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-dark text-text-secondary-dark">
<div class="flex h-screen">
    @include('admin._sidebar')

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <header class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-4xl font-bold text-text-dark">Asignar Eventos</h2>
                    <p class="text-text-secondary-dark mt-1">Juez: <span class="font-semibold text-primary">{{ $juez->nombre_completo }}</span></p>
                </div>
                <a href="{{ route('admin.jueces') }}" class="px-4 py-2 bg-card-dark border border-border-dark text-primary rounded-lg hover:bg-border-dark transition font-semibold">Volver</a>
            </header>

            <div class="bg-card-dark rounded-lg shadow-xl border border-border-dark p-6">
                <form method="POST" action="{{ route('admin.jueces.guardar-asignacion', $juez->id) }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-text-dark mb-4">
                            Selecciona los eventos a asignar:
                        </label>

                        @if($eventos->count() > 0)
                            <div class="space-y-3 max-h-96 overflow-y-auto border border-border-dark rounded-lg p-4 bg-background-dark">
                                @foreach($eventos as $evento)
                                    <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-card-dark transition cursor-pointer border border-transparent hover:border-primary/30">
                                        <input
                                            type="checkbox"
                                            name="eventos[]"
                                            value="{{ $evento->id_evento }}"
                                            {{ in_array($evento->id_evento, $eventosAsignados) ? 'checked' : '' }}
                                            class="mt-1 w-4 h-4 text-primary bg-card-dark border-border-dark rounded focus:ring-primary focus:ring-offset-0"
                                        />
                                        <div class="flex-1">
                                            <p class="font-semibold text-text-dark">{{ $evento->nombre }}</p>
                                            <p class="text-sm text-text-secondary-dark">
                                                {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                                            </p>
                                            @if($evento->descripcion)
                                                <p class="text-sm text-text-secondary-dark mt-1">{{ \Illuminate\Support\Str::limit($evento->descripcion, 80) }}</p>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 text-center text-text-secondary-dark border border-border-dark rounded-lg bg-background-dark">
                                <span class="material-symbols-outlined text-3xl mx-auto block mb-2">info</span>
                                <p>No hay eventos creados aún.</p>
                            </div>
                        @endif

                        @error('eventos')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-primary/10 border border-primary/30 rounded-lg p-4 mb-6">
                        <p class="text-sm text-primary">
                            <span class="font-semibold">💡 Nota:</span> El juez podrá ver y evaluar los equipos de los eventos seleccionados.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-primary text-background-dark rounded-lg hover:bg-primary/80 transition font-semibold">
                            Guardar Asignaciones
                        </button>
                        <a href="{{ route('admin.jueces') }}" class="px-6 py-2 bg-card-dark border border-border-dark text-text-secondary-dark rounded-lg hover:bg-border-dark hover:text-primary transition font-semibold">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

</body>
</html>
