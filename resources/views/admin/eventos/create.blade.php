<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Crear Evento - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
                <nav class="mt-8 space-y-2">
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined filled">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-3xl">
                <div class="mb-8">
                    <a href="{{ route('admin.eventos') }}" class="text-primary hover:underline flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Volver
                    </a>
                    <h2 class="text-4xl font-bold text-slate-900 dark:text-white mt-4">Crear Nuevo Evento</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Completa los detalles del evento</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                    <div class="p-6">
                        <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Nombre del Evento</label>
                                <input type="text" name="nombre" placeholder="Ingresa el nombre del evento" value="{{ old('nombre') }}"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Descripción del Evento</label>
                                <textarea name="descripcion" rows="4" 
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Fecha de Inicio</label>
                                    <input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Fecha de Fin</label>
                                    <input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin') }}"
                                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Reglas del Evento</label>
                                <textarea name="reglas" rows="4" 
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">{{ old('reglas') }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Premios</label>
                                <textarea name="premios" rows="4" 
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">{{ old('premios') }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Otra Información Relevante</label>
                                <textarea name="otra_informacion" rows="4" 
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">{{ old('otra_informacion') }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Imagen del Evento</label>
                                <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-lg p-10 text-center hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors relative">
                                    <input type="file" name="foto" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-400 mb-2">image</span>
                                        <p class="font-semibold text-slate-700 dark:text-slate-300 mb-1">Cargar Imagen</p>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm">Arrastra y suelta o haz clic para seleccionar</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Estado del Evento</label>
                                <select name="estado" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" required>
                                    <option value="pendiente" {{ old('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="publicado" {{ old('estado') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                                </select>
                            </div>

                            <div class="flex justify-end gap-4">
                                <a href="{{ route('admin.eventos') }}" class="px-6 py-2 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition font-semibold">
                                    Cancelar
                                </a>
                                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                    Crear Evento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
