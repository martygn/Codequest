<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - CodeQuest</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animación suave de entrada */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    </style>
</head>
<body class="font-sans antialiased bg-[#0A192F] text-[#8892B0]">

    <nav class="absolute top-0 left-0 w-full p-6">
        <div class="p-6 flex items-center gap-3">
            <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
            
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-center items-center pt-20 sm:pt-0 px-4 relative overflow-hidden">
        
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-[#64FFDA] rounded-full mix-blend-multiply filter blur-[128px] opacity-10 pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-[#112240] rounded-full mix-blend-multiply filter blur-[128px] opacity-20 pointer-events-none"></div>

        <div class="w-full sm:max-w-lg animate-fade-in-up relative z-10">
            
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold text-[#CCD6F6] mb-3 tracking-tight">Únete a la comunidad</h2>
                <p class="text-[#8892B0] text-lg">
                    Crea tu cuenta y comienza a formar tu equipo ideal.
                </p>
            </div>

            <div class="bg-[#112240] shadow-2xl rounded-3xl border border-[#233554] p-8 sm:p-10 relative overflow-hidden">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6 relative z-10">
                    @csrf

                    <div class="group">
                        <label for="name" class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">NOMBRE COMPLETO</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0] group-focus-within:text-[#64FFDA] transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                                   placeholder="Ej. Juan Pérez"
                                   class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554] rounded-xl py-3.5 pl-12 pr-4 
                                          focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] focus:bg-[#0A192F]
                                          transition-all duration-200 outline-none placeholder-[#8892B0]/50" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="email" class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">CORREO ELECTRÓNICO</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0] group-focus-within:text-[#64FFDA] transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                   placeholder="tu@correo.com"
                                   class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554] rounded-xl py-3.5 pl-12 pr-4 
                                          focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] focus:bg-[#0A192F]
                                          transition-all duration-200 outline-none placeholder-[#8892B0]/50" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="password" class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">CONTRASEÑA</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0] group-focus-within:text-[#64FFDA] transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   placeholder="Mínimo 8 caracteres"
                                   class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554] rounded-xl py-3.5 pl-12 pr-4 
                                          focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] focus:bg-[#0A192F]
                                          transition-all duration-200 outline-none placeholder-[#8892B0]/50" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="password_confirmation" class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">CONFIRMAR CONTRASEÑA</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0] group-focus-within:text-[#64FFDA] transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="Repite tu contraseña"
                                   class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554] rounded-xl py-3.5 pl-12 pr-4 
                                          focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] focus:bg-[#0A192F]
                                          transition-all duration-200 outline-none placeholder-[#8892B0]/50" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button class="w-full bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-4 px-4 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.3)] hover:shadow-[0_0_25px_rgba(100,255,218,0.5)] transition-all duration-200 transform hover:-translate-y-0.5 uppercase tracking-wide text-sm flex items-center justify-center">
                            Crear Cuenta
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-center mt-6 pt-4 border-t border-[#233554]">
                        <p class="text-sm text-[#8892B0]">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="font-mono font-bold text-[#64FFDA] hover:text-[#CCD6F6] border-b border-transparent hover:border-[#CCD6F6] transition-all ml-1">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </form>
            </div>
            
            <div class="mt-8 text-center text-xs text-[#8892B0] opacity-50">
                &copy; {{ date('Y') }} CodeQuest. Todos los derechos reservados.
            </div>

        </div>
    </div>
</body>
</html>