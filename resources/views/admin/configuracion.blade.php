<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración de Cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
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
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary">
<div class="flex min-h-screen">
    <aside class="w-64 p-6 shrink-0 border-r border-border-light dark:border-border-dark">
        <h1 class="text-2xl font-bold mb-12 text-primary">CodeQuest</h1>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.perfil') }}">
                        <span class="material-symbols-outlined">account_circle</span>
                        <span>Perfil</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_month</span>
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
                    <a class="flex items-center gap-3 px-4 py-2 rounded bg-surface-light dark:bg-surface-dark font-semibold text-text-light-primary dark:text-text-dark-primary transition-colors" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-10">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-bold mb-10 text-text-light-primary dark:text-text-dark-primary">Configuración</h2>

            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8 shadow-sm" role="alert">
                    <strong class="font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        ¡Éxito!
                    </strong>
                    <span class="block sm:inline ml-7">{{ session('success') }}</span>
                </div>
            @endif

            <section class="mb-12 bg-surface-light dark:bg-surface-dark p-6 rounded-lg shadow-sm">
                <h3 class="text-2xl font-bold mb-6 text-text-light-primary dark:text-text-dark-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">badge</span> Información Personal
                </h3>
                
                {{-- IMPORTANTE: Ruta debe coincidir con web.php --}}
                <form action="{{ route('admin.updateInfo') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="nombre">Nombre</label>
                        {{-- IMPORTANTE: name="name" --}}
                        <input 
                            class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary transition-all" 
                            id="nombre" 
                            name="name" 
                            value="{{ old('name', auth()->user()->name) }}" 
                            type="text"
                            required
                        />
                        @error('name')
                            <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="email">Correo electrónico</label>
                        {{-- IMPORTANTE: name="email" --}}
                        <input 
                            class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary transition-all" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', auth()->user()->email) }}" 
                            type="email"
                            required
                        />
                        @error('email')
                            <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button class="bg-primary text-white font-semibold py-2 px-6 rounded hover:bg-opacity-90 transition-all shadow-md active:scale-95" type="submit">
                            Guardar Información
                        </button>
                    </div>
                </form>
            </section>

            <section class="bg-surface-light dark:bg-surface-dark p-6 rounded-lg shadow-sm">
                <h3 class="text-2xl font-bold mb-6 text-text-light-primary dark:text-text-dark-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">lock</span> Seguridad de la Cuenta
                </h3>
                
                <form action="{{ route('admin.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="current_password">Contraseña Actual</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary focus:ring-primary focus:border-primary transition-all" 
                            id="current_password" 
                            name="current_password" 
                            type="password" 
                            required
                        />
                        @error('current_password')
                            <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-border-light dark:border-border-dark pt-4">
                        <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="new_password">Nueva Contraseña</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary focus:ring-primary focus:border-primary transition-all" 
                            id="new_password" 
                            name="password" 
                            type="password" 
                            required
                        />
                        @error('password')
                            <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="confirm_password">Confirmar Nueva Contraseña</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary focus:ring-primary focus:border-primary transition-all" 
                            id="confirm_password" 
                            name="password_confirmation" 
                            type="password" 
                            required
                        />
                    </div>

                    <div>
                        <button class="bg-primary text-white font-semibold py-2 px-6 rounded hover:bg-opacity-90 transition-all shadow-md active:scale-95" type="submit">
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