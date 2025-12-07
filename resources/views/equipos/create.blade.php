<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-gray-900 mb-8">Crear Nuevo Equipo</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('equipos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del Equipo *</label>
                            <input type="text" name="nombre" placeholder="Equipo Minecraft"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del Proyecto *</label>
                            <input type="text" name="nombre_proyecto"
                                placeholder="Sistema de gestión de inventarios"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Descripción del Equipo *</label>
                            <textarea name="descripcion" rows="4" placeholder="Describe tu equipo y proyecto..."
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required></textarea>
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
                                <p class="font-bold text-gray-700 text-lg mb-1">Imagen del Equipo</p>
                                <p class="text-gray-500 text-sm mb-4">Arrastra y suelta una imagen aquí o haz clic para seleccionar un archivo</p>
                                <span class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded pointer-events-none">
                                    Seleccionar Archivo
                                </span>
                            </div>
                        </div>

                        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Tu equipo será revisado por un administrador antes de ser aprobado y aparecer en la lista pública.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('equipos.index') }}"
                               class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                                ← Volver a equipos
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded shadow-lg transition duration-200">
                                Crear Equipo
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
