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

                    @if($eventos->count() > 0)
                        <div class="space-y-4">
                            @foreach($eventos as $evento)
                                @php
                                    $juecesAsignados = $eventosJueces[$evento->id_evento] ?? 0;
                                    $completo = $juecesAsignados >= 3;
                                    $yaAsignado = in_array($evento->id_evento, $eventosAsignados);
                                @endphp
                                <div class="border border-border-dark rounded-lg p-4 transition {{ $completo && !$yaAsignado ? 'bg-red-500/5 opacity-60' : 'bg-background-dark hover:bg-[#1a3a4f]' }}">
                                    <div class="flex items-start gap-4">
                                        <input
                                            type="checkbox"
                                            name="eventos[]"
                                            value="{{ $evento->id_evento }}"
                                            {{ $yaAsignado ? 'checked' : '' }}
                                            {{ $completo && !$yaAsignado ? 'disabled' : '' }}
                                            class="mt-1 w-5 h-5 text-primary bg-card-dark border-border-dark rounded focus:ring-primary focus:ring-offset-0 cursor-pointer"
                                        />
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="font-bold text-text-dark text-lg">{{ $evento->nombre }}</h3>
                                                <div class="flex items-center gap-2">
                                                    @if($completo)
                                                        <span class="px-3 py-1 bg-red-500/20 border border-red-500/50 rounded-full text-red-400 text-xs font-bold">
                                                            🔴 COMPLETO (3/3)
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 {{ $juecesAsignados >= 2 ? 'bg-yellow-500/20 border border-yellow-500/50' : 'bg-green-500/20 border border-green-500/50' }} rounded-full {{ $juecesAsignados >= 2 ? 'text-yellow-400' : 'text-green-400' }} text-xs font-bold">
                                                            {{ $juecesAsignados >= 2 ? '⚠️' : '✓' }} {{ $juecesAsignados }}/3 Jueces
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center gap-4 text-sm text-text-secondary-dark mb-2">
                                                <div class="flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                                                    {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-lg">{{ $evento->estado === 'publicado' ? 'check_circle' : 'schedule' }}</span>
                                                    {{ ucfirst($evento->estado) }}
                                                </div>
                                            </div>

                                            @if($evento->descripcion)
                                                <p class="text-sm text-text-secondary-dark">{{ \Illuminate\Support\Str::limit($evento->descripcion, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        <div class="mt-8 pt-6 border-t border-border-dark">
                            {{ $eventos->links('pagination::tailwind') }}
                        </div>
                    @else
                        <div class="p-6 text-center text-text-secondary-dark border border-border-dark rounded-lg bg-background-dark">
                            <span class="material-symbols-outlined text-6xl mx-auto block mb-2 opacity-50">event</span>
                            <p class="text-lg">No hay eventos creados aún.</p>
                        </div>
                    @endif

                    @if($eventos->count() > 0)
                        <div class="bg-primary/10 border border-primary/30 rounded-lg p-4 mt-6 mb-6">
                            <p class="text-sm text-primary">
                                <span class="font-semibold">💡 Nota:</span> Los eventos con estado <strong>COMPLETO (3/3)</strong> no pueden recibir más jueces. El juez podrá ver y evaluar los equipos de los eventos seleccionados.
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="px-6 py-3 bg-primary hover:bg-[#52d6b3] text-background-dark rounded-lg transition font-bold flex items-center gap-2">
                                <span class="material-symbols-outlined">save</span>
                                Guardar Asignaciones
                            </button>
                            <a href="{{ route('admin.jueces') }}" class="px-6 py-3 bg-card-dark border border-border-dark text-text-secondary-dark hover:bg-border-dark hover:text-primary rounded-lg transition font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined">cancel</span>
                                Cancelar
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </main>
</div>

</body>
</html>
