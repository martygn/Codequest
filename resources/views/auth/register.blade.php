<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-black py-12 px-4">
        <div class="w-full max-w-lg">
            <!-- Título -->
            <div class="text-center mb-10">
                <h2 class="text-4xl font-bold text-white">Crea tu cuenta</h2>
                <p class="mt-3 text-gray-400">Únete a la comunidad de CodeQuest</p>
            </div>

            <!-- Formulario con fondo y sombra -->
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Nombres en fila -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre')" class="text-white/90 text-sm" />
                            <x-text-input id="nombre" name="nombre" type="text" :value="old('nombre')" required autofocus
                                          class="mt-1 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" 
                                          placeholder="Juan" />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-1 text-red-400" />
                        </div>
                        <div>
                            <x-input-label for="apellido_paterno" :value="__('Paterno')" class="text-white/90 text-sm" />
                            <x-text-input id="apellido_paterno" name="apellido_paterno" type="text" :value="old('apellido_paterno')" required
                                          class="mt-1 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                          placeholder="Pérez" />
                            <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-1 text-red-400" />
                        </div>
                        <div>
                            <x-input-label for="apellido_materno" :value="__('Materno')" class="text-white/90 text-sm" />
                            <x-text-input id="apellido_materno" name="apellido_materno" type="text" :value="old('apellido_materno')"
                                          class="mt-1 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                          placeholder="García" />
                            <x-input-error :messages="$errors->get('apellido_materno')" class="mt-1 text-red-400" />
                        </div>
                    </div>

                    <!-- Username -->
                    <div>
                        <x-input-label for="username" :value="__('Nombre de usuario')" class="text-white/90" />
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <x-text-input id="username" name="username" type="text" :value="old('username')" required
                                          class="pl-12 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-gray-200 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Correo electrónico')" class="text-white/90" />
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <x-text-input id="email" name="email" type="email" :value="old('email')" required
                                          class="pl-12 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <x-input-label for="password" :value="__('Contraseña')" class="text-white/90" />
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2 2 2 0 2 2-.9 2-2zm-7 9h14v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2z" />
                                </svg>
                            </span>
                            <x-text-input id="password" name="password" type="password" required
                                          class="pl-12 pr-12 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" />
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-300 hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-white/90" />
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2 2 2 0 2 2-.9 2-2zm-7 9h14v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2z" />
                                </svg>
                            </span>
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                                          class="pl-12 block w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <!-- Botón -->
                    <x-primary-button class="w-full justify-center py-4 text-lg font-bold rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg transform hover:scale-105 transition">
                        Registrarse
                    </x-primary-button>

                    <!-- Separador -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/20"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-gray-900/50 text-gray-400">O regístrate con</span>
                        </div>
                    </div>

                    <!-- Google -->
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center w-full gap-3 py-4 bg-white/10 hover:bg-white/20 border border-white/30 rounded-xl text-white font-medium transition">
                        <svg class="w-6 h-6" viewBox="0 0 24 24">...</svg>
                        Continuar con Google
                    </a>

                    <!-- Ya tienes cuenta? -->
                    <p class="text-center text-gray-400 mt-8">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login')" class="text-indigo-400 hover:text-indigo-300 font-bold">
                            Inicia sesión aquí
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
    @endpush
</x-guest-layout>