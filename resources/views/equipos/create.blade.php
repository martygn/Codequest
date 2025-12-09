<x-app-layout>
    <div class="py-12 bg-[#0A192F] min-h-screen text-[#8892B0] font-sans" style="
    padding-top: 130px;">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8" >
            


            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('equipos.index') }}" class="p-2 rounded-full hover:bg-[#112240] text-[#64FFDA] transition-colors">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <h1 class="text-3xl font-bold text-[#CCD6F6] tracking-tight">Crear Nuevo Equipo</h1>
            </div>

            <div class="bg-[#112240] overflow-hidden shadow-2xl sm:rounded-2xl border border-[#233554]">
                <div class="p-8">

                    {{-- Errores --}}
                    @if ($errors->any())
                        <div class="mb-8 bg-red-500/10 border border-red-500/30 rounded-xl p-4">
                            <h3 class="text-red-400 font-bold mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">error</span> Errores en el formulario:
                            </h3>
                            <ul class="text-red-300 text-sm space-y-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('equipos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="group">
                            <label class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">Nombre del Equipo *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0]">
                                    <span class="material-symbols-outlined">diversity_3</span>
                                </span>
                                <input type="text" name="nombre" placeholder="Ej. Equipo CodeQuest" required
                                    class="w-full pl-11 bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">Nombre del Proyecto *</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#8892B0]">
                                    <span class="material-symbols-outlined">rocket_launch</span>
                                </span>
                                <input type="text" name="nombre_proyecto" placeholder="Ej. Sistema de gestión de inventarios" required
                                    class="w-full pl-11 bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-mono font-bold text-[#64FFDA] mb-2 uppercase tracking-wide">Descripción del Equipo *</label>
                            <textarea name="descripcion" rows="4" placeholder="Describe tu equipo y la idea del proyecto..." required
                                class="w-full bg-[#0A192F] text-[#CCD6F6] border border-[#233554] rounded-xl py-3 px-4 focus:border-[#64FFDA] focus:ring-1 focus:ring-[#64FFDA] outline-none transition-all placeholder-[#8892B0]/30 resize-none"></textarea>
                        </div>

                        <div class="mb-8 border-2 border-dashed border-[#233554] hover:border-[#64FFDA] rounded-xl p-8 text-center transition-all bg-[#0A192F]/50 relative group cursor-pointer">
                            <input type="file" name="banner" id="bannerInput"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                accept="image/*"
                                onchange="previewImage(event)">
                            
                            <div class="flex flex-col items-center justify-center pointer-events-none transition-opacity duration-300" id="bannerPlaceholder">
                                <div class="w-16 h-16 bg-[#233554] rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl text-[#64FFDA]">cloud_upload</span>
                                </div>
                                <p class="font-bold text-[#CCD6F6] text-base mb-1">Imagen del Equipo</p>
                                <p class="text-[#8892B0] text-xs mb-4">Arrastra una imagen o haz clic para seleccionar</p>
                                <span class="bg-[#112240] border border-[#233554] text-[#64FFDA] text-xs font-bold py-2 px-4 rounded-lg">
                                    Seleccionar Archivo
                                </span>
                            </div>

                            <div id="imagePreview" class="hidden relative z-10">
                                <img id="previewImage" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg shadow-lg border border-[#233554]">
                                <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500/90 hover:bg-red-600 text-white p-2 rounded-full shadow-lg transition-transform hover:scale-110 z-30 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        </div>

                        <div class="mb-8 bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4 flex items-start gap-3">
                            <span class="material-symbols-outlined text-yellow-400 mt-0.5">info</span>
                            <div class="text-sm text-yellow-200/80">
                                <p class="font-bold text-yellow-400 mb-1">Proceso de Aprobación</p>
                                <p>Tu equipo será revisado por un administrador antes de ser aprobado y aparecer públicamente en la plataforma.</p>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row justify-end items-center gap-4 border-t border-[#233554] pt-6">
                            <a href="{{ route('equipos.index') }}"
                               class="w-full sm:w-auto text-center text-[#8892B0] hover:text-[#CCD6F6] font-medium transition-colors text-sm py-3">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-[#64FFDA] hover:bg-[#52d6b3] text-[#0A192F] font-bold py-3 px-8 rounded-xl shadow-[0_0_15px_rgba(100,255,218,0.3)] transition-all transform hover:-translate-y-0.5">
                                <span class="material-symbols-outlined text-lg">check</span>
                                Crear Equipo
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const placeholder = document.getElementById('bannerPlaceholder');
                const preview = document.getElementById('imagePreview');
                const previewImage = document.getElementById('previewImage');

                previewImage.src = e.target.result;
                placeholder.classList.add('opacity-0', 'absolute'); // Ocultar con opacidad para mantener layout si fuera necesario, o display none
                placeholder.style.display = 'none';
                preview.classList.remove('hidden');
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const input = document.getElementById('bannerInput');
            const placeholder = document.getElementById('bannerPlaceholder');
            const preview = document.getElementById('imagePreview');

            input.value = ''; // Limpiar input file
            placeholder.style.display = 'flex';
            placeholder.classList.remove('opacity-0', 'absolute');
            preview.classList.add('hidden');
            
            // Prevenir que el click se propague al input file de nuevo
            event.stopPropagation();
            event.preventDefault();
        }
    </script>
</x-app-layout>


