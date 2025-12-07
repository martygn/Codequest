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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    
                    @if($miEquipo)
                        {{-- ESTADO 1: USUARIO CON EQUIPO --}}
                        <div class="md:flex justify-between items-start mb-8 border-b border-gray-100 pb-6">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-3xl font-bold text-gray-900">{{ $miEquipo->nombre }}</h3>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full uppercase tracking-wide">
                                        {{ $miEquipo->estado ?? 'Activo' }}
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
                                <form action="{{ route('player.equipos.salir') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres abandonar este equipo? Esta acción no se puede deshacer.');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-100 focus:outline-none focus:border-red-300 focus:ring ring-red-200 active:bg-red-200 disabled:opacity-25 transition ease-in-out duration-150">
                                        <span class="material-symbols-outlined text-sm mr-2">
                                        Salir del Equipo
                                    </button>
                                </form>
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
                                        <a href="{{ route('eventos.show', $miEquipo->evento->id_evento) }}" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
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

                    @else
                        {{-- ESTADO 2: USUARIO SIN EQUIPO --}}
                        <div class="text-center py-16">
                            <div class="bg-indigo-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-5xl text-indigo-400">groups</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">¡Aún no tienes equipo!</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                                Para participar en los hackathons necesitas unirte a un equipo existente o crear el tuyo propio.
                            </p>
                            
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition duration-150 ease-in-out">
                                    <span class="material-symbols-outlined mr-2">search</span>
                                    Buscar Equipo
                                </a>
                                {{-- Si tienes la ruta de crear equipo disponible para usuarios, si no, quita este botón --}}
                                <a href="{{ route('equipos.create') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition duration-150 ease-in-out">
                                    <span class="material-symbols-outlined mr-2">add</span>
                                    Crear Equipo
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>