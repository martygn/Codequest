<x-app-layout>
    <div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Mis Equipos</h2>
                <p class="text-sm text-[#8892B0]">Gestiona tus equipos y participaciones</p>
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
                        <div style="background-color: #112240;" class="overflow-hidden shadow-sm sm:rounded-lg border border-[#233554]">
                            <div class="p-8">
                                @php
                                    $estadoColors = [
                                        'en revisión' => 'bg-yellow-100 text-yellow-800',
                                        'aprobado' => 'bg-green-100 text-green-800',
                                        'rechazado' => 'bg-red-100 text-red-800',
                                    ];
                                    $now = \Carbon\Carbon::now();
                                    $eventoEnCurso = $miEquipo->evento && $now->between($miEquipo->evento->fecha_inicio, $miEquipo->evento->fecha_fin);
                                    $tieneProyectoSubido = $miEquipo->repositorio && $miEquipo->repositorio->estado === 'enviado';
                                @endphp

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
                                        <p class="text-[#8892B0] max-w-2xl">{{ $miEquipo->descripcion ?? 'Sin descripción disponible.' }}</p>

                                        <div class="mt-4 flex items-center gap-2">
                                            <span class="text-xs font-bold text-[#64FFDA] uppercase tracking-wider">Código de Acceso:</span>
                                            <code class="bg-[#0A192F] px-3 py-1 rounded text-[#CCD6F6] font-mono font-bold border border-[#233554] select-all">
                                                {{ $miEquipo->codigo ?? 'N/A' }}
                                            </code>
                                        </div>
                                    </div>

                                    <div class="mt-4 md:mt-0 flex items-center gap-2">
                                        <button type="button" onclick="openConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')" class="inline-flex items-center px-4 py-2 bg-red-500/10 text-red-400 border border-red-500/20 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-500/20 focus:outline-none transition ease-in-out duration-150">
                                            Salir del Equipo
                                        </button>

                                    @if($miEquipo->id_lider == $user->id && $eventoEnCurso)
                                        @if($tieneProyectoSubido)
                                            <!-- Botón para VER PROYECTO (si ya subió) -->
                                            <a href="{{ route('proyecto.create', $miEquipo) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition ml-3">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Ver Proyecto
                                            </a>
                                        @else
                                            <!-- Botón para SUBIR PROYECTO (si no ha subido) -->
                                            <a href="{{ route('proyecto.create', $miEquipo) }}"
                                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition ml-3">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Subir Proyecto
                                            </a>
                                        @endif
                                    @endif
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

                                                            {{-- Identificar Líder --}}
                                                            @if(isset($miEquipo->id_lider) && $miEquipo->id_lider == $miembro->id)
                                                                <span class="ml-1 text-xs font-bold text-yellow-400" title="Líder">★</span>
                                                            @endif
                                                        </div>

                                                        {{-- Botón Expulsar (Solo líder) --}}
                                                        @if($miEquipo->participantes()->wherePivot('usuario_id', $user->id)->wherePivot('posicion', 'Líder')->exists() && $miembro->id !== $user->id)
                                                            <button type="button" onclick="abrirModalExpulsar{{ $miEquipo->id_equipo }}({{ $miembro->id }}, '{{ addslashes($miembro->name) }}')"
                                                                class="ml-2 px-2 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200 transition">
                                                                Expulsar
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
                                        <div class="mb-4">
                                            <p class="text-sm font-bold text-[#8892B0]">Nombre del Proyecto</p>
                                            <p class="text-white">{{ $miEquipo->nombre_proyecto ?? 'Aún no definido' }}</p>

                                            <!-- Estado del proyecto -->
                                            @if($tieneProyectoSubido)
                                                <div class="mt-2">
                                                    @if($miEquipo->repositorio->calificacion_total)
                                                        <div class="inline-flex items-center px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-sm border border-green-500/20">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Calificado: {{ $miEquipo->repositorio->calificacion_total }}/100
                                                        </div>
                                                    @else
                                                        <div class="inline-flex items-center px-3 py-1 bg-yellow-500/10 text-yellow-400 rounded-full text-sm border border-yellow-500/20">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            En espera de evaluación
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
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
                                    <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6">
                                        <h4 class="text-lg font-bold text-yellow-900 mb-4 flex items-center">
                                            <span class="material-symbols-outlined mr-2">mail</span>
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

                                                    <div class="flex gap-2 ml-4">
                                                        <form action="{{ route('equipos.aceptar-solicitud-lider', [$miEquipo->id_equipo, $solicitante->id]) }}" method="POST" class="inline">
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
                                            <p class="text-gray-700 mb-4">¿Estás seguro de que deseas expulsar a <strong id="miembroNombre{{ $miEquipo->id_equipo }}"></strong> del equipo?</p>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Razón de expulsión (opcional)</label>
                                                <textarea name="razon" placeholder="Especifica el motivo de la expulsión..."
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-red-500" rows="3"></textarea>
                                            </div>

                                            <div class="flex gap-3">
                                                <button type="button" onclick="cerrarModalExpulsar{{ $miEquipo->id_equipo }}()"
                                                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                                                    Cancelar
                                                </button>
                                                <button type="submit"
                                                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition">
                                                    Expulsar
                                                </button>
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
                {{-- ESTADO: USUARIO SIN EQUIPOS --}}
                <div style="background-color: #112240;" class="overflow-hidden shadow-sm sm:rounded-lg border border-[#233554]">
                    <div class="p-8">
                        <div class="text-center py-16">
                            <div class="h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #1A3A52;">
                                <span class="material-symbols-outlined text-5xl text-[#64FFDA]">groups</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">¡Aún no tienes equipos!</h3>
                            <p class="text-[#8892B0] mb-8 max-w-md mx-auto">
                                Para participar en los hackathons necesitas unirte a un equipo existente o crear el tuyo propio.
                            </p>

                            <div class="flex justify-center gap-4">
                                <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-[#0A192F] bg-[#64FFDA] hover:opacity-80 shadow-lg transition duration-150 ease-in-out">
                                    <span class="material-symbols-outlined mr-2">search</span>
                                    Buscar Equipo
                                </a>
                                <a href="{{ route('equipos.create') }}" class="inline-flex items-center px-6 py-3 border border-[#233554] text-base font-medium rounded-md text-[#64FFDA] bg-[#0A192F] hover:bg-[#1A2F47] shadow-sm transition duration-150 ease-in-out">
                                    <span class="material-symbols-outlined mr-2">add</span>
                                    Crear Equipo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function openConfirmModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeConfirmModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>
