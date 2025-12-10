<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración de Cuenta - CodeQuest</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        // PALETA "DARK TECH"
                        primary: "#64FFDA", // Turquesa
                        "background-dark": "#0A192F",  // Azul Muy Oscuro
                        "card-dark": "#112240",        // Azul Profundo
                        "text-dark": "#CCD6F6",        // Azul Claro
                        "text-secondary-dark": "#8892B0", // Gris Azulado
                        "border-dark": "#233554",      // Bordes
                        "active-dark": "rgba(100, 255, 218, 0.1)", // Hover activo
                    },
                    fontFamily: {
                        display: ["Roboto", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        /* Scrollbar oscura */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0A192F; }
        ::-webkit-scrollbar-thumb { background: #233554; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64FFDA; }
    </style>
</head>
<body class="font-display bg-background-dark text-text-dark antialiased">

<div class="flex h-screen overflow-hidden">
    
    <aside class="w-64 bg-card-dark border-r border-border-dark flex flex-col shadow-xl z-20">
        <div class="p-6 flex items-center gap-3">
             <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-12 w-auto">
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>
        
        <nav class="flex-grow px-4 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.panel') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Evento Asignado</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('juez.constancias') }}">
                        <span class="material-symbols-outlined">description</span>
                        <span>Historial Constancias</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('juez.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="p-4 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-red-400 hover:bg-red-500/10 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto bg-background-dark relative">
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-4xl mx-auto">
            
            <header class="mb-8">
                <h2 class="text-3xl font-bold text-text-dark">Configuración de Cuenta</h2>
                <p class="text-text-secondary-dark text-sm mt-1">Administra tu información personal y seguridad</p>
            </header>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-8 flex items-center gap-2 shadow-lg">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8">
                
                {{-- INFORMACIÓN PERSONAL --}}
                <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                    <div class="p-6 border-b border-border-dark bg-[#0D1B2A]">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">badge</span>
                            Información Personal
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <form action="{{ route('juez.updateInfo') }}" method="POST" class="space-y-6">
                            @csrf @method('PUT')

                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Nombre</label>
                                    <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                        class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                                    @error('nombre') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Apellido Paterno</label>
                                    <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', auth()->user()->apellido_paterno) }}" required
                                        class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                                    @error('apellido_paterno') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Apellido Materno</label>
                                    <input type="text" name="apellido_materno" value="{{ old('apellido_materno', auth()->user()->apellido_materno) }}" required
                                        class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                                    @error('apellido_materno') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Correo Electrónico</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                        class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                                    @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-primary text-background-dark font-bold py-2.5 px-6 rounded-lg hover:bg-opacity-90 shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5 text-sm flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">save</span>
                                    Guardar Información
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- SEGURIDAD --}}
                <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">
                    <div class="p-6 border-b border-border-dark bg-[#0D1B2A]">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">lock</span>
                            Seguridad de la Cuenta
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <form action="{{ route('juez.updatePassword') }}" method="POST" class="space-y-6">
                            @csrf @method('PUT')

                            <div class="max-w-md space-y-6">
                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Contraseña Actual</label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary-dark text-lg">key</span>
                                        <input type="password" name="current_password" required
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder-text-secondary-dark/30">
                                    </div>
                                    @error('current_password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Nueva Contraseña</label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary-dark text-lg">lock_reset</span>
                                        <input type="password" name="password" required
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                                    </div>
                                    @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Confirmar Nueva Contraseña</label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-text-secondary-dark text-lg">check_circle</span>
                                        <input type="password" name="password_confirmation" required
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-start pt-2">
                                <button type="submit" class="bg-primary/10 text-primary border border-primary/30 font-bold py-2.5 px-6 rounded-lg hover:bg-primary hover:text-background-dark transition-all text-sm flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">update</span>
                                    Actualizar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

</body>
</html>