<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Registro de Evento</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre del Evento</label>
                            <input type="text" name="nombre" placeholder="Ingresa el nombre del evento"
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Descripción del Evento</label>
                            <textarea name="descripcion" rows="4" 
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Fecha de Inicio</label>
                                <input type="datetime-local" name="fecha_inicio" 
                                    class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Fecha de Fin</label>
                                <input type="datetime-local" name="fecha_fin" 
                                    class="w-full bg-gray-100 text-gray-500 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Reglas del Evento</label>
                            <textarea name="reglas" rows="4" 
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Premios</label>
                            <textarea name="premios" rows="4" 
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Otra Información Relevante</label>
                            <textarea name="otra_informacion" rows="4" 
                                class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                        </div>

                        <div class="mb-8 border-2 border-dashed border-gray-300 rounded-lg p-10 text-center hover:bg-gray-50 transition-colors relative">
                            <input type="file" name="foto" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                            <div class="flex flex-col items-center justify-center">
                                <p class="font-bold text-gray-700 text-lg mb-1">Cargar Imagen del Evento</p>
                                <p class="text-gray-500 text-sm mb-4">Arrastra y suelta una imagen aquí o haz clic para seleccionar un archivo</p>
                                <span class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded pointer-events-none">
                                    Seleccionar Archivo
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="estado" value="pendiente">

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded shadow-lg transition duration-200">
                                Registrar Evento
                            </button>
                        </div>

                    </form> 
                </div> 
            </div> 
        </div>
    </div>
</x-app-layout>