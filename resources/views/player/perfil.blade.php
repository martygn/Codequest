<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">¡Operación exitosa!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- ENCABEZADO (Sin el icono 'person') --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Información Personal</h3>
                        <p class="text-sm text-gray-500">Actualiza tus datos personales y correo electrónico.</p>
                    </div>

                    <form action="{{ route('player.perfil.update') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- GRID DE 3 COLUMNAS PARA NOMBRE Y APELLIDOS --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- 1. Nombre --}}
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" name="nombre" id="nombre" 
                                    value="{{ old('nombre', $user->nombre) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('nombre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- 2. Apellido Paterno --}}
                            <div>
                                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno" 
                                    value="{{ old('apellido_paterno', $user->apellido_paterno) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('apellido_paterno') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- 3. Apellido Materno --}}
                            <div>
                                <label for="apellido_materno" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno" 
                                    value="{{ old('apellido_materno', $user->apellido_materno) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('apellido_materno') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Correo Electrónico --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" name="email" id="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Botones y Rol --}}
                        <div class="pt-4 flex items-center gap-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Guardar Cambios
                            </button>
                            
                            <span class="text-sm text-gray-400">
                                Rol: {{ ucfirst($user->tipo ?? 'Participante') }}
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>