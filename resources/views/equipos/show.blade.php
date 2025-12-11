<x-app-layout>
<div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="padding-top: 120px;">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        {{-- Banner del equipo (CORREGIDO PARA R2) --}}
        <div class="mb-8 rounded-3xl overflow-hidden shadow-2xl border border-[#233554] relative group">
            @if($equipo->banner)
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] to-transparent opacity-70 z-10"></div>
                <img src="{{ config('filesystems.disks.r2.url') . '/' . $equipo->banner }}"
                     alt="Banner del equipo {{ $equipo->nombre }}"
                     class="w-full h-80 object-cover transition-transform duration-1000 group-hover:scale-110"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                
                <div class="w-full h-80 bg-gradient-to-br from-[#64FFDA]/20 via-[#1F63E1]/20 to-[#112240] flex items-center justify-center hidden relative z-0">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                    <h1 class="text-7xl font-extrabold text-[#CCD6F6] z-10 drop-shadow-2xl">{{ $equipo->nombre }}</h1>
                </div>
            @else
                <div class="w-full h-80 bg-gradient-to-br from-[#64FFDA]/20 via-[#1F63E1]/20 to-[#112240] flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                    <div class="absolute top-[-40%] right-[-20%] w-96 h-96 bg-[#64FFDA] rounded-full mix-blend-overlay blur-[120px] opacity-20"></div>
                    <h1 class="text-7xl font-extrabold text-[#CCD6F6] z-10 drop-shadow-2xl">{{ $equipo->nombre }}</h1>
                </div>
            @endif
            
            {{-- Nombre del equipo encima del banner si tiene imagen --}}
            @if($equipo->banner)
            <div class="absolute bottom-10 left-10 z-20">
                <h1 class="text-6xl font-extrabold text-white drop-shadow-2xl">{{ $equipo->nombre }}</h1>
                @if($equipo->evento)
                    <p class="text-xl text-[#64FFDA] mt-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-2xl">event</span>
                        {{ $equipo->evento->nombre }}
                    </p>
                @endif
            </div>
            @endif
        </div>

        {{-- Mensajes Flash --}}
        @if(session('success') || session('error') || session('info'))
            <div class="space-y-4 mb-8">
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-xl">
                        <span class="material-symbols-outlined text-2xl">check_circle</span>
                        <span class="font-medium text-lg">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-xl">
                        <span class="material-symbols-outlined text-2xl">error</span>
                        <span class="font-medium text-lg">{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('info'))
                    <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-xl">
                        <span class="material-symbols-outlined text-2xl">info</span>
                        <span class="font-medium text-lg">{{ session('info') }}</span>
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-[#112240] overflow-hidden shadow-2xl rounded-3xl border border-[#233554]">
            <div class="p-10">

                {{-- Estado y Evento --}}
                <div class="mb-10 pb-8 border-b-2 border-[#233554] flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        @if($equipo->evento)
                            <div class="flex items-center text-[#64FFDA] font-bold text-lg mb-3">
                                <span class="material-symbols-outlined text-2xl mr-3">event</span>
                                {{ $equipo->evento->nombre }}
                            </div>
                        @else
                            <div class="flex items-center text-[#8892B0] text-lg mb-3">
                                <span class="material-symbols-outlined text-2xl mr-3">event_busy</span>
                                Sin evento asignado
                            </div>
                        @endif
                        <h2 class="text-2xl font-bold text-[#CCD6F6]">Detalles del Equipo</h2>
                    </div>
                    
                    <div>
                        @php
                            $estadoColors = [
                                'en revisión' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/30',
                                'aprobado' => 'bg-green-500/10 text-green-400 border-green-500/30',
                                'rechazado' => 'bg-red-500/10 text-red-400 border-red-500/30',
                            ];
                            $claseEstado = $estadoColors[$equipo->estado] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/30';
                        @endphp
                        <span class="inline-flex items-center px-6 py-3 rounded-2xl border-2 {{ $claseEstado }} font-bold uppercase text-sm tracking-wider shadow-lg">
                            {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 xl:gap-12">

                    {{-- Columna Izquierda: Info --}}
                    <div class="xl:col-span-2 space-y-10 order-2 xl:order-1">
                        
                        {{-- Proyecto --}}
                        <div class="bg-gradient-to-br from-[#64FFDA]/5 to-transparent p-8 rounded-2xl border border-[#64FFDA]/20">
                            <h3 class="text-lg font-bold text-[#64FFDA] mb-4 flex items-center gap-3">
                                <span class="material-symbols-outlined text-2xl">code</span> Proyecto
                            </h3>
                            <p class="text-3xl font-extrabold text-white">{{ $equipo->nombre_proyecto ?? 'Sin nombre de proyecto' }}</p>
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <h3 class="text-2xl font-bold text-[#CCD6F6] mb-6 flex items-center gap-4">
                                <span class="material-symbols-outlined text-[#64FFDA] text-3xl">description</span> Descripción
                            </h3>
                            <div class="bg-[#0A192F] rounded-2xl p-8 border border-[#233554] text-[#CCD6F6] leading-relaxed whitespace-pre-line shadow-xl text-lg">
                                {{ $equipo->descripcion ?? 'Sin descripción disponible.' }}
                            </div>
                        </div>

                        {{-- Líder --}}
                        @if($equipo->lider)
                        <div>
                            <h3 class="text-2xl font-bold text-[#CCD6F6] mb-6 flex items-center gap-4">
                                <span class="material-symbols-outlined text-[#64FFDA] text-3xl">military_tech</span> Líder del Equipo
                            </h3>
                            <div class="bg-gradient-to-r from-[#64FFDA]/10 to-transparent rounded-2xl p-6 border border-[#64FFDA]/30 flex items-center gap-6">
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#64FFDA] to-[#52d6b3] flex items-center justify-center text-[#0A192F] font-bold text-3xl shadow-2xl">
                                    {{ strtoupper(substr($equipo->lider->nombre, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-white">{{ $equipo->lider->nombre_completo }}</p>
                                    <p class="text-[#64FFDA] text-lg">{{ $equipo->lider->correo }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>

                    {{-- Columna Derecha: Miembros y Solicitudes --}}
                    <div class="space-y-10 order-1 xl:order-2">
                        
                        {{-- Miembros --}}
                        <div>
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-[#CCD6F6]">Integrantes</h3>
                                <span class="text-2xl font-bold text-[#64FFDA] bg-[#64FFDA]/10 px-5 py-2 rounded-2xl border border-[#64FFDA]/30">
                                    {{ $equipo->participantes()->count() }} / 4
                                </span>
                            </div>

                            <div class="space-y-5">
                                @if($equipo->participantes()->count() == 0)
                                    <div class="p-8 bg-[#0A192F] border-2 border-dashed border-[#233554] rounded-2xl text-center text-[#8892B0]">
                                        <span class="material-symbols-outlined text-6xl mb-4 block opacity-30">group_off</span>
                                        <p>Sin integrantes aún</p>
                                    </div>
                                @else
                                    @foreach($equipo->participantes as $participante)
                                        <div class="bg-[#0A192F] p-5 rounded-2xl border border-[#233554] flex items-center justify-between group hover:border-[#64FFDA] transition-all">
                                            <div class="flex items-center gap-5">
                                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#64FFDA] to-[#52d6b3] flex items-center justify-center text-[#0A192F] font-bold text-2xl shadow-xl">
                                                    {{ strtoupper(substr($participante->nombre, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-lg font-bold text-[#CCD6F6]">{{ $participante->nombre_completo }}</p>
                                                    <p class="text-sm text-[#8892B0]">{{ $participante->correo }}</p>
                                                </div>
                                            </div>

                                            @php $rol = $participante->pivot->posicion; @endphp
                                            <span class="px-4 py-2 rounded-xl font-bold text-sm
                                                {{ $rol === 'Líder' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40' : 'bg-[#64FFDA]/10 text-[#64FFDA] border border-[#64FFDA]/30' }}">
                                                {{ $rol ?? 'Miembro' }}
                                            </span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Solicitudes Pendientes (Solo Líder) --}}
                        @php
                            $solicitudesPendientes = $equipo->solicitudes_pendientes ?? [];
                            $esLider = $equipo->esLider(auth()->id());
                        @endphp
                        @if($esLider && count($solicitudesPendientes) > 0)
                            <div class="bg-yellow-500/10 border-2 border-yellow-500/30 rounded-2xl p-6">
                                <h4 class="text-xl font-bold text-yellow-400 mb-6 flex items-center gap-3">
                                    <span class="material-symbols-outlined text-2xl">notifications_active</span>
                                    Solicitudes Pendientes
                                </h4>
                                
                                <div class="space-y-4">
                                    @foreach($solicitudesPendientes as $usuarioId)
                                        @php $solicitante = App\Models\Usuario::find($usuarioId); @endphp
                                        @if($solicitante)
                                            <div class="bg-[#0A192F] p-5 rounded-xl border border-[#233554]">
                                                <p class="font-bold text-white mb-1">{{ $solicitante->nombre_completo }}</p>
                                                <p class="text-sm text-[#8892B0] mb-4">{{ $solicitante->correo }}</p>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <form action="{{ route('equipos.aceptar-solicitud-lider', [$equipo->id_equipo, $solicitante->id]) }}" method="POST">
                                                        @csrf
                                                        <button class="w-full bg-green-500/20 hover:bg-green-500/40 text-green-400 font-bold py-2 rounded-lg border border-green-500/40 transition-all text-sm">
                                                            Aceptar
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('equipos.rechazar-solicitud-lider', [$equipo->id_equipo, $solicitante->id]) }}" method="POST">
                                                        @csrf
                                                        <button class="w-full bg-red-500/20 hover:bg-red-500/40 text-red-400 font-bold py-2 rounded-lg border border-red-500/40 transition-all text-sm">
                                                            Rechazar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Acciones --}}
                <div class="mt-12 pt-8 border-t-2 border-[#233554] flex flex-wrap items-center justify-between gap-6">
                    <a href="{{ route('equipos.index') }}"
                       class="inline-flex items-center gap-3 px-6 py-4 bg-[#0A192F] border-2 border-[#233554] rounded-2xl text-[#CCD6F6] hover:text-[#64FFDA] hover:border-[#64FFDA] transition-all font-bold">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                        Volver a Equipos
                    </a>

                    <div class="flex flex-wrap gap-4">
                        @if($equipo->tieneMiembro(auth()->id()))
                            <form action="{{ route('equipos.salir', $equipo->id_equipo) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-8 py-4 bg-red-600 hover:bg-red-500 text-white font-bold rounded-2xl transition-all shadow-lg flex items-center gap-3" onclick="return confirm('¿Seguro que deseas salir del equipo?')">
                                    <span class="material-symbols-outlined text-xl">logout</span>
                                    Salir del Equipo
                                </button>
                            </form>
                        @endif

                        @if(auth()->user()->tipo === 'participante' && !$equipo->tieneMiembro(auth()->id()) && $equipo->participantes()->count() < 4 && $equipo->estaAprobado())
                            <form action="{{ route('equipos.solicitar-unirse', $equipo->id_equipo) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-10 py-4 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold rounded-2xl shadow-2xl transition-all flex items-center gap-3">
                                    <span class="material-symbols-outlined text-2xl">person_add</span>
                                    Solicitar Unirse
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- MODAL EXPULSIÓN --}}
<div id="modalExpulsar" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center backdrop-blur-md">
    <div class="bg-[#112240] border-2 border-[#233554] rounded-3xl shadow-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="material-symbols-outlined text-red-400 text-3xl">warning</span>
            Expulsar Miembro
        </h3>
        <p class="text-[#8892B0] mb-6">¿Estás seguro de expulsar a <span id="nombreMiembro" class="text-[#64FFDA] font-bold"></span>?</p>
        
        <form id="formExpulsar" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-[#64FFDA] mb-2">Motivo (opcional)</label>
                <textarea name="razon" placeholder="Explica el motivo..." 
                    class="w-full bg-[#0A192F] border border-[#233554] rounded-2xl p-4 text-[#CCD6F6] focus:border-[#64FFDA] focus:ring-2 focus:ring-[#64FFDA]/50 outline-none resize-none h-32"></textarea>
            </div>
            
            <div class="flex justify-end gap-4">
                <button type="button" onclick="cerrarModalExpulsar()" 
                    class="px-full px-6 py-3 border-2 border-[#233554] rounded-2xl text-[#8892B0] hover:text-white hover:bg-[#233554] font-bold transition-all">
                    Cancelar
                </button>
                <button type="submit" 
                    class="px-8 py-3 bg-red-600 hover:bg-red-500 text-white font-bold rounded-2xl shadow-xl transition-all">
                    Confirmar Expulsión
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalExpulsar(usuarioId, nombreCompleto) {
    document.getElementById('nombreMiembro').textContent = nombreCompleto;
    document.getElementById('formExpulsar').action = `/equipos/{{ $equipo->id_equipo }}/expulsar/${usuarioId}`;
    document.getElementById('modalExpulsar').classList.remove('hidden');
}

function cerrarModalExpulsar() {
    document.getElementById('modalExpulsar').classList.add('hidden');
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarModalExpulsar();
});
</script>
</x-app-layout>