<x-app-layout>
    <div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="
    padding-top: 120px;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Encabezado con Icono --}}
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-[#112240] rounded-xl flex items-center justify-center border border-[#233554] shadow-lg">
                    <span class="material-symbols-outlined text-[#64FFDA] text-2xl">person_edit</span>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Mi Perfil</h2>
                    <p class="text-sm text-[#8892B0]">Gestiona tu información personal</p>
                </div>
            </div>

            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="mb-8 bg-green-500/10 border border-green-500/30 text-green-400 p-4 rounded-xl flex items-center gap-3 shadow-lg animate-pulse">
                    <span class="material-symbols-outlined">check_circle</span>
                    <div>
                        <p class="font-bold text-sm">¡Operación exitosa!</p>
                        <p class="text-xs opacity-90">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554] relative">
                
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#64FFDA] via-[#0A192F] to-[#64FFDA]"></div>

                <div class="p-8 md:p-10">
                    
                    {{-- Encabezado Interno --}}
                    <div class="mb-8 border-b border-[#233554] pb-6">
                        <h3 class="text-xl font-bold text-[#CCD6F6] mb-1">Información Personal</h3>
                        <p class="text-sm text-[#8892B0]">Actualiza tus datos personales y correo electrónico.</p>
                    </div>

                    <form action="{{ route('player.perfil.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- GRID DE 3 COLUMNAS PARA NOMBRE Y APELLIDOS --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            {{-- 1. Nombre --}}
                            <div class="group">
                                <label for="nombre" class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">Nombre</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0]">
                                        <span class="material-symbols-outlined text-sm">badge</span>
                                    </span>
                                    <input type="text" name="nombre" id="nombre" 
                                        value="{{ old('nombre', $user->nombre) }}" required
                                        class="pl-10 w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30 shadow-inner">
                                </div>
                                @error('nombre') <span class="text-red-400 text-xs mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-[10px]">error</span> {{ $message }}</span> @enderror
                            </div>

                            {{-- 2. Apellido Paterno --}}
                            <div class="group">
                                <label for="apellido_paterno" class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">A. Paterno</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno" 
                                    value="{{ old('apellido_paterno', $user->apellido_paterno) }}" required
                                    class="w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30 shadow-inner">
                                @error('apellido_paterno') <span class="text-red-400 text-xs mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-[10px]">error</span> {{ $message }}</span> @enderror
                            </div>

                            {{-- 3. Apellido Materno --}}
                            <div class="group">
                                <label for="apellido_materno" class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">A. Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno" 
                                    value="{{ old('apellido_materno', $user->apellido_materno) }}" required
                                    class="w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30 shadow-inner">
                                @error('apellido_materno') <span class="text-red-400 text-xs mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-[10px]">error</span> {{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Correo Electrónico --}}
                        <div class="group">
                            <label for="email" class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">Correo Electrónico</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0]">
                                    <span class="material-symbols-outlined text-sm">mail</span>
                                </span>
                                <input type="email" name="email" id="email" 
                                    value="{{ old('email', $user->email) }}" required
                                    class="pl-10 w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30 shadow-inner">
                            </div>
                            @error('email') <span class="text-red-400 text-xs mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-[10px]">error</span> {{ $message }}</span> @enderror
                        </div>

                        {{-- Botones y Rol --}}
                        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-[#233554] mt-8">
                            
                            <span class="text-xs text-[#8892B0] font-mono bg-[#0A192F] px-3 py-1 rounded-full border border-[#233554]">
                                Rol Actual: <span class="text-[#64FFDA] font-bold">{{ ucfirst($user->tipo ?? 'Participante') }}</span>
                            </span>

                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-3 px-8 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5">
                                <span class="material-symbols-outlined text-lg">save</span>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>