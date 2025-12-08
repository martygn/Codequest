@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            📊 Dashboard de Resultados
        </h1>
        <p class="text-gray-600 mt-2">Administra y visualiza los resultados de todos los eventos</p>
    </div>

    <!-- Eventos con calificaciones -->
    @if ($resultados->count() > 0)
        <div class="space-y-8">
            @foreach ($resultados as $resultado)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Encabezado del evento -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white">
                        <h2 class="text-2xl font-bold">{{ $resultado['evento']->nombre }}</h2>
                        <p class="text-blue-100 mt-1">📅 {{ $resultado['evento']->fecha_inicio->format('d/m/Y') }} - {{ $resultado['evento']->fecha_fin->format('d/m/Y') }}</p>
                    </div>

                    <!-- Contenido -->
                    <div class="p-6">
                        <!-- Top 3 -->
                        @if ($resultado['ranking']->count() >= 3)
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">🥇 Top 3 Ganadores</h3>
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach ($resultado['ranking']->take(3) as $index => $item)
                                        @php
                                            $medallasColor = [
                                                ['bg' => 'from-yellow-400 to-yellow-500', 'border' => 'yellow', 'medal' => '🥇'],
                                                ['bg' => 'from-gray-400 to-gray-500', 'border' => 'gray', 'medal' => '🥈'],
                                                ['bg' => 'from-orange-400 to-orange-500', 'border' => 'orange', 'medal' => '🥉'],
                                            ];
                                            $color = $medallasColor[$index];
                                        @endphp
                                        <div class="bg-gradient-to-b {{ $color['bg'] }} rounded-lg p-4 text-white text-center shadow-md">
                                            <p class="text-4xl mb-2">{{ $color['medal'] }}</p>
                                            <p class="font-bold text-lg">{{ $item['equipo']->nombre }}</p>
                                            <p class="text-2xl font-bold mt-2">{{ number_format($item['puntaje_promedio'], 2) }}</p>
                                            <p class="text-sm opacity-90">{{ $item['calificaciones_count'] }} jueces</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Ranking completo -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-semibold text-gray-900">Posición</th>
                                        <th class="px-4 py-2 text-left font-semibold text-gray-900">Equipo</th>
                                        <th class="px-4 py-2 text-center font-semibold text-gray-900">Puntuación</th>
                                        <th class="px-4 py-2 text-center font-semibold text-gray-900">Jueces</th>
                                        <th class="px-4 py-2 text-center font-semibold text-gray-900">Estado</th>
                                        <th class="px-4 py-2 text-center font-semibold text-gray-900">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resultado['ranking'] as $index => $item)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 font-bold text-blue-600">#{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $item['equipo']->nombre }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-bold">{{ number_format($item['puntaje_promedio'], 2) }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center">{{ $item['calificaciones_count'] }}</td>
                                            <td class="px-4 py-3 text-center">
                                                @if ($item['ganador'])
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">🏆 GANADOR</span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Participante</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="{{ route('admin.resultados.show', $resultado['evento']->id_evento) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                                    Ver Detalles
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Sin resultados -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-12 text-center">
            <p class="text-4xl mb-4">📭</p>
            <p class="text-xl text-gray-700">No hay eventos con calificaciones aún</p>
            <p class="text-gray-600 mt-2">Los resultados aparecerán aquí cuando se registren calificaciones de jueces</p>
        </div>
    @endif
</div>
@endsection
