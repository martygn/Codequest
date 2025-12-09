<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración - CodeQuest</title>
    
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
            <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
            
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>
        
        <nav class="flex-grow px-4 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">gavel</span>
                        <span>Jueces</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <span>Resultados</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.configuracion') }}">
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
            
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg flex items-center gap-3 shadow-lg animate-pulse">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <header class="mb-8">
                <h1 class="text-3xl font-bold text-text-dark">Configuración de Cuenta</h1>
                <p class="text-text-secondary-dark text-sm mt-1">Gestiona tu perfil y seguridad.</p>
            </header>

            <div class="grid gap-8">

                <section class="bg-card-dark p-8 rounded-xl shadow-lg border border-border-dark relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <span class="material-symbols-outlined text-9xl text-primary">badge</span>
                    </div>

                    <h3 class="text-xl font-bold text-text-dark mb-6 flex items-center gap-2 relative z-10">
                        <span class="material-symbols-outlined text-primary">person</span> Información Personal
                    </h3>
                    
                    <form action="{{ route('admin.updateInfo') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none placeholder-text-secondary-dark/30">
                                @error('nombre') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', auth()->user()->apellido_paterno) }}" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none">
                                @error('apellido_paterno') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Apellido Materno</label>
                                <input type="text" name="apellido_materno" value="{{ old('apellido_materno', auth()->user()->apellido_materno) }}" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none">
                                @error('apellido_materno') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Correo electrónico</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none">
                                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="bg-primary text-background-dark font-bold py-3 px-6 rounded-lg hover:bg-opacity-90 transition-all shadow-[0_0_15px_rgba(100,255,218,0.3)] hover:translate-y-[-2px]">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </section>

                <section class="bg-card-dark p-8 rounded-xl shadow-lg border border-border-dark relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <span class="material-symbols-outlined text-9xl text-primary">lock_reset</span>
                    </div>

                    <h3 class="text-xl font-bold text-text-dark mb-6 flex items-center gap-2 relative z-10">
                        <span class="material-symbols-outlined text-primary">shield_lock</span> Seguridad
                    </h3>
                    
                    <form action="{{ route('admin.updatePassword') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf @method('PUT')

                        <div class="max-w-md space-y-6">
                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Contraseña Actual</label>
                                <input type="password" name="current_password" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none">
                                @error('current_password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Nueva Contraseña</label>
                                <input type="password" name="password" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none">
                                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-mono text-primary mb-2 uppercase">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary transition-all px-4 py-3 outline-none">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="border border-primary text-primary font-bold py-3 px-6 rounded-lg hover:bg-primary/10 transition-all">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </section>

            </div>
        </div>
    </main>
</div>

</body>
</html>