<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="mb-6 text-sm text-gray-500 font-medium">
                <a href="{{ route('eventos.index') }}" class="hover:text-gray-900 transition-colors">Eventos</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $evento->nombre }}</span>
            </div>

            {{-- Título --}}
            <div class="mb-8">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
                    {{ $evento->nombre }}
                </h1>
                <p class="text-gray-500 text-lg leading-relaxed">
                    {{ $evento->descripcion_corta ?? 'Un evento para mentes creativas y solucionadores de problemas. Desarrolla soluciones innovadoras en un entorno colaborativo.' }}
                </p>
            </div>

            <div class="space-y-10">

                {{-- Descripción --}}
                <section>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Descripción</h3>
                    <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $evento->descripcion }}
                    </div>
                </section>

                {{-- Reglas --}}
                <section>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Reglas</h3>
                    <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $evento->reglas ?? 'No se han especificado reglas detalladas para este evento. Por favor consulta con los organizadores.' }}
                    </div>
                </section>

                {{-- Premios --}}
                <section>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Premios</h3>
                    <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $evento->premios ?? 'Información sobre premios pendiente de confirmación.' }}
                    </div>
                </section>

                {{-- Fechas Importantes --}}
                <section class="mt-12">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Fechas Importantes</h3>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">

                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">
                                    Registro
                                </span>
                                <span class="block text-gray-900 font-bold text-base">
                                    Hasta el {{ \Carbon\Carbon::parse($evento->fecha_inicio)->subDays(1)->translatedFormat('d \d\e F \d\e Y') }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">
                                    Inicio del Evento
                                </span>
                                <span class="block text-gray-900 font-bold text-base">
                                    {{ $evento->fecha_inicio->translatedFormat('d \d\e F \d\e Y') }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">
                                    Presentación de Proyectos
                                </span>
                                <span class="block text-gray-900 font-bold text-base">
                                    {{ $evento->fecha_fin->copy()->subDay()->translatedFormat('d \d\e F \d\e Y') }}
                                </span>
                            </div>

                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">
                                    Ceremonia de Premiación
                                </span>
                                <span class="block text-gray-900 font-bold text-base">
                                    {{ $evento->fecha_fin->translatedFormat('d \d\e F \d\e Y') }}
                                </span>
                            </div>

                        </div>
                    </div>
                </section>

            </div>

            {{-- Botón Inscribirse --}}
            <div class="mt-16 flex justify-end pb-10">
                @auth
                    @if($esParticipante)
                        @if($tieneEquipoEnEsteEvento)
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                <p class="font-bold">✅ Ya tienes un equipo inscrito en este evento.</p>
                            </div>
                        @elseif($tieneEquipoAprobado && $evento->estado === 'publicado')
                            {{-- Tiene equipo aprobado pero no en este evento y el evento está publicado --}}
                            <a href="{{ route('eventos.inscribir-equipo', $evento->id_evento) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
                                Inscribir mi equipo en este evento
                            </a>
                        @elseif($tieneEquipoAprobado && $evento->estado !== 'publicado')
                            {{-- Evento pendiente: no se puede inscribir aún --}}
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded">
                                <p class="font-bold">⚠️ Este evento aún no ha sido publicado. Solo podrás inscribir equipos cuando se publique.</p>
                            </div>
                        @else
                            {{-- No tiene ningún equipo aprobado --}}
                            <div class="flex flex-col items-end">
                                <a href="{{ route('equipos.create') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
                                    Crear equipo para participar
                                </a>
                                <p class="text-sm text-gray-600 mt-2">Primero debes crear y obtener la aprobación de un equipo.</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                            <p class="font-bold">⚠️ Solo los participantes pueden inscribirse en eventos.</p>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
                        Iniciar sesión para participar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
