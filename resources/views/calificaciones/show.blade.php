@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">⭐ Calificar Equipo</h1>
        <p class="text-gray-600 mt-2">
            Evento: <strong>{{ $evento->nombre }}</strong> | 
            Equipo: <strong>{{ $equipo->nombre }}</strong>
        </p>
    </div>

    <!-- Información del equipo -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">👥 Información del Equipo</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-600">Líder:</p>
                <p class="font-semibold">{{ $equipo->lider->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-600">Cantidad de miembros:</p>
                <p class="font-semibold">{{ $equipo->participantes->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Formulario de calificación -->
    <form action="{{ route('calificaciones.store', $equipo->id_equipo) }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
        @csrf

        <div class="space-y-8">
            <!-- Creatividad -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_creatividad" class="block text-sm font-semibold text-gray-900">
                        🎨 Creatividad e Innovación
                    </label>
                    <span id="valor_creatividad" class="text-2xl font-bold text-blue-600">{{ old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) }}</span>
                </div>
                <input type="range" 
                       id="puntaje_creatividad" 
                       name="puntaje_creatividad" 
                       min="1" 
                       max="10" 
                       value="{{ old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) }}"
                       class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('creatividad')">
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Nada creativo</span>
                    <span>Muy creativo</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">¿Qué tan innovador y creativo es el proyecto?</p>
            </div>

            <!-- Funcionalidad -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_funcionalidad" class="block text-sm font-semibold text-gray-900">
                        ⚙️ Funcionalidad
                    </label>
                    <span id="valor_funcionalidad" class="text-2xl font-bold text-green-600">{{ old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) }}</span>
                </div>
                <input type="range" 
                       id="puntaje_funcionalidad" 
                       name="puntaje_funcionalidad" 
                       min="1" 
                       max="10" 
                       value="{{ old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) }}"
                       class="w-full h-2 bg-green-200 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('funcionalidad')">
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>No funciona</span>
                    <span>Funciona perfectamente</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">¿El proyecto cumple con los requisitos y funciona correctamente?</p>
            </div>

            <!-- Diseño -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_diseño" class="block text-sm font-semibold text-gray-900">
                        🎯 Diseño y UX
                    </label>
                    <span id="valor_diseño" class="text-2xl font-bold text-purple-600">{{ old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) }}</span>
                </div>
                <input type="range" 
                       id="puntaje_diseño" 
                       name="puntaje_diseño" 
                       min="1" 
                       max="10" 
                       value="{{ old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) }}"
                       class="w-full h-2 bg-purple-200 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('diseño')">
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Diseño pobre</span>
                    <span>Diseño excelente</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">¿La interfaz es atractiva, intuitiva y fácil de usar?</p>
            </div>

            <!-- Presentación -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_presentacion" class="block text-sm font-semibold text-gray-900">
                        🎤 Presentación
                    </label>
                    <span id="valor_presentacion" class="text-2xl font-bold text-orange-600">{{ old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) }}</span>
                </div>
                <input type="range" 
                       id="puntaje_presentacion" 
                       name="puntaje_presentacion" 
                       min="1" 
                       max="10" 
                       value="{{ old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) }}"
                       class="w-full h-2 bg-orange-200 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('presentacion')">
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Mala presentación</span>
                    <span>Presentación excelente</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">¿La presentación fue clara, organizada y convincente?</p>
            </div>

            <!-- Documentación -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <label for="puntaje_documentacion" class="block text-sm font-semibold text-gray-900">
                        📚 Documentación
                    </label>
                    <span id="valor_documentacion" class="text-2xl font-bold text-red-600">{{ old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5) }}</span>
                </div>
                <input type="range" 
                       id="puntaje_documentacion" 
                       name="puntaje_documentacion" 
                       min="1" 
                       max="10" 
                       value="{{ old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5) }}"
                       class="w-full h-2 bg-red-200 rounded-lg appearance-none cursor-pointer"
                       oninput="actualizarValor('documentacion')">
                <div class="flex justify-between text-xs text-gray-500 mt-2">
                    <span>Sin documentación</span>
                    <span>Muy bien documentado</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">¿El código y proyecto están bien documentados?</p>
            </div>

            <!-- Puntuación Final -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-2 border-blue-200 rounded-lg p-6 mt-8">
                <h3 class="text-lg font-bold text-gray-900 mb-2">📊 Puntuación Final</h3>
                <div class="text-4xl font-bold text-blue-600" id="puntaje_final">
                    {{ number_format((old('puntaje_creatividad', $calificacion->puntaje_creatividad ?? 5) + 
                                      old('puntaje_funcionalidad', $calificacion->puntaje_funcionalidad ?? 5) + 
                                      old('puntaje_diseño', $calificacion->puntaje_diseño ?? 5) + 
                                      old('puntaje_presentacion', $calificacion->puntaje_presentacion ?? 5) + 
                                      old('puntaje_documentacion', $calificacion->puntaje_documentacion ?? 5)) / 5, 2) }}
                </div>
            </div>

            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-sm font-semibold text-gray-900 mb-2">
                    💬 Observaciones (opcional)
                </label>
                <textarea id="observaciones" 
                          name="observaciones" 
                          rows="4"
                          placeholder="Añade tus observaciones sobre el proyecto..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('observaciones', $calificacion->observaciones ?? '') }}</textarea>
            </div>

            <!-- Recomendaciones -->
            <div>
                <label for="recomendaciones" class="block text-sm font-semibold text-gray-900 mb-2">
                    💡 Recomendaciones (opcional)
                </label>
                <textarea id="recomendaciones" 
                          name="recomendaciones" 
                          rows="4"
                          placeholder="Sugiere mejoras y recomendaciones..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('recomendaciones', $calificacion->recomendaciones ?? '') }}</textarea>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mt-8">
            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                {{ $calificacion && $calificacion->exists ? '✏️ Actualizar Calificación' : '📤 Enviar Calificación' }}
            </button>
            <a href="{{ route('eventos.show', $evento->id_evento) }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
                ❌ Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function actualizarValor(campo) {
    const valores = {
        creatividad: document.getElementById('puntaje_creatividad').value,
        funcionalidad: document.getElementById('puntaje_funcionalidad').value,
        diseño: document.getElementById('puntaje_diseño').value,
        presentacion: document.getElementById('puntaje_presentacion').value,
        documentacion: document.getElementById('puntaje_documentacion').value,
    };

    document.getElementById('valor_' + campo).textContent = valores[campo];

    const promedio = (
        parseInt(valores.creatividad) +
        parseInt(valores.funcionalidad) +
        parseInt(valores.diseño) +
        parseInt(valores.presentacion) +
        parseInt(valores.documentacion)
    ) / 5;

    document.getElementById('puntaje_final').textContent = promedio.toFixed(2);
}
</script>
@endsection
