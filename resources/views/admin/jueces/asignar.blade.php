<!DOCTYPE html>
<html lang="es">
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
                        primary: "#3b82f6",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
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
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex h-screen">
    @include('admin._sidebar')

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <header class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-4xl font-bold text-slate-900 dark:text-white">Asignar Eventos</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Juez: <span class="font-semibold">{{ $juez->nombre_completo }}</span></p>
                </div>
                <a href="{{ route('admin.jueces') }}" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white rounded-lg hover:bg-slate-300 dark:hover:bg-slate-700 transition font-semibold">Volver</a>
            </header>

            <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                <form method="POST" action="{{ route('admin.jueces.guardar-asignacion', $juez->id) }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-4">
                            Selecciona los eventos a asignar:
                        </label>

                        @if($eventos->count() > 0)
                            <div class="space-y-3 max-h-96 overflow-y-auto border border-slate-200 dark:border-slate-700 rounded-lg p-4">
                                @foreach($eventos as $evento)
                                    <label class="flex items-start gap-3 p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="eventos[]" 
                                            value="{{ $evento->id_evento }}"
                                            {{ in_array($evento->id_evento, $eventosAsignados) ? 'checked' : '' }}
                                            class="mt-1 w-4 h-4 text-primary rounded border-slate-300 dark:border-slate-600 focus:ring-primary"
                                        />
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-900 dark:text-white">{{ $evento->nombre }}</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                                {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                                            </p>
                                            @if($evento->descripcion)
                                                <p class="text-sm text-slate-500 dark:text-slate-500 mt-1">{{ \Illuminate\Support\Str::limit($evento->descripcion, 80) }}</p>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="p-6 text-center text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-lg">
                                <span class="material-symbols-outlined text-3xl mx-auto block mb-2">info</span>
                                <p>No hay eventos creados aún.</p>
                            </div>
                        @endif

                        @error('eventos')
                            <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <span class="font-semibold">💡 Nota:</span> El juez podrá ver y evaluar los equipos de los eventos seleccionados.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Guardar Asignaciones
                        </button>
                        <a href="{{ route('admin.jueces') }}" class="px-6 py-2 bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white rounded-lg hover:bg-slate-300 dark:hover:bg-slate-700 transition font-semibold">
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
