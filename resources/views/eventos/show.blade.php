<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            
            <div class="mb-6 text-sm text-gray-500 font-medium">
                <a href="{{ route('eventos.index') }}" class="hover:text-gray-900 transition-colors">Eventos</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $evento->nombre }}</span>
            </div>

            <div class="mb-8">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
                    {{ $evento->nombre }}
                </h1>
                <p class="text-gray-500 text-lg leading-relaxed">
                    {{ $evento->descripcion_corta ?? 'Un evento para mentes creativas y solucionadores de problemas. Desarrolla soluciones innovadoras en un entorno colaborativo.' }}
                </p>
            </div>

            <div class="space-y-10">

                
                <section>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Descripción</h3>
                    <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $evento->descripcion }}
                    </div>
                </section>

                <section>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Reglas</h3>
                    <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $evento->reglas ?? 'No se han especificado reglas detalladas para este evento. Por favor consulta con los organizadores.' }}
                    </div>
                </section>

                <section>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Premios</h3>
                    <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $evento->premios ?? 'Información sobre premios pendiente de confirmación.' }}
                    </div>
                </section>

                <section class="mt-12">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Fechas Importantes</h3>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">

                    
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
                                    {{ $evento->fecha_fin->subDay()->translatedFormat('d \d\e F \d\e Y') }}
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

            <div class="mt-16 flex justify-end pb-10">
    <a href="{{ route('equipos.create', ['evento_id' => $evento->id_evento]) }}"
    <a href="{{ route('equipos.create', ['evento_id' => $evento->id_evento]) }}" 
       class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-sm transition duration-200 text-base">
        Inscribirse
    </a>
</div>

        </div>
    </div>
</x-app-layout>
</x-app-layout>
