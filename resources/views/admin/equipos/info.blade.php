<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Información del Equipo - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('admin.equipos') }}" class="text-blue-600 hover:underline flex items-center gap-2">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Volver a Equipos
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                    <h1 class="text-3xl font-bold text-white">{{ $info['nombre'] }}</h1>
                    <p class="text-blue-100 mt-2">{{ $info['nombre_proyecto'] }}</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Estado</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $info['estado'] === 'aprobado' ? 'bg-green-100 text-green-800' :
                                       ($info['estado'] === 'rechazado' ? 'bg-red-100 text-red-800' :
                                       'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($info['estado']) }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Líder</h3>
                                <p class="text-gray-900 dark:text-white">{{ $info['lider'] }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Evento</h3>
                                <p class="text-gray-900 dark:text-white">{{ $info['evento'] }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Miembros</h3>
                                <p class="text-gray-900 dark:text-white">{{ $info['num_miembros'] }} / 4</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Fecha de Creación</h3>
                                <p class="text-gray-900 dark:text-white">{{ $info['fecha_creacion'] }}</p>
                            </div>

                            @if($equipo->descripcion)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">Descripción</h3>
                                <p class="text-gray-900 dark:text-white mt-1">{{ $equipo->descripcion }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($equipo->evento && $equipo->evento->estaActivo())
                    <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                        <p class="text-yellow-800 dark:text-yellow-300 text-sm">
                            ⚠️ Este equipo está participando en un evento activo.
                            No se puede rechazar mientras el evento esté en curso.
                        </p>
                    </div>
                    @endif

                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-end space-x-4">
                            <form action="{{ route('equipos.update-status', $equipo->id_equipo) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="estado" class="border rounded px-3 py-2 mr-2">
                                    <option value="en revisión" {{ $equipo->estado == 'en revisión' ? 'selected' : '' }}>En revisión</option>
                                    <option value="aprobado" {{ $equipo->estado == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rechazado" {{ $equipo->estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Actualizar Estado
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
