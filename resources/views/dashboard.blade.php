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
                @foreach($eventosProximos->concat($eventosProximos)->take(12) as $evento)
                    <div class="flex-none w-96 px-4">
                        <div class="bg-gradient-to-br from-[#112240] to-[#0A192F] rounded-2xl overflow-hidden border border-[#233554] shadow-2xl hover:shadow-[#64FFDA]/20 transition-all hover:scale-105">
                            <div class="relative">
                                <img src="{{ $evento->imagen ? Storage::disk('r2')->url($evento->imagen) : asset('images/event-default.jpg') }}"
                                     alt="{{ $evento->nombre }}"
                                     class="w-full h-64 object-cover">
                                <div class="absolute top-4 right-4 bg-[#64FF6B6B]/90 text-white px-4 py-2 rounded-full font-bold text-sm backdrop-blur-sm">
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

        <!-- Flechas (opcional) -->
        <button class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-r-xl backdrop-blur-sm opacity-0 group-hover:opacity-100 transition">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-l-xl backdrop-blur-sm opacity-0 group-hover:opacity-100 transition">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
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
                <div class="flex animate-infinite-scroll gap-10">
                    @foreach($equiposDestacados->merge($equiposDestacados)->merge($equiposDestacados) as $equipo)
                        <div class="flex-none w-80 group">
                            <div class="relative bg-gradient-to-br from-[#112240]/90 to-[#1a2a44] rounded-3xl overflow-hidden border border-[#233554] 
                                        hover:border-[#64FFDA] hover:shadow-2xl hover:shadow-[#64FFDA]/20 
                                        transition-all duration-500 hover:-translate-y-6">
                                
                                <!-- Efecto neón en el borde -->
                                <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 
                                            bg-gradient-to-br from-[#64FFDA]/10 blur-xl transition"></div>

                                <!-- Avatar grande con brillo -->
                                <div class="relative z-10 flex justify-center -mt-16 mb-6">
                                    <div class="relative">
                                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-[#64FFDA] to-[#00D4AA] p-1 
                                                    shadow-2xl shadow-[#64FFDA]/30 group-hover:scale-110 transition">
                                            <div class="w-full h-full rounded-full bg-[#0A192F] flex items-center justify-center 
                                                        text-5xl font-black text-[#64FFDA] border-4 border-[#112240]">
                                                {{ strtoupper(substr($equipo->nombre, 0, 2)) }}
                                            </div>
                                        </div>
                                        <!-- Halo neón -->
                                        <div class="absolute inset-0 rounded-full bg-[#64FFDA] blur-2xl opacity-30 
                                                    group-hover:opacity-60 transition"></div>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="relative z-10 px-8 pb-8 text-center">
                                    <h3 class="text-2xl font-bold text-[#CCD6F6] mb-2 group-hover:text-[#64FFDA] transition">
                                        {{ $equipo->nombre }}
                                    </h3>
                                    <p class="text-[#64FFDA] font-bold text-lg mb-4">
                                        {{ $equipo->participantes_count ?? $equipo->participantes->count() }} Miembros
                                    </p>

                                    @if($equipo->evento)
                                        <div class="inline-flex items-center gap-2 bg-[#64FFDA]/10 text-[#64FFDA] px-4 py-2 
                                                    rounded-full text-sm font-bold mb-6 border border-[#64FFDA]/30">
                                            <span class="material-symbols-outlined text-base">trophy</span>
                                            {{ Str::limit($equipo->evento->nombre, 20) }}
                                        </div>
                                    @endif

                                    <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                                       class="inline-flex items-center gap-3 px-8 py-4 mt-6 bg-gradient-to-r from-[#64FFDA] to-[#00D4AA] 
                                              text-[#0A192F] rounded-2xl font-black text-lg hover:shadow-xl hover:shadow-[#64FFDA]/40 
                                              transition-all duration-300 transform hover:scale-105">
                                        <span class="material-symbols-outlined text-2xl">visibility</span>
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