<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Eventos</h2>
                <p class="text-gray-500">Gestiona los eventos</p>
            </div>

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
                        </div>
                    </form>

                    <div class="flex space-x-8 border-b border-gray-200">
                        @php
                            $currentStatus = request('status', 'todos');
                        @endphp

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

                </div>
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
            </div>

        </div>
    </div>
</x-app-layout>