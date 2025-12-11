<x-app-layout>
<div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="padding-top: 120px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-12">
            <h2 class="text-5xl font-bold text-[#CCD6F6] tracking-tight flex items-center gap-5">
                <span class="material-symbols-outlined text-[#64FFDA] text-6xl">groups</span>
                Mis Equipos
            </h2>
            <p class="text-xl text-[#8892B0] mt-4">Gestiona tus equipos, entregas y calificaciones</p>
        </div>

        {{-- Mensajes Flash --}}
        @if(session('success') || session('error'))
            <div class="space-y-4 mb-10">
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-8 py-5 rounded-2xl flex items-center gap-4 shadow-xl">
                        <span class="material-symbols-outlined text-3xl">check_circle</span>
                        <span class="font-medium text-lg">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-8 py-5 rounded-2xl flex items-center gap-4 shadow-xl">
                        <span class="material-symbols-outlined text-3xl">error</span>
                        <span class="font-medium text-lg">{{ session('error') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @if($misEquipos->count() > 0)
            <div class="space-y-16">
                @foreach($misEquipos as $miEquipo)
                    @php
                        $now = \Carbon\Carbon::now();
                        $eventoEnCurso = $miEquipo->evento && $now->between($miEquipo->evento->fecha_inicio, $miEquipo->evento->fecha_fin->setTime(23,59,59));
                        $tieneProyectoSubido = $miEquipo->repositorio && $miEquipo->repositorio->estado === 'enviado';
                        $esLider = $miEquipo->id_lider == auth()->id();
                    @endphp

                    <div class="bg-[#112240] rounded-3xl shadow-2xl border border-[#233554] overflow-hidden">
                        <div class="relative">

                            {{-- Banner del equipo (grande y bonito) --}}
                            <div class="h-72 relative overflow-hidden">
                                @if($miEquipo->banner)
                                    <img src="{{ Storage::disk('r2')->url($miEquipo->banner) }}"
                                         alt="Banner de {{ $miEquipo->nombre }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#64FFDA]/20 via-[#1F63E1]/20 to-[#112240] flex items-center justify-center">
                                        <span class="text-8xl font-extrabold text-[#64FFDA]/30">
                                            {{ strtoupper(substr($miEquipo->nombre, 0, 3)) }}
                                        </span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#112240] via-transparent to-transparent"></div>
                            </div>

                            <div class="px-10 pb-10 pt-8">
                                <div class="flex flex-col lg:flex-row justify-between items-start gap-8">

                                    {{-- Información principal + avatar --}}
                                    <div class="flex items-start gap-8">
                                        <div class="relative -mt-20">
                                            <div class="w-36 h-36 rounded-3xl bg-[#0A192F] border-6 border-[#64FFDA] shadow-2xl overflow-hidden flex items-center justify-center">
                                                @if($miEquipo->banner)
                                                    <img src="{{ Storage::disk('r2')->url($miEquipo->banner) }}"
                                                         alt="{{ $miEquipo->nombre }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-6xl font-bold text-[#64FFDA]">
                                                        {{ strtoupper(substr($miEquipo->nombre, 0, 2)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="pt-4">
                                            <div class="flex items-center gap-5 mb-4">
                                                <h3 class="text-5xl font-bold text-[#CCD6F6]">{{ $miEquipo->nombre }}</h3>
                                                <span class="px-5 py-2 text-lg font-bold rounded-full uppercase tracking-wider border
                                                    {{ $miEquipo->estado === 'aprobado' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                                                       ($miEquipo->estado === 'rechazado' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20') }}">
                                                    {{ ucfirst($miEquipo->estado ?? 'activo') }}
                                                </span>
                                            </div>
                                            <p class="text-xl text-[#8892B0] max-w-2xl">{{ $miEquipo->descripcion ?? 'Sin descripción disponible.' }}</p>

                                            <div class="mt-6 flex items-center gap-4">
                                                <span class="text-lg font-bold text-[#64FFDA]">Código:</span>
                                                <code class="bg-[#0A192F] px-5 py-3 rounded-xl text-[#64FFDA] font-mono text-xl border-2 border-[#64FFDA]/40 select-all">
                                                    {{ $miEquipo->codigo ?? 'N/A' }}
                                                </code>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Botones de acción --}}
                                    <div class="flex flex-col gap-5">
                                        <button type="button" onclick="openConfirmModal('salirEquipo{{ $miEquipo->id_equipo }}')"
                                                class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-red-500/10 text-red-400 border-2 border-red-500/30 rounded-2xl font-bold hover:bg-red-500/20 transition-all">
                                            <span class="material-symbols-outlined text-2xl">exit_to_app</span>
                                            Salir del Equipo
                                        </button>

                                        @if($esLider && $miEquipo->evento)
                                            @if($tieneProyectoSubido)
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                                    <a href="{{ route('proyecto.ver-player', $miEquipo->repositorio) }}"
                                                       class="inline-flex items-center justify-center gap-4 px-8 py-5 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-xl hover:bg-[#52d6b3] transition-all shadow-2xl">
                                                        <span class="material-symbols-outlined text-3xl">visibility</span>
                                                        Ver Proyecto
                                                    </a>
                                                    <a href="{{ route('proyectos.download', $miEquipo->repositorio) }}"
                                                       class="inline-flex items-center justify-center gap-4 px-8 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-bold text-xl hover:opacity-90 transition-all shadow-2xl">
                                                        <span class="material-symbols-outlined text-3xl">download</span>
                                                        Descargar
                                                    </a>
                                                </div>
                                            @else
                                                @if($eventoEnCurso)
                                                    <a href="{{ route('proyecto.create', $miEquipo) }}"
                                                       class="inline-flex items-center justify-center gap-5 px-12 py-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl font-bold text-2xl hover:opacity-90 transition-all shadow-2xl">
                                                        <span class="material-symbols-outlined text-4xl">cloud_upload</span>
                                                        Subir Proyecto Final
                                                    </a>
                                                @else
                                                    <div class="px-10 py-5 bg-gray-600/30 border-2 border-gray-500/40 rounded-2xl text-gray-300 text-center font-medium">
                                                        Evento no activo
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                {{-- Integrantes y Proyecto --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-12">
                                    {{-- Integrantes --}}
                                    <div>
                                        <h4 class="text-2xl font-bold text-[#64FFDA] mb-8 flex items-center gap-center gap-4">
                                            <span class="material-symbols-outlined text-3xl">group</span>
                                            Integrantes ({{ $miEquipo->participantes->count() }})
                                        </h4>
                                        <div class="space-y-5">
                                            @foreach($miEquipo->participantes as $miembro)
                                                <div class="flex items-center justify-between p-6 rounded-2xl border border-[#233554] {{ $miembro->id == auth()->id() ? 'bg-[#64FFDA]/10 border-[#64FFDA]/40' : 'bg-[#0A192F]/60' }} transition-all">
                                                    <div class="flex items-center gap-5">
                                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#64FFDA] to-[#52d6b3] flex items-center justify-center text-[#0A192F] font-bold text-2xl shadow-lg">
                                                            {{ strtoupper(substr($miembro->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <p class="font-bold text-xl text-[#CCD6F6] flex items-center gap-3">
                                                                {{ $miembro->name }}
                                                                @if($miembro->id == auth()->id())
                                                                    <span class="text-sm bg-[#64FFDA]/20 text-[#64FFDA] px-3 py-1 rounded-lg border border-[#64FFDA]/30">Tú</span>
                                                                @endif
                                                            </p>
                                                            <p class="text-[#8892B0]">{{ $miembro->email }}</p>
                                                        </div>
                                                    </div>
                                                    @if($miembro->id == $miEquipo->id_lider)
                                                        <span class="px-5 py-2 bg-yellow-500/10 text-yellow-400 border border-yellow-500/30 rounded-xl font-bold text-lg">Líder</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Proyecto y Evento --}}
                                    <div class="bg-gradient-to-br from-[#64FFDA]/5 to-transparent rounded-3xl border border-[#64FFDA]/20 p-10">
                                        <h4 class="text-2xl font-bold text-[#64FFDA] mb-8 flex items-center gap-4">
                                            <span class="material-symbols-outlined text-4xl">rocket_launch</span>
                                            Proyecto
                                        </h4>

                                        <p class="text-[#8892B0] mb-3">Nombre del proyecto</p>
                                        <p class="text-3xl font-bold text-[#CCD6F6] mb-8">{{ $miEquipo->nombre_proyecto ?? 'Sin definir' }}</p>

                                        @if($tieneProyectoSubido)
                                            <div class="bg-[#0A192F] rounded-2xl p-8 border border-[#233554]">
                                                <p class="text-green-400 font-bold mb-4 flex items-center gap-3 text-lg">
                                                    <span class="material-symbols-outlined text-2xl">check_circle</span>
                                                    Proyecto entregado
                                                </p>
                                                <p class="text-[#CCD6F6] mb-6 text-lg">{{ $miEquipo->repositorio->archivo_nombre }}</p>
                                                @if($miEquipo->repositorio->calificacion_total)
                                                    <div class="text-center py-8">
                                                        <div class="text-7xl font-bold text-[#64FFDA]">{{ $miEquipo->repositorio->calificacion_total }}</div>
                                                        <p class="text-[#8892B0] text-xl mt-2">puntos de 100</p>
                                                    </div>
                                                @else
                                                    <p class="text-yellow-400 flex items-center gap-3 text-lg mt-6">
                                                        <span class="material-symbols-outlined text-2xl">pending</span>
                                                        Pendiente de evaluación
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-16 text-[#8892B0]/50">
                                                <span class="material-symbols-outlined text-9xl mb-6 block opacity-20">description</span>
                                                <p class="text-2xl">Aún no has subido el proyecto final</p>
                                            </div>
                                        @endif

                                        @if($miEquipo->evento)
                                            <div class="mt-10 pt-8 border-t-2 border-[#233554]">
                                                <p class="text-[#8892B0] text-lg mb-3">Evento inscrito</p>
                                                <p class="text-[#64FFDA] text-3xl font-bold">{{ $miEquipo->evento->nombre }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-[#112240] rounded-3xl border border-[#233554] p-20 text-center shadow-2xl">
                <span class="material-symbols-outlined text-9xl text-[#8892B0] opacity-20 mb-8 block">group_off</span>
                <h3 class="text-4xl font-bold text-[#CCD6F6] mb-6">Aún no formas parte de ningún equipo</h3>
                <p class="text-2xl text-[#8892B0] mb-12 max-w-2xl mx-auto">
                    Únete a un equipo existente o crea uno nuevo para participar en los eventos.
                </p>
                <div class="flex justify-center gap-8">
                    <a href="{{ route('equipos.index') }}" class="px-12 py-6 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-2xl hover:bg-[#52d6b3] transition-all shadow-2xl">
                        Buscar Equipo
                    </a>
                    <a href="{{ route('equipos.create') }}" class="px-12 py-6 bg-[#112240] border-4 border-[#64FFDA] text-[#64FFDA] rounded-2xl font-bold text-2xl hover:bg-[#64FFDA]/10 transition-all">
                        Crear Equipo
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Scripts para modales -->
<script>
    function openConfirmModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeConfirmModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
</x-app-layout>