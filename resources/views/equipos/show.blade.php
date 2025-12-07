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
                    <img src="{{ Storage::url($equipo->banner) }}"
                        alt="Banner del equipo {{ $equipo->nombre }}"
                        class="w-full h-64 object-cover"
                        onerror="this.src='https://via.placeholder.com/800x400/3B82F6/FFFFFF?text={{ urlencode($equipo->nombre) }}'">
                @else
                    <div class="w-full h-64 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <h1 class="text-4xl font-bold text-white">{{ $equipo->nombre }}</h1>
                    </div>
                @endif
            </div>

            {{-- Mostrar mensajes flash --}}
@if(session('success') || session('error') || session('info'))
    <div class="space-y-4 mb-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif
    </div>
@endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                    {{-- Título y estado --}}
                    <div class="mb-8 border-b pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $equipo->nombre }}</h1>
                                @if($equipo->evento)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-lg">{{ $equipo->evento->nombre }}</span>
                                </div>
                                @endif
                            </div>
                            <div>
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

                    {{-- Líder del equipo --}}
                    @if($equipo->lider)
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Líder del Equipo</h2>
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-lg">
                                        {{ strtoupper(substr($equipo->lider->nombre, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $equipo->lider->nombre_completo }}</h3>
                                    <p class="text-gray-600">{{ $equipo->lider->correo }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

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

                    {{-- Mostrar solicitudes pendientes para el líder --}}
                    @if($equipo->esLider(auth()->id()) && $equipo->solicitudes_pendientes)
                        <div class="mt-8 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Solicitudes Pendientes</h3>

                            @foreach($equipo->solicitudes_pendientes as $usuarioId)
                                @php
                                    $solicitante = App\Models\Usuario::find($usuarioId);
                                @endphp
                                @if($solicitante)
                                <div class="flex items-center justify-between mb-4 p-4 bg-white dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 dark:text-blue-300 font-bold">
                                                {{ strtoupper(substr($solicitante->nombre, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white">{{ $solicitante->nombre_completo }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $solicitante->correo }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('equipos.aceptar-solicitud-lider', [$equipo->id_equipo, $solicitante->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Aceptar
                                            </button>
                                        </form>
                                        <form action="{{ route('equipos.rechazar-solicitud-lider', [$equipo->id_equipo, $solicitante->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    {{-- Botones de acción --}}
                    <div class="mt-10 pt-6 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('equipos.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-bold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver a equipos
                        </a>

                    {{-- Botón para salir del equipo --}}
                    @if($equipo->tieneMiembro(auth()->id()))
                        <form action="{{ route('equipos.salir', $equipo->id_equipo) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                    onclick="return confirm('¿Estás seguro que deseas salir del equipo?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Salir del equipo
                            </button>
                        </form>
                    @endif

                        <div class="flex space-x-3">
                            {{-- Botón para solicitar unirse --}}
                            @if(auth()->user()->tipo === 'participante' &&
                                !$equipo->tieneMiembro(auth()->id()) &&
                                !$equipo->tieneSolicitudPendiente(auth()->id()) &&
                                $equipo->participantes()->count() < 4 &&
                                $equipo->estaAprobado())
                                <form action="{{ route('equipos.solicitar-unirse', $equipo->id_equipo) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Solicitar unirse
                                    </button>
                                </form>
                            @endif

                            {{-- Botones de administrador --}}
                            @if(auth()->user()->esAdministrador())
                                @if(!$equipo->estaAprobado())
                                    <form action="{{ route('equipos.aprobar', $equipo->id_equipo) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            Aprobar Equipo
                                        </button>
                                    </form>
                                    <form action="{{ route('equipos.rechazar', $equipo->id_equipo) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                            Rechazar Equipo
                                        </button>
                                    </form>
                                @endif

                                {{-- Asignar evento --}}
                                <form action="{{ route('equipos.asignar-evento', $equipo->id_equipo) }}" method="POST" class="inline">
                                    @csrf
                                    <select name="id_evento" class="rounded-md border-gray-300" required>
                                        <option value="">Seleccionar evento</option>
                                        @foreach(App\Models\Evento::where('fecha_fin', '>=', now())->get() as $evento)
                                            <option value="{{ $evento->id_evento }}" {{ $equipo->id_evento == $evento->id_evento ? 'selected' : '' }}>
                                                {{ $evento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded">
                                        Asignar Evento
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
