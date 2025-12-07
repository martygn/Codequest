<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Equipos</h2>
                <p class="text-gray-500">Gestiona los equipos y sus proyectos</p>
            </div>

            {{-- Botón para agregar equipo para participantes y administradores --}}
            <div class="mb-6 flex justify-end">
                <a href="{{ route('equipos.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Crear Nuevo Equipo
                </a>
            </div>

            {{-- Filtros y búsqueda --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-200">
                <div class="p-6 bg-white">

                    <form method="GET" action="{{ route('equipos.index') }}" class="mb-6 relative">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Buscar equipos o proyectos">
                        </div>
                    </form>

                    <div class="flex space-x-8 border-b border-gray-200">
                        @php
                            $currentFilter = request('filtro', 'todos');
                        @endphp

                        <a href="{{ route('equipos.index', ['filtro' => 'todos']) }}"
                           class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $currentFilter == 'todos' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Todos los eventos
                        </a>
                        <a href="{{ route('equipos.index', ['filtro' => 'mis_eventos']) }}"
                           class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $currentFilter == 'mis_eventos' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Mis eventos
                        </a>
                        <a href="{{ route('equipos.index', ['filtro' => 'eventos_pasados']) }}"
                           class="pb-3 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $currentFilter == 'eventos_pasados' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Eventos pasados
                        </a>
                    </div>

                </div>
            </div>

            {{-- Tabla de equipos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Nombre del equipo
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Nombre del proyecto
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Evento
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Miembros
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Fecha de creación
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($equipos as $equipo)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $equipo->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $equipo->nombre_proyecto ?? 'Sin proyecto' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $equipo->evento->nombre ?? 'Sin evento' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $estadoColors = [
                                                'en revisión' => 'bg-yellow-100 text-yellow-800',
                                                'aprobado' => 'bg-green-100 text-green-800',
                                                'rechazado' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full
                                            {{ $estadoColors[$equipo->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($equipo->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @php
                                            $totalMiembros = $equipo->participantes()->count();
                                        @endphp
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9A6.5 6.5 0 0112 3.5 6.5 6.5 0 0118.5 10z"></path>
                                            </svg>
                                            {{ $totalMiembros }} / 4
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $equipo->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                                               class="text-blue-600 hover:text-blue-900 font-bold transition-colors">
                                                Ver
                                            </a>
                                        </div>
                                        <div class="flex space-x-3">
                                            {{-- Botón Unirse solo para participantes y si no son miembros y hay cupo --}}
                                            @if(auth()->user()->tipo === 'participante' &&
                                                !$equipo->tieneMiembro(auth()->id()) &&
                                                $equipo->participantes()->count() < 4)
                                                <form action="{{ route('equipos.unirse', $equipo->id_equipo) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="text-green-600 hover:text-green-900 font-bold transition-colors">
                                                        Unirse
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        No se encontraron equipos en esta sección.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $equipos->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
