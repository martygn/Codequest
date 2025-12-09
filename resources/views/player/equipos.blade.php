<x-app-layout>
    <div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Encabezado --}}
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-[#112240] rounded-xl flex items-center justify-center border border-[#233554] shadow-lg">
                    <span class="material-symbols-outlined text-[#64FFDA] text-2xl">groups</span>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Mis Equipos</h2>
                    <p class="text-sm text-[#8892B0]">Gestiona tus equipos y participaciones</p>
                </div>
            </div>

            {{-- Mensajes Flash --}}
            @if(session('success') || session('error'))
                <div class="space-y-4 mb-8">
                    @if(session('success'))
                        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 shadow-lg animate-pulse">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-center gap-2 shadow-lg animate-pulse">
                            <span class="material-symbols-outlined">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            @if($misEquipos->count() > 0)
                {{-- LISTA DE EQUIPOS --}}
                <div class="space-y-8">
                    @foreach($misEquipos as $miEquipo)
                        <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554] transition-all hover:border-[#64FFDA]/30">
                            
                            @php
                                $estadoColor = match($miEquipo->estado) {
                                    'aprobado' => 'bg-green-500',
                                    'rechazado' => 'bg-red-500',
                                    default => 'bg-yellow-500'
                                };
                            @endphp
                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $estadoColor }}"></div>

                            <div class="p-8 relative">
                                
                                {{-- Header del Equipo --}}
                                <div class="md:flex justify-between items-start mb-8 border-b border-[#233554] pb-6">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-3xl font-bold text-white">{{ $miEquipo->nombre }}</h3>
                                            @php
                                                $estadoBadge = match($miEquipo->estado) {
                                                    'aprobado' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                                    'rechazado' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                                    default => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'
                                                };
                                            @endphp
                                            <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide border {{ $estadoBadge }}">
                                                {{ ucfirst($miEquipo->estado ?? 'Activo') }}
                                            </span>
                                        </div>
                                        <p class="text-[#8892B0] max-w-2xl text-sm">{{ $miEquipo->descripcion ?? 'Sin descripción disponible.' }}</p>
                                        
                                        <div class="mt-4 flex items-center gap-2">
                                            <span class="text-xs font-bold text-[#64FFDA] uppercase tracking-wider">Código de Acceso:</span>
                                            <code class="bg-[#0A192F] px-3 py-1 rounded text-[#CCD6F6] font-mono font-bold border border-[#233554] select-all">
                                                {{ $miEquipo->codigo ?? 'N/A' }}
                                            </code>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6 md:mt-0">
                                        <button type="button" onclick="openConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')" class="inline-flex items-center px-4 py-2 bg-red-500/10 text-red-400 border border-red-500/30 rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-red-500/20 transition-all">
                                            <span class="material-symbols-outlined text-lg mr-1">logout</span> Salir del Equipo
                                        </button>

                                        <div id="salirEquipo{{ $miEquipo->id_equipo }}" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50 backdrop-blur-sm" onclick="if(event.target === this) closeConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')">
                                            <div class="bg-[#112240] border border-[#233554] rounded-xl shadow-2xl max-w-md w-full mx-4" onclick="event.stopPropagation()">
                                                <div class="px-6 py-4 border-b border-[#233554]">
                                                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-red-400">warning</span> Confirmar acción
                                                    </h3>
                                                </div>
                                                <div class="px-6 py-4">
                                                    <p class="text-[#8892B0]">¿Estás seguro de que quieres abandonar este equipo? Esta acción no se puede deshacer.</p>
                                                </div>
                                                <div class="px-6 py-4 border-t border-[#233554] flex justify-end gap-3">
                                                    <button type="button" onclick="closeConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')" class="px-4 py-2 text-[#8892B0] hover:text-white border border-[#233554] rounded-lg text-sm font-bold transition-colors">
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('player.equipos.salir') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="equipo_id" value="{{ $miEquipo->id_equipo }}">
                                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 font-bold text-sm transition-colors shadow-lg">
                                                            Abandonar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    
                                    <div>
                                        <h4 class="text-sm font-bold text-[#64FFDA] uppercase tracking-wider mb-4 flex items-center gap-2">
                                            <span class="material-symbols-outlined">group</span> Integrantes
                                        </h4>
                                        <ul class="space-y-3">
                                            @foreach($miEquipo->participantes as $miembro)
                                                <li class="flex items-center justify-between p-3 rounded-xl border border-[#233554] {{ $miembro->id === $user->id ? 'bg-[#0A192F]/80 border-[#64FFDA]/30' : 'bg-[#0A192F]/40' }}">
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 rounded-full bg-[#112240] border border-[#233554] flex items-center justify-center text-[#64FFDA] font-bold mr-3 shadow-inner">
                                                            {{ strtoupper(substr($miembro->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-white flex items-center gap-2">
                                                                {{ $miembro->name }}
                                                                @if($miembro->id === $user->id) <span class="text-[10px] text-[#64FFDA] bg-[#64FFDA]/10 px-1.5 rounded border border-[#64FFDA]/20">Tú</span> @endif
                                                            </p>
                                                            <p class="text-xs text-[#8892B0]">{{ $miembro->email }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-2">
                                                        <div class="text-right">
                                                            @if(isset($miembro->pivot->posicion))
                                                                <span class="text-[10px] font-bold px-2 py-1 rounded bg-[#112240] border border-[#233554] text-[#8892B0]">
                                                                    {{ $miembro->pivot->posicion }}
                                                                </span>
                                                            @endif
                                                            
                                                            @if(isset($miEquipo->id_lider) && $miEquipo->id_lider == $miembro->id)
                                                                <span class="ml-1 text-xs font-bold text-yellow-400" title="Líder">★</span>
                                                            @endif
                                                        </div>

                                                        {{-- Botón Expulsar (Solo líder) --}}
                                                        @if($miEquipo->participantes()->wherePivot('usuario_id', $user->id)->wherePivot('posicion', 'Líder')->exists() && $miembro->id !== $user->id)
                                                            <button type="button" onclick="abrirModalExpulsar{{ $miEquipo->id_equipo }}({{ $miembro->id }}, '{{ addslashes($miembro->name) }}')" 
                                                                    class="ml-2 p-1.5 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-colors" title="Expulsar">
                                                                <span class="material-symbols-outlined text-base">person_remove</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="bg-[#0A192F] p-6 rounded-xl border border-[#233554]">
                                        <h4 class="text-sm font-bold text-[#64FFDA] uppercase tracking-wider mb-4 flex items-center gap-2">
                                            <span class="material-symbols-outlined">rocket_launch</span> Proyecto
                                        </h4>
                                        
                                        <div class="mb-6">
                                            <p class="text-xs font-mono text-[#8892B0] mb-1">NOMBRE DEL PROYECTO</p>
                                            <p class="text-lg font-bold text-white">{{ $miEquipo->nombre_proyecto ?? 'Aún no definido' }}</p>
                                        </div>
                                        
                                        <div>
                                            @if($miEquipo->evento)
                                                <p class="text-xs font-mono text-[#8892B0] mb-1">EVENTO</p>
                                                <a href="{{ route('eventos.show', $miEquipo->evento->id_evento) }}"
                                                   class="text-[#64FFDA] hover:text-white font-bold text-lg hover:underline decoration-[#64FFDA] decoration-2 underline-offset-4 transition-all">
                                                    {{ $miEquipo->evento->nombre }}
                                                </a>
                                            @else
                                                <div class="bg-yellow-500/10 border border-yellow-500/20 p-3 rounded-lg text-xs text-yellow-200/80 flex items-start gap-2">
                                                    <span class="material-symbols-outlined text-base text-yellow-400">warning</span>
                                                    Este equipo aún no está inscrito en ningún evento.
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                {{-- Solicitudes Pendientes (Líder) --}}
                                @php
                                    $solicitudesPendientes = $miEquipo->solicitudes_pendientes ?? [];
                                    $esLiderDelEquipo = $miEquipo->participantes()->wherePivot('usuario_id', $user->id)->wherePivot('posicion', 'Líder')->exists();
                                @endphp
                                @if($esLiderDelEquipo && count($solicitudesPendientes) > 0)
                                    <div class="mt-8 bg-yellow-500/5 border-l-4 border-yellow-500/50 rounded-r-lg p-6">
                                        <h4 class="text-sm font-bold text-yellow-400 mb-4 flex items-center gap-2">
                                            <span class="material-symbols-outlined">notifications_active</span> 
                                            Solicitudes Pendientes ({{ count($solicitudesPendientes) }})
                                        </h4>
                                        
                                        <div class="space-y-3">
                                            @foreach($solicitudesPendientes as $usuarioId)
                                                @php $solicitante = App\Models\Usuario::find($usuarioId); @endphp
                                                @if($solicitante)
                                                <div class="flex items-center justify-between p-4 bg-[#0A192F] rounded-lg border border-[#233554]">
                                                    <div class="flex items-center gap-3">
                                                        <div class="h-10 w-10 bg-[#112240] rounded-full flex items-center justify-center border border-[#233554]">
                                                            <span class="text-[#64FFDA] font-bold">{{ strtoupper(substr($solicitante->nombre, 0, 1)) }}</span>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-white text-sm">{{ $solicitante->nombre_completo }}</h4>
                                                            <p class="text-xs text-[#8892B0]">{{ $solicitante->correo }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <form action="{{ route('equipos.aceptar-solicitud-lider', [$miEquipo->id_equipo, $solicitante->id]) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1.5 bg-green-500/20 text-green-400 text-xs font-bold rounded hover:bg-green-500/30 border border-green-500/30 transition-colors">Aceptar</button>
                                                        </form>
                                                        <form action="{{ route('equipos.rechazar-solicitud-lider', [$miEquipo->id_equipo, $solicitante->id]) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1.5 bg-red-500/20 text-red-400 text-xs font-bold rounded hover:bg-red-500/30 border border-red-500/30 transition-colors">Rechazar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Modal Expulsión --}}
                                <div id="modalExpulsar{{ $miEquipo->id_equipo }}" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center backdrop-blur-sm" onclick="if(event.target === this) cerrarModalExpulsar{{ $miEquipo->id_equipo }}()">
                                    <div class="bg-[#112240] rounded-xl shadow-2xl max-w-md w-full mx-4 border border-[#233554]" onclick="event.stopPropagation()">
                                        <div class="px-6 py-4 border-b border-[#233554]">
                                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                                <span class="material-symbols-outlined text-red-400">person_remove</span> Expulsar Miembro
                                            </h3>
                                        </div>
                                        <form id="formExpulsar{{ $miEquipo->id_equipo }}" method="POST" class="p-6 space-y-4">
                                            @csrf
                                            <p class="text-[#8892B0] text-sm">¿Confirmas la expulsión de <strong id="miembroNombre{{ $miEquipo->id_equipo }}" class="text-[#64FFDA]"></strong>?</p>
                                            
                                            <div>
                                                <label class="block text-xs font-mono text-[#64FFDA] mb-2 uppercase">Motivo (Opcional)</label>
                                                <textarea name="razon" placeholder="Escribe la razón..." 
                                                    class="w-full bg-[#0A192F] border border-[#233554] rounded-lg p-3 text-[#CCD6F6] text-sm focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none resize-none h-20 placeholder-[#8892B0]/30"></textarea>
                                            </div>
                                            
                                            <div class="flex justify-end gap-3 pt-2">
                                                <button type="button" onclick="cerrarModalExpulsar{{ $miEquipo->id_equipo }}()" class="px-4 py-2 border border-[#233554] rounded-lg text-[#8892B0] hover:text-white text-sm font-bold transition-colors">Cancelar</button>
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 font-bold text-sm shadow-lg transition-colors">Expulsar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <script>
                                    function abrirModalExpulsar{{ $miEquipo->id_equipo }}(usuarioId, usuarioNombre) {
                                        document.getElementById('miembroNombre{{ $miEquipo->id_equipo }}').textContent = usuarioNombre;
                                        document.getElementById('formExpulsar{{ $miEquipo->id_equipo }}').action = '/mis-equipos/{{ $miEquipo->id_equipo }}/expulsar/' + usuarioId;
                                        document.getElementById('modalExpulsar{{ $miEquipo->id_equipo }}').classList.remove('hidden');
                                    }
                                    function cerrarModalExpulsar{{ $miEquipo->id_equipo }}() {
                                        document.getElementById('modalExpulsar{{ $miEquipo->id_equipo }}').classList.add('hidden');
                                    }
                                </script>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- ESTADO VACÍO --}}
                <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554]">
                    <div class="p-16 text-center">
                        <div class="bg-[#0A192F] h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6 border border-[#233554] shadow-inner">
                            <span class="material-symbols-outlined text-5xl text-[#64FFDA] opacity-50">groups_3</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">¡Aún no tienes equipos!</h3>
                        <p class="text-[#8892B0] mb-8 max-w-md mx-auto">Para participar en los hackathons necesitas unirte a un equipo existente o crear el tuyo propio.</p>
                        
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-6 py-3 bg-[#0A192F] border border-[#233554] text-[#64FFDA] font-bold rounded-xl hover:border-[#64FFDA] transition-all">
                                <span class="material-symbols-outlined mr-2">search</span> Buscar Equipo
                            </a>
                            <a href="{{ route('equipos.create') }}" class="inline-flex items-center px-6 py-3 bg-[#64FFDA] text-[#0A192F] font-bold rounded-xl hover:bg-[#52d6b3] shadow-lg transition-all transform hover:-translate-y-0.5">
                                <span class="material-symbols-outlined mr-2">add</span> Crear Equipo
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        // Funciones generales para modal de confirmación
        function openConfirmModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeConfirmModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('[id^="salirEquipo"]').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('[id^="modalExpulsar"]').forEach(el => el.classList.add('hidden'));
            }
        });
    </script>
</x-app-layout>