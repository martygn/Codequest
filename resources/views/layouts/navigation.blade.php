<nav x-data="{ open: false }" class="glass-nav fixed top-0 w-full z-50 border-b border-[#233554]">
    
    <style>
        .glass-nav {
            background: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(12px);
        }
        .nav-link-active {
            color: #64FFDA;
            position: relative;
        }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -24px; /* Ajuste para alinear con el borde del nav */
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #64FFDA;
            box-shadow: 0 0 10px #64FFDA;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <div class="flex items-center">
                <div class="shrink-0 flex items-center gap-3 group cursor-pointer">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                          <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
                        <span class="text-2xl font-bold text-white tracking-tight group-hover:text-[#64FFDA] transition-colors">CodeQuest</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex h-full items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out h-full {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'text-[#8892B0] hover:text-white' }}">
                        {{ __('Inicio') }}
                    </a>
                    <a href="{{ route('eventos.index') }}" 
                       class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out h-full {{ request()->routeIs('eventos.*') ? 'nav-link-active' : 'text-[#8892B0] hover:text-white' }}">
                        {{ __('Eventos') }}
                    </a>
                    <a href="{{ route('equipos.index') }}" 
                       class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out h-full {{ request()->routeIs('equipos.*') ? 'nav-link-active' : 'text-[#8892B0] hover:text-white' }}">
                        {{ __('Equipos') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                
                {{-- Campanita de Notificaciones --}}
                @php
                    $notificacionesNoLeidas = Auth::user()->notificaciones()->noLeidas()->count();
                @endphp
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" class="p-2 rounded-full text-[#8892B0] hover:text-[#64FFDA] hover:bg-white/5 transition-all relative focus:outline-none">
                        <span class="material-symbols-outlined text-2xl">notifications</span>
                        @if($notificacionesNoLeidas > 0)
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-[#0A192F] animate-pulse"></span>
                        @endif
                    </button>

                    {{-- Panel Dropdown Notificaciones --}}
                    <div x-show="notifOpen" 
                         @click.away="notifOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-[#112240] border border-[#233554] rounded-xl shadow-2xl z-50 overflow-hidden origin-top-right">
                        
                        <div class="px-4 py-3 border-b border-[#233554] flex justify-between items-center bg-[#0A192F]/50">
                            <h3 class="text-sm font-bold text-white">Notificaciones</h3>
                            @if($notificacionesNoLeidas > 0)
                                <span class="text-[10px] bg-[#64FFDA]/10 text-[#64FFDA] px-2 py-0.5 rounded border border-[#64FFDA]/20">{{ $notificacionesNoLeidas }} Nuevas</span>
                            @endif
                        </div>

                        <div class="max-h-80 overflow-y-auto custom-scrollbar">
                            @php
                                $notificaciones = Auth::user()->notificaciones()->orderBy('created_at', 'desc')->limit(10)->get();
                            @endphp

                            @forelse($notificaciones as $notificacion)
                                @php
                                    $iconColor = match($notificacion->tipo) {
                                        'success' => 'text-green-400',
                                        'error' => 'text-red-400',
                                        'warning' => 'text-yellow-400',
                                        default => 'text-[#64FFDA]',
                                    };
                                    $bgClass = $notificacion->leida ? 'bg-transparent' : 'bg-[#64FFDA]/5';
                                @endphp
                                <div class="p-3 border-b border-[#233554] hover:bg-[#0A192F] transition-colors {{ $bgClass }} flex gap-3 relative group">
                                    <span class="material-symbols-outlined text-sm mt-0.5 {{ $iconColor }}">circle</span>
                                    <div class="flex-1">
                                        <p class="text-sm text-[#CCD6F6] font-medium">{{ $notificacion->titulo }}</p>
                                        <p class="text-xs text-[#8892B0] mt-0.5 line-clamp-2">{{ $notificacion->mensaje }}</p>
                                        <span class="text-[10px] text-[#8892B0]/60 mt-1 block">{{ $notificacion->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(!$notificacion->leida)
                                        <button onclick="marcarComoLeida({{ $notificacion->id }})" class="absolute top-2 right-2 text-[#8892B0] hover:text-[#64FFDA] opacity-0 group-hover:opacity-100 transition-opacity" title="Marcar como leída">
                                            <span class="material-symbols-outlined text-base">check</span>
                                        </button>
                                    @endif
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <span class="material-symbols-outlined text-4xl text-[#233554] mb-2">notifications_off</span>
                                    <p class="text-sm text-[#8892B0]">No tienes notificaciones</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Dropdown de Perfil --}}
                <div class="relative ml-3" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden lg:block">
                            <p class="text-sm font-bold text-white group-hover:text-[#64FFDA] transition-colors">{{ Auth::user()->name }}</p>
                            
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#233554] to-[#112240] border border-[#64FFDA] flex items-center justify-center text-[#64FFDA] font-bold shadow-lg group-hover:scale-105 transition-transform group-hover:shadow-[#64FFDA]/30">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-[#112240] border border-[#233554] rounded-xl shadow-2xl py-2 z-50 origin-top-right">
                        
                        <a href="{{ route('player.perfil') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#CCD6F6] hover:bg-[#0A192F] hover:text-[#64FFDA] transition-colors">
                            <span class="material-symbols-outlined text-lg">person</span> {{ __('Mi Perfil') }}
                        </a>
                        <a href="{{ route('player.equipos') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#CCD6F6] hover:bg-[#0A192F] hover:text-[#64FFDA] transition-colors">
                            <span class="material-symbols-outlined text-lg">group</span> {{ __('Mis Equipos') }}
                        </a>
                        <a href="{{ route('player.eventos') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#CCD6F6] hover:bg-[#0A192F] hover:text-[#64FFDA] transition-colors">
                            <span class="material-symbols-outlined text-lg">event</span> {{ __('Mis Eventos') }}
                        </a>

                        <div class="border-t border-[#233554] my-1"></div>

                        @if(Auth::user()->esAdmin())
                            <a href="{{ route('admin.resultados-panel') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#64FFDA] font-bold hover:bg-[#0A192F] transition-colors">
                                <span class="material-symbols-outlined text-lg">analytics</span> {{ __('Admin Panel') }}
                            </a>
                        @elseif(Auth::user()->es_juez)
                            <a href="{{ route('juez.panel') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#64FFDA] font-bold hover:bg-[#0A192F] transition-colors">
                                <span class="material-symbols-outlined text-lg">gavel</span> {{ __('Panel de Juez') }}
                            </a>
                        @endif

                        <div class="border-t border-[#233554] my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-[#0A192F] hover:text-red-300 transition-colors">
                                <span class="material-symbols-outlined text-lg">logout</span> {{ __('Cerrar Sesión') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#8892B0] hover:text-white hover:bg-[#112240] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#112240] border-b border-[#233554]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#CCD6F6] hover:text-[#64FFDA] hover:bg-[#0A192F]">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('eventos.index')" :active="request()->routeIs('eventos.*')" class="text-[#CCD6F6] hover:text-[#64FFDA] hover:bg-[#0A192F]">
                {{ __('Eventos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('equipos.index')" :active="request()->routeIs('equipos.*')" class="text-[#CCD6F6] hover:text-[#64FFDA] hover:bg-[#0A192F]">
                {{ __('Equipos') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-[#233554]">
            <div class="px-4 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-[#0A192F] border border-[#64FFDA] flex items-center justify-center text-[#64FFDA] font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-[#8892B0]">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('player.perfil')" class="text-[#8892B0] hover:text-[#64FFDA]">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 hover:text-red-300">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function marcarComoLeida(notificacionId) {
        fetch(`/notificaciones/${notificacionId}/marcar-leida`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        }).then(() => location.reload());
    }
</script>