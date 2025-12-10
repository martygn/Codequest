<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Crear Evento - CodeQuest</title>
    
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
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('admin.eventos') }}">
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

        <div class="relative z-10 max-w-3xl mx-auto">
            
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-text-dark">Crear Nuevo Evento</h1>
                    <p class="text-text-secondary-dark text-sm mt-1">Completa los detalles para lanzar una nueva competencia.</p>
                </div>
                <a href="{{ route('admin.eventos') }}" class="text-text-secondary-dark hover:text-primary flex items-center gap-2 text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Volver
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-start gap-3">
                    <span class="material-symbols-outlined mt-0.5 text-lg">error</span>
                    <div>
                        <p class="font-bold text-sm mb-1">Por favor corrige los siguientes errores:</p>
                        <ul class="list-disc list-inside text-xs opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-card-dark rounded-xl shadow-lg border border-border-dark p-8">
                
                <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Nombre del Evento</label>
                        <input type="text" name="nombre" placeholder="Ej. Hackathon 2025" value="{{ old('nombre') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all">
                    </div>

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Descripción</label>
                        <textarea name="descripcion" rows="4" placeholder="Detalles generales del evento..."
                            class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all resize-none">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Fecha de Inicio</label>
                            <input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio') }}" 
                                min="{{ now()->format('Y-m-d\TH:i') }}" required
                                class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all [color-scheme:dark]">
                        </div>
                        <div>
                            <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Fecha de Fin</label>
                            <input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin') }}" 
                                min="{{ now()->format('Y-m-d\TH:i') }}" required
                                class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all [color-scheme:dark]">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Reglas del Evento</label>
                        <textarea name="reglas" rows="4" placeholder="Especifica las normas..."
                            class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all resize-none">{{ old('reglas') }}</textarea>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Premios</label>
                        <textarea name="premios" rows="3" placeholder="¿Qué ganarán los participantes?"
                            class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all resize-none">{{ old('premios') }}</textarea>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Otra Información Relevante</label>
                        <textarea name="otra_informacion" rows="3" placeholder="Notas adicionales..."
                            class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary placeholder-text-secondary-dark/30 outline-none transition-all resize-none">{{ old('otra_informacion') }}</textarea>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Imagen del Evento</label>
                        <div class="border-2 border-dashed border-border-dark hover:border-primary rounded-lg p-8 text-center transition-colors relative cursor-pointer group bg-background-dark/50">
                            <input type="file" name="foto" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                            <div class="flex flex-col items-center justify-center pointer-events-none">
                                <span class="material-symbols-outlined text-4xl text-text-secondary-dark group-hover:text-primary mb-2 transition-colors">image</span>
                                <p class="font-bold text-text-dark text-sm group-hover:text-white transition-colors">Cargar Imagen</p>
                                <p class="text-text-secondary-dark text-xs mt-1">PNG, JPG hasta 5MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-mono text-primary mb-2 uppercase tracking-wide">Estado Inicial</label>
                        <select name="estado" required class="w-full px-4 py-2.5 rounded-lg bg-background-dark border border-border-dark text-text-dark focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all">
                            <option value="pendiente" {{ old('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente (Borrador)</option>
                            <option value="publicado" {{ old('estado') === 'publicado' ? 'selected' : '' }}>Publicado (Visible)</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-border-dark mt-8">
                        <a href="{{ route('admin.eventos') }}" class="px-6 py-2.5 border border-border-dark text-text-secondary-dark hover:text-white hover:border-white rounded-lg text-sm font-bold transition-all">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-primary text-background-dark rounded-lg hover:bg-opacity-90 shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5 text-sm font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Crear Evento
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </main>
</div>

</body>
</html>