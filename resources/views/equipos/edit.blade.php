<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-gray-900 mb-8">Editar Equipo: {{ $equipo->nombre }}</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('equipos.update', $equipo->id_equipo) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del Equipo *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $equipo->nombre) }}"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del Proyecto *</label>
                            <input type="text" name="nombre_proyecto" value="{{ old('nombre_proyecto', $equipo->nombre_proyecto) }}"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Evento *</label>
                            <select name="id_evento"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                required>
                                <option value="">Selecciona un evento</option>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id_evento }}" {{ $equipo->id_evento == $evento->id_evento ? 'selected' : '' }}>
                                        {{ $evento->nombre }} - {{ $evento->fecha_inicio->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Descripción del Equipo</label>
                            <textarea name="descripcion" rows="4"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Banner Actual</label>
                            @if($equipo->banner)
                                <img src="{{ asset('storage/' . $equipo->banner) }}"
                                     alt="Banner actual"
                                     class="w-full h-48 object-cover rounded-lg mb-4">
                            @else
                                <p class="text-gray-500 italic">No hay banner cargado</p>
                            @endif
                        </div>

                        <div class="mb-8 border-2 border-dashed border-gray-300 rounded-lg p-10 text-center hover:bg-gray-50 transition-colors relative">
                            <input type="file" name="banner"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept="image/*">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="font-bold text-gray-700 text-lg mb-1">Cambiar Imagen del Equipo</p>
                                <p class="text-gray-500 text-sm mb-4">Haz clic para seleccionar un nuevo archivo</p>
                                <span class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded pointer-events-none">
                                    Seleccionar Archivo
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('equipos.show', $equipo->id_equipo) }}"
                               class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                                ← Cancelar
                            </a>
                            <div class="flex space-x-3">
                                @if(auth()->user()->esAdministrador())
                                    <form action="{{ route('equipos.destroy', $equipo->id_equipo) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este equipo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded shadow-lg transition duration-200">
                                            Eliminar Equipo
                                        </button>
                                    </form>
                                @endif
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded shadow-lg transition duration-200">
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
