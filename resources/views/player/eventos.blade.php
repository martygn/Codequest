<x-app-layout>
<div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="padding-top: 120px;">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($misEventos as $evento)
                            <div class="group bg-[#0A192F] border border-[#233554] rounded-2xl overflow-hidden hover:shadow-2xl hover:shadow-[#64FFDA]/20 transition-all duration-500 flex flex-col h-full transform hover:-translate-y-2 hover:border-[#64FFDA]/60">
                                
                                {{-- Imagen del evento (CORREGIDA PARA R2) --}}
                                <div class="h-48 bg-[#112240] relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] to-transparent opacity-70 z-10"></div>
                                    
                                    @if($evento->foto)
                                        <img src="{{ Storage::disk('r2')->url($evento->foto) }}"
                                             alt="{{ $evento->nombre }}"
                                             class="w-full h-full object-cover opacity-90 group-hover:scale-110 transition-transform duration-1000">
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full bg-gradient-to-br from-[#64FFDA]/10 to-[#1F63E1]/10 text-[#64FFDA]/40">
                                            <span class="material-symbols-outlined text-8xl mb-4">event</span>
                                            <p class="text-2xl font-bold">{{ Str::upper(substr($evento->nombre, 0, 2)) }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-4 right-4 z-20">
                                        <span class="bg-green-500/95 backdrop-blur-lg text-white text-xs font-bold px-3 py-2 rounded-xl shadow-2xl flex items-center border border-green-400/60">
                                            <span class="material-symbols-outlined text-sm mr-1">check_circle</span> INSCRITO
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-6 flex-1 flex flex-col">
                                    <h4 class="font-bold text-2xl text-[#CCD6F6] mb-3 group-hover:text-[#64FFDA] transition-colors leading-tight">
                                        {{ $evento->nombre }}
                                    </h4>
                                    
                                    <div class="text-sm text-[#8892B0] mb-8 flex-1 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($evento->descripcion, 120) }}
                                    </div>
                                    
                                    <div class="border-t border-[#233554] pt-5 mt-auto space-y-4">
                                        <div class="flex items-center text-sm text-[#8892B0]">
                                            <span class="material-symbols-outlined text-lg mr-3 text-[#64FFDA]">calendar_month</span>
                                            <div>
                                                <span class="font-bold text-[#CCD6F6]">Inicio:</span>
                                                <span class="ml-1">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-[#8892B0]">
                                            <span class="material-symbols-outlined text-lg mr-3 text-[#64FFDA]">location_on</span>
                                            <span>{{ $evento->lugar ?? 'Online / Virtual' }}</span>
                                        </div>

                                        <div class="flex gap-3 mt-6">
                                            <a href="{{ route('eventos.show', $evento->id_evento) }}"
                                               class="flex-1 text-center bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-[#64FFDA]/40 text-sm uppercase tracking-wider">
                                                Ver Detalles
                                            </a>
                                            
                                            @if(isset($equiposPorEvento[$evento->id_evento]))
                                                <form action="{{ route('equipos.quitar-evento', $equiposPorEvento[$evento->id_evento]->id_equipo) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit"
                                                            class="w-full text-center bg-red-500/20 hover:bg-red-500/40 text-red-400 hover:text-red-300 font-bold py-3 rounded-xl border border-red-500/40 hover:border-red-400 transition-all duration-300 text-sm uppercase tracking-wider"
                                                            onclick="return confirm('¿Salir de este evento? Tu equipo quedará libre.')">
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
                    <div class="text-center py-20">
                        <div class="bg-[#0A192F] h-32 w-32 rounded-full flex items-center justify-center mx-auto mb-8 border-4 border-dashed border-[#233554]">
                            <span class="material-symbols-outlined text-7xl text-[#64FFDA]/30">event_busy</span>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-4">No estás inscrito en eventos</h3>
                        <p class="text-[#8892B0] mb-10 max-w-md mx-auto text-lg leading-relaxed">
                            @if($miEquipo)
                                Tu equipo <strong class="text-[#64FFDA]">{{ $miEquipo->nombre }}</strong> no participa en ningún evento activo actualmente.
                            @else
                                Primero debes unirte a un equipo para poder inscribirte en los eventos.
                            @endif
                        </p>
                        
                        <div class="flex justify-center gap-6">
                            @if($soyLider ?? false)
                                <a href="{{ route('eventos.index') }}"
                                   class="inline-flex items-center gap-3 px-10 py-5 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-xl hover:bg-[#52d6b3] transition-all shadow-2xl transform hover:-translate-y-1">
                                    <span class="material-symbols-outlined text-3xl">explore</span>
                                    Explorar Eventos
                                </a>
                            @elseif(!$miEquipo)
                                <a href="{{ route('equipos.index') }}"
                                   class="inline-flex items-center gap-3 px-10 py-5 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-xl hover:bg-[#52d6b3] transition-all shadow-2xl">
                                    <span class="material-symbols-outlined text-3xl">group_add</span>
                                    Buscar Equipo
                                </a>
                            @else
                                <div class="px-10 py-5 bg-[#0A192F]/50 border border-[#233554] rounded-2xl text-[#8892B0] text-center font-medium text-lg">
                                    <span class="material-symbols-outlined text-4xl block mb-3 opacity-60">hourglass_empty</span>
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