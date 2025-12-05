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
                            <textarea name="descripcion" rows="4" placeholder="Descripción"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
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

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                            <p class="text-blue-800 text-sm">
                                <strong>ℹ️ Nota:</strong> Tu equipo será sometido a revisión por los administradores. 
                                Una vez aprobado, podrás unirte a los eventos que desees.
                            </p>
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
