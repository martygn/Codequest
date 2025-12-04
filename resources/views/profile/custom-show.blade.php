<x-app-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="relative mb-16">
                <div class="h-48 w-full bg-cover bg-center rounded-lg shadow-md" 
                     style="background-image: url('https://wallpapers.com/images/featured/minecraft-background-c62i8585q8m7koxq.jpg');">
                </div>
                <div class="absolute -bottom-12 left-10">
                    <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover bg-white" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128" 
                         alt="{{ $user->name }}">
                </div>
            </div>

            <div class="px-10">
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Datos generales:</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-3">
                                <span class="text-blue-600 font-medium">Nombre:</span>
                                <span class="col-span-2 font-medium text-gray-900">{{ $user->name }}</span>
                            </div>
                            <div class="grid grid-cols-3">
                                <span class="text-blue-600 font-medium">Correo:</span>
                                <span class="col-span-2 font-medium text-gray-900">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow inline-block">
                                Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Mis Equipos:</h3>
                </div>
                
                @forelse ($user->equipos as $equipo)
                    <div class="bg-white border border-gray-100 p-4 rounded-lg shadow-sm mb-4 hover:shadow-md transition">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                            <div>
                                <p class="text-xs text-gray-500">Equipo:</p>
                                <p class="font-bold text-sm">{{ $equipo->nombre ?? 'Nombre del Equipo' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Integrantes:</p>
                                <p class="font-bold text-sm text-gray-700">
                                    {{-- Cuenta los usuarios si la relación existe, si no pone 1 --}}
                                    {{ $equipo->users_count ?? '1' }} Miembros
                                </p>
                            </div>
                            <div class="md:col-span-2 text-right">
                                <a href="{{ route('equipos.show', $equipo) }}" class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700 font-bold">
                                    Ver Mi Equipo
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-yellow-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="font-bold text-yellow-700">¡No tienes equipo!</p>
                                    <p class="text-sm text-yellow-600">Aún no te has unido a ningún equipo.</p>
                                </div>
                            </div>
                            <a href="{{ route('equipos.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow">
                                Unirme a un Equipo
                            </a>
                        </div>
                    </div>
                @endforelse

                <hr class="my-8 border-gray-200">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Mis Eventos:</h3>
                </div>

                @forelse ($user->eventos ?? [] as $evento)
                    <div class="bg-white border border-gray-100 p-4 rounded-lg shadow-sm mb-4 hover:shadow-md transition">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                            <div>
                                <p class="text-xs text-gray-500">Fecha:</p>
                                <p class="font-bold text-sm">{{ $evento->fecha ?? $evento->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Evento:</p>
                                <p class="font-bold text-sm">{{ $evento->nombre ?? 'Nombre Evento' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Estado:</p>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Inscrito</span>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('eventos.show', $evento) }}" class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700 font-bold">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 p-6 rounded-lg text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay eventos activos</h3>
                        <p class="mt-1 text-sm text-gray-500">Parece que no te has registrado en ningún evento o hackathon reciente.</p>
                        <div class="mt-6">
                            <a href="{{ route('eventos.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                                Explorar Eventos Disponibles
                            </a>
                        </div>
                    </div>
                @endforelse

                <div class="mt-10 flex justify-end">
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Seguro? Esta acción es irreversible.');">
                        @csrf @method('delete')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow">
                            Eliminar Cuenta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>