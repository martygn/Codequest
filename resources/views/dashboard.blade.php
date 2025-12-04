<x-app-layout>

    <div class="py-12">
        {{-- Hero Section --}}
        <div class="relative bg-gradient-to-br from-gray-900 to-gray-800 text-white overflow-hidden mb-12">
            <div class="absolute inset-0 opacity-10">
                <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Bienvenido a CodeQuest
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8">
                    La plataforma definitiva para registrar y gestionar equipos de programación en eventos
                </p>
                <a href="{{ route('eventos.index') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition duration-300 transform hover:scale-105">
                    Explorar Eventos
                </a>
            </div>
        </div>

        {{-- Próximos Eventos Carrusel --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Próximos Eventos</h2>

            <div class="relative" id="carouselWrapper">
                @if(count($proximosEventos) > 0)
                <style>
                    @keyframes carouselSlide {
                        0% {
                            transform: translateX(0);
                        }
                        100% {
                            transform: translateX(calc(-400px - 1.5rem));
                        }
                    }
                    
                    .carousel-track {
                        animation: carouselSlide 30s linear infinite;
                    }
                    
                    .carousel-track:hover {
                        animation-play-state: paused;
                    }
                </style>
                
                <div class="overflow-hidden">
                    <div class="carousel-track flex gap-6 pb-4">
                        <!-- Primera iteración de eventos -->
                        @foreach($proximosEventos as $evento)
                        <div class="flex-shrink-0 w-96 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="aspect-video bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                @if($evento->foto)
                                    <img src="{{ asset('storage/' . $evento->foto) }}"
                                         alt="{{ $evento->nombre }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="text-center p-8">
                                        <div class="text-white text-lg font-semibold border-4 border-white p-6">
                                            {{ Str::upper($evento->nombre) }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $evento->nombre }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                                    📅 {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d \d\e F \d\e Y') }}
                                </p>
                                @if($evento->lugar)
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    📍 {{ $evento->lugar }}
                                </p>
                                @endif
                                <div class="mt-4">
                                    <a href="{{ route('eventos.show', $evento->id_evento) }}"
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                        Ver detalles →
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Segunda iteración de eventos (para efecto infinito) -->
                        @foreach($proximosEventos as $evento)
                        <div class="flex-shrink-0 w-96 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="aspect-video bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                @if($evento->foto)
                                    <img src="{{ asset('storage/' . $evento->foto) }}"
                                         alt="{{ $evento->nombre }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="text-center p-8">
                                        <div class="text-white text-lg font-semibold border-4 border-white p-6">
                                            {{ Str::upper($evento->nombre) }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $evento->nombre }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                                    📅 {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d \d\e F \d\e Y') }}
                                </p>
                                @if($evento->lugar)
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    📍 {{ $evento->lugar }}
                                </p>
                                @endif
                                <div class="mt-4">
                                    <a href="{{ route('eventos.show', $evento->id_evento) }}"
                                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                        Ver detalles →
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">No hay eventos próximos disponibles</p>
                    <a href="{{ route('eventos.create') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
                        Crear un evento →
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Equipos Destacados Carrusel --}}
        <div class="bg-white dark:bg-gray-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Equipos Destacados</h2>

                <div class="relative" id="equiposCarouselWrapper">
                    @if(count($equiposDestacados) > 0)
                    <style>
                        @keyframes equiposCarouselSlide {
                            0% {
                                transform: translateX(0);
                            }
                            100% {
                                transform: translateX(calc(-384px - 1.5rem));
                            }
                        }
                        
                        .equipos-carousel-track {
                            animation: equiposCarouselSlide 30s linear infinite;
                        }
                        
                        .equipos-carousel-track:hover {
                            animation-play-state: paused;
                        }
                    </style>
                    
                    <div class="overflow-hidden">
                        <div class="equipos-carousel-track flex gap-6 pb-4">
                            <!-- Primera iteración de equipos -->
                            @foreach($equiposDestacados as $equipo)
                            <div class="flex-shrink-0 w-96 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <div class="aspect-square flex items-center justify-center p-8 {{ $loop->even ? 'bg-gray-900' : 'bg-gray-100 dark:bg-gray-700' }}">
                                    @if($equipo->banner)
                                        <img src="{{ asset('storage/' . $equipo->banner) }}"
                                             alt="{{ $equipo->nombre }}"
                                             class="max-w-full max-h-full object-contain">
                                    @else
                                        <div class="w-32 h-32 rounded-full border-4 {{ $loop->even ? 'border-white' : 'border-gray-900 dark:border-gray-300' }} flex items-center justify-center">
                                            <span class="text-4xl font-bold {{ $loop->even ? 'text-white' : 'text-gray-900 dark:text-gray-100' }}">
                                                {{ strtoupper(substr($equipo->nombre, 0, 2)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 text-center">
                                    <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-2">
                                        {{ $equipo->nombre }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-1">
                                        👥 Miembros: {{ $equipo->participantes_count ?? 0 }}
                                    </p>
                                    @if($equipo->evento)
                                    <p class="text-gray-500 dark:text-gray-500 text-sm">
                                        🏆 {{ $equipo->evento->nombre }}
                                    </p>
                                    @endif
                                    <div class="mt-4">
                                        <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                            Ver equipo →
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Segunda iteración de equipos (para efecto infinito) -->
                            @foreach($equiposDestacados as $equipo)
                            <div class="flex-shrink-0 w-96 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                                <div class="aspect-square flex items-center justify-center p-8 {{ $loop->even ? 'bg-gray-900' : 'bg-gray-100 dark:bg-gray-700' }}">
                                    @if($equipo->banner)
                                        <img src="{{ asset('storage/' . $equipo->banner) }}"
                                             alt="{{ $equipo->nombre }}"
                                             class="max-w-full max-h-full object-contain">
                                    @else
                                        <div class="w-32 h-32 rounded-full border-4 {{ $loop->even ? 'border-white' : 'border-gray-900 dark:border-gray-300' }} flex items-center justify-center">
                                            <span class="text-4xl font-bold {{ $loop->even ? 'text-white' : 'text-gray-900 dark:text-gray-100' }}">
                                                {{ strtoupper(substr($equipo->nombre, 0, 2)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 text-center">
                                    <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-2">
                                        {{ $equipo->nombre }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-1">
                                        👥 Miembros: {{ $equipo->participantes_count ?? 0 }}
                                    </p>
                                    @if($equipo->evento)
                                    <p class="text-gray-500 dark:text-gray-500 text-sm">
                                        🏆 {{ $equipo->evento->nombre }}
                                    </p>
                                    @endif
                                    <div class="mt-4">
                                        <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                            Ver equipo →
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">No hay equipos destacados disponibles</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
