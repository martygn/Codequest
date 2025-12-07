<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración de Cuenta | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
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
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24 }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary">
<div class="flex min-h-screen">
    <aside class="w-64 p-6 shrink-0 border-r border-border-light dark:border-border-dark">
        <h1 class="text-2xl font-bold mb-12 text-primary">CodeQuest <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded ml-2">Admin</span></h1>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Panel Principal</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_month</span>
                        <span>Gestionar Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Gestionar Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.perfil') }}">
                        <span class="material-symbols-outlined">account_circle</span>
                        <span>Perfil Admin</span>
                    </a>
                </li>
                <li>
                    {{-- Enlace activo --}}
                    <a class="flex items-center gap-3 px-4 py-2 rounded bg-surface-light dark:bg-surface-dark font-semibold text-text-light-primary dark:text-text-dark-primary transition-colors" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="mt-12 pt-6 border-t border-gray-200">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded w-full transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10">
        <div class="max-w-3xl">
            <h2 class="text-4xl font-bold mb-10">Configuración</h2>

            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <section class="mb-12">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">badge</span> Información Personal
                </h3>
                
                {{-- Formulario 1: Actualizar Info --}}
                <form action="{{ route('admin.configuracion.updateInfo') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" for="nombre">Nombre</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light focus:ring-primary focus:border-primary" 
                            id="nombre" 
                            name="name" 
                            value="{{ old('name', auth()->user()->name) }}" 
                            type="text"
                            required
                        />
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" for="email">Correo electrónico</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light focus:ring-primary focus:border-primary" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', auth()->user()->email) }}" 
                            type="email"
                            required
                        />
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button class="bg-primary text-white font-semibold py-2 px-6 rounded hover:opacity-90 transition-opacity" type="submit">
                        Guardar Cambios
                    </button>
                </form>
            </section>

            <section class="border-t pt-10">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined">lock</span> Seguridad de la Cuenta
                </h3>
                
                {{-- Formulario 2: Cambiar Contraseña --}}
                <form action="{{ route('admin.configuracion.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2" for="current_password">Contraseña Actual</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light focus:ring-primary focus:border-primary" 
                            id="current_password" 
                            name="current_password" 
                            type="password" 
                            placeholder="Para confirmar cambios"
                            required
                        />
                        @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" for="new_password">Nueva Contraseña</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light focus:ring-primary focus:border-primary" 
                            id="new_password" 
                            name="password" 
                            type="password" 
                            placeholder="Mínimo 8 caracteres"
                            required
                        />
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2" for="confirm_password">Confirmar Nueva Contraseña</label>
                        <input 
                            class="w-full max-w-md rounded border border-border-light focus:ring-primary focus:border-primary" 
                            id="confirm_password" 
                            name="password_confirmation" 
                            type="password" 
                            placeholder="Repite la nueva contraseña"
                            required
                        />
                    </div>

                    <button class="bg-primary text-white font-semibold py-2 px-6 rounded hover:opacity-90 transition-opacity" type="submit">
                        Cambiar Contraseña
                    </button>
                </form>
            </section>
        </div>
    </main>
</div>
</body>
</html>