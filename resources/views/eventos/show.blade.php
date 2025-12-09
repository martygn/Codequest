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

            {{-- Encabezado --}}
            <div class="bg-[#112240] rounded-3xl p-8 md:p-10 shadow-2xl border border-[#233554] relative overflow-hidden mb-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#64FFDA] rounded-full mix-blend-overlay filter blur-[100px] opacity-10 pointer-events-none"></div>
                
                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-sm">
                    {{ $evento->nombre }}
                </h1>
                <p class="text-lg md:text-xl text-[#8892B0] leading-relaxed max-w-3xl">
                    {{ $evento->descripcion_corta ?? 'Un evento para mentes creativas y solucionadores de problemas. Desarrolla soluciones innovadoras en un entorno colaborativo.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Columna Principal (Info) --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Descripción --}}
                    <section>
                        <h3 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">description</span> Descripción
                        </h3>
                        <div class="bg-[#112240] p-6 rounded-2xl border border-[#233554] text-[#8892B0] leading-relaxed whitespace-pre-line shadow-lg">
                            {{ $evento->descripcion }}
                        </div>
                    </section>

                    {{-- Reglas --}}
                    <section>
                        <h3 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">gavel</span> Reglas
                        </h3>
                        <div class="bg-[#112240] p-6 rounded-2xl border border-[#233554] text-[#8892B0] leading-relaxed whitespace-pre-line shadow-lg">
                            {{ $evento->reglas ?? 'No se han especificado reglas detalladas para este evento. Por favor consulta con los organizadores.' }}
                        </div>
                    </section>

                    {{-- Premios --}}
                    <section>
                        <h3 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">emoji_events</span> Premios
                        </h3>
                        <div class="bg-[#112240] p-6 rounded-2xl border border-[#233554] text-[#8892B0] leading-relaxed whitespace-pre-line shadow-lg">
                            {{ $evento->premios ?? 'Información sobre premios pendiente de confirmación.' }}
                        </div>
                    </section>

                </div>

                {{-- Columna Lateral (Fechas y Acción) --}}
                <div class="space-y-8">
                    
                    <div class="bg-[#112240] rounded-2xl p-6 border border-[#233554] shadow-lg sticky top-6">
                        <h3 class="text-lg font-bold text-white mb-6 border-b border-[#233554] pb-3">
                            Cronograma
                        </h3>

                        <div class="space-y-6 relative">
                            <div class="absolute left-[7px] top-2 bottom-2 w-0.5 bg-[#233554]"></div>

                            <div class="relative pl-8">
                                <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-[#0A192F] border-2 border-[#64FFDA]"></div>
                                <span class="block text-xs font-mono font-bold text-[#64FFDA] uppercase mb-1">CIERRE DE REGISTRO</span>
                                <span class="block text-[#CCD6F6] font-bold">
                                    {{ \Carbon\Carbon::parse($evento->fecha_inicio)->subDays(1)->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <div class="relative pl-8">
                                <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-[#0A192F] border-2 border-[#64FFDA]"></div>
                                <span class="block text-xs font-mono font-bold text-[#64FFDA] uppercase mb-1">INICIO EVENTO</span>
                                <span class="block text-[#CCD6F6] font-bold">
                                    {{ $evento->fecha_inicio->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <div class="relative pl-8">
                                <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-[#0A192F] border-2 border-[#233554]"></div>
                                <span class="block text-xs font-mono font-bold text-[#8892B0] uppercase mb-1">PROYECTOS</span>
                                <span class="block text-[#CCD6F6] font-medium">
                                    {{ $evento->fecha_fin->copy()->subDay()->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <div class="relative pl-8">
                                <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-[#0A192F] border-2 border-[#233554]"></div>
                                <span class="block text-xs font-mono font-bold text-[#8892B0] uppercase mb-1">PREMIACIÓN</span>
                                <span class="block text-[#CCD6F6] font-medium">
                                    {{ $evento->fecha_fin->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#112240] rounded-2xl p-6 border border-[#233554] shadow-lg">
                        @auth
                            @if($esParticipante)
                                @if($tieneEquipoEnEsteEvento)
                                    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-start gap-3">
                                        <span class="material-symbols-outlined text-xl">check_circle</span>
                                        <p class="font-bold text-sm">Ya tienes un equipo inscrito en este evento.</p>
                                    </div>
                                @elseif($tieneEquipoAprobado && $evento->estado === 'publicado')
                                    <a href="{{ route('eventos.inscribir-equipo', $evento->id_evento) }}"
                                       class="w-full flex justify-center items-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.4)] transition-all transform hover:-translate-y-1">
                                        <span class="material-symbols-outlined">how_to_reg</span>
                                        Inscribir mi Equipo
                                    </a>
                                @elseif($tieneEquipoAprobado && $evento->estado !== 'publicado')
                                    <div class="bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 px-4 py-3 rounded-xl flex items-start gap-3">
                                        <span class="material-symbols-outlined text-xl">warning</span>
                                        <p class="font-bold text-sm">Este evento aún no ha sido publicado. Las inscripciones están cerradas temporalmente.</p>
                                    </div>
                                @else
                                    <div class="flex flex-col gap-3">
                                        <a href="{{ route('equipos.create') }}"
                                           class="w-full flex justify-center items-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.4)] transition-all transform hover:-translate-y-1">
                                            <span class="material-symbols-outlined">group_add</span>
                                            Crear Equipo
                                        </a>
                                        <p class="text-xs text-[#8892B0] text-center px-2">
                                            * Para participar necesitas crear un equipo y que sea aprobado.
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 px-4 py-3 rounded-xl flex items-start gap-3">
                                    <span class="material-symbols-outlined text-xl">lock</span>
                                    <p class="font-bold text-sm">Solo los participantes pueden inscribirse en eventos.</p>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full flex justify-center items-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.4)] transition-all transform hover:-translate-y-1">
                                <span class="material-symbols-outlined">login</span>
                                Iniciar Sesión para Participar
                            </a>
                        @endauth
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>