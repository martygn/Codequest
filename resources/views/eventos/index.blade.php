<x-app-layout>
    <div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans"style="
    padding-top: 120px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Gestiona los eventos</h2>
                    <p class="text-sm text-[#8892B0] mt-1">Administra todas las competencias y hackathons de la plataforma.</p>
                </div>

                {{-- Botón Agregar Evento (solo admins) --}}
                @if(auth()->user()->tipo === 'administrador')
                <a href="{{ route('eventos.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] text-sm font-bold rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    Agregar Evento
                </a>
                @endif
            </div>

            {{-- Panel con Buscador y Tabs --}}
            <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554] mb-8">
                <div class="p-6 md:p-8">
                    
                    {{-- Buscador y Filtros --}}
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                        
                        <form method="GET" action="{{ route('eventos.index') }}" class="w-full md:max-w-md relative">
                            <input type="hidden" name="status" value="{{ $currentStatus ?? 'todos' }}">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0]">
                                    <span class="material-symbols-outlined">search</span>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-11 pr-4 py-3 bg-[#0A192F] border border-[#233554] rounded-xl text-[#CCD6F6] placeholder-[#8892B0]/50 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] transition-all outline-none"
                                    placeholder="Buscar eventos...">
                            </div>
                        </form>

                        <nav class="flex p-1 space-x-1 bg-[#0A192F] rounded-xl border border-[#233554]">
                            @php
                                $statusClasses = [
                                    'active' => 'bg-[#64FFDA] text-[#0A192F] shadow-sm',
                                    'inactive' => 'text-[#8892B0] hover:text-[#CCD6F6] hover:bg-[#112240]'
                                ];
                                $current = $currentStatus ?? 'todos';
                            @endphp

                            <a href="{{ route('eventos.index', ['status' => 'todos']) }}"
                               class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $current == 'todos' ? $statusClasses['active'] : $statusClasses['inactive'] }}">
                                Todos
                            </a>
                            <a href="{{ route('eventos.index', ['status' => 'pendiente']) }}"
                               class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $current == 'pendiente' ? $statusClasses['active'] : $statusClasses['inactive'] }}">
                                Pendientes
                            </a>
                            <a href="{{ route('eventos.index', ['status' => 'publicado']) }}"
                               class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $current == 'publicado' ? $statusClasses['active'] : $statusClasses['inactive'] }}">
                                Publicados
                            </a>
                        </nav>
                    </div>

                    {{-- Tabla de Eventos --}}
                    <div class="overflow-hidden rounded-xl border border-[#233554]">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#233554]">
                                <thead class="bg-[#0D1B2A]">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                            Nombre del Evento
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                            Fecha
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-center text-xs font-mono font-bold text-[#64FFDA] uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-[#112240] divide-y divide-[#233554]">
                                    @forelse ($eventos as $evento)
                                        <tr class="hover:bg-[#0A192F]/50 transition-colors group">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-[#CCD6F6] group-hover:text-white transition-colors">
                                                    {{ $evento->nombre }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-[#8892B0] flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-base">event</span>
                                                    {{ $evento->fecha_inicio ? $evento->fecha_inicio->format('Y-m-d') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $estado = $evento->estado ?? 'pendiente';
                                                    $badgeClass = match($estado) {
                                                        'publicado' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                                        'pendiente' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                                        default => 'bg-gray-500/10 text-gray-400 border-gray-500/20'
                                                    };
                                                @endphp
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $badgeClass }}">
                                                    {{ ucfirst($estado) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                <a href="{{ route('eventos.show', $evento) }}"
                                                   class="inline-flex items-center gap-1 text-[#64FFDA] hover:text-white font-bold transition-colors hover:underline decoration-2 underline-offset-4">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                    Revisar
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center justify-center text-[#8892B0]">
                                                    <div class="p-4 bg-[#0A192F] rounded-full border border-[#233554] mb-3">
                                                        <span class="material-symbols-outlined text-4xl opacity-50">event_busy</span>
                                                    </div>
                                                    <p class="text-sm font-medium">No se encontraron eventos en esta sección.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Paginación --}}
                    @if($eventos->hasPages())
                    <div class="mt-6 border-t border-[#233554] pt-6">
                        {{ $eventos->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>