<x-app-layout>

    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans">
        
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

        {{-- Próximos Eventos Carrusel --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-[#CCD6F6]">Próximos Eventos</h2>
                <div class="h-px flex-1 bg-[#233554] ml-6"></div>
            </div>

            <div class="relative" id="carouselWrapper">
                @if(count($proximosEventos) > 0)
                <style>
                    @keyframes carouselSlide {
                        0% { transform: translateX(0); }
                        100% { transform: translateX(calc(-400px * 5)); } /* Ajustado para suavidad */
                    }
                    .carousel-track { animation: carouselSlide 40s linear infinite; }
                    .carousel-track:hover { animation-play-state: paused; }
                </style>
                
                <div class="overflow-hidden py-4">
                    <div class="carousel-track flex gap-8">
                        @foreach($proximosEventos as $evento)
                        <div class="flex-shrink-0 w-96 bg-[#112240] rounded-2xl shadow-xl border border-[#233554] overflow-hidden hover:border-[#64FFDA] transition-all duration-300 group hover:-translate-y-2">
                            
                            <div class="h-48 bg-[#0A192F] relative overflow-hidden">
                                @if($evento->foto)
                                    <img src="{{ asset('storage/' . $evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#0D1B2A]">
                                        <span class="text-4xl font-bold text-[#233554]">{{ Str::upper(substr($evento->nombre, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 bg-[#0A192F]/80 backdrop-blur text-[#64FFDA] text-xs font-mono py-1 px-3 rounded border border-[#64FFDA]/30 shadow-lg">
                                    {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M Y') }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="font-bold text-xl text-[#CCD6F6] mb-2 truncate group-hover:text-[#64FFDA] transition-colors">
                                    {{ $evento->nombre }}
                                </h3>
                                @if($evento->lugar)
                                <p class="text-[#8892B0] text-sm mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base">location_on</span>
                                    {{ Str::limit($evento->lugar, 30) }}
                                </p>
                                @endif
                                <a href="{{ route('eventos.show', $evento->id_evento) }}" class="block w-full text-center py-3 rounded-lg border border-[#233554] text-[#64FFDA] font-bold hover:bg-[#64FFDA] hover:text-[#0A192F] transition-all duration-300">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                        @endforeach
                        
                        {{-- Duplicado para efecto infinito --}}
                        @foreach($proximosEventos as $evento)
                        <div class="flex-shrink-0 w-96 bg-[#112240] rounded-2xl shadow-xl border border-[#233554] overflow-hidden hover:border-[#64FFDA] transition-all duration-300 group hover:-translate-y-2">
                            <div class="h-48 bg-[#0A192F] relative overflow-hidden">
                                @if($evento->foto)
                                    <img src="{{ asset('storage/' . $evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#0D1B2A]">
                                        <span class="text-4xl font-bold text-[#233554]">{{ Str::upper(substr($evento->nombre, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 bg-[#0A192F]/80 backdrop-blur text-[#64FFDA] text-xs font-mono py-1 px-3 rounded border border-[#64FFDA]/30 shadow-lg">
                                    {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M Y') }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-xl text-[#CCD6F6] mb-2 truncate group-hover:text-[#64FFDA] transition-colors">{{ $evento->nombre }}</h3>
                                @if($evento->lugar)
                                <p class="text-[#8892B0] text-sm mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-base">location_on</span> {{ Str::limit($evento->lugar, 30) }}</p>
                                @endif
                                <a href="{{ route('eventos.show', $evento->id_evento) }}" class="block w-full text-center py-3 rounded-lg border border-[#233554] text-[#64FFDA] font-bold hover:bg-[#64FFDA] hover:text-[#0A192F] transition-all duration-300">Ver Detalles</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center py-16 bg-[#112240] rounded-2xl border border-dashed border-[#233554]">
                    <span class="material-symbols-outlined text-6xl text-[#233554] mb-4">event_busy</span>
                    <p class="text-[#8892B0] text-lg">No hay eventos próximos disponibles</p>
                    <a href="{{ route('eventos.create') }}" class="mt-4 inline-block text-[#64FFDA] hover:underline font-medium">Crear un evento →</a>
                </div>
                @endif
            </div>
        </div>

        {{-- Equipos Destacados Carrusel --}}
        <div class="bg-[#0D1B2A] py-16 border-t border-[#233554]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-[#CCD6F6]">Equipos Destacados</h2>
                    <div class="h-px flex-1 bg-[#233554] ml-6"></div>
                </div>

                <div class="relative" id="equiposCarouselWrapper">
                    @if(count($equiposDestacados) > 0)
                    <style>
                        @keyframes equiposCarouselSlide {
                            0% { transform: translateX(0); }
                            100% { transform: translateX(calc(-384px * 5)); }
                        }
                        .equipos-carousel-track { animation: equiposCarouselSlide 35s linear infinite; }
                        .equipos-carousel-track:hover { animation-play-state: paused; }
                    </style>
                    
                    <div class="overflow-hidden py-4">
                        <div class="equipos-carousel-track flex gap-8">
                            @foreach($equiposDestacados as $equipo)
                            <div class="flex-shrink-0 w-80 bg-[#112240] rounded-2xl shadow-lg border border-[#233554] p-6 hover:border-[#64FFDA] transition-all duration-300 group hover:-translate-y-2">
                                <div class="flex justify-center -mt-12 mb-4">
                                    <div class="w-24 h-24 rounded-full border-4 border-[#0D1B2A] bg-[#0A192F] overflow-hidden flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        @if($equipo->banner)
                                            <img src="{{ asset('storage/' . $equipo->banner) }}" alt="{{ $equipo->nombre }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-3xl font-bold text-[#64FFDA]">{{ strtoupper(substr($equipo->nombre, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3 class="font-bold text-xl text-[#CCD6F6] mb-1 group-hover:text-[#64FFDA] transition-colors">{{ $equipo->nombre }}</h3>
                                    <p class="text-[#8892B0] text-sm mb-4">
                                        {{ $equipo->participantes_count ?? 0 }} Miembros
                                    </p>
                                    @if($equipo->evento)
                                    <span class="inline-block bg-[#0A192F] text-[#8892B0] text-xs px-3 py-1 rounded-full mb-4 border border-[#233554]">
                                        {{ Str::limit($equipo->evento->nombre, 20) }}
                                    </span>
                                    @endif
                                    <a href="{{ route('equipos.show', $equipo->id_equipo) }}" class="block w-full py-2 rounded-lg bg-[#0A192F] text-[#CCD6F6] text-sm font-bold hover:bg-[#64FFDA] hover:text-[#0A192F] transition-all duration-300">
                                        Ver Perfil
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            
                            {{-- Duplicado --}}
                            @foreach($equiposDestacados as $equipo)
                            <div class="flex-shrink-0 w-80 bg-[#112240] rounded-2xl shadow-lg border border-[#233554] p-6 hover:border-[#64FFDA] transition-all duration-300 group hover:-translate-y-2">
                                <div class="flex justify-center -mt-12 mb-4">
                                    <div class="w-24 h-24 rounded-full border-4 border-[#0D1B2A] bg-[#0A192F] overflow-hidden flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        @if($equipo->banner)
                                            <img src="{{ asset('storage/' . $equipo->banner) }}" alt="{{ $equipo->nombre }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-3xl font-bold text-[#64FFDA]">{{ strtoupper(substr($equipo->nombre, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3 class="font-bold text-xl text-[#CCD6F6] mb-1 group-hover:text-[#64FFDA] transition-colors">{{ $equipo->nombre }}</h3>
                                    <p class="text-[#8892B0] text-sm mb-4">{{ $equipo->participantes_count ?? 0 }} Miembros</p>
                                    @if($equipo->evento)
                                    <span class="inline-block bg-[#0A192F] text-[#8892B0] text-xs px-3 py-1 rounded-full mb-4 border border-[#233554]">{{ Str::limit($equipo->evento->nombre, 20) }}</span>
                                    @endif
                                    <a href="{{ route('equipos.show', $equipo->id_equipo) }}" class="block w-full py-2 rounded-lg bg-[#0A192F] text-[#CCD6F6] text-sm font-bold hover:bg-[#64FFDA] hover:text-[#0A192F] transition-all duration-300">Ver Perfil</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center py-16 bg-[#112240] rounded-2xl border border-dashed border-[#233554]">
                        <span class="material-symbols-outlined text-6xl text-[#233554] mb-4">groups_3</span>
                        <p class="text-[#8892B0] text-lg">No hay equipos destacados disponibles</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>