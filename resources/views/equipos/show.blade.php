<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Equipo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Banner del equipo --}}
            <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                @if($equipo->banner)
                    <img src="{{ asset('storage/' . $equipo->banner) }}"
                         alt="Banner del equipo {{ $equipo->nombre }}"
                         class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <h1 class="text-4xl font-bold text-white">{{ $equipo->nombre }}</h1>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                    {{-- Título y evento --}}
                    <div class="mb-8 border-b pb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $equipo->nombre }}</h1>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-lg">{{ $equipo->evento->nombre ?? 'Evento no asignado' }}</span>
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Estado del Proyecto</h2>
                        @php
                            $estadoColors = [
                                'en revisión' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'aprobado' => 'bg-green-100 text-green-800 border-green-200',
                                'rechazado' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                        @endphp
                        <div class="inline-flex items-center px-6 py-3 rounded-lg border-2 {{ $estadoColors[$equipo->estado] ?? 'bg-gray-100' }}">
                            <span class="font-bold text-lg">{{ ucfirst($equipo->estado) }}</span>
                        </div>
                    </div>

                    {{-- Proyecto --}}
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Proyecto</h2>
                        <p class="text-gray-700 text-lg">{{ $equipo->nombre_proyecto ?? 'Sin proyecto asignado' }}</p>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-10">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Descripción del equipo</h2>
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <p class="text-gray-700 whitespace-pre-line">{{ $equipo->descripcion ?? 'Sin descripción disponible' }}</p>
                        </div>
                    </div>

                    {{-- Sección de integrantes --}}
                    <div class="mt-10">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Integrantes</h2>
                            <div class="text-gray-600">
                                <span class="font-bold">{{ $equipo->participantes()->count() }}</span> / 4 miembros
                            </div>
                        </div>

                        @if($equipo->participantes()->count() == 0)
                            <div class="bg-yellow-50 rounded-lg p-6 text-center">
                                <p class="text-yellow-800">Este equipo no tiene integrantes aún.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                                @foreach($equipo->participantes as $participante)
                                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:bg-gray-100 transition-colors">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-600 font-bold text-lg">
                                                        {{ strtoupper(substr($participante->nombre, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-bold text-gray-900 mb-1">{{ $participante->nombre_completo }}</h3>
                                                <p class="text-gray-600 text-sm mb-2">{{ $participante->correo }}</p>
                                                <p class="text-gray-600 text-sm">
                                                    @switch($participante->pivot->posicion)
                                                        @case('Líder')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                👑 {{ $participante->pivot->posicion }}
                                                            </span>
                                                            @break
                                                        @case('Programador Front-end')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                💻 {{ $participante->pivot->posicion }}
                                                            </span>
                                                            @break
                                                        @case('Programador Back-end')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                ⚙️ {{ $participante->pivot->posicion }}
                                                            </span>
                                                            @break
                                                        @case('Diseñador')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                🎨 {{ $participante->pivot->posicion }}
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                👤 {{ $participante->pivot->posicion ?? 'Miembro' }}
                                                            </span>
                                                    @endswitch
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Botones de acción --}}
                    <div class="mt-10 pt-6 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('equipos.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-bold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver a equipos
                        </a>

                        @if(auth()->user()->esAdministrador())
                            <div class="flex space-x-3">
                                {{-- Botón para editar equipo --}}
                                <a href="{{ route('equipos.edit', $equipo->id_equipo) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Editar Equipo
                                </a>

                                {{-- Cambiar estado del equipo --}}
                                <form action="{{ route('equipos.update-status', $equipo->id_equipo) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="estado" onchange="this.form.submit()"
                                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="en revisión" {{ $equipo->estado == 'en revisión' ? 'selected' : '' }}>En revisión</option>
                                        <option value="aprobado" {{ $equipo->estado == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                        <option value="rechazado" {{ $equipo->estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                    </select>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
