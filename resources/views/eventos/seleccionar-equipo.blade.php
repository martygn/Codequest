<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-gray-900 mb-8">Seleccionar Equipo para {{ $evento->nombre }}</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-gray-600 mb-6">Tienes múltiples equipos aprobados. Selecciona uno para inscribir en este evento:</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($equiposAprobados as $equipo)
                            <form action="{{ route('eventos.seleccionar-equipo', $evento->id_evento) }}" method="POST" class="block">
                                @csrf
                                <input type="hidden" name="equipo_id" value="{{ $equipo->id_equipo }}">

                                <button type="submit"
                                        class="w-full bg-white border border-gray-200 rounded-lg p-6 hover:bg-gray-50 hover:border-blue-300 transition-colors text-left">
                                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $equipo->nombre }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $equipo->nombre_proyecto }}</p>
                                    <p class="text-sm text-gray-500">
                                        Miembros: {{ $equipo->participantes()->count() }} / 4
                                    </p>
                                </button>
                            </form>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('eventos.show', $evento->id_evento) }}"
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            ← Volver al evento
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
