@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">📊 Resultados Detallados - {{ $evento->nombre }}</h1>
        <p class="text-gray-600 mt-2">📅 {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}</p>
    </div>

    <!-- Estadísticas de resumen -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Equipos Participantes</p>
            <p class="text-4xl font-bold text-blue-600">{{ $ranking->count() }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Total de Calificaciones</p>
            <p class="text-4xl font-bold text-green-600">{{ $calificaciones->count() }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Promedio General</p>
            <p class="text-4xl font-bold text-purple-600">{{ number_format($calificaciones->avg('puntaje_final') ?? 0, 2) }}</p>
        </div>
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Equipo Ganador</p>
            <p class="text-xl font-bold text-yellow-600">{{ $ganador['equipo']->nombre ?? 'No asignado' }}</p>
        </div>
    </div>

    <!-- Ranking principal -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white">
            <h2 class="text-2xl font-bold">🏆 Ranking Completo</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-900">Posición</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-900">Equipo</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-900">Puntuación Promedio</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-900">Desviación Est.</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-900">Calificaciones</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-900">Estado</th>
                        @if (Auth::user()->esAdmin())
                            <th class="px-6 py-3 text-center font-semibold text-gray-900">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ranking as $index => $item)
                        <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                            <td class="px-6 py-4">
                                <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                    #{{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-lg font-semibold text-gray-900">{{ $item['equipo']->nombre }}</p>
                                <p class="text-sm text-gray-600">Líder: {{ $item['equipo']->lider->nombre }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-bold">{{ number_format($item['puntaje_promedio'], 2) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-gray-700 font-semibold">{{ number_format($item['desviacion_estandar'], 2) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full">{{ $item['calificaciones_count'] }} jueces</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item['ganador'])
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-bold">🏆 GANADOR</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full">Participante</span>
                                @endif
                            </td>
                            @if (Auth::user()->esAdmin())
                                <td class="px-6 py-4 text-center">
                                    @if (!$item['ganador'])
                                        <form action="{{ route('admin.resultados.marcar-ganador', $evento->id_evento) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="equipo_id" value="{{ $item['equipo']->id_equipo }}">
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-semibold transition">
                                                Seleccionar Ganador
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.resultados.marcar-ganador', $evento->id_evento) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="equipo_id" value="">
                                            <button type="submit" class="text-gray-600 hover:text-gray-800 font-semibold transition">
                                                Desseleccionar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No hay calificaciones registradas para este evento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla de calificaciones individuales -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 text-white">
            <h2 class="text-2xl font-bold">📋 Calificaciones por Juez</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Equipo</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Juez</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-900">🎨</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-900">⚙️</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-900">🎯</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-900">🎤</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-900">📚</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-900">Promedio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($calificaciones->sortBy('equipo_id') as $calificacion)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $calificacion->equipo->nombre }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $calificacion->juez->nombre }}</td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-semibold">{{ $calificacion->puntaje_creatividad }}</span></td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-green-100 text-green-800 rounded font-semibold">{{ $calificacion->puntaje_funcionalidad }}</span></td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-purple-100 text-purple-800 rounded font-semibold">{{ $calificacion->puntaje_diseño }}</span></td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-orange-100 text-orange-800 rounded font-semibold">{{ $calificacion->puntaje_presentacion }}</span></td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-red-100 text-red-800 rounded font-semibold">{{ $calificacion->puntaje_documentacion }}</span></td>
                            <td class="px-4 py-3 text-center"><span class="px-2 py-1 bg-gradient-to-r from-blue-100 to-purple-100 text-gray-900 rounded font-bold">{{ number_format($calificacion->puntaje_final, 2) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                No hay calificaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Opciones de admin -->
    <div class="mt-8 flex gap-4">
        <a href="{{ route('admin.resultados.exportar', $evento->id_evento) }}" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-center">
            📄 Exportar a PDF
        </a>
        @if ($ganador)
            <a href="{{ route('admin.resultados.constancia', $evento->id_evento) }}" class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition text-center">
                🎖️ Generar Constancia
            </a>
        @endif
        <a href="{{ route('admin.resultados.index') }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
            ⬅️ Volver
        </a>
    </div>
</div>
@endsection
