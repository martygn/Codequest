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
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    </style>
</head>

<body class="font-sans antialiased bg-[#0A192F] text-[#8892B0]">

    <nav class="absolute top-0 left-0 w-full p-6">
        <a href="/" class="text-2xl font-extrabold text-[#CCD6F6] tracking-tight hover:text-[#64FFDA] transition-colors">
            CodeQuest
        </a>
    </nav>

    <div class="min-h-screen flex flex-col justify-center items-center pt-20 px-4 relative overflow-hidden">
        
        <!-- EFECTOS -->
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-[#64FFDA] rounded-full mix-blend-multiply filter blur-[128px] opacity-10"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-[#112240] rounded-full mix-blend-multiply filter blur-[128px] opacity-20"></div>

        <div class="w-full sm:max-w-3xl animate-fade-in-up relative z-10"> 
            
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold text-[#CCD6F6] mb-3 tracking-tight">Únete a la comunidad</h2>
                <p class="text-[#8892B0] text-lg">
                    Crea tu cuenta y comienza a formar tu equipo ideal.
                </p>
            </div>

            <!-- CONTENEDOR PRINCIPAL -->
            <div class="bg-[#112240] shadow-2xl rounded-3xl border border-[#233554] p-8 sm:p-10 relative overflow-hidden">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- FILA NOMBRE - PATERNO - MATERNO -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- NOMBRE -->
                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">NOMBRE</label>
                            <input 
                                id="nombre"
                                name="nombre"
                                type="text"
                                required autofocus
                                placeholder="Juan"
                                :value="old('nombre')"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <!-- APELLIDO PATERNO -->
                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">A. PATERNO</label>
                            <input 
                                id="apellido_paterno"
                                name="apellido_paterno"
                                type="text"
                                required
                                placeholder="Pérez"
                                :value="old('apellido_paterno')"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <!-- APELLIDO MATERNO -->
                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">A. MATERNO</label>
                            <input 
                                id="apellido_materno"
                                name="apellido_materno"
                                type="text"
                                placeholder="García"
                                :value="old('apellido_materno')"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2 text-red-400 text-xs" />
                        </div>
                    </div>

                    <!-- USERNAME - EMAIL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">USUARIO</label>
                            <input 
                                id="username"
                                name="username"
                                type="text"
                                required
                                placeholder="usuario123"
                                :value="old('username')"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">CORREO</label>
                            <input 
                                id="email"
                                name="email"
                                type="email"
                                required
                                placeholder="correo@ejemplo.com"
                                :value="old('email')"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
                        </div>
                    </div>

                    <!-- PASSWORD - CONFIRM -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">CONTRASEÑA</label>
                            <input 
                                id="password"
                                name="password"
                                type="password"
                                required
                                placeholder="Mínimo 8 caracteres"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <div class="group">
                            <label class="block text-xs font-mono text-[#64FFDA] mb-2 ml-1">CONFIRMAR</label>
                            <input 
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                placeholder="Repite tu contraseña"
                                class="w-full bg-[#0A192F] text-[#CCD6F6] font-medium border border-[#233554]
                                       rounded-xl py-3.5 px-4 focus:border-[#64FFDA] focus:ring-1
                                       focus:ring-[#64FFDA] placeholder-[#8892B0]/50 outline-none transition-all duration-200">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs" />
                        </div>

                    </div>

                    <!-- BOTÓN -->
                    <button class="w-full bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-4 px-4 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.3)] hover:shadow-[0_0_25px_rgba(100,255,218,0.5)] transition-all duration-200 transform hover:-translate-y-0.5 uppercase tracking-wide text-sm">
                        Crear cuenta
                    </button>

                    <!-- FOOTER -->
                    <div class="flex items-center justify-center mt-6 pt-4 border-t border-[#233554]">
                        <p class="text-sm text-[#8892B0]">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="font-mono font-bold text-[#64FFDA] hover:text-[#CCD6F6] transition-colors ml-1">
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
