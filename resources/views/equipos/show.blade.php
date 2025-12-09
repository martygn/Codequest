<x-app-layout>
    <div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Banner del equipo --}}
            <div class="mb-8 rounded-2xl overflow-hidden shadow-2xl border border-[#233554] relative group">
                @if($equipo->banner)
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] to-transparent opacity-60 z-10"></div>
                    <img src="{{ asset('storage/' . $equipo->banner) }}"
                         alt="Banner del equipo {{ $equipo->nombre }}"
                         class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-105"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    
                    <div class="w-full h-64 bg-[#112240] flex items-center justify-center hidden relative z-0">
                         <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                         <h1 class="text-5xl font-bold text-[#CCD6F6] z-10">{{ $equipo->nombre }}</h1>
                    </div>
                @else
                    <div class="w-full h-64 bg-[#112240] flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                        <div class="absolute top-[-50%] right-[-10%] w-[300px] h-[300px] bg-[#64FFDA] rounded-full mix-blend-overlay filter blur-[100px] opacity-10"></div>
                        <h1 class="text-5xl font-bold text-[#CCD6F6] z-10">{{ $equipo->nombre }}</h1>
                    </div>
                @endif
                
                @if($equipo->banner)
                <div class="absolute bottom-6 left-6 z-20">
                    <h1 class="text-4xl font-bold text-white drop-shadow-md">{{ $equipo->nombre }}</h1>
                </div>
                @endif
            </div>

            {{-- Mensajes Flash --}}
            @if(session('success') || session('error') || session('info'))
                <div class="space-y-4 mb-8">
                    @if(session('success'))
                        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-center gap-2">
                            <span class="material-symbols-outlined">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 px-4 py-3 rounded-xl flex items-center gap-2">
                            <span class="material-symbols-outlined">info</span>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554]">
                <div class="p-8">

                    {{-- Header Interno (Estado y Evento) --}}
                    <div class="mb-8 border-b border-[#233554] pb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            @if($equipo->evento)
                                <div class="flex items-center text-[#64FFDA] font-mono text-sm mb-1">
                                    <span class="material-symbols-outlined text-base mr-1">event</span>
                                    {{ $equipo->evento->nombre }}
                                </div>
                            @else
                                <div class="flex items-center text-[#8892B0] font-mono text-sm mb-1">
                                    <span class="material-symbols-outlined text-base mr-1">event_busy</span>
                                    Sin evento asignado
                                </div>
                            @endif
                            <h2 class="text-xl font-bold text-[#CCD6F6]">Detalles del Equipo</h2>
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
                            <span class="inline-flex items-center px-4 py-2 rounded-lg border {{ $claseEstado }} font-bold uppercase text-xs tracking-wider">
                                {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- Columna Izquierda: Info --}}
                        <div class="lg:col-span-2 space-y-8">
                            
                            {{-- Proyecto --}}
                            <div class="bg-[#0A192F] p-6 rounded-xl border border-[#233554]">
                                <h3 class="text-xs font-mono text-[#64FFDA] uppercase mb-2">Proyecto</h3>
                                <p class="text-xl font-bold text-white">{{ $equipo->nombre_proyecto ?? 'Sin nombre de proyecto' }}</p>
                            </div>

                            {{-- Descripción --}}
                            <div>
                                <h3 class="text-lg font-bold text-[#CCD6F6] mb-3 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[#64FFDA]">description</span> Descripción
                                </h3>
                                <div class="bg-[#0A192F] rounded-xl p-6 border border-[#233554] text-[#8892B0] leading-relaxed whitespace-pre-line">
                                    {{ $equipo->descripcion ?? 'Sin descripción disponible.' }}
                                </div>
                            </div>

                            {{-- Líder --}}
                            @if($equipo->lider)
                            <div>
                                <h3 class="text-lg font-bold text-[#CCD6F6] mb-3 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[#64FFDA]">military_tech</span> Líder del Equipo
                                </h3>
                                <div class="bg-[#0A192F] rounded-xl p-4 border border-[#233554] flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-[#112240] border border-[#64FFDA] flex items-center justify-center text-[#64FFDA] font-bold text-lg">
                                        {{ strtoupper(substr($equipo->lider->nombre, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $equipo->lider->nombre_completo }}</p>
                                        <p class="text-sm text-[#8892B0]">{{ $equipo->lider->correo }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>

                        {{-- Columna Derecha: Miembros --}}
                        <div class="space-y-8">
                            
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-bold text-[#CCD6F6]">Integrantes</h3>
                                    <span class="text-xs font-mono text-[#64FFDA] bg-[#64FFDA]/10 px-2 py-1 rounded border border-[#64FFDA]/20">
                                        {{ $equipo->participantes()->count() }} / 4
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    @if($equipo->participantes()->count() == 0)
                                        <div class="p-4 bg-[#0A192F] border border-dashed border-[#233554] rounded-xl text-center text-[#8892B0] text-sm">
                                            Sin integrantes aún.
                                        </div>
                                    @else
                                        @foreach($equipo->participantes as $participante)
                                            <div class="bg-[#0A192F] p-3 rounded-xl border border-[#233554] flex items-center justify-between group hover:border-[#64FFDA] transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-[#112240] border border-[#233554] flex items-center justify-center text-[#8892B0] font-bold text-sm">
                                                        {{ strtoupper(substr($participante->nombre, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-[#CCD6F6]">{{ $participante->nombre_completo }}</p>
                                                        
                                                        {{-- Badge Rol --}}
                                                        @php $rol = $participante->pivot->posicion; @endphp
                                                        @if($rol === 'Líder')
                                                            <span class="text-[10px] text-yellow-400 bg-yellow-400/10 px-1.5 rounded border border-yellow-400/20">Líder</span>
                                                        @else
                                                            <span class="text-[10px] text-[#64FFDA] bg-[#64FFDA]/10 px-1.5 rounded border border-[#64FFDA]/20">{{ $rol ?? 'Miembro' }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Botón Expulsar (Solo líder) --}}
                                                @php
                                                    $usuarioActual = auth()->user();
                                                    $esLider = $equipo->esLider($usuarioActual->id);
                                                @endphp
                                                @if($esLider && $participante->id !== $usuarioActual->id)
                                                    <button onclick="abrirModalExpulsar({{ $participante->id }}, '{{ $participante->nombre_completo }}')" 
                                                            class="text-[#8892B0] hover:text-red-400 transition-colors p-1" title="Expulsar">
                                                        <span class="material-symbols-outlined text-lg">person_remove</span>
                                                    </button>
                                                @endif
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
                                <div class="bg-yellow-500/5 border border-yellow-500/20 rounded-xl p-4">
                                    <h4 class="text-sm font-bold text-yellow-400 mb-3 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base">notifications</span> Solicitudes
                                    </h4>
                                    
                                    <div class="space-y-3">
                                        @foreach($solicitudesPendientes as $usuarioId)
                                            @php $solicitante = App\Models\Usuario::find($usuarioId); @endphp
                                            @if($solicitante)
                                                <div class="bg-[#0A192F] p-3 rounded-lg border border-[#233554]">
                                                    <div class="mb-2">
                                                        <p class="text-sm font-bold text-white">{{ $solicitante->nombre_completo }}</p>
                                                        <p class="text-xs text-[#8892B0]">{{ $solicitante->correo }}</p>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <form action="{{ route('equipos.aceptar-solicitud-lider', [$equipo->id_equipo, $solicitante->id]) }}" method="POST" class="w-1/2">
                                                            @csrf
                                                            <button type="submit" class="w-full bg-green-500/20 text-green-400 text-xs font-bold py-1.5 rounded hover:bg-green-500/30 border border-green-500/30 transition-colors">Aceptar</button>
                                                        </form>
                                                        <form action="{{ route('equipos.rechazar-solicitud-lider', [$equipo->id_equipo, $solicitante->id]) }}" method="POST" class="w-1/2">
                                                            @csrf
                                                            <button type="submit" class="w-full bg-red-500/20 text-red-400 text-xs font-bold py-1.5 rounded hover:bg-red-500/30 border border-red-500/30 transition-colors">Rechazar</button>
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

                    {{-- Acciones Generales --}}
                    <div class="mt-12 pt-6 border-t border-[#233554] flex flex-wrap items-center justify-between gap-4">
                        
                        <a href="{{ route('equipos.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-[#0A192F] border border-[#233554] rounded-lg text-[#8892B0] hover:text-white hover:border-[#64FFDA] transition-all font-medium text-sm">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Volver
                        </a>

                        <div class="flex flex-wrap items-center gap-3">
                            {{-- Salir del equipo --}}
                            @if($equipo->tieneMiembro(auth()->id()))
                                <form action="{{ route('equipos.salir', $equipo->id_equipo) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg hover:bg-red-500/20 transition-all font-bold text-sm flex items-center gap-2" onclick="return confirm('¿Seguro que deseas salir?')">
                                        <span class="material-symbols-outlined text-lg">logout</span> Salir
                                    </button>
                                </form>
                            @endif

                            {{-- Solicitar Unirse --}}
                            @if(auth()->user()->tipo === 'participante' &&
                                !$equipo->tieneMiembro(auth()->id()) &&
                                !$equipo->tieneSolicitudPendiente(auth()->id()) &&
                                $equipo->participantes()->count() < 4 &&
                                $equipo->estaAprobado())
                                <form action="{{ route('equipos.solicitar-unirse', $equipo->id_equipo) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-5 py-2.5 bg-[#64FFDA] text-[#0A192F] font-bold rounded-lg hover:bg-[#52d6b3] shadow-lg transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">person_add</span> Solicitar Unirse
                                    </button>
                                </form>
                            @endif

                            {{-- Admin Actions --}}
                            @if(auth()->user()->esAdministrador())
                                @if(!$equipo->estaAprobado())
                                    <form action="{{ route('equipos.aprobar', $equipo->id_equipo) }}" method="POST"> @csrf 
                                        <button class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white font-bold rounded-lg transition-colors">Aprobar</button> 
                                    </form>
                                    <form action="{{ route('equipos.rechazar', $equipo->id_equipo) }}" method="POST"> @csrf 
                                        <button class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-bold rounded-lg transition-colors">Rechazar</button> 
                                    </form>
                                @endif
                                
                                {{-- Asignar Evento --}}
                                <form action="{{ route('equipos.asignar-evento', $equipo->id_equipo) }}" method="POST" class="flex items-center gap-2 bg-[#0A192F] p-1 rounded-lg border border-[#233554]">
                                    @csrf
                                    <select name="id_evento" class="bg-transparent text-[#CCD6F6] text-sm border-none focus:ring-0 outline-none w-40">
                                        <option value="" class="bg-[#0A192F]">Asignar Evento...</option>
                                        @foreach(App\Models\Evento::where('fecha_fin', '>=', now())->get() as $evento)
                                            <option value="{{ $evento->id_evento }}" class="bg-[#0A192F]" {{ $equipo->id_evento == $evento->id_evento ? 'selected' : '' }}>
                                                {{ Str::limit($evento->nombre, 20) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-[#64FFDA]/10 text-[#64FFDA] hover:bg-[#64FFDA] hover:text-[#0A192F] p-1.5 rounded transition-all">
                                        <span class="material-symbols-outlined text-lg">save</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE EXPULSIÓN (Dark Mode) --}}
    <div id="modalExpulsar" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-[#112240] border border-[#233554] rounded-2xl shadow-2xl p-6 w-96 transform scale-100 transition-all">
            <h3 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-400">warning</span> Expulsar Miembro
            </h3>
            <p class="text-[#8892B0] text-sm mb-6">¿Confirmas la expulsión de <span id="nombreMiembro" class="text-[#64FFDA] font-bold"></span>?</p>
            
            <form id="formExpulsar" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-mono text-[#64FFDA] uppercase mb-1">Motivo (Opcional)</label>
                    <textarea name="razon" placeholder="Escribe la razón..." 
                        class="w-full bg-[#0A192F] border border-[#233554] rounded-lg p-3 text-[#CCD6F6] text-sm focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none resize-none h-20"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="cerrarModalExpulsar()" 
                        class="px-4 py-2 border border-[#233554] rounded-lg text-[#8892B0] hover:text-white hover:bg-[#233554] text-sm font-medium transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 text-sm font-bold shadow-lg transition-colors">
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

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') cerrarModalExpulsar();
    });
    </script>
</x-app-layout>