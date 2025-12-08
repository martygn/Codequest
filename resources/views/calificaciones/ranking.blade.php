@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            🏆 Ranking - {{ $evento->nombre }}
        </h1>
    </div>

    <!-- Podio de ganadores -->
    @if ($ranking->count() >= 3)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">🥇 Podio de Ganadores</h2>
            <div class="grid grid-cols-3 gap-4">
                <!-- Segundo lugar (Izquierda) -->
                <div class="flex flex-col items-center">
                    <div class="w-full bg-gradient-to-b from-gray-400 to-gray-500 rounded-t-2xl p-6 text-white">
                        <p class="text-center text-6xl mb-2">🥈</p>
                        <p class="text-center text-2xl font-bold">{{ $ranking->get(1)['equipo']->nombre }}</p>
                    </div>
                    <div class="w-full bg-gray-200 rounded-b-2xl p-4 text-center">
                        <p class="text-gray-700 font-bold text-xl">{{ number_format($ranking->get(1)['puntaje_promedio'], 2) }} pts</p>
                        <p class="text-gray-600 text-sm">Juzgado por {{ $ranking->get(1)['calificaciones_count'] }} jueces</p>
                    </div>
                    <div class="mt-4 h-32 border-l-4 border-gray-400"></div>
                </div>

                <!-- Primer lugar (Centro) -->
                <div class="flex flex-col items-center">
                    <div class="w-full bg-gradient-to-b from-yellow-400 to-yellow-500 rounded-t-2xl p-6 text-white">
                        <p class="text-center text-7xl mb-2">🥇</p>
                        <p class="text-center text-2xl font-bold">{{ $ranking->get(0)['equipo']->nombre }}</p>
                    </div>
                    <div class="w-full bg-yellow-100 rounded-b-2xl p-4 text-center border-2 border-yellow-400">
                        <p class="text-gray-900 font-bold text-2xl">{{ number_format($ranking->get(0)['puntaje_promedio'], 2) }} pts</p>
                        <p class="text-gray-700 text-sm font-semibold">Juzgado por {{ $ranking->get(0)['calificaciones_count'] }} jueces</p>
                    </div>
                    <div class="mt-4 h-40 border-l-4 border-yellow-400"></div>
                </div>

                <!-- Tercer lugar (Derecha) -->
                <div class="flex flex-col items-center">
                    <div class="w-full bg-gradient-to-b from-orange-500 to-orange-600 rounded-t-2xl p-6 text-white">
                        <p class="text-center text-5xl mb-2">🥉</p>
                        <p class="text-center text-2xl font-bold">{{ $ranking->get(2)['equipo']->nombre }}</p>
                    </div>
                    <div class="w-full bg-orange-100 rounded-b-2xl p-4 text-center">
                        <p class="text-gray-900 font-bold text-xl">{{ number_format($ranking->get(2)['puntaje_promedio'], 2) }} pts</p>
                        <p class="text-gray-700 text-sm">Juzgado por {{ $ranking->get(2)['calificaciones_count'] }} jueces</p>
                    </div>
                    <div class="mt-4 h-24 border-l-4 border-orange-500"></div>
                </div>
            </div>
        </div>
    @endif

    <!-- Ranking completo -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">📊 Ranking Completo</h2>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Posición</th>
                        <th class="px-6 py-4 text-left font-semibold">Equipo</th>
                        <th class="px-6 py-4 text-center font-semibold">Puntuación Promedio</th>
                        <th class="px-6 py-4 text-center font-semibold">Calificaciones</th>
                        <th class="px-6 py-4 text-center font-semibold">Estatus</th>
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
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                        {{ number_format($item['puntaje_promedio'], 2) }}
                                    </span>
                                    <span class="text-xs text-gray-500">/ 10.00</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">{{ $item['calificaciones_count'] }} jueces</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item['ganador'])
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-bold">🏆 GANADOR</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full">Participante</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No hay equipos clasificados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Total de Equipos</p>
            <p class="text-4xl font-bold text-blue-600">{{ $ranking->count() }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Puntuación Máxima</p>
            <p class="text-4xl font-bold text-green-600">{{ number_format($ranking->first()['puntaje_promedio'] ?? 0, 2) }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6 shadow-md">
            <p class="text-gray-700 text-sm font-semibold mb-2">Puntuación Mínima</p>
            <p class="text-4xl font-bold text-purple-600">{{ number_format($ranking->last()['puntaje_promedio'] ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Opciones para admin -->
    @if (Auth::user()->esAdmin())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4">⚙️ Opciones de Administrador</h3>
            <div class="flex gap-4">
                <a href="{{ route('admin.resultados.exportar', $evento->id_evento) }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    📄 Exportar a PDF
                </a>
                <a href="{{ route('admin.resultados.constancia', $evento->id_evento) }}" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    🎖️ Generar Constancia
                </a>
                <a href="{{ route('admin.resultados.show', $evento->id_evento) }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">
                    📊 Ver Detalles
                </a>
            </div>
        </div>
    @endif

    <!-- Botón volver -->
    <div class="text-center">
        <a href="{{ route('eventos.show', $evento->id_evento) }}" class="px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition inline-block">
            ⬅️ Volver al Evento
        </a>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #3b82f6, #9333ea);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection
