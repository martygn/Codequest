<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Mensaje de Error --}}
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($misEquipos->count() > 0)
                {{-- MOSTRAR TODOS LOS EQUIPOS --}}
                <div class="space-y-6">
                    @foreach($misEquipos as $miEquipo)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-8">
                                @php
                                    $estadoColors = [
                                        'en revisión' => 'bg-yellow-100 text-yellow-800',
                                        'aprobado' => 'bg-green-100 text-green-800',
                                        'rechazado' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                
                                <div class="md:flex justify-between items-start mb-8 border-b border-gray-100 pb-6">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-3xl font-bold text-gray-900">{{ $miEquipo->nombre }}</h3>
                                            <span class="px-3 py-1 {{ $estadoColors[$miEquipo->estado] ?? 'bg-gray-100 text-gray-800' }} text-xs font-semibold rounded-full uppercase tracking-wide">
                                                {{ ucfirst($miEquipo->estado ?? 'Activo') }}
                                            </span>
                                        </div>
                                        <p class="text-gray-500 max-w-2xl">{{ $miEquipo->descripcion ?? 'Sin descripción disponible.' }}</p>
                                        
                                        <div class="mt-4 flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-700">Código de Acceso:</span>
                                            <code class="bg-gray-100 px-2 py-1 rounded text-indigo-600 font-mono font-bold border border-gray-200">
                                                {{ $miEquipo->codigo ?? 'N/A' }}
                                            </code>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 md:mt-0">
                                        <button type="button" onclick="openConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-100 focus:outline-none focus:border-red-300 focus:ring ring-red-200 active:bg-red-200 disabled:opacity-25 transition ease-in-out duration-150">
                                            Salir del Equipo
                                        </button>

                                        <!-- Modal de Confirmación -->
                                        <div id="salirEquipo{{ $miEquipo->id_equipo }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="if(event.target === this) closeConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')">
                                            <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4" onclick="event.stopPropagation()">
                                                <div class="px-6 py-4 border-b border-gray-200">
                                                    <h3 class="text-lg font-bold text-gray-900">Confirmar acción</h3>
                                                </div>
                                                <div class="px-6 py-4">
                                                    <p class="text-gray-700">¿Estás seguro de que quieres abandonar este equipo? Esta acción no se puede deshacer.</p>
                                                </div>
                                                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                                                    <button type="button" onclick="closeConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 font-semibold transition">
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('player.equipos.salir') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="equipo_id" value="{{ $miEquipo->id_equipo }}">
                                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold transition">
                                                            Abandonar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Lista de Integrantes -->
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                            <span class="material-symbols-outlined mr-2">group</span> Integrantes
                                        </h4>
                                        <ul class="space-y-3">
                                            @foreach($miEquipo->participantes as $miembro)
                                                <li class="flex items-center justify-between p-3 rounded-lg {{ $miembro->id === $user->id ? 'bg-indigo-50 border border-indigo-100' : 'bg-gray-50' }}">
                                                    <div class="flex items-center">
                                                        <div class="h-8 w-8 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold mr-3">
                                                            {{ substr($miembro->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $miembro->name }}
                                                                @if($miembro->id === $user->id) <span class="text-xs text-indigo-600 font-bold">(Tú)</span> @endif
                                                            </p>
                                                            <p class="text-xs text-gray-500">{{ $miembro->email }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-2">
                                                        <div class="text-right">
                                                            @if(isset($miembro->pivot->posicion))
                                                                <span class="text-xs font-medium px-2 py-1 rounded bg-white border border-gray-200 text-gray-600">
                                                                    {{ $miembro->pivot->posicion }}
                                                                </span>
                                                            @endif
                                                            
                                                            {{-- Identificar Líder --}}
                                                            @if(isset($miEquipo->id_lider) && $miEquipo->id_lider == $miembro->id)
                                                                <span class="ml-1 text-xs font-bold text-yellow-600" title="Líder del equipo">★</span>
                                                            @endif
                                                        </div>

                                                        {{-- Botón de expulsión para líderes --}}
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

                                    <!-- Información del Proyecto/Evento -->
                                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                            <span class="material-symbols-outlined mr-2">rocket_launch</span> Proyecto
                                        </h4>
                                        <div class="mb-4">
                                            <p class="text-sm font-bold text-gray-600">Nombre del Proyecto</p>
                                            <p class="text-gray-900">{{ $miEquipo->nombre_proyecto ?? 'Aún no definido' }}</p>
                                        </div>
                                        
                                        @if($miEquipo->evento)
                                            <div>
                                                <p class="text-sm font-bold text-gray-600">Participando en Evento</p>
                                                <a href="{{ route('eventos.show', $miEquipo->evento) }}" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                                    {{ $miEquipo->evento->nombre }}
                                                </a>
                                            </div>
                                        @else
                                            <div class="bg-yellow-50 border border-yellow-100 p-3 rounded text-sm text-yellow-700">
                                                Este equipo aún no está inscrito en ningún evento.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Sección de solicitudes pendientes para el líder --}}
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
                                                @php
                                                    $solicitante = App\Models\Usuario::find($usuarioId);
                                                @endphp
                                                @if($solicitante)
                                                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-yellow-200 hover:shadow-md transition">
                                                    <div class="flex items-center flex-1">
                                                        <div class="h-10 w-10 rounded-full bg-yellow-200 flex items-center justify-center text-yellow-700 font-bold mr-4">
                                                            {{ strtoupper(substr($solicitante->nombre, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-gray-900">{{ $solicitante->nombre_completo }}</p>
                                                            <p class="text-xs text-gray-600">{{ $solicitante->correo }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex gap-2 ml-4">
                                                        <form action="{{ route('equipos.aceptar-solicitud-lider', [$miEquipo->id_equipo, $solicitante->id]) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 transition">
                                                                ✓ Aceptar
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('equipos.rechazar-solicitud-lider', [$miEquipo->id_equipo, $solicitante->id]) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition">
                                                                ✕ Rechazar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Modal de expulsión --}}
                                <div id="modalExpulsar{{ $miEquipo->id_equipo }}" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" onclick="if(event.target === this) cerrarModalExpulsar{{ $miEquipo->id_equipo }}()">
                                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" onclick="event.stopPropagation()">
                                        <div class="px-6 py-4 border-b border-gray-200">
                                            <h3 class="text-lg font-bold text-gray-900">Expulsar Miembro</h3>
                                        </div>
                                        <form id="formExpulsar{{ $miEquipo->id_equipo }}" method="POST" class="p-6">
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

                                    document.addEventListener('keydown', function(event) {
                                        if (event.key === 'Escape') {
                                            cerrarModalExpulsar{{ $miEquipo->id_equipo }}();
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                {{-- ESTADO: USUARIO SIN EQUIPOS --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <div class="text-center py-16">
                            <div class="bg-indigo-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-5xl text-indigo-400">groups</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">¡Aún no tienes equipos!</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                                Para participar en los hackathons necesitas unirte a un equipo existente o crear el tuyo propio.
                            </p>
                            
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition duration-150 ease-in-out">
                                    <span class="material-symbols-outlined mr-2">search</span>
                                    Buscar Equipo
                                </a>
                                <a href="{{ route('equipos.create') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition duration-150 ease-in-out">
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
</x-app-layout>