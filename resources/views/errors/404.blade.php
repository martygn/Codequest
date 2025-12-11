@if(auth()->check())
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Página no Encontrada</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    </head>
    <body class="bg-[#0A192F] text-[#8892B0]">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-2xl">
                <!-- Contenedor principal -->
                <div class="relative bg-gradient-to-br from-[#112240] to-[#0A192F] rounded-3xl overflow-hidden shadow-2xl border border-[#233554] group">
                    
                    <!-- Efectos de fondo -->
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                    <div class="absolute top-[-50%] right-[-10%] w-[500px] h-[500px] bg-[#64FFDA] rounded-full mix-blend-overlay filter blur-[120px] opacity-10 pointer-events-none group-hover:opacity-20 transition-opacity duration-700"></div>
                    <div class="absolute bottom-[-50%] left-[-10%] w-[400px] h-[400px] bg-[#1F63E1] rounded-full mix-blend-overlay filter blur-[100px] opacity-10 pointer-events-none"></div>

                    <!-- Contenido -->
                    <div class="relative z-10 px-6 py-16 md:py-24 text-center">
                        
                        <!-- Ícono 404 Animado -->
                        <div class="mb-8 inline-block">
                            <div class="relative">
                                <div class="text-9xl md:text-[150px] font-black text-transparent bg-clip-text bg-gradient-to-r from-[#64FFDA] to-[#00D4AA] animate-pulse">
                                    404
                                </div>
                                <div class="absolute inset-0 text-9xl md:text-[150px] font-black text-[#64FFDA] blur-xl opacity-30 animate-pulse"></div>
                            </div>
                        </div>

                        <!-- Título Principal -->
                        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-[#CCD6F6] drop-shadow-lg">
                            Oops, Página no Encontrada
                        </h1>

                        <!-- Subtítulo descriptivo -->
                        <p class="text-lg md:text-xl text-[#8892B0] mb-2 leading-relaxed">
                            Parece que intentaste acceder a una ruta que no existe
                        </p>
                        <p class="text-base md:text-lg text-[#8892B0] mb-10 leading-relaxed">
                            O no tienes permiso para verla.
                        </p>

                        <!-- Icono material con animación -->
                        <div class="flex justify-center mb-8">
                            <span class="material-symbols-outlined text-9xl text-[#64FFDA] opacity-50 animate-bounce">
                                explore
                            </span>
                        </div>

                        <!-- Información técnica (opcional) -->
                        <div class="bg-[#0A192F]/50 border border-[#233554] rounded-lg p-4 mb-8 text-left backdrop-blur-sm">
                            <p class="text-[#8892B0] text-sm font-mono">
                                <span class="text-[#64FFDA] font-bold">Ruta solicitada:</span>
                                <br>
                                <code class="text-xs md:text-sm">{{ request()->path() }}</code>
                            </p>
                            <p class="text-[#8892B0] text-xs mt-2">
                                <span class="text-[#64FFDA] font-bold">Rol:</span> 
                                {{ auth()->user()->esAdmin() ? 'Administrador' : (auth()->user()->esJuez() ? 'Juez' : 'Jugador') }}
                            </p>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <!-- Botón Dashboard -->
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center justify-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-[0_0_20px_rgba(100,255,218,0.4)]">
                                <span class="material-symbols-outlined text-xl">home</span>
                                Ir al Dashboard
                            </a>

                            <!-- Botón Atrás -->
                            <button onclick="history.back()"
                                    class="inline-flex items-center justify-center gap-2 bg-[#112240] hover:bg-[#1a3a52] text-[#64FFDA] font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1 border border-[#233554] shadow-lg">
                                <span class="material-symbols-outlined text-xl">arrow_back</span>
                                Volver Atrás
                            </button>
                        </div>

                        <!-- Sugerencias según el rol -->
                        <div class="mt-12 pt-8 border-t border-[#233554]">
                            <p class="text-[#8892B0] text-sm mb-4">¿Qué puedes hacer?</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if(auth()->user()->esAdmin())
                                    <!-- Opciones Admin -->
                                    <a href="{{ route('admin.eventos') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">event</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Gestionar Eventos</p>
                                    </a>
                                    
                                    <a href="{{ route('admin.equipos') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">group</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Gestionar Equipos</p>
                                    </a>
                                    
                                    <a href="{{ route('admin.resultados-panel') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">leaderboard</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Resultados</p>
                                    </a>
                                @elseif(auth()->user()->esJuez())
                                    <!-- Opciones Juez -->
                                    <a href="{{ route('juez.panel') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">gavel</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Mi Panel</p>
                                    </a>
                                    
                                    <a href="{{ route('juez.constancias') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">article</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Constancias</p>
                                    </a>
                                    
                                    <a href="{{ route('juez.configuracion') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">settings</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Configuración</p>
                                    </a>
                                @else
                                    <!-- Opciones Jugador -->
                                    <a href="{{ route('eventos.index') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">event</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Ver Eventos</p>
                                    </a>
                                    
                                    <a href="{{ route('equipos.buscar') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">group</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Buscar Equipos</p>
                                    </a>
                                    
                                    <a href="{{ route('player.perfil') }}" 
                                       class="p-4 rounded-lg bg-[#112240]/50 border border-[#233554] hover:border-[#64FFDA]/50 transition-all group">
                                        <span class="material-symbols-outlined text-[#64FFDA] text-2xl block mb-2">person</span>
                                        <p class="text-[#CCD6F6] font-bold text-sm group-hover:text-[#64FFDA] transition">Mi Perfil</p>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Decoración inferior -->
                <div class="mt-12 text-center">
                    <p class="text-[#8892B0] text-sm">
                        CodeQuest © 2024 - Plataforma de Hackathones
                    </p>
                </div>
            </div>

        </div>

        <style>
            @keyframes pulse-glow {
                0%, 100% {
                    opacity: 0.5;
                }
                50% {
                    opacity: 1;
                }
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-20px);
                }
            }

            .animate-pulse {
                animation: pulse-glow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            .animate-bounce {
                animation: float 3s ease-in-out infinite;
            }
        </style>
    </body>
    </html>
@else
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Página no Encontrada</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    </head>
    <body class="bg-[#0A192F] text-[#8892B0]">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-2xl">
                <!-- Contenedor principal -->
                <div class="relative bg-gradient-to-br from-[#112240] to-[#0A192F] rounded-3xl overflow-hidden shadow-2xl border border-[#233554] group">
                    
                    <!-- Efectos de fondo -->
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')]"></div>
                    <div class="absolute top-[-50%] right-[-10%] w-[500px] h-[500px] bg-[#64FFDA] rounded-full mix-blend-overlay filter blur-[120px] opacity-10 pointer-events-none group-hover:opacity-20 transition-opacity duration-700"></div>
                    <div class="absolute bottom-[-50%] left-[-10%] w-[400px] h-[400px] bg-[#1F63E1] rounded-full mix-blend-overlay filter blur-[100px] opacity-10 pointer-events-none"></div>

                    <!-- Contenido -->
                    <div class="relative z-10 px-6 py-16 md:py-24 text-center">
                        
                        <!-- Ícono 404 -->
                        <div class="mb-8 inline-block">
                            <div class="relative">
                                <div class="text-9xl md:text-[150px] font-black text-transparent bg-clip-text bg-gradient-to-r from-[#64FFDA] to-[#00D4AA]">
                                    404
                                </div>
                                <div class="absolute inset-0 text-9xl md:text-[150px] font-black text-[#64FFDA] blur-xl opacity-30"></div>
                            </div>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-[#CCD6F6]">
                            Página no Encontrada
                        </h1>
                        <p class="text-lg text-[#8892B0] mb-10">
                            La página que buscas no existe.
                        </p>

                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-[0_0_20px_rgba(100,255,218,0.4)]">
                            <span class="material-symbols-outlined">login</span>
                            Ir al Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
@endif

