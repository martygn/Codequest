<x-app-layout>
    <div class="min-h-screen bg-[#0A192F] py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#64FFDA] text-3xl">notifications</span>
                        <h1 class="text-3xl font-bold text-[#CCD6F6]">Notificaciones</h1>
                    </div>

                    @if($notificaciones->where('leida', false)->count() > 0)
                    <form action="{{ route('notificaciones.marcar-todas-leidas') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[#64FFDA] hover:text-[#52d6b3] text-sm font-semibold transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">done_all</span>
                            Marcar todas como leídas
                        </button>
                    </form>
                    @endif
                </div>

                <p class="text-[#8892B0]">
                    Tienes <span class="text-[#64FFDA] font-bold">{{ $notificaciones->where('leida', false)->count() }}</span> notificaciones sin leer
                </p>
            </div>

            <!-- Notificaciones -->
            @if($notificaciones->count() > 0)
                <div class="space-y-4">
                    @foreach($notificaciones as $notificacion)
                        @php
                            $iconos = [
                                'info' => 'info',
                                'warning' => 'warning',
                                'success' => 'check_circle',
                                'error' => 'error',
                            ];
                            $estilos = [
                                'info' => 'bg-blue-500/10 border-blue-500/30',
                                'warning' => 'bg-yellow-500/10 border-yellow-500/30',
                                'success' => 'bg-green-500/10 border-green-500/30',
                                'error' => 'bg-red-500/10 border-red-500/30',
                            ];
                            $coloresIcono = [
                                'info' => 'text-blue-400',
                                'warning' => 'text-yellow-400',
                                'success' => 'text-green-400',
                                'error' => 'text-red-400',
                            ];
                            $icono = $iconos[$notificacion->tipo] ?? $iconos['info'];
                            $clase = $estilos[$notificacion->tipo] ?? $estilos['info'];
                            $colorIcono = $coloresIcono[$notificacion->tipo] ?? $coloresIcono['info'];
                        @endphp

                        <div class="border {{ $clase }} rounded-xl p-5 shadow-lg backdrop-blur-sm transition hover:scale-[1.01] {{ !$notificacion->leida ? 'border-l-4 border-l-[#64FFDA]' : 'opacity-70' }}">
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined {{ $colorIcono }} text-3xl mt-1">{{ $icono }}</span>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="font-bold text-[#CCD6F6] text-lg">{{ $notificacion->titulo }}</h3>
                                            @if(!$notificacion->leida)
                                                <span class="inline-block bg-[#64FFDA] text-[#0A192F] text-xs font-bold px-2 py-0.5 rounded-full mt-1">Nueva</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if(!$notificacion->leida)
                                                <button onclick="marcarComoLeida('{{ $notificacion->id }}')" class="text-[#64FFDA] hover:text-[#52d6b3] transition-colors" title="Marcar como leída">
                                                    <span class="material-symbols-outlined text-xl">done</span>
                                                </button>
                                            @endif
                                            <form action="{{ route('notificaciones.eliminar', $notificacion) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta notificación?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[#8892B0] hover:text-red-400 transition-colors" title="Eliminar">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="text-[#8892B0] mb-2">{{ $notificacion->mensaje }}</p>
                                    <p class="text-[#64FFDA] text-xs">{{ $notificacion->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-8">
                    {{ $notificaciones->links() }}
                </div>
            @else
                <div class="bg-[#112240] rounded-xl p-12 text-center border border-[#233554]">
                    <span class="material-symbols-outlined text-[#8892B0] text-6xl mb-4 block">notifications_off</span>
                    <p class="text-[#8892B0] text-lg">No tienes notificaciones</p>
                </div>
            @endif

        </div>
    </div>

    <script>
        function marcarComoLeida(notificacionId) {
            fetch(`/notificaciones/${notificacionId}/marcar-leida`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(() => location.reload());
        }
    </script>
</x-app-layout>
