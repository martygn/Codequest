<x-app-layout>
    <div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Encabezado con Icono --}}
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-[#112240] rounded-xl flex items-center justify-center border border-[#233554] shadow-lg">
                    <span class="material-symbols-outlined text-[#64FFDA] text-2xl">event_available</span>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Mis Eventos</h2>
                    <p class="text-sm text-[#8892B0]">Gestiona tus participaciones activas</p>
                </div>
            </div>
            
            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="mb-8 bg-green-500/10 border border-green-500/30 text-green-400 p-4 rounded-xl flex items-center gap-3 shadow-lg animate-pulse">
                    <span class="material-symbols-outlined">check_circle</span>
                    <div>
                        <p class="font-bold text-sm">¡Éxito!</p>
                        <p class="text-xs opacity-90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554] relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#64FFDA] via-[#0A192F] to-[#64FFDA]"></div>

                <div class="p-8">
                
                    @if(count($misEventos) > 0)
                        {{-- CASO 1: HAY EVENTOS --}}
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 border-b border-[#233554] pb-6 gap-4">
                            <div>
                                <h3 class="text-2xl font-bold text-white mb-1">Eventos Activos</h3>
                                <p class="text-sm text-[#8892B0]">Tu equipo está compitiendo en estos eventos.</p>
                            </div>
                            <span class="bg-[#64FFDA]/10 border border-[#64FFDA]/30 text-[#64FFDA] text-xs px-3 py-1.5 rounded-full font-bold shadow-sm uppercase tracking-wide">
                                {{ count($misEventos) }} Inscrito(s)
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($misEventos as $evento)
                                <div class="group bg-[#0A192F] border border-[#233554] rounded-xl overflow-hidden hover:shadow-2xl hover:shadow-[#64FFDA]/10 transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1 hover:border-[#64FFDA]/50">
                                    
                                    {{-- Imagen --}}
                                    <div class="h-40 bg-[#112240] relative overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] to-transparent opacity-60 z-10"></div>
                                        @if($evento->foto)
                                            <img src="{{ asset('storage/' . $evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-full object-cover opacity-90 group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="flex items-center justify-center h-full text-[#233554] opacity-50 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]">
                                                <span class="material-symbols-outlined text-6xl">event</span>
                                            </div>
                                        @endif
                                        
                                        <div class="absolute top-3 right-3 z-20">
                                            <span class="bg-green-500/90 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg flex items-center border border-green-400/50">
                                                <span class="material-symbols-outlined text-[10px] mr-1">check_circle</span> INSCRITO
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="p-5 flex-1 flex flex-col">
                                        <h4 class="font-bold text-lg text-[#CCD6F6] mb-2 group-hover:text-[#64FFDA] transition-colors leading-tight truncate">
                                            {{ $evento->nombre }}
                                        </h4>
                                        
                                        <div class="text-sm text-[#8892B0] mb-6 flex-1 line-clamp-3 leading-relaxed">
                                            {{ Str::limit($evento->descripcion, 100) }}
                                        </div>
                                        
                                        <div class="border-t border-[#233554] pt-4 mt-auto space-y-3">
                                            <div class="flex items-center text-xs text-[#8892B0]">
                                                <span class="material-symbols-outlined text-base mr-2 text-[#64FFDA]">calendar_month</span>
                                                <span class="font-bold text-[#CCD6F6] mr-1">Inicio:</span> {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M, Y') }}
                                            </div>
                                            
                                            <div class="flex items-center text-xs text-[#8892B0] mb-4">
                                                <span class="material-symbols-outlined text-base mr-2 text-[#64FFDA]">location_on</span>
                                                <span>{{ $evento->lugar ?? 'Online' }}</span>
                                            </div>

                                            <div class="flex gap-2">
                                                <a href="{{ route('eventos.show', $evento->id_evento) }}" class="flex-1 text-center bg-[#112240] hover:bg-[#64FFDA] hover:text-[#0A192F] text-[#64FFDA] font-bold py-2.5 rounded-lg border border-[#233554] hover:border-[#64FFDA] transition-all duration-300 text-sm uppercase tracking-wide">
                                                    Ver Detalles
                                                </a>
                                                
                                                @if(isset($equiposPorEvento[$evento->id_evento]))
                                                    <form action="{{ route('equipos.quitar-evento', $equiposPorEvento[$evento->id_evento]->id_equipo) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="w-full text-center bg-red-500/10 hover:bg-red-500/30 text-red-400 hover:text-red-300 font-bold py-2.5 rounded-lg border border-red-500/30 hover:border-red-400 transition-all duration-300 text-sm uppercase tracking-wide"
                                                            onclick="return confirm('¿Estás seguro de que deseas salir de este evento?')">
                                                            Salir del Evento
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        {{-- CASO 2: NO HAY EVENTOS --}}
                        <div class="text-center py-16">
                            <div class="bg-[#0A192F] h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6 border border-[#233554] shadow-inner">
                                <span class="material-symbols-outlined text-5xl text-[#64FFDA]/50">event_busy</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">No estás inscrito en eventos</h3>
                            
                            <p class="text-[#8892B0] mb-8 max-w-md mx-auto text-sm leading-relaxed">
                                @if($miEquipo)
                                    Tu equipo <strong class="text-[#64FFDA]">{{ $miEquipo->nombre }}</strong> no participa en ningún evento activo actualmente.
                                @else
                                    Primero debes unirte a un equipo para poder inscribirte en los eventos y hackathons.
                                @endif
                            </p>
                            
                            <div class="flex justify-center">
                                @if($soyLider)
                                    <div class="text-center">
                                        <p class="text-xs text-[#64FFDA] font-bold mb-4 bg-[#64FFDA]/10 py-1.5 px-4 rounded-full inline-block border border-[#64FFDA]/20">
                                            ✨ ¡Eres líder! Puedes inscribir a tu equipo.
                                        </p>
                                        <br>
                                        <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-[#0A192F] bg-[#64FFDA] hover:bg-[#52d6b3] shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5">
                                            <span class="material-symbols-outlined mr-2 text-lg">explore</span>
                                            Explorar Eventos Disponibles
                                        </a>
                                    </div>
                                @elseif(!$miEquipo)
                                     <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-[#0A192F] bg-[#64FFDA] hover:bg-[#52d6b3] shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5">
                                        <span class="material-symbols-outlined mr-2 text-lg">group_add</span>
                                        Buscar Equipo Primero
                                    </a>
                                @else
                                    <div class="inline-flex items-center px-4 py-2 bg-[#0A192F] border border-[#233554] rounded-lg font-bold text-xs text-[#8892B0] uppercase tracking-widest cursor-not-allowed opacity-70">
                                        <span class="material-symbols-outlined text-sm mr-2">hourglass_empty</span>
                                        Esperando inscripción del líder
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>