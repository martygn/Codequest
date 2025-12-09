<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Perfil - Panel Admin</title>

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
        /* Scrollbar oscura para que combine */
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
                    <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
                </div>

                <nav class="space-y-1">
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">gavel</span>
                        <span>Jueces</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <span>Resultados</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-primary bg-active-dark border-l-2 border-primary rounded-r-lg font-medium" href="{{ route('admin.perfil') }}">
                        <span class="material-symbols-outlined">person</span>
                        <span>Perfil</span>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-3 text-text-secondary-dark rounded-lg hover:text-primary hover:bg-white/5 transition-all" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </nav>
            </div>

            <div class="pt-4 border-t border-border-dark">
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

            <!-- Efecto de fondo -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-5xl mx-auto relative z-10">

                <!-- Breadcrumb -->
                <div class="mb-8 text-sm text-text-secondary-dark">
                    <a class="text-primary hover:underline" href="{{ route('dashboard') }}">Panel de control</a>
                    <span> / </span>
                    <span>Perfil</span>
                </div>

                <!-- Card de Perfil -->
                <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark overflow-hidden">

                    <!-- Banner y Avatar -->
                    <div class="relative">
                        <div class="w-full h-48 bg-gradient-to-r from-primary/20 via-primary/10 to-transparent relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                        </div>
                        <div class="absolute -bottom-16 left-8">
                            <div class="w-32 h-32 rounded-full border-4 border-card-dark bg-border-dark flex items-center justify-center shadow-xl">
                                <span class="material-symbols-outlined text-6xl text-primary">person</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido del Perfil -->
                    <div class="pt-20 px-8 pb-8">
                        <h2 class="text-3xl font-bold text-text-dark mb-2">{{ Auth::user()->nombre ?? 'Usuario' }}</h2>
                        <p class="text-sm text-text-secondary-dark mb-6">Administrador del sistema</p>

                        <!-- Datos Generales -->
                        <div class="border-t border-border-dark pt-6">
                            <h3 class="text-lg font-semibold text-text-dark mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">badge</span>
                                Datos generales
                            </h3>

                            <div class="space-y-6">
                                <!-- Nombre -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="text-xs font-mono text-primary uppercase">Nombre:</label>
                                    <p class="md:col-span-2 text-text-dark font-medium">{{ Auth::user()->nombre_completo ?? 'N/A' }}</p>
                                </div>

                                <!-- Correo -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="text-xs font-mono text-primary uppercase">Correo:</label>
                                    <p class="md:col-span-2 text-text-dark font-medium">{{ Auth::user()->correo ?? Auth::user()->email ?? 'N/A' }}</p>
                                </div>

                                <!-- Tipo de Usuario -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="text-xs font-mono text-primary uppercase">Tipo de Usuario:</label>
                                    <div class="md:col-span-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-primary/10 text-primary border border-primary/30 font-bold text-sm uppercase tracking-wide">
                                            {{ ucfirst(Auth::user()->tipo ?? 'admin') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Contraseña -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="text-xs font-mono text-primary uppercase">Contraseña:</label>
                                    <p class="md:col-span-2 text-text-secondary-dark tracking-widest font-mono">••••••••</p>
                                </div>
                            </div>

                            <!-- Botón Cambiar Contraseña -->
                            <div class="mt-8">
                                <a href="{{ route('admin.configuracion') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-background-dark font-bold rounded-lg hover:bg-primary/90 shadow-lg transition-all">
                                    <span class="material-symbols-outlined text-lg">lock_reset</span>
                                    Cambiar Contraseña
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón Eliminar Cuenta (Separado) -->
                <div class="flex justify-end mt-8">
                    <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 shadow-lg transition-all">
                        <span class="material-symbols-outlined text-lg">delete_forever</span>
                        Eliminar Cuenta
                    </button>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
