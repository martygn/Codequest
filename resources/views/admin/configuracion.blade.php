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
        
        {{-- SIDEBAR (BARRA LATERAL) --}}
        {{-- Agregamos 'flex flex-col' para poder empujar el logout hacia abajo --}}
        <aside class="w-64 p-6 shrink-0 border-r border-border-light dark:border-border-dark hidden md:flex flex-col fixed h-full bg-background-light dark:bg-background-dark z-10">
            <h1 class="text-2xl font-bold mb-12 text-primary">CodeQuest</h1>
            
            {{-- Menú de Navegación --}}
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
                        <a class="flex items-center gap-3 px-4 py-2 rounded bg-surface-light dark:bg-surface-dark font-semibold text-text-light-primary dark:text-text-dark-primary transition-colors" href="{{ route('admin.configuracion') }}">
                            <span class="material-symbols-outlined">settings</span>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- BOTÓN CERRAR SESIÓN (AL FINAL DE LA BARRA) --}}
            <div class="mt-auto border-t border-border-light dark:border-border-dark pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        {{-- Agregamos 'md:ml-64' para dejar espacio a la sidebar fija --}}
        <main class="flex-1 p-10 md:ml-64">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold mb-10 text-text-light-primary dark:text-text-dark-primary">Configuración</h2>

                {{-- MENSAJE DE ÉXITO --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8 shadow-sm flex items-center gap-3" role="alert">
                        <span class="material-symbols-outlined">check_circle</span>
                        <div>
                            <strong class="font-bold">¡Éxito!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                {{-- FORMULARIO DE INFORMACIÓN PERSONAL --}}
                <section class="mb-12 bg-surface-light dark:bg-surface-dark p-6 rounded-lg shadow-sm">
                    <h3 class="text-2xl font-bold mb-6 text-text-light-primary dark:text-text-dark-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">badge</span> Información Personal
                    </h3>
                    
                    <form action="{{ route('admin.updateInfo') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        {{-- 1. Campo Nombre --}}
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="nombre">Nombre</label>
                            <input 
                                class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary transition-all" 
                                id="nombre" 
                                name="nombre" 
                                value="{{ old('nombre', auth()->user()->nombre) }}" 
                                type="text"
                                required
                            />
                            @error('nombre')
                                <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2. Campo Apellido Paterno --}}
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="apellido_paterno">Apellido Paterno</label>
                            <input 
                                class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary transition-all" 
                                id="apellido_paterno" 
                                name="apellido_paterno" 
                                value="{{ old('apellido_paterno', auth()->user()->apellido_paterno) }}" 
                                type="text"
                                required
                            />
                            @error('apellido_paterno')
                                <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 3. Campo Apellido Materno --}}
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="apellido_materno">Apellido Materno</label>
                            <input 
                                class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary transition-all" 
                                id="apellido_materno" 
                                name="apellido_materno" 
                                value="{{ old('apellido_materno', auth()->user()->apellido_materno) }}" 
                                type="text"
                                required
                            />
                            @error('apellido_materno')
                                <p class="text-primary text-sm mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 4. Campo Email --}}
                        <div>
                            <label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="email">Correo electrónico</label>
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

                {{-- FORMULARIO DE PASSWORD --}}
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