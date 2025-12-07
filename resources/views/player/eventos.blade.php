<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Eventos') }}
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
                
                    @if(count($misEventos) > 0)
                        {{-- CASO 1: HAY EVENTOS --}}
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Eventos Activos</h3>
                                <p class="text-gray-500">Eventos en los que tu equipo está participando actualmente.</p>
                            </div>
                            <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full font-bold shadow-sm">
                                {{ count($misEventos) }} Inscrito(s)
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($misEventos as $evento)
                                <div class="group border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 bg-white flex flex-col h-full transform hover:-translate-y-1">
                                    {{-- Imagen del evento (placeholder si no hay) --}}
                                    <div class="h-40 bg-gradient-to-r from-indigo-500 to-purple-600 relative overflow-hidden">
                                        @if($evento->foto)
                                            <img src="{{ Storage::url($evento->foto) }}" alt="{{ $evento->nombre }}" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="flex items-center justify-center h-full text-white opacity-30">
                                                <span class="material-symbols-outlined text-6xl">event</span>
                                            </div>
                                        @endif
                                        
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow-md flex items-center">
                                                <span class="material-symbols-outlined text-xs mr-1">check_circle</span> Inscrito
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-5 flex-1 flex flex-col">
                                        <h4 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors leading-tight">
                                            {{ $evento->nombre }}
                                        </h4>
                                        
                                        <div class="text-sm text-gray-500 mb-4 flex-1">
                                            {{ Str::limit($evento->descripcion, 100) }}
                                        </div>
                                        
                                        <div class="border-t border-gray-100 pt-4 mt-auto space-y-2">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <span class="material-symbols-outlined text-lg mr-2 text-indigo-500">calendar_month</span>
                                                <span class="font-medium">Inicio:</span>&nbsp;{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M, Y') }}
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                                <span class="material-symbols-outlined text-lg mr-2 text-indigo-500">location_on</span>
                                                <span>{{ $evento->lugar ?? 'Online' }}</span>
                                            </div>

                                            <a href="{{ route('eventos.show', $evento->id_evento) }}" class="block w-full text-center bg-gray-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-bold py-2 rounded-lg border border-gray-200 hover:border-indigo-600 transition-all duration-200">
                                                Ver Detalles
                                            </a>
                                            @if(isset($equiposPorEvento) && isset($equiposPorEvento[$evento->id_evento]) && $equiposPorEvento[$evento->id_evento]->id_lider == auth()->id())
                                                @php $equipoInscrito = $equiposPorEvento[$evento->id_evento]; @endphp
                                                <form action="{{ route('equipos.quitar-evento', $equipoInscrito) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="w-full text-center bg-red-50 hover:bg-red-600 hover:text-white text-red-700 font-bold py-2 rounded-lg border border-red-200 hover:border-red-600 transition-all duration-200">
                                                        Salir del evento
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        {{-- CASO 2: NO HAY EVENTOS --}}
                        <div class="text-center py-16">
                            <div class="bg-gray-50 h-24 w-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-symbols-outlined text-5xl text-gray-400">event_busy</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No estás inscrito en eventos</h3>
                            
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                                @if($miEquipo)
                                    Tu equipo <strong>{{ $miEquipo->nombre }}</strong> no participa en ningún evento activo actualmente.
                                @else
                                    Primero debes unirte a un equipo para poder inscribirte en los eventos y hackathons.
                                @endif
                            </p>
                            
                            <div class="flex justify-center">
                                @if($soyLider)
                                    <div class="text-center">
                                        <p class="text-sm text-indigo-600 font-medium mb-3 bg-indigo-50 py-1 px-3 rounded-full inline-block">
                                            ✨ ¡Eres líder! Puedes inscribir a tu equipo.
                                        </p>
                                        <br>
                                        <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition duration-150 ease-in-out">
                                            <span class="material-symbols-outlined mr-2">explore</span>
                                            Explorar Eventos Disponibles
                                        </a>
                                    </div>
                                @elseif(!$miEquipo)
                                     <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition duration-150 ease-in-out">
                                        <span class="material-symbols-outlined mr-2">group_add</span>
                                        Buscar Equipo Primero
                                    </a>
                                @else
                                    <div class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest cursor-not-allowed">
                                        <span class="material-symbols-outlined text-sm mr-2">hourglass_empty</span>
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