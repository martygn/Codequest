<x-app-layout>
    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans" style="padding-top: 120px;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-[#CCD6F6] flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#64FFDA] text-4xl">upload</span>
                        Subir Proyecto Final
                    </h1>
                    <p class="text-[#8892B0] mt-2">Entrega final del proyecto del hackatón</p>
                </div>
                <a href="{{ route('player.equipos') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#112240] border border-[#233554] rounded-lg text-[#64FFDA] hover:bg-[#233554] transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Volver a Mis Equipos
                </a>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-center gap-2">
                    <span class="material-symbols-outlined">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @php
                $evento = $equipo->evento;
                $hoy = now();
                $fechaInicioEvento = \Carbon\Carbon::parse($evento->fecha_inicio)->startOfDay();
                $fechaFinEvento = \Carbon\Carbon::parse($evento->fecha_fin)->setTime(23, 59, 59);
                $eventoActivo = $hoy->between($fechaInicioEvento, $fechaFinEvento);
                $eventoFinalizado = $hoy->greaterThan($fechaFinEvento);
                $fechaEntrega = \Carbon\Carbon::now()->format('d/m/Y');
                $horaLimite = "23:59";
            @endphp

            @if($eventoFinalizado)
                <div class="mb-6 bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-6">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-yellow-400 text-3xl">warning</span>
                        <div>
                            <h3 class="text-yellow-400 font-bold text-lg">Evento Finalizado</h3>
                            <p class="text-[#8892B0] mt-2">El evento <strong class="text-[#CCD6F6]">"{{ $evento->nombre }}"</strong> ha finalizado. No se pueden subir proyectos después de la fecha límite.</p>
                            <p class="text-[#8892B0] mt-2">
                                <strong>Fecha límite:</strong> {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }} a las {{ $horaLimite }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Información del Proyecto -->
            <div class="bg-[#112240] rounded-xl shadow-xl border border-[#233554] p-6 mb-6">
                <h2 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#64FFDA]">info</span>
                    Información del Proyecto
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">groups</span>
                            <span class="text-[#8892B0]">Equipo:</span>
                            <span class="bg-[#64FFDA] text-[#0A192F] px-3 py-1 rounded-lg font-bold text-sm">{{ $equipo->nombre }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">assignment</span>
                            <span class="text-[#8892B0]">Proyecto:</span>
                            <span class="text-[#CCD6F6]">{{ $equipo->nombre_proyecto }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">person</span>
                            <span class="text-[#8892B0]">Líder:</span>
                            <span class="text-[#CCD6F6]">{{ $equipo->lider->nombre }}</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">calendar_today</span>
                            <span class="text-[#8892B0]">Fecha de Entrega:</span>
                            <span class="text-[#CCD6F6]">{{ $fechaEntrega }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">schedule</span>
                            <span class="text-[#8892B0]">Hora Límite:</span>
                            <span class="text-[#CCD6F6]">{{ $horaLimite }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#64FFDA]">group</span>
                            <span class="text-[#8892B0]">Miembros:</span>
                            <span class="text-[#CCD6F6]">{{ $equipo->participantes->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Criterios de Evaluación -->
            <div class="bg-[#112240] rounded-xl shadow-xl border border-[#233554] p-6 mb-6">
                <h2 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#64FFDA]">assessment</span>
                    Descripción y Criterios de Evaluación
                </h2>
                <p class="text-[#8892B0] mb-6">Este es el apartado destinado a la entrega final del proyecto desarrollado durante el hackatón. Cada equipo deberá subir su propuesta tecnológica cumpliendo con los lineamientos establecidos.</p>

                <h3 class="text-[#64FFDA] font-bold mb-4">Criterios de Evaluación:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <span class="bg-[#64FFDA] text-[#0A192F] px-3 py-1 rounded-lg font-bold text-sm">30%</span>
                            <div>
                                <h4 class="font-bold text-[#CCD6F6]">Innovación y creatividad</h4>
                                <p class="text-[#8892B0] text-sm mt-1">Originalidad y enfoque novedoso de la solución</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <span class="bg-[#64FFDA] text-[#0A192F] px-3 py-1 rounded-lg font-bold text-sm">20%</span>
                            <div>
                                <h4 class="font-bold text-[#CCD6F6]">Impacto y escalabilidad</h4>
                                <p class="text-[#8892B0] text-sm mt-1">Potencial de impacto y crecimiento</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <span class="bg-[#64FFDA] text-[#0A192F] px-3 py-1 rounded-lg font-bold text-sm">30%</span>
                            <div>
                                <h4 class="font-bold text-[#CCD6F6]">Funcionalidad técnica</h4>
                                <p class="text-[#8892B0] text-sm mt-1">Calidad técnica y funcionamiento del proyecto</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <span class="bg-[#64FFDA] text-[#0A192F] px-3 py-1 rounded-lg font-bold text-sm">20%</span>
                            <div>
                                <h4 class="font-bold text-[#CCD6F6]">Claridad en presentación</h4>
                                <p class="text-[#8892B0] text-sm mt-1">Documentación y exposición clara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reglas del Evento -->
            <div class="bg-[#112240] rounded-xl shadow-xl border border-[#233554] p-6 mb-6">
                <h2 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-yellow-400">rule</span>
                    Reglas del Evento
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex gap-3">
                            <span class="text-[#64FFDA] font-bold text-lg">1</span>
                            <div>
                                <p class="text-[#CCD6F6]"><strong>Cada equipo debe entregar un solo proyecto</strong> en este apartado (el <strong>Líder</strong> es el encargado de subir el proyecto).</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex gap-3">
                            <span class="text-[#64FFDA] font-bold text-lg">2</span>
                            <div>
                                <p class="text-[#CCD6F6]"><strong>El archivo debe estar identificado</strong> con el nombre del equipo y del proyecto.</p>
                                <p class="text-[#8892B0] text-sm mt-1">Ejemplo: <code class="bg-[#112240] px-2 py-1 rounded text-[#64FFDA]">{{ str_replace(' ', '', $equipo->nombre) }}_{{ str_replace(' ', '', $equipo->nombre_proyecto) }}.pdf</code></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex gap-3">
                            <span class="text-[#64FFDA] font-bold text-lg">3</span>
                            <div>
                                <p class="text-[#CCD6F6]"><strong>Formatos permitidos:</strong></p>
                                <div class="flex gap-2 mt-2">
                                    <span class="bg-[#112240] text-[#64FFDA] px-2 py-1 rounded text-sm">.zip</span>
                                    <span class="bg-[#112240] text-[#64FFDA] px-2 py-1 rounded text-sm">.pdf</span>
                                    <span class="bg-[#112240] text-[#64FFDA] px-2 py-1 rounded text-sm">.pptx</span>
                                </div>
                                <p class="text-[#8892B0] text-sm mt-1">(Máximo 50MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4">
                        <div class="flex gap-3">
                            <span class="text-[#64FFDA] font-bold text-lg">4</span>
                            <div>
                                <p class="text-[#CCD6F6]"><strong>La entrega debe realizarse antes de la fecha límite establecida.</strong> No se aceptarán entregas después de las <strong>23:59</strong>.</p>
                                <p class="text-[#8892B0] text-sm mt-1">Fecha límite: {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }} a las {{ $horaLimite }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#0A192F] border border-[#233554] rounded-lg p-4 md:col-span-2">
                        <div class="flex gap-3">
                            <span class="text-[#64FFDA] font-bold text-lg">5</span>
                            <div>
                                <p class="text-[#CCD6F6]"><strong>El proyecto debe ser original, creado durante el hackatón.</strong> De no ser así, serán sometidos a expulsión.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proyecto Subido (si existe) -->
            @if($equipo->repositorio)
                <div class="bg-[#112240] rounded-xl shadow-xl border border-green-500/30 p-6 mb-6">
                    <h2 class="text-xl font-bold text-[#CCD6F6] mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-400">check_circle</span>
                        Proyecto Subido
                    </h2>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[#CCD6F6] flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#64FFDA]">description</span>
                                <strong>{{ $equipo->repositorio->archivo_nombre }}</strong>
                            </p>
                            <p class="text-[#8892B0] text-sm mt-1">Subido: {{ \Carbon\Carbon::parse($equipo->repositorio->enviado_en)->format('d/m/Y H:i') }}</p>

                            @if($equipo->repositorio->calificacion_total)
                                <div class="mt-4">
                                    <p class="text-[#64FFDA] font-bold text-2xl">{{ $equipo->repositorio->calificacion_total }}/100</p>
                                    <div class="w-full bg-[#0A192F] rounded-full h-3 mt-2">
                                        <div class="bg-[#64FFDA] h-3 rounded-full" style="width: {{ $equipo->repositorio->calificacion_total }}%"></div>
                                    </div>
                                    <p class="text-[#8892B0] text-sm mt-1">Calificación Final</p>
                                </div>
                            @else
                                <p class="text-yellow-400 text-sm mt-4 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">pending</span>
                                    Pendiente de calificación
                                </p>
                            @endif
                        </div>
                        <a href="{{ route('proyectos.download', $equipo->repositorio) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#64FFDA] text-[#0A192F] rounded-lg font-bold hover:bg-[#52d6b3] transition-colors">
                            <span class="material-symbols-outlined">download</span>
                            Descargar
                        </a>
                    </div>
                </div>
            @endif

            <!-- Formulario de Subida -->
            @if(!$eventoFinalizado && (!$equipo->repositorio || $equipo->repositorio->estado !== 'enviado'))
                <div class="bg-[#112240] rounded-xl shadow-xl border border-[#233554] p-6">
                    <h2 class="text-xl font-bold text-[#CCD6F6] mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#64FFDA]">cloud_upload</span>
                        Subir Proyecto
                    </h2>

                    <form action="{{ route('proyecto.store', $equipo) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-[#CCD6F6] font-semibold mb-2">
                                Archivo del Proyecto *
                            </label>
                            <input type="file" name="archivo" required accept=".zip,.pdf,.pptx"
                                   class="w-full px-4 py-3 bg-[#0A192F] border border-[#233554] rounded-lg text-[#CCD6F6] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#64FFDA] file:text-[#0A192F] hover:file:bg-[#52d6b3] focus:outline-none focus:border-[#64FFDA]">
                            <p class="text-[#8892B0] text-sm mt-2">Formatos: .zip, .pdf, .pptx (Máximo 50MB)</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[#CCD6F6] font-semibold mb-2">
                                URL del Repositorio (Opcional)
                            </label>
                            <input type="url" name="url_github" placeholder="https://github.com/usuario/repositorio"
                                   class="w-full px-4 py-3 bg-[#0A192F] border border-[#233554] rounded-lg text-[#CCD6F6] placeholder-[#8892B0] focus:outline-none focus:border-[#64FFDA]">
                        </div>

                        <div class="mb-6">
                            <label class="block text-[#CCD6F6] font-semibold mb-2">
                                Comentarios Adicionales (Opcional)
                            </label>
                            <textarea name="comentarios" rows="4" placeholder="Describe brevemente tu proyecto..."
                                      class="w-full px-4 py-3 bg-[#0A192F] border border-[#233554] rounded-lg text-[#CCD6F6] placeholder-[#8892B0] focus:outline-none focus:border-[#64FFDA]"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-[#0A192F] border border-[#233554] rounded-lg text-[#8892B0] hover:bg-[#233554] hover:text-[#CCD6F6] transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" class="px-6 py-3 bg-[#64FFDA] text-[#0A192F] rounded-lg font-bold hover:bg-[#52d6b3] transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined">upload</span>
                                Subir Proyecto
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
