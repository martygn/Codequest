<x-app-layout>

    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        
        {{-- Hero Section (DISEÑO MEJORADO) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="relative bg-[#112240] text-[#CCD6F6] overflow-hidden rounded-3xl shadow-2xl border border-[#233554] group">
                
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                
                <div class="absolute top-[-50%] right-[-10%] w-[500px] h-[500px] bg-[#64FFDA] rounded-full mix-blend-overlay filter blur-[120px] opacity-10 pointer-events-none group-hover:opacity-20 transition-opacity duration-700"></div>
                <div class="absolute bottom-[-50%] left-[-10%] w-[400px] h-[400px] bg-[#1F63E1] rounded-full mix-blend-overlay filter blur-[100px] opacity-10 pointer-events-none"></div>

                <div class="relative px-6 py-20 md:py-24 text-center z-10">

                    <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight text-white drop-shadow-lg">
                        Bienvenido a <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#64FFDA] to-[#2998FF]">CodeQuest</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-[#8892B0] mb-10 max-w-3xl mx-auto leading-relaxed">
                        La plataforma definitiva para registrar y gestionar equipos de programación. <br class="hidden md:block"> Compite, colabora y domina el código.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('eventos.index') }}"
                           class="inline-flex items-center justify-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-[0_0_20px_rgba(100,255,218,0.4)]">
                           <span class="material-symbols-outlined text-xl">rocket_launch</span>
                            Explorar Eventos
                        </a>
                        
                        
                    </div>
                </div>
            </div>
        </div>

        {{-- Notificaciones (Adaptadas al tema oscuro) --}}
        @php
            $notificaciones = auth()->user()->notificaciones()->noLeidas()->orderBy('created_at', 'desc')->limit(5)->get();
        @endphp

        @if($notificaciones->count() > 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#64FFDA] text-2xl">notifications_active</span>
                    <h3 class="text-2xl font-bold text-[#CCD6F6]">Notificaciones</h3>
                    <span class="bg-[#64FFDA] text-[#0A192F] text-xs font-bold px-2 py-1 rounded-full">{{ $notificaciones->count() }}</span>
                </div>
                <a href="{{ route('notificaciones.index') }}" class="text-[#64FFDA] hover:text-[#52d6b3] text-sm font-semibold transition-colors">
                    Ver todas →
                </a>
            </div>

            <div class="space-y-3">
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
                    <div class="border {{ $clase }} rounded-xl p-4 shadow-lg backdrop-blur-sm transition hover:scale-[1.01] hover:border-[#64FFDA]/50">
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined {{ $colorIcono }} text-2xl mt-1">{{ $icono }}</span>
                            <div class="flex-1">
                                <h4 class="font-bold text-[#CCD6F6] mb-1">{{ $notificacion->titulo }}</h4>
                                <p class="text-[#8892B0] text-sm">{{ $notificacion->mensaje }}</p>
                                <p class="text-[#64FFDA] text-xs mt-2">{{ $notificacion->created_at->diffForHumans() }}</p>
                            </div>
                            <button onclick="marcarComoLeida('{{ $notificacion->id }}')" class="text-[#8892B0] hover:text-[#64FFDA] transition-colors">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

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

        <!-- Próximos Eventos - Carrusel Infinito -->
<div class="mb-16">
    <h2 class="text-4xl font-bold text-[#CCD6F6] mb-8 flex items-center gap-4">
        <span class="material-symbols-outlined text-[#64FFDA] text-5xl">event</span>
        Próximos Eventos
    </h2>

    <div class="relative group">
        <div class="overflow-hidden rounded-2xl">
            <div class="flex animate-scroll hover:pause">
                @foreach($eventosProximos as $evento)
                    <div class="flex-none w-96 px-4">
                        <div class="bg-gradient-to-br from-[#112240] to-[#0A192F] rounded-2xl overflow-hidden border border-[#233554] shadow-2xl hover:shadow-[#64FFDA]/20 transition-all hover:scale-105">
                            <div class="relative">
                                @if($evento->foto)
                                    <img src="{{ config('filesystems.disks.r2.url') . '/' . $evento->foto }}"
                                         alt="{{ $evento->nombre }}"
                                         class="w-full h-64 object-cover"
                                         onerror="this.onerror=null; this.src='{{ asset('images/event-default.jpg') }}';">
                                @else
                                    <div class="w-full h-64 bg-gradient-to-br from-[#112240] to-[#0A192F] flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-8xl">event</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 bg-[#64FFDA]/90 text-white px-4 py-2 rounded-full font-bold text-sm backdrop-blur-sm">
                                    {{ $evento->fecha_inicio->format('d M Y') }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-[#64FFDA] mb-2">{{ $evento->nombre }}</h3>
                                <p class="text-[#8892B0] mb-4 line-clamp-2">{{ $evento->descripcion }}</p>
                                <div class="flex items-center gap-2 text-sm text-[#64FFDA] mb-4">
                                    <span class="material-symbols-outlined text-lg">location_on</span>
                                    <span>{{ $evento->ubicacion ?? 'Virtual' }}</span>
                                </div>
                                <a href="{{ route('eventos.show', $evento) }}"
                                   class="block w-full text-center py-3 bg-[#64FFDA] text-[#0A192F] rounded-xl font-bold hover:bg-[#52d6b3] transition-all shadow-lg">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

<style>
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-scroll {
        display: flex;
        width: max-content;
        animation: scroll 30s linear infinite;
    }
    .hover\:pause:hover {
        animation-play-state: paused;
    }
</style>

        {{-- Equipos Destacados - CARRUSEL NEÓN INFINITO (versión definitiva) --}}
<div class="bg-gradient-to-b from-[#0A192F] via-[#0D1B2A] to-[#0A192F] py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#64FFDA] to-[#00D4AA] mb-4">
                Equipos Destacados
            </h2>
            <p class="text-[#8892B0] text-lg">Los más activos y creativos del hackatón</p>
        </div>

        @if($equiposDestacados->count() > 0)
            <div class="relative">
                <!-- Duplicamos el contenido para efecto infinito -->
                <div class="flex animate-infinite-scroll gap-8">
                    @foreach($equiposDestacados->merge($equiposDestacados)->merge($equiposDestacados) as $equipo)
                        <div class="flex-none w-96 group">
                            <div class="relative bg-gradient-to-br from-[#112240] to-[#0A192F] rounded-2xl overflow-hidden border border-[#233554]
                                        hover:border-[#64FFDA] hover:shadow-2xl hover:shadow-[#64FFDA]/20
                                        transition-all duration-500 hover:-translate-y-2 h-full flex flex-col">

                                <!-- Banner del equipo -->
                                <div class="relative h-48 bg-gradient-to-br from-[#233554] to-[#112240] overflow-hidden">
                                    @if($equipo->banner)
                                        <img src="{{ config('filesystems.disks.r2.url') . '/' . $equipo->banner }}"
                                             alt="Banner {{ $equipo->nombre }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-[#64FFDA]/20 to-[#00D4AA]/20 flex items-center justify-center\'><span class=\'material-symbols-outlined text-[#64FFDA] text-7xl\'>groups</span></div>';">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-[#64FFDA]/20 to-[#00D4AA]/20 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[#64FFDA] text-7xl">groups</span>
                                        </div>
                                    @endif
                                    <!-- Overlay gradiente -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#112240] via-transparent to-transparent"></div>

                                    <!-- Badge del evento -->
                                    @if($equipo->evento)
                                        <div class="absolute top-4 right-4 bg-[#64FFDA]/90 backdrop-blur-sm text-[#0A192F] px-3 py-1.5 rounded-full text-xs font-bold border border-[#64FFDA] shadow-lg flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">trophy</span>
                                            {{ Str::limit($equipo->evento->nombre, 15) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Contenido del equipo -->
                                <div class="relative flex-1 p-6 flex flex-col">
                                    <h3 class="text-2xl font-bold text-[#CCD6F6] mb-3 group-hover:text-[#64FFDA] transition line-clamp-1">
                                        {{ $equipo->nombre }}
                                    </h3>

                                    <div class="flex items-center gap-2 text-[#8892B0] mb-6">
                                        <span class="material-symbols-outlined text-[#64FFDA]">group</span>
                                        <span class="font-bold text-[#64FFDA]">{{ $equipo->participantes_count ?? $equipo->participantes->count() }}</span>
                                        <span>Miembros</span>
                                    </div>

                                    <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                                       class="mt-auto w-full text-center py-3 bg-gradient-to-r from-[#64FFDA] to-[#00D4AA]
                                              text-[#0A192F] rounded-xl font-bold hover:shadow-lg hover:shadow-[#64FFDA]/40
                                              transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined">visibility</span>
                                        Ver Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CSS del carrusel infinito -->
            <style>
                @keyframes infinite-scroll {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .animate-infinite-scroll {
                    animation: infinite-scroll 40s linear infinite;
                }
                .animate-infinite-scroll:hover {
                    animation-play-state: paused;
                }
            </style>
        @else
            <div class="text-center py-20">
                <span class="material-symbols-outlined text-9xl text-[#233554] opacity-20 mb-8 block">emoji_events</span>
                <p class="text-2xl text-[#8892B0]">Aún no hay equipos destacados</p>
                <p class="text-[#64FFDA] mt-4">¡Sé el primero en brillar!</p>
            </div>
        @endif
    </div>
</div>
    </div>
</x-app-layout>