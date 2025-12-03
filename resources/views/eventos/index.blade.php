<x-app-layout>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-start mb-16">
                <div class="max-w-2xl">
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Eventos Disponibles</h1>
                    <p class="mt-4 text-lg text-gray-500">
                        Explora los próximos eventos de programación y regístrate para competir.
                    </p>
                </div>
                
                <a href="{{ route('eventos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                    Crear Evento
                </a>
            </div>

            <div class="space-y-20"> @forelse ($eventos as $evento)
                    <div class="flex flex-col md:flex-row items-center gap-10">
                        
                        <div class="w-full md:w-1/2 space-y-4">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $evento->nombre }}
                            </h2>
                            
                            <p class="text-gray-600 text-base leading-relaxed">
                                {{-- Cortamos la descripción si es muy larga para mantener el diseño limpio --}}
                                {{ Str::limit($evento->descripcion, 150) }}
                            </p>

                            <div class="pt-2">
                                <a href="{{ route('eventos.show', $evento->id_evento) }}" 
                                   class="inline-flex items-center justify-center px-6 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 transition duration-150">
                                    Inscribirse
                                </a>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2">
                            <div class="relative rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                @if($evento->foto)
                                    <img src="{{ asset('storage/' . $evento->foto) }}" 
                                         alt="{{ $evento->nombre }}" 
                                         class="w-full h-64 object-cover transform hover:scale-105 transition duration-500 ease-in-out">
                                @else
                                    <div class="w-full h-64 bg-green-100 flex items-center justify-center text-green-800">
                                        <svg class="w-20 h-20 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-20">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay eventos disponibles</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza creando uno nuevo.</p>
                        <div class="mt-6">
                            <a href="{{ route('eventos.create') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                                Crear un evento &rarr;
                            </a>
                        </div>
                    </div>
                @endforelse

            </div>

            <div class="mt-12">
                {{ $eventos->links() }}
            </div>

        </div>
    </div>
</x-app-layout>