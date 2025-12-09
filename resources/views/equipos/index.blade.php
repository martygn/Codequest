<x-app-layout>
    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10" style="height: 130px;">
            
          
                <div>
                    <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Equipos</h2>
                    <p class="text-sm text-[#8892B0] mt-1">Explora, únete o crea equipos para competir.</p>
                </div>

                <a href="{{ route('equipos.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-xl">group_add</span>
                    Crear Nuevo Equipo
                </a>
            </div>

            {{-- Panel de Control (Filtros y Buscador) --}}
            <div class="bg-[#112240] rounded-2xl shadow-xl border border-[#233554] overflow-hidden mb-8">
                <div class="p-6 md:p-8">

                    {{-- Buscador --}}
                    <form method="GET" action="{{ route('equipos.index') }}" class="mb-8">
                        <div class="relative max-w-lg">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0]">
                                <span class="material-symbols-outlined">search</span>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="w-full pl-11 pr-4 py-3 bg-[#0A192F] border border-[#233554] rounded-xl text-[#CCD6F6] placeholder-[#8892B0]/50 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all"
                                   placeholder="Buscar por nombre o proyecto...">
                        </div>
                    </form>

                    {{-- Pestañas de Filtro --}}
                    <div class="flex flex-wrap gap-2 border-b border-[#233554] pb-1">
                        @php
                            $currentFilter = request('filtro', 'todos');
                            $activeClass = 'border-[#64FFDA] text-[#64FFDA]';
                            $inactiveClass = 'border-transparent text-[#8892B0] hover:text-[#CCD6F6] hover:border-[#233554]';
                        @endphp

                        <a href="{{ route('equipos.index', ['filtro' => 'todos']) }}"
                           class="px-4 py-2 border-b-2 font-bold text-sm transition-all {{ $currentFilter === 'todos' ? $activeClass : $inactiveClass }}">
                            Todos los equipos
                        </a>
                        <a href="{{ route('equipos.index', ['filtro' => 'mis_eventos']) }}"
                           class="px-4 py-2 border-b-2 font-bold text-sm transition-all {{ $currentFilter === 'mis_eventos' ? $activeClass : $inactiveClass }}">
                            Mis equipos
                        </a>
                        <a href="{{ route('equipos.index', ['filtro' => 'eventos_pasados']) }}"
                           class="px-4 py-2 border-b-2 font-bold text-sm transition-all {{ $currentFilter === 'eventos_pasados' ? $activeClass : $inactiveClass }}">
                            Historial
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tabla de Equipos --}}
            <div class="bg-[#112240] rounded-2xl shadow-xl border border-[#233554] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#233554]">
                        <thead class="bg-[#0D1B2A]">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Equipo
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Proyecto
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Evento
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Miembros
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Creación
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-[#112240] divide-y divide-[#233554]">
                            @forelse ($equipos as $equipo)
                                <tr class="hover:bg-[#0A192F]/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[#CCD6F6] group-hover:text-white transition-colors">
                                            {{ $equipo->nombre }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#8892B0]">
                                            {{ $equipo->nombre_proyecto ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[#8892B0]">
                                            {{ $equipo->evento?->nombre ?? 'Sin Asignar' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $estadoClass = match($equipo->estado) {
                                                'aprobado' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                                'rechazado' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                                default => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $estadoClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $equipo->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8892B0]">
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-base text-[#64FFDA]">group</span>
                                            {{ $equipo->participantes()->count() }} / 4
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8892B0] font-mono text-xs">
                                        {{ $equipo->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex flex-col items-center gap-2">
                                            <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                                               class="text-[#64FFDA] hover:text-white transition-colors hover:underline decoration-2 underline-offset-4">
                                                Ver Detalles
                                            </a>

                                            @if(auth()->user()->tipo === 'participante' &&
                                                !$equipo->tieneMiembro(auth()->id()) &&
                                                !$equipo->tieneSolicitudPendiente(auth()->id()) &&
                                                $equipo->participantes()->count() < 4 &&
                                                $equipo->estaAprobado())
                                                
                                                <form action="{{ route('equipos.solicitar-unirse', $equipo->id_equipo) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs bg-[#64FFDA]/10 text-[#64FFDA] px-2 py-1 rounded border border-[#64FFDA]/30 hover:bg-[#64FFDA] hover:text-[#0A192F] transition-all">
                                                        Solicitar Unirse
                                                    </button>
                                                </form>

                                            @elseif(auth()->user()->tipo === 'participante' && $equipo->tieneSolicitudPendiente(auth()->id()))
                                                <span class="text-xs text-yellow-400 italic">Solicitud enviada</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-[#8892B0]">
                                            <div class="p-4 bg-[#0A192F] rounded-full border border-[#233554] mb-3">
                                                <span class="material-symbols-outlined text-4xl opacity-50">group_off</span>
                                            </div>
                                            <p class="text-sm font-medium">No se encontraron equipos con este filtro.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($equipos->hasPages())
                <div class="px-6 py-4 border-t border-[#233554] bg-[#0A192F]">
                    {{ $equipos->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>