@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">📦 Gestionar Repositorio</h1>
        <p class="text-gray-600 mt-2">Equipo: <strong>{{ $equipo->nombre }}</strong></p>
    </div>

    <!-- Mensaje de estado -->
    @if ($repositorio && $repositorio->estaVerificado())
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800">✅ <strong>Repositorio verificado</strong> - Verificado por: {{ $repositorio->verificador?->nombre ?? 'Sistema' }}</p>
        </div>
    @elseif ($repositorio && $repositorio->estaEnviado() && $repositorio->estado === 'enviado')
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-blue-800">⏳ <strong>En revisión</strong> - Tu repositorio está siendo revisado por los administradores</p>
        </div>
    @elseif ($repositorio && $repositorio->estado === 'rechazado')
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800">❌ <strong>Rechazado</strong> - Por favor revisa y vuelve a enviar</p>
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('repositorios.store', $equipo->id_equipo) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <!-- URLs de Repositorios -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">🔗 URLs del Repositorio</h2>
            
            <!-- GitHub -->
            <div class="mb-4">
                <label for="url_github" class="block text-sm font-medium text-gray-700 mb-1">GitHub</label>
                <input type="url" 
                       id="url_github" 
                       name="url_github" 
                       value="{{ old('url_github', $repositorio->url_github ?? '') }}"
                       placeholder="https://github.com/usuario/proyecto"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url_github') border-red-500 @enderror">
                @error('url_github')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- GitLab -->
            <div class="mb-4">
                <label for="url_gitlab" class="block text-sm font-medium text-gray-700 mb-1">GitLab</label>
                <input type="url" 
                       id="url_gitlab" 
                       name="url_gitlab" 
                       value="{{ old('url_gitlab', $repositorio->url_gitlab ?? '') }}"
                       placeholder="https://gitlab.com/usuario/proyecto"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url_gitlab') border-red-500 @enderror">
                @error('url_gitlab')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bitbucket -->
            <div class="mb-4">
                <label for="url_bitbucket" class="block text-sm font-medium text-gray-700 mb-1">Bitbucket</label>
                <input type="url" 
                       id="url_bitbucket" 
                       name="url_bitbucket" 
                       value="{{ old('url_bitbucket', $repositorio->url_bitbucket ?? '') }}"
                       placeholder="https://bitbucket.org/usuario/proyecto"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url_bitbucket') border-red-500 @enderror">
                @error('url_bitbucket')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Personalizada -->
            <div class="mb-4">
                <label for="url_personalizado" class="block text-sm font-medium text-gray-700 mb-1">Otra plataforma</label>
                <input type="url" 
                       id="url_personalizado" 
                       name="url_personalizado" 
                       value="{{ old('url_personalizado', $repositorio->url_personalizado ?? '') }}"
                       placeholder="https://tu-plataforma.com/repositorio"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url_personalizado') border-red-500 @enderror">
                @error('url_personalizado')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rama de Producción -->
            <div class="mb-4">
                <label for="rama_produccion" class="block text-sm font-medium text-gray-700 mb-1">Rama de Producción</label>
                <input type="text" 
                       id="rama_produccion" 
                       name="rama_produccion" 
                       value="{{ old('rama_produccion', $repositorio->rama_produccion ?? 'main') }}"
                       placeholder="main"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rama_produccion') border-red-500 @enderror">
                @error('rama_produccion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">📝 Descripción del Proyecto</label>
            <textarea id="descripcion" 
                      name="descripcion" 
                      rows="4"
                      placeholder="Describe brevemente tu proyecto..."
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $repositorio->descripcion ?? '') }}</textarea>
            @error('descripcion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Archivo ZIP/RAR/7Z -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">📁 O sube un archivo ZIP/RAR/7Z</h2>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                <input type="file" 
                       id="archivo" 
                       name="archivo" 
                       accept=".zip,.rar,.7z"
                       class="hidden"
                       onchange="mostrarNombreArchivo(this)">
                <label for="archivo" class="cursor-pointer">
                    <p class="text-2xl mb-2">📦</p>
                    <p class="text-gray-700"><strong>Click para seleccionar</strong> o arrastra un archivo</p>
                    <p class="text-sm text-gray-500 mt-2">ZIP, RAR o 7Z (máx. 100 MB)</p>
                </label>
                <p id="nombreArchivo" class="text-sm text-green-600 mt-2 font-semibold"></p>
            </div>
            @error('archivo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Información actual si existe -->
        @if ($repositorio && $repositorio->exists)
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-3">Información actual:</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Estado:</p>
                        <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $repositorio->estado)) }}</p>
                    </div>
                    @if ($repositorio->archivo_nombre)
                        <div>
                            <p class="text-gray-600">Archivo:</p>
                            <p class="font-semibold">{{ $repositorio->archivo_nombre }}</p>
                        </div>
                    @endif
                    @if ($repositorio->enviado_en)
                        <div>
                            <p class="text-gray-600">Enviado:</p>
                            <p class="font-semibold">{{ $repositorio->enviado_en->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                @if ($repositorio->archivo_path)
                    <div class="mt-4">
                        <form action="{{ route('repositorios.descargar', $repositorio->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition inline-flex items-center gap-2">
                                📥 Descargar archivo
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endif

        <!-- Botones -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                {{ $repositorio && $repositorio->exists ? '✏️ Actualizar Repositorio' : '📤 Enviar Repositorio' }}
            </button>
            <a href="{{ route('equipos.show', $equipo->id_equipo) }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
                ❌ Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function mostrarNombreArchivo(input) {
    const nombreArchivo = document.getElementById('nombreArchivo');
    if (input.files && input.files[0]) {
        nombreArchivo.textContent = '✅ ' + input.files[0].name;
    }
}
</script>
@endsection
