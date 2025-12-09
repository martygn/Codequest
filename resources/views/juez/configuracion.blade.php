<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración de Cuenta - CodeQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
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
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between fixed inset-y-0 left-0 z-10">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-12">CodeQuest</h1>
            <nav class="space-y-2">
                <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('juez.panel') }}">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <span>Eventos</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('juez.constancias') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Historial de Constancias</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2 text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold" href="{{ route('juez.configuracion') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Configuración</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto pt-8 border-t border-slate-200 dark:border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 md:pl-72 lg:pl-72">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8">
                <h2 class="text-4xl font-bold text-slate-900 dark:text-white">Configuración de Cuenta</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Administra tu información personal y seguridad</p>
            </header>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-8 shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- INFORMACIÓN PERSONAL --}}
            <section class="mb-12 bg-white dark:bg-slate-900 p-8 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2 text-slate-900 dark:text-white">
                    <span class="material-symbols-outlined">badge</span> Información Personal
                </h3>

                <form action="{{ route('juez.updateInfo') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('nombre') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', auth()->user()->apellido_paterno) }}" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('apellido_paterno') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', auth()->user()->apellido_materno) }}" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('apellido_materno') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('email') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="bg-primary text-white font-semibold py-3 px-8 rounded hover:bg-opacity-90 transition-all shadow-md active:scale-95">
                        Guardar Información
                    </button>
                </form>
            </section>

            {{-- CAMBIO DE CONTRASEÑA --}}
            <section class="bg-white dark:bg-slate-900 p-8 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2 text-slate-900 dark:text-white">
                    <span class="material-symbols-outlined">lock</span> Seguridad de la Cuenta
                </h3>

                <form action="{{ route('juez.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="max-w-md space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Contraseña Actual</label>
                            <input type="password" name="current_password" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('current_password') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Nueva Contraseña</label>
                            <input type="password" name="password" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('password') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="bg-primary text-white font-semibold py-3 px-8 rounded hover:bg-opacity-90 transition-all shadow-md active:scale-95">
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </section>

        </div>
    </main>
</div>
</body>
</html>
