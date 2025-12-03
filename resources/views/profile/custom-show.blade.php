<x-app-layout>
    <div class="py-12 bg-white">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="relative mb-16">
                <div class="h-48 w-full bg-cover bg-center rounded-lg" 
                     style="background-image: url('https://wallpapers.com/images/featured/minecraft-background-c62i8585q8m7koxq.jpg');">
                </div>

                <div class="absolute -bottom-12 left-10">
                    <img class="h-32 w-32 rounded-full border-4 border-white shadow-lg object-cover" 
                         src="https://ui-avatars.com/api/?name=Mendoza+Yael&background=random&size=128" 
                         alt="Avatar">
                </div>
            </div>

            <div class="px-10">
                <h1 class="text-3xl font-bold text-gray-900">Mendoza Villafaña Eder Yael</h1>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Datos generales:</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-3">
                                <span class="text-gray-500">Nombre:</span>
                                <span class="col-span-2 font-medium text-gray-900">Mendoza Villafaña Eder Yael</span>
                            </div>
                            <div class="grid grid-cols-3">
                                <span class="text-gray-500">Correo:</span>
                                <span class="col-span-2 font-medium text-gray-900">mendozaederyael@gmail.com</span>
                            </div>
                            <div class="grid grid-cols-3">
                                <span class="text-gray-500">Contraseña:</span>
                                <span class="col-span-2 font-medium text-gray-900">*********</span>
                            </div>
                        </div>
                        
                        <button class="mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                            Cambiar Contraseña
                        </button>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <h3 class="text-lg font-bold text-gray-800 mb-4">Mis Equipos:</h3>
                
                <div class="bg-white border border-gray-100 p-4 rounded-lg shadow-sm mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                        <div>
                            <p class="text-xs text-gray-500">Evento Hackathon</p>
                            <p class="font-bold text-sm">15 de Octubre de 2024</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Equipo:</p>
                            <p class="font-bold text-sm">Equipo Minecraft</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Proyecto:</p>
                            <p class="font-bold text-sm">Aplicacion Movil</p>
                        </div>
                        <div class="text-right">
                            <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded hover:bg-blue-600">
                                Ver Proyecto
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <h3 class="text-lg font-bold text-gray-800 mb-4">Mis Eventos:</h3>
                
                <div class="bg-white border border-gray-100 p-4 rounded-lg shadow-sm mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                        <div>
                            <p class="text-xs text-gray-500">Evento Hackathon</p>
                            <p class="font-bold text-sm">15 de Octubre de 2024</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Rol:</p>
                            <p class="font-bold text-sm">Juez</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nombre:</p>
                            <p class="font-bold text-sm">HackaTec</p>
                        </div>
                        <div class="text-right">
                            <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded hover:bg-blue-600">
                                Ver Listado...
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow">
                        Eliminar Cuenta
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>