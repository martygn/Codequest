<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-700">Gestiona los eventos</h2>
            </div>

            {{-- Botón Agregar Evento (solo admins) --}}
            @if(auth()->user()->tipo === 'administrador')
            <div class="mb-6 flex justify-end">
                <a href="{{ route('eventos.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Evento
                </a>
            </div>
            @endif

            {{-- Panel con Buscador y Tabs --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200">
                <div class="p-6">
                    {{-- Buscador --}}
                    <form method="GET" action="{{ route('eventos.index') }}" class="mb-6">
                        <input type="hidden" name="status" value="{{ $currentStatus ?? 'todos' }}">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Buscar eventos">
                        </div>
                    </form>

                    {{-- Tabs --}}
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('eventos.index', ['status' => 'todos']) }}"
                               class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors
                               {{ $currentStatus == 'todos' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Todos
                            </a>
                            <a href="{{ route('eventos.index', ['status' => 'pendiente']) }}"
                               class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors
                               {{ $currentStatus == 'pendiente' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Pendientes
                            </a>
                            <a href="{{ route('eventos.index', ['status' => 'publicado']) }}"
                               class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors
                               {{ $currentStatus == 'publicado' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                Publicados
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            {{-- Tabla de Eventos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Nombre del Evento
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($eventos as $evento)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $evento->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-blue-600 font-medium">
                                            {{ $evento->fecha_inicio ? $evento->fecha_inicio->format('Y-m-d') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-md
                                            {{ ($evento->estado ?? 'pendiente') === 'pendiente' ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($evento->estado ?? 'Pendiente') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <a href="{{ route('eventos.show', $evento) }}"
                                           class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                                            Revisar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="text-sm">No se encontraron eventos en esta sección.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($eventos->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $eventos->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
