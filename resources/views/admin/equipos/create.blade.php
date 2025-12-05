<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Crear Equipo - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#2998FF",
                        "background-light": "#F8FAFC",
                        "background-dark": "#18181B",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">CodeQuest</h1>
                <nav class="mt-8 space-y-2">
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 rounded font-semibold" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-gray-600 dark:text-gray-400 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-white dark:bg-zinc-900 p-8">
            <div class="max-w-3xl">
                <div class="mb-8">
                    <a href="{{ route('admin.equipos') }}" class="text-primary hover:underline flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Volver
                    </a>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">Crear Nuevo Equipo</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Completa los detalles del equipo</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-gray-200 dark:border-zinc-700 p-6">
                    <form action="{{ route('admin.equipos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Nombre del Equipo</label>
                            <input type="text" name="nombre" placeholder="Ingresa el nombre del equipo" value="{{ old('nombre') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition text-gray-900 dark:text-white" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Nombre del Proyecto</label>
                            <input type="text" name="nombre_proyecto" placeholder="Ingresa el nombre del proyecto" value="{{ old('nombre_proyecto') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition text-gray-900 dark:text-white" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Descripción del Equipo</label>
                            <textarea name="descripcion" rows="4" placeholder="Describe al equipo y su proyecto"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition text-gray-900 dark:text-white">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-6">
                            <p class="text-blue-800 dark:text-blue-300 text-sm">
                                <strong>ℹ️ Nota:</strong> Los equipos se crean independientemente de los eventos. Los participantes se inscribirán manualmente a los eventos después.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Banner del Equipo</label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg p-10 text-center hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors relative">
                                <input type="file" name="banner" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">image</span>
                                    <p class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Cargar Imagen</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Arrastra y suelta o haz clic para seleccionar</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Estado del Equipo</label>
                            <select name="estado" class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition text-gray-900 dark:text-white" required>
                                <option value="en revisión" {{ old('estado') === 'en revisión' ? 'selected' : '' }}>En revisión</option>
                                <option value="aprobado" {{ old('estado') === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rechazado" {{ old('estado') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.equipos') }}" class="px-6 py-2 border border-gray-300 dark:border-zinc-600 text-gray-900 dark:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition font-semibold">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:opacity-90 transition font-semibold">
                                Crear Equipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
