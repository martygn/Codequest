<x-app-layout>
<div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="padding-top: 120px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-[#CCD6F6] tracking-tight flex items-center gap-4">
                <span class="material-symbols-outlined text-[#64FFDA] text-5xl">groups</span>
                Mis Equipos
            </h2>
            <p class="text-lg text-[#8892B0] mt-3">Gestiona tus equipos y entregas y calificaciones</p>
        </div>

        {{-- Mensajes Flash --}}
        @if(session('success') || session('error'))
            <div class="space-y-4 mb-8">
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-lg">
                        <span class="material-symbols-outlined text-2xl">check_circle</span>
                        <span class="font-medium text-lg">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-lg">
                        <span class="material-symbols-outlined text-2xl">error</span>
                        <span class="font-medium text-lg">{{ session('error') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @if($misEquipos->count() > 0)
            <div class="space-y-10">
                @foreach($misEquipos as $miEquipo)
                    @php
                        $now = \Carbon\Carbon::now();
                        $eventoEnCurso = $miEquipo->evento && $now->between($miEquipo->evento->fecha_inicio, $miEquipo->evento->fecha_fin->setTime(23,59,59));
                        $tieneProyectoSubido = $miEquipo->repositorio && $miEquipo->repositorio->estado === 'enviado';
                        $esLider = $miEquipo->id_lider == auth()->id();
                    @endphp

                    <div class="bg-[#112240] rounded-2xl shadow-2xl border border-[#233554] overflow-hidden">
                        <div class="p-8">
                            <div class="md:flex justify-between items-start mb-8 pb-8 border-b border-[#233554]">
                                <div>
                                    <div class="flex items-center gap-4 mb-4">
                                        <h3 class="text-4xl font-bold text-[#CCD6F6]">{{ $miEquipo->nombre }}</h3>
                                        <span class="px-4 py-2 text-sm font-bold rounded-full uppercase tracking-wider border
                                            {{ $miEquipo->estado === 'aprobado' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                                               ($miEquipo->estado === 'rechazado' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20') }}">
                                            {{ ucfirst($miEquipo->estado ?? 'activo') }}
                                        </span>
                                    </div>
                                    <p class="text-[#8892B0] text-lg max-w-3xl">{{ $miEquipo->descripcion ?? 'Sin descripción disponible.' }}</p>

                                    <div class="mt-5 flex items-center gap-3">
                                        <span class="text-sm font-bold text-[#64FFDA] uppercase">Código de acceso:</span>
                                        <code class="bg-[#0A192F] px-4 py-2 rounded-lg text-[#64FFDA] font-mono text-lg border border-[#64FFDA]/30 select-all">
                                            {{ $miEquipo->codigo ?? 'N/A' }}
                                        </code>
                                    </div>
                                </div>

                                <div class="mt-6 md:mt-0 flex flex-col gap-4">
                                    <button type="button" onclick="openConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')"
                                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-500/10 text-red-400 border border-red-500/30 rounded-xl font-bold hover:bg-red-500/20 transition-all">
                                        <span class="material-symbols-outlined text-xl">exit_to_app</span>
                                        Salir del Equipo
                                    </button>

                                    @if($esLider && $miEquipo->evento)
                                        @if($tieneProyectoSubido)
                                            <div class="flex gap-4">
                                                <a href="{{ route('proyecto.ver-player', $miEquipo->repositorio) }}"
                                                   class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-lg hover:bg-[#52d6b3] transition-all shadow-xl">
                                                    <span class="material-symbols-outlined text-2xl">visibility</span>
                                                    Ver Proyecto
                                                </a>
                                                <a href="{{ route('proyectos.download', $miEquipo->repositorio) }}"
                                                   class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-xl">
                                                    <span class="material-symbols-outlined text-2xl">download</span>
                                                    Descargar
                                                </a>
                                            </div>
                                        @else
                                            @if($eventoEnCurso)
                                                <a href="{{ route('proyecto.create', $miEquipo) }}"
                                                   class="inline-flex items-center justify-center gap-4 px-10 py-5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold text-xl hover:opacity-90 transition-all shadow-2xl">
                                                    <span class="material-symbols-outlined text-3xl">cloud_upload</span>
                                                    Subir Proyecto Final
                                                </a>
                                            @else
                                                <div class="px-8 py-4 bg-gray-600/20 border border-gray-500/30 rounded-2xl text-gray-400 font-medium text-center">
                                                    El evento no está activo
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                                <!-- Integrantes -->
                                <div>
                                    <h4 class="text-lg font-bold text-[#64FFDA] mb-6 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-2xl">group</span>
                                        Integrantes ({{ $miEquipo->participantes->count() }})
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($miEquipo->participantes as $miembro)
                                            <div class="flex items-center justify-between p-5 rounded-2xl border border-[#233554] {{ $miembro->id == auth()->id() ? 'bg-[#64FFDA]/5 border-[#64FFDA]/30' : 'bg-[#0A192F]/50' }}">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#64FFDA] to-[#52d6b3] flex items-center justify-center text-[#0A192F] font-bold text-xl shadow-lg">
                                                        {{ strtoupper(substr($miembro->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-[#CCD6F6] flex items-center gap-2">
                                                            {{ $miembro->name }}
                                                            @if($miembro->id == auth()->id())
                                                                <span class="text-xs bg-[#64FFDA]/20 text-[#64FFDA] px-2 py-1 rounded-lg border border-[#64FFDA]/30">Tú</span>
                                                            @endif
                                                        </p>
                                                        <p class="text-sm text-[#8892B0]">{{ $miembro->email }}</p>
                                                    </div>
                                                </div>
                                                @if($miembro->id == $miEquipo->id_lider)
                                                    <span class="px-4 py-2 bg-yellow-500/10 text-yellow-400 border border-yellow-500/30 rounded-xl font-bold text-sm">Líder</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Proyecto y Evento -->
                                <div class="bg-gradient-to-br from-[#64FFDA]/5 to-transparent rounded-2xl border border-[#64FFDA]/20 p-8">
                                    <h4 class="text-xl font-bold text-[#64FFDA] mb-6 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-3xl">rocket_launch</span>
                                        Proyecto
                                    </h4>

                                    <p class="text-[#8892B0] mb-2">Nombre del proyecto</p>
                                    <p class="text-2xl font-bold text-[#CCD6F6] mb-6">{{ $miEquipo->nombre_proyecto ?? 'Sin definir' }}</p>

                                    @if($tieneProyectoSubido)
                                        <div class="bg-[#0A192F] rounded-2xl p-6 border border-[#233554]">
                                            <p class="text-green-400 font-bold mb-3 flex items-center gap-2">
                                                <span class="material-symbols-outlined">check_circle</span>
                                                Proyecto entregado
                                            </p>
                                            <p class="text-[#CCD6F6] mb-4">{{ $miEquipo->repositorio->archivo_nombre }}</p>
                                            @if($miEquipo->repositorio->calificacion_total)
                                                <div class="text-center py-6">
                                                    <div class="text-6xl font-bold text-[#64FFDA]">{{ $miEquipo->repositorio->calificacion_total }}</div>
                                                    <p class="text-[#8892B0] text-lg">puntos de 100</p>
                                                </div>
                                            @else
                                                <p class="text-yellow-400 flex items-center gap-2 mt-4">
                                                    <span class="material-symbols-outlined">pending</span>
                                                    Pendiente de evaluación
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center py-12 text-[#8892B0]/60">
                                            <span class="material-symbols-outlined text-8xl mb-4 block opacity-30">description</span>
                                            <p class="text-xl">Aún no has subido el proyecto final</p>
                                        </div>
                                    @endif

                                   

                                    @if($miEquipo->evento)
                                        <div class="mt-8 pt-6 border-t border-[#233554]">
                                            <p class="text-[#8892B0] text-sm mb-2">Evento inscrito</p>
                                            <p class="text-[#64FFDA] text-600 text-2xl font-bold">{{ $miEquipo->evento->nombre }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Sin equipos -->
            <div class="bg-[#112240] rounded-2xl border border-[#233554] p-16 text-center shadow-2xl">
                <span class="material-symbols-outlined text-9xl text-[#8892B0] opacity-20 mb-8 block">group_off</span>
                <h3 class="text-3xl font-bold text-[#CCD6F6] mb-4">Aún no formas parte de ningún equipo</h3>
                <p class="text-xl text-[#8892B0] mb-10 max-w-2xl mx-auto">
                    Únete a un equipo existente o crea uno nuevo para participar en los eventos.
                </p>
                <div class="flex justify-center gap-6">
                    <a href="{{ route('equipos.index') }}" class="px-10 py-5 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-xl hover:bg-[#52d6b3] transition-all shadow-xl">
                        Buscar Equipo
                    </a>
                    <a href="{{ route('equipos.create') }}" class="px-10 py-5 bg-[#112240] border-2 border-[#64FFDA] text-[#64FFDA] rounded-2xl font-bold text-xl hover:bg-[#64FFDA]/10 transition-all">
                        Crear Equipo
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Scripts para modales (los mismos que ya tenías) -->
<script>
    function openConfirmModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeConfirmModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
</x-app-layout>