<x-app-layout>
<div class="min-h-screen bg-[#0A192F] py-12 text-[#8892B0] font-sans" style="padding-top: 120px;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold text-[#CCD6F6] flex items-center gap-4">
                    <span class="material-symbols-outlined text-[#64FFDA] text-5xl">cloud_upload</span>
                    Subir Proyecto Final
                </h1>
                <p class="text-[#8892B0] mt-3 text-lg">Entrega final del proyecto del hackatón</p>
            </div>
            <a href="{{ route('player.equipos') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-[#112240] border border-[#233554] rounded-xl text-[#64FFDA] hover:bg-[#233554] transition-all font-medium">
                <span class="material-symbols-outlined">arrow_back</span>
                Volver a Mis Equipos
            </a>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-lg">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-lg">
                <span class="material-symbols-outlined text-2xl">error</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @php
            $evento = $equipo->evento;
            $hoy = now();
            $fechaFinEvento = \Carbon\Carbon::parse($evento->fecha_fin)->setTime(23, 59, 59);
            $eventoFinalizado = $hoy->greaterThan($fechaFinEvento);
        @endphp

        @if($eventoFinalizado)
            <div class="mb-8 bg-gradient-to-r from-yellow-600/20 to-transparent border border-yellow-500/40 rounded-2xl p-8 text-center">
                <span class="material-symbols-outlined text-7xl text-yellow-400 mb-4 block">schedule</span>
                <h3 class="text-2xl font-bold text-yellow-400 mb-3">El evento ha finalizado</h3>
                <p class="text-[#CCD6F6] text-lg">No se pueden subir proyectos después de las 23:59 del {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }}</p>
            </div>
            @php return; @endphp
        @endif

        <!-- Info del equipo y evento -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-[#112240] rounded-2xl border border-[#233554] p-6 shadow-xl">
                <h2 class="text-xl font-bold text-[#CCD6F6] mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#64FFDA]">info</span>
                    Información del Equipo
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA]">groups</span>
                            <div>
                                <p class="text-[#8892B0] text-sm">Equipo</p>
                                <p class="text-[#CCD6F6] font-bold text-lg">{{ $equipo->nombre }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA]">assignment</span>
                            <div>
                                <p class="text-[#8892B0] text-sm">Proyecto</p>
                                <p class="text-[#CCD6F6] font-bold">{{ $equipo->nombre_proyecto }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA]">person</span>
                            <div>
                                <p class="text-[#8892B0] text-sm">Líder del equipo</p>
                                <p class="text-[#CCD6F6] font-bold">{{ $equipo->lider->nombre }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#64FFDA]">group</span>
                            <div>
                                <p class="text-[#8892B0] text-sm">Miembros</p>
                                <p class="text-[#CCD6F6] font-bold">{{ $equipo->participantes->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#64FFDA]/10 to-transparent rounded-2xl border border-[#64FFDA]/30 p-6 text-center">
                <span class="material-symbols-outlined text-6xl text-[#64FFDA] mb-4 block">schedule</span>
                <p class="text-[#8892B0] text-sm">Hora límite de entrega</p>
                <p class="text-3xl font-bold text-[#CCD6F6] mt-2">23:59</p>
                <p class="text-[#8892B0] text-sm mt-1">{{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Proyecto ya subido -->
        @if($equipo->repositorio)
            <div class="bg-gradient-to-r from-green-600/20 to-transparent border border-green-500/40 rounded-2xl p-8 mb-8 shadow-2xl">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="text-center sm:text-left">
                        <p class="text-green-400 text-sm font-medium uppercase tracking-wider mb-2">Proyecto ya entregado</p>
                        <h3 class="text-2xl font-bold text-[#CCD6F6] flex items-center gap-3">
                            <span class="material-symbols-outlined text-4xl text-green-400">check_circle</span>
                            {{ $equipo->repositorio->archivo_nombre }}
                        </h3>
                        <p class="text-[#8892B0] mt-2">
                            Subido el {{ \Carbon\Carbon::parse($equipo->repositorio->enviado_en)->format('d/m/Y \a \l\a\s H:i') }}
                        </p>
                        @if($equipo->repositorio->calificacion_total)
                            <div class="mt-6 inline-block">
                                <p class="text-5xl font-bold text-[#64FFDA]">{{ $equipo->repositorio->calificacion_total }}</p>
                                <p class="text-[#8892B0]">puntos de 100</p>
                            </div>
                        @else
                            <p class="mt-4 text-yellow-400 flex items-center gap-2">
                                <span class="material-symbols-outlined">pending</span>
                                Pendiente de calificación
                            </p>
                        @endif
                    </div>
                    <a href="{{ route('proyectos.download', $equipo->repositorio) }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-[#64FFDA] text-[#0A192F] rounded-2xl font-bold text-lg hover:shadow-xl hover:shadow-[#64FFDA]/30 transition-all">
                        <span class="material-symbols-outlined text-2xl">download</span>
                        Descargar Proyecto
                    </a>
                </div>
            </div>
            @php return; @endphp
        @endif

        <!-- Formulario de subida -->
        <div class="bg-[#112240] rounded-2xl shadow-2xl border border-[#233554] overflow-hidden">
            <div class="bg-gradient-to-r from-[#64FFDA]/10 to-transparent px-8 py-6 border-b border-[#233554]">
                <h2 class="text-2xl font-bold text-[#CCD6F6] flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#64FFDA] text-3xl">cloud_upload</span>
                    Subir Nuevo Proyecto
                </h2>
            </div>

            <form action="{{ route('proyecto.store', $equipo) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf

                <!-- Selector de archivo con previsualización -->
                <div>
                    <label class="block text-[#CCD6F6] font-bold mb-4 text-lg">
                        Archivo del Proyecto *
                    </label>
                    <div class="border-2 border-dashed border-[#233554] rounded-2xl p-8 text-center hover:border-[#64FFDA] transition-all" id="dropZone">
                        <input type="file" name="archivo" id="archivoInput" required accept=".zip,.pdf,.pptx" class="hidden">
                        <div id="preview" class="space-y-4">
                            <span class="material-symbols-outlined text-7xl text-[#8892B0] opacity-50">cloud_upload</span>
                            <p class="text-xl text-[#CCD6F6]">Arrastra tu archivo aquí o haz clic para seleccionar</p>
                            <p class="text-[#8892B0]">Formatos: .zip, .pdf, .pptx — Máximo 50MB</p>
                            <button type="button" onclick="document.getElementById('archivoInput').click()"
                                    class="mt-4 px-8 py-3 bg-[#64FFDA] text-[#0A192F] rounded-xl font-bold hover:bg-[#52d6b3] transition-all">
                                Seleccionar archivo
                            </button>
                        </div>
                    </div>
                    <div id="fileInfo" class="mt-4 hidden">
                        <div class="flex items-center justify-between bg-[#0A192F] rounded-xl p-4 border border-[#233554]">
                            <div class="flex items-center gap-4">
                                <span id="fileIcon" class="material-symbols-outlined text-4xl text-[#64FFDA]"></span>
                                <div>
                                    <p id="fileName" class="text-[#CCD6F6] font-medium"></p>
                                    <p id="fileSize" class="text-[#8892B0] text-sm"></p>
                                </div>
                            </div>
                            <button type="button" onclick="resetFile()" class="text-red-400 hover:text-red-300">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- URL GitHub -->
                <div>
                    <label class="block text-[#CCD6F6] font-bold mb-3">
                        Repositorio GitHub (Opcional)
                    </label>
                    <input type="url" name="url_github" placeholder="https://github.com/tu-usuario/tu-proyecto"
                           class="w-full px-5 py-4 bg-[#0A192F] border border-[#233554] rounded-xl text-[#CCD6F6] placeholder-[#8892B0]/70 focus:outline-none focus:border-[#64FFDA] transition-all">
                </div>

                <!-- Comentarios -->
                <div>
                    <label class="block text-[#CCD6F6] font-bold mb-3">
                        Comentarios Adicionales (Opcional)
                    </label>
                    <textarea name="comentarios" rows="5" maxlength="1000" placeholder="Describe tu proyecto, tecnologías usadas, desafíos superados..."
                              class="w-full px-5 py-4 bg-[#0A192F] border border-[#233554] rounded-xl text-[#CCD6F6] placeholder-[#8892B0]/70 focus:outline-none focus:border-[#64FFDA] transition-all resize-none"></textarea>
                    <p class="text-right text-xs text-[#8892B0] mt-2"><span id="charCount">0</span>/1000 caracteres</p>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4 pt-6 border-t border-[#233554]">
                    <button type="button" onclick="window.history.back()"
                            class="px-8 py-4 bg-[#0A192F] border border-[#233554] rounded-xl text-[#8892B0] hover:bg-[#233554] hover:text-[#CCD6F6] font-bold transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-10 py-4 bg-[#64FFDA] text-[#0A192F] rounded-xl font-bold text-xl hover:bg-[#52d6b3] transition-all shadow-xl hover:shadow-[#64FFDA]/30 flex items-center gap-3">
                        <span class="material-symbols-outlined text-2xl">send</span>
                        Entregar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('archivoInput');
    const dropZone = document.getElementById('dropZone');
    const preview = document.getElementById('preview');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileIcon = document.getElementById('fileIcon');

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function updatePreview(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const icons = {
            pdf: 'picture_as_pdf',
            zip: 'folder_zip',
            pptx: 'description',
        };
        fileIcon.textContent = icons[ext] || 'description';
        fileName.textContent = file.name;
        fileSize.textContent = formatBytes(file.size);
        preview.classList.add('hidden');
        fileInfo.classList.remove('hidden');
    }

    function resetFile() {
        fileInput.value = '';
        preview.classList.remove('hidden');
        fileInfo.classList.add('hidden');
    }

    fileInput.addEventListener('change', e => {
        if (e.target.files[0]) updatePreview(e.target.files[0]);
    });

    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-[#64FFDA]'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-[#64FFDA]'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-[#64FFDA]');
        if (e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            updatePreview(e.dataTransfer.files[0]);
        }
    });

    // Contador de caracteres
    document.querySelector('textarea[name="comentarios"]').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });
</script>

</x-app-layout>