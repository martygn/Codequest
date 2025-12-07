<nav x-data="{ open: false }" class="bg-gradient-to-br from-gray-900 to-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <span class="text-2xl font-bold text-white">CodeQuest</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-400' }} transition duration-200">
                        {{ __('Inicio') }}
                    </a>
                    <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('eventos.index') ? 'border-blue-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-400' }} transition duration-200">
                        {{ __('Eventos') }}
                    </a>
                    <a href="{{ route('equipos.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('equipos.index') ? 'border-blue-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-400' }} transition duration-200">
                        {{ __('Equipos') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- Notificaciones Campanita --}}
                @php
                    $notificacionesNoLeidas = Auth::user()->notificaciones()->noLeidas()->count();
                @endphp
                <div class="relative">
                    <button onclick="toggleNotificaciones()" class="p-2 rounded-full hover:bg-gray-700 transition me-2 relative">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($notificacionesNoLeidas > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                {{ $notificacionesNoLeidas }}
                            </span>
                        @endif
                    </button>

                    {{-- Panel de Notificaciones --}}
                    <div id="notificacionesPanel" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-50 max-h-96 overflow-y-auto">
                        @php
                            $notificaciones = Auth::user()->notificaciones()->orderBy('created_at', 'desc')->limit(10)->get();
                        @endphp

                        @if($notificaciones->count() > 0)
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notificaciones</h3>
                            </div>

                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($notificaciones as $notificacion)
                                    @php
                                        $colorBg = [
                                            'info' => 'bg-blue-50 dark:bg-blue-900/30',
                                            'warning' => 'bg-yellow-50 dark:bg-yellow-900/30',
                                            'success' => 'bg-green-50 dark:bg-green-900/30',
                                            'error' => 'bg-red-50 dark:bg-red-900/30',
                                        ];
                                        $colorText = [
                                            'info' => 'text-blue-800 dark:text-blue-300',
                                            'warning' => 'text-yellow-800 dark:text-yellow-300',
                                            'success' => 'text-green-800 dark:text-green-300',
                                            'error' => 'text-red-800 dark:text-red-300',
                                        ];
                                    @endphp
                                    <div class="p-4 {{ $colorBg[$notificacion->tipo] ?? $colorBg['info'] }}">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-semibold {{ $colorText[$notificacion->tipo] ?? $colorText['info'] }} text-sm">{{ $notificacion->titulo }}</h4>
                                                <p class="text-xs {{ $colorText[$notificacion->tipo] ?? $colorText['info'] }} mt-1">{{ $notificacion->mensaje }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $notificacion->created_at->diffForHumans() }}</p>
                                            </div>
                                            <button onclick="marcarComoLeida({{ $notificacion->id }})" class="ml-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-lg">
                                                ✕
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <p class="text-gray-500 dark:text-gray-400 text-sm">No tienes notificaciones</p>
                            </div>
                        @endif
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-700 hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white font-semibold me-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('player.perfil')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('player.equipos')">
                            {{ __('Mis Equipos') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('player.eventos')">
                            {{ __('Mis Eventos') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('eventos.index')" :active="request()->routeIs('eventos.*')">
                {{ __('Eventos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('equipos.index')" :active="request()->routeIs('equipos.*')">
                {{ __('Equipos') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('player.perfil')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('player.equipos')">
                    {{ __('Mis Equipos') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('player.eventos')">
                    {{ __('Mis Eventos') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleNotificaciones() {
    const panel = document.getElementById('notificacionesPanel');
    panel.classList.toggle('hidden');
}

function marcarComoLeida(notificacionId) {
    fetch(`/notificaciones/${notificacionId}/marcar-leida`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
    }).then(() => location.reload());
}

// Cerrar panel al hacer clic fuera
document.addEventListener('click', function(event) {
    const panel = document.getElementById('notificacionesPanel');
    const campanita = event.target.closest('button');
    if (!event.target.closest('.relative') && panel && !panel.classList.contains('hidden')) {
        panel.classList.add('hidden');
    }
});
</script>