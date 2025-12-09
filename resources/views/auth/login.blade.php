<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - CodeQuest</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animación de Flotación para el Cohete */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Animación de Entrada suave del formulario */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* Fondo de malla sutil (oscuro para fondo blanco) */
        .bg-grid-pattern-dark {
            background-image: radial-gradient(rgba(100, 255, 218, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        /* Fondo de malla sutil (claro para fondo azul) */
        .bg-grid-pattern-light {
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#0A192F] text-[#8892B0]">

    <div class="min-h-screen w-full flex flex-col md:flex-row overflow-hidden md:rounded-none bg-[#0A192F] shadow-2xl md:shadow-none my-8 md:my-0 mx-4 md:mx-0 max-w-6xl md:max-w-none">
        
        <div class="hidden md:flex md:w-1/2 bg-[#112240] relative items-center justify-center p-8 overflow-hidden border-r border-[#233554]">
            
            <div class="absolute inset-0 bg-grid-pattern-dark opacity-30"></div>

            <div class="relative z-10 text-center w-full">
                
               
              

                <div class="animate-float w-full max-w-3xl mx-auto transform hover:scale-105 transition-transform duration-500 px-4">
                    <img src="{{ asset('logo4.png') }}" 
                         alt="CodeQuest Illustration" 
                         class="w-full h-auto object-contain">
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6 bg-[#0A192F] relative overflow-hidden">
            
            <div class="absolute inset-0 bg-grid-pattern-light opacity-20 animate-pulse"></div>
            <div class="absolute top-10 right-10 w-32 h-32 bg-[#112240] opacity-50 rounded-full blur-2xl"></div>
            <div class="absolute bottom-10 left-10 w-64 h-64 bg-[#64FFDA] opacity-5 rounded-full blur-3xl"></div>

            <div class="w-full max-w-md animate-fade-in-up relative z-10">
                
                <div class="md:hidden text-center mb-8">
                    <span class="text-4xl font-extrabold text-[#CCD6F6] drop-shadow-md">CodeQuest</span>
                </div>

                <div class="bg-[#112240] p-8 rounded-3xl shadow-2xl border border-[#233554] backdrop-blur-sm">
                    
                    <div class="mb-8 text-center md:text-left">
                        <h2 class="text-3xl font-bold text-[#CCD6F6] mb-2">¡Hola de nuevo! 👋</h2>
                        <p class="text-[#8892B0]">Ingresa tus credenciales para continuar.</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="group">
                            <label for="email" class="block text-sm font-bold text-[#64FFDA] mb-1 transition-colors group-focus-within:text-[#64FFDA]">Correo electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-[#8892B0] group-focus-within:text-[#64FFDA] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="email" 
                                       class="w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3.5 pl-11 pr-4 
                                              focus:bg-[#0A192F] focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] 
                                              transition-all duration-300 outline-none font-medium placeholder-[#8892B0]/50" 
                                       type="email" name="email" :value="old('email')" required autofocus 
                                       placeholder="ejemplo@codequest.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="group">
                            <label for="password" class="block text-sm font-bold text-[#64FFDA] mb-1 transition-colors group-focus-within:text-[#64FFDA]">Contraseña</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-[#8892B0] group-focus-within:text-[#64FFDA] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" 
                                       class="w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3.5 pl-11 pr-4 
                                              focus:bg-[#0A192F] focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] 
                                              transition-all duration-300 outline-none font-medium placeholder-[#8892B0]/50" 
                                       type="password" name="password" required autocomplete="current-password" 
                                       placeholder="••••••••" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input id="remember_me" type="checkbox" 
                                           class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-[#8892B0] bg-[#0A192F] transition-all checked:border-[#64FFDA] checked:bg-[#64FFDA]" 
                                           name="remember">
                                    <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[#0A192F] opacity-0 peer-checked:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <span class="ml-2 text-sm text-[#8892B0] group-hover:text-[#64FFDA] font-medium">Recuérdame</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-bold text-[#64FFDA] hover:text-[#CCD6F6] hover:underline transition-all" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <button class="w-full relative overflow-hidden bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-4 px-4 rounded-xl shadow-lg hover:shadow-[0_0_20px_rgba(100,255,218,0.3)] transition-all duration-300 transform hover:-translate-y-1 group">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                INICIAR SESIÓN
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-[#233554] text-center">
                        <p class="text-[#8892B0]">¿Aún no eres parte del equipo?</p>
                        <a href="{{ route('register') }}" class="inline-block mt-2 font-bold text-[#64FFDA] hover:text-[#CCD6F6] transition-colors duration-200">
                            Crear una cuenta nueva &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>