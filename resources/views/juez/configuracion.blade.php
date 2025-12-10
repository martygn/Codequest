<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuración - Panel del Juez</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

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
                        display: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0A192F; }
        ::-webkit-scrollbar-thumb { background: #233554; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64FFDA; }
    </style>
</head>
<body class="bg-background-dark font-display text-text-dark antialiased">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-card-dark border-r border-border-dark p-6 flex flex-col justify-between shadow-xl z-20">
        <div>
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
                <div>
                    <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
                    <p class="text-xs text-text-secondary-dark mt-1">Panel del Juez</p>
                </div>
            </div>

            <nav class="space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.panel') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('juez.constancias') }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Constancias</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="{{ route('juez.configuracion') }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Configuración</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-text-secondary-dark hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-background-dark p-8 relative">

        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-3xl mx-auto relative z-10">

            <header class="mb-8">
                <h2 class="text-4xl font-bold text-text-dark">Configuración de Cuenta</h2>
                <p class="text-text-secondary-dark mt-2">Administra tu información personal y seguridad</p>
            </header>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl mb-8 shadow-lg flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- INFORMACIÓN PERSONAL --}}
            <section class="mb-12 bg-card-dark p-8 rounded-xl shadow-lg border border-border-dark">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2 text-text-dark">
                    <span class="material-symbols-outlined text-primary">badge</span> Información Personal
                </h3>

                <form action="{{ route('juez.updateInfo') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('nombre') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', auth()->user()->apellido_paterno) }}" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('apellido_paterno') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', auth()->user()->apellido_materno) }}" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('apellido_materno') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-background-dark font-bold rounded-lg hover:bg-primary/90 shadow-lg transition-all">
                        <span class="material-symbols-outlined">save</span>
                        Guardar Información
                    </button>
                </form>
            </section>

            {{-- CAMBIO DE CONTRASEÑA --}}
            <section class="bg-card-dark p-8 rounded-xl shadow-lg border border-border-dark">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2 text-text-dark">
                    <span class="material-symbols-outlined text-primary">lock</span> Seguridad de la Cuenta
                </h3>

                <form action="{{ route('juez.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="max-w-md space-y-6">
                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Contraseña Actual</label>
                            <input type="password" name="current_password" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('current_password') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Nueva Contraseña</label>
                            <input type="password" name="password" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                            @error('password') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary uppercase mb-2">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full rounded-lg border border-border-dark bg-background-dark text-text-dark focus:ring-2 focus:ring-primary focus:border-primary transition-all px-4 py-3">
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-background-dark font-bold rounded-lg hover:bg-primary/90 shadow-lg transition-all">
                            <span class="material-symbols-outlined">lock_reset</span>
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
