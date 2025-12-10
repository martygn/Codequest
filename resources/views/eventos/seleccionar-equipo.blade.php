<x-app-layout>
    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans" style="padding-top: 120px;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Advertencia si hay equipos en otros eventos --}}
            @if(!empty($equiposEnOtroEvento))
            <div class="mb-8 bg-yellow-500/10 border-l-4 border-yellow-500 p-4 rounded-lg flex items-start gap-3">
                <span class="material-symbols-outlined text-yellow-500 flex-shrink-0 text-2xl mt-0.5">warning</span>
                <div>
                    <p class="text-yellow-500 font-bold">⚠️ Advertencia: Algunos equipos ya están en otros eventos</p>
                    <p class="text-yellow-400 text-sm mt-1">
                        Los siguientes equipos ya están inscritos en otros eventos y no pueden ser seleccionados:
                    </p>
                    <ul class="text-yellow-400 text-sm mt-2 ml-4 space-y-1">
                        @foreach($equiposEnOtroEvento as $equipoId => $eventoAsignado)
                            @php
                                $equipo = $equiposAprobados->where('id_equipo', $equipoId)->first();
                            @endphp
                            @if($equipo)
                            <li>• <strong>{{ $equipo->nombre }}</strong> en el evento <strong>"{{ $eventoAsignado->nombre }}"</strong></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Seleccionar Equipo</h2>
                <p class="text-sm text-[#8892B0] mt-2">Tienes múltiples equipos aprobados. Selecciona uno para inscribir en <strong class="text-[#64FFDA]">{{ $evento->nombre }}</strong>:</p>
            </div>

            {{-- Grilla de Equipos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($equiposAprobados as $equipo)
                    @php
                        $estaEnOtroEvento = isset($equiposEnOtroEvento[$equipo->id_equipo]);
                    @endphp
                    <form action="{{ route('eventos.seleccionar-equipo', $evento->id_evento) }}" method="POST" class="block">
                        @csrf
                        <input type="hidden" name="equipo_id" value="{{ $equipo->id_equipo }}">

                        <button type="submit"
                                @if($estaEnOtroEvento) disabled @endif
                                class="w-full {{ $estaEnOtroEvento ? 'bg-[#1a2d4d] border-[#3d4a5c] cursor-not-allowed opacity-60' : 'bg-[#112240] border-[#233554] hover:border-[#64FFDA] hover:shadow-[0_0_20px_rgba(100,255,218,0.2)] hover:bg-[#1a3a4f]' }} border rounded-xl p-6 transition-all text-left group">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="font-bold text-[#CCD6F6] text-lg mb-2 group-hover:text-[#64FFDA] transition-colors">{{ $equipo->nombre }}</h3>
                                    <p class="text-[#8892B0] mb-3 text-sm">{{ $equipo->nombre_proyecto }}</p>
                                    <p class="text-xs text-[#6B7C99]">
                                        👥 Miembros: {{ $equipo->participantes()->count() }} / 4
                                    </p>
                                </div>
                                @if($estaEnOtroEvento)
                                <div class="flex-shrink-0">
                                    <span class="material-symbols-outlined text-yellow-500 text-2xl">lock</span>
                                </div>
                                @else
                                <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-[#64FFDA] text-2xl">arrow_forward</span>
                                </div>
                                @endif
                            </div>
                        </button>
                    </form>
                @endforeach
            </div>

            {{-- Link de regreso --}}
            <div class="pt-6 border-t border-[#233554]">
                <a href="{{ route('eventos.show', $evento->id_evento) }}"
                   class="inline-flex items-center gap-2 text-[#64FFDA] hover:text-[#52d6b3] font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Volver al evento
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
