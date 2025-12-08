<!DOCTYPE html>
<html lang="es"> {{-- Quitamos la clase "light" forzada --}}
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración de Cuenta - CodeQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }
    </style>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#E53965",
                        "background-light": "#FFFFFF",
                        "background-dark": "#111827",
                        "surface-light": "#F3F4F6",
                        "surface-dark": "#1F2937",
                        "text-light-primary": "#1F2937",
                        "text-dark-primary": "#F9FAFB",
                        "text-light-secondary": "#6B7280",
                        "text-dark-secondary": "#9CA3AF",
                        "border-light": "#E5E7EB",
                        "border-dark": "#374151"
                    },
                    fontFamily: { display: ["Inter", "sans-serif"] },
                    borderRadius: { DEFAULT: "0.5rem" },
                },
            },
        };
    </script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 p-6 shrink-0 border-r border-border-light dark:border-border-dark hidden md:flex flex-col fixed inset-y-0 left-0 bg-background-light dark:bg-background-dark z-10">
        <h1 class="text-2xl font-bold mb-12 text-primary">CodeQuest</h1>
        
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">gavel</span>
                        <span>Jueces</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded bg-surface-light dark:bg-surface-dark font-semibold text-text-light-primary dark:text-text-dark-primary" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Logout al final del sidebar --}}
        <div class="mt-auto pt-8 border-t border-border-light dark:border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 md:pl-72 lg:pl-72"> {{-- Espacio para el sidebar fijo --}}
        <div class="max-w-3xl mx-auto">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-8 shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- INFORMACIÓN PERSONAL --}}
            <section class="mb-12 bg-surface-light dark:bg-surface-dark p-8 rounded-lg shadow-sm">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">badge</span> Información Personal
                </h3>
                
                <form action="{{ route('admin.updateInfo') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('nombre') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', auth()->user()->apellido_paterno) }}" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('apellido_paterno') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', auth()->user()->apellido_materno) }}" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('apellido_materno') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('email') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="bg-primary text-white font-semibold py-3 px-8 rounded hover:bg-opacity-90 transition-all shadow-md active:scale-95">
                        Guardar Información
                    </button>
                </form>
            </section>

            {{-- CAMBIO DE CONTRASEÑA --}}
            <section class="bg-surface-light dark:bg-surface-dark p-8 rounded-lg shadow-sm">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">lock</span> Seguridad de la Cuenta
                </h3>
                
                <form action="{{ route('admin.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="max-w-md space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">Contraseña Actual</label>
                            <input type="password" name="current_password" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('current_password') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Nueva Contraseña</label>
                            <input type="password" name="password" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('password') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full rounded border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
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