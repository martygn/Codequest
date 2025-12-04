<x-app-layout>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Eventos</h2>
                <p class="text-gray-500">Gestiona los eventos</p>
            </div>

            {{-- Botón para agregar evento solo para administradores --}}
            @if(auth()->user()->tipo === 'administrador')
            <div class="mb-6 flex justify-end">
                <a href="{{ route('eventos.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Evento
                </a>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200">
                <div class="p-6 bg-white">

                    <form method="GET" action="{{ route('eventos.index') }}" class="mb-6 relative">
                        <input type="hidden" name="status" value="{{ $status ?? 'todos' }}">

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Buscar eventos">
            
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

                        <a href="{{ route('eventos.index', ['status' => 'todos']) }}"
                           class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $currentStatus == 'todos' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Todos
                        </a>
                        <a href="{{ route('eventos.index', ['status' => 'pendiente']) }}"
                           class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $currentStatus == 'pendiente' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Pendientes
                        </a>
                        <a href="{{ route('eventos.index', ['status' => 'publicado']) }}"
                           class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $currentStatus == 'publicado' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Publicados
                        </a>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Nombre del Evento
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($eventos as $evento)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $evento->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                                        {{ $evento->fecha_inicio ? $evento->fecha_inicio->format('Y-m-d') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-4 py-1 inline-flex text-xs leading-5 font-bold rounded-md
                                            {{ ($evento->estado ?? 'pendiente') === 'pendiente' ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($evento->estado ?? 'pendiente') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('eventos.show', $evento->id_evento) }}" class="text-gray-500 hover:text-indigo-600 font-bold transition-colors">
                                            Revisar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        No se encontraron eventos en esta sección.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $eventos->links() }}
                </div>
            <div class="mt-12">
                {{ $eventos->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
