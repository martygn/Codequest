<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Crear Juez - CodeQuest</title>
    
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
            <div class="w-8 h-8 rounded bg-primary/10 flex items-center justify-center text-primary font-bold">CQ</div>
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.jueces') }}">
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.configuracion') }}">
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

        <div class="relative z-10 max-w-2xl mx-auto">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-text-dark">Crear Juez</h1>
                    <p class="text-text-secondary-dark text-sm mt-1">Registra un nuevo evaluador para el sistema.</p>
                </div>
                <a href="{{ route('admin.jueces') }}" class="text-text-secondary-dark hover:text-primary flex items-center gap-2 text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Volver
                </a>
            </div>

            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-8">
                
                <form action="{{ route('admin.jueces.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Nombre</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-3 text-text-secondary-dark">person</span>
                                <input type="text" name="nombre" required
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all"
                                    placeholder="Ej. Roberto">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" required
                                class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all"
                                placeholder="Ej. Gómez">
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Apellido Materno</label>
                            <input type="text" name="apellido_materno"
                                class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all"
                                placeholder="Ej. Pérez">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Correo Electrónico</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-3 text-text-secondary-dark">mail</span>
                                <input type="email" name="correo" required
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all"
                                    placeholder="juez@codequest.com">
                            </div>
                            @error('correo') 
                                <p class="text-red-400 text-xs mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span> {{ $message }}
                                </p> 
                            @enderror
                        </div>
                    </div>

                    <div class="bg-primary/5 border border-primary/20 rounded-lg p-4 flex items-start gap-3 text-sm text-text-secondary-dark">
                        <span class="material-symbols-outlined text-primary mt-0.5">info</span>
                        <p>Al crear el juez, se generará una contraseña aleatoria automáticamente y las credenciales de acceso serán enviadas al correo electrónico proporcionado.</p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-primary text-background-dark font-bold py-2.5 px-6 rounded-lg hover:bg-opacity-90 shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Registrar Juez
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

</body>
</html>