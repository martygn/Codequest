<x-app-layout>
    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="mb-8 flex items-center text-sm font-mono tracking-wide">
                <a href="{{ route('eventos.index') }}" class="text-[#64FFDA] hover:text-white transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Eventos
                </a>
                <span class="mx-3 text-[#233554]">/</span>
                <span class="text-[#CCD6F6] font-bold">{{ $evento->nombre }}</span>
            </div>

            {{-- Banner del Evento (IMAGEN DESDE R2) --}}
            <div class="relative bg-[#112240] rounded-3xl overflow-hidden shadow-2xl border border-[#233554] mb-10">
                <div class="h-96 relative">
                    @if($evento->foto)
                        <img src="{{ Storage::disk('r2')->url($evento->foto) }}"
                             alt="{{ $evento->nombre }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#64FFDA]/20 via-[#1F63E1]/20 to-[#112240] flex items-center justify-center">
                            <span class="text-9xl font-extrabold text-[#64FFDA]/30 tracking-wider">
                                {{ strtoupper(substr($evento->nombre, 0, 3)) }}
                            </span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-transparent to-transparent"></div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-4 drop-shadow-2xl">
                        {{ $evento->nombre }}
                    </h1>
                    <p class="text-xl md:text-2xl text-[#8892B0] leading-relaxed max-w-4xl drop-shadow-lg">
                        {{ $evento->descripcion_corta ?? 'Un evento para mentes creativas y solucionadores de problemas. Desarrolla soluciones innovadoras en un entorno colaborativo.' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                {{-- Columna Principal (Info) --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    {{-- Descripción --}}
                    <section>
                        <h3 class="text-2xl font-bold text-[#CCD6F6] mb-5 flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA] text-3xl">description</span> 
                            Descripción del Evento
                        </h3>
                        <div class="bg-[#112240] p-8 rounded-2xl border border-[#233554] text-[#CCD6F6] leading-relaxed whitespace-pre-line shadow-xl text-lg">
                            {{ $evento->descripcion }}
                        </div>
                    </section>

                    {{-- Reglas --}}
                    <section>
                        <h3 class="text-2xl font-bold text-[#CCD6F6] mb-5 flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA] text-3xl">gavel</span> 
                            Reglas y Lineamientos
                        </h3>
                        <div class="bg-[#112240] p-8 rounded-2xl border border-[#233554] text-[#CCD6F6] leading-relaxed whitespace-pre-line shadow-xl text-lg">
                            {{ $evento->reglas ?? 'No se han especificado reglas detalladas para este evento. Por favor consulta con los organizadores.' }}
                        </div>
                    </section>

                    {{-- Premios --}}
                    <section>
                        <h3 class="text-2xl font-bold text-[#CCD6F6] mb-5 flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA] text-3xl">emoji_events</span> 
                            Premios y Reconocimientos
                        </h3>
                        <div class="bg-[#112240] p-8 rounded-2xl border border-[#233554] text-[#CCD6F6] leading-relaxed whitespace-pre-line shadow-xl text-lg">
                            {{ $evento->premios ?? 'Información sobre premios pendiente de confirmación.' }}
                        </div>
                    </section>

                </div>

                {{-- Columna Lateral (Fechas y Acción) --}}
                <div class="space-y-8">
                    
                    <div class="bg-[#112240] rounded-3xl p-8 border border-[#233554] shadow-2xl sticky top-6">
                        <h3 class="text-2xl font-bold text-white mb-8 border-b-2 border-[#64FFDA]/30 pb-4">
                            <span class="material-symbols-outlined text-[#64FFDA] mr-3">schedule</span>
                            Cronograma
                        </h3>

                        <div class="space-y-8 relative">
                            <div class="absolute left-8 top-4 bottom-4 w-0.5 bg-[#233554]"></div>

                            <div class="relative pl-16">
                                <div class="absolute left-4 top-2 w-6 h-6 rounded-full bg-[#64FFDA] border-4 border-[#0A192F] shadow-lg"></div>
                                <span class="block text-xs font-mono font-bold text-[#64FFDA] uppercase mb-2">Cierre de Registro</span>
                                <span class="block text-2xl font-bold text-[#CCD6F6]">
                                    {{ \Carbon\Carbon::parse($evento->fecha_inicio)->subDays(1)->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <div class="relative pl-16">
                                <div class="absolute left-4 top-2 w-6 h-6 rounded-full bg-[#64FFDA] border-4 border-[#0A192F] shadow-lg"></div>
                                <span class="block text-xs font-mono font-bold text-[#64FFDA] uppercase mb-2">Inicio del Evento</span>
                                <span class="block text-2xl font-bold text-[#CCD6F6]">
                                    {{ $evento->fecha_inicio->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <div class="relative pl-16">
                                <div class="absolute left-4 top-2 w-6 h-6 rounded-full bg-[#8892B0] border-4 border-[#0A192F]"></div>
                                <span class="block text-xs font-mono font-bold text-[#8892B0] uppercase mb-2">Entrega de Proyectos</span>
                                <span class="block text-xl font-bold text-[#CCD6F6]">
                                    {{ $evento->fecha_fin->copy()->subDay()->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <div class="relative pl-16">
                                <div class="absolute left-4 top-2 w-6 h-6 rounded-full bg-[#8892B0] border-4 border-[#0A192F]"></div>
                                <span class="block text-xs font-mono font-bold text-[#8892B0] uppercase mb-2">Ceremonia de Premiación</span>
                                <span class="block text-xl font-bold text-[#CCD6F6]">
                                    {{ $evento->fecha_fin->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Botón de Acción --}}
                    <div class="bg-[#112240] rounded-3xl p-8 border border-[#233554] shadow-2xl">
                        @auth
                            @if($esParticipante)
                                @if($tieneEquipoEnEsteEvento)
                                    <div class="bg-green-500/10 border-2 border-green-500/40 text-green-400 px-6 py-5 rounded-2xl flex items-center gap-4 shadow-xl">
                                        <span class="material-symbols-outlined text-4xl">verified</span>
                                        <div>
                                            <p class="font-bold text-lg">¡Ya estás inscrito!</p>
                                            <p class="text-sm opacity-90">Tu equipo participa en este evento</p>
                                        </div>
                                    </div>
                                @elseif($tieneEquipoAprobado && $evento->estado === 'publicado')
                                    <a href="{{ route('eventos.inscribir-equipo', $evento->id_evento) }}"
                                       class="w-full flex justify-center items-center gap-4 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-6 px-8 rounded-2xl shadow-2xl hover:shadow-[#64FFDA]/50 transition-all transform hover:-translate-y-2 text-xl">
                                        <span class="material-symbols-outlined text-3xl">how_to_reg</span>
                                        Inscribir mi Equipo
                                    </a>
                                @elseif($tieneEquipoAprobado && $evento->estado !== 'publicado')
                                    <div class="bg-yellow-500/10 border-2 border-yellow-500/40 text-yellow-400 px-6 py-5 rounded-2xl flex items-center gap-4">
                                        <span class="material-symbols-outlined text-3xl">pending</span>
                                        <p class="font-bold text-lg">Evento no publicado aún</p>
                                    </div>
                                @else
                                    <div class="text-center space-y-5">
                                        <a href="{{ route('equipos.create') }}"
                                           class="inline-flex items-center gap-4 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-5 px-10 rounded-2xl shadow-2xl text-xl">
                                            <span class="material-symbols-outlined text-3xl">group_add</span>
                                            Crear Equipo Primero
                                        </a>
                                        <p class="text-sm text-[#8892B0] opacity-80">
                                            Necesitas un equipo aprobado para participar
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="bg-gray-500/10 border-2 border-gray-500/40 text-gray-400 px-6 py-5 rounded-2xl text-center">
                                    <span class="material-symbols-outlined text-4xl block mb-3">lock_person</span>
                                    <p class="font-bold text-lg">Solo participantes pueden inscribirse</p>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full flex justify-center items-center gap-4 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-6 px-8 rounded-2xl shadow-2xl text-xl">
                                <span class="material-symbols-outlined text-3xl">login</span>
                                Iniciar Sesión para Participar
                            </a>
                        @endauth
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>