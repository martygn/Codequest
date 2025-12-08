@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">📊 Calificaciones - {{ $evento->nombre }}</h1>
    </div>

    <!-- Tabla de calificaciones -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Equipo</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Juez</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">🎨 Creatividad</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">⚙️ Funcionalidad</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">🎯 Diseño</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">🎤 Presentación</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">📚 Documentación</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">📊 Promedio</th>
                        @if (Auth::user()->esAdmin())
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($calificaciones as $calificacion)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $calificacion->equipo->nombre }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $calificacion->juez->nombre }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">{{ $calificacion->puntaje_creatividad }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">{{ $calificacion->puntaje_funcionalidad }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-semibold">{{ $calificacion->puntaje_diseño }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full font-semibold">{{ $calificacion->puntaje_presentacion }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold">{{ $calificacion->puntaje_documentacion }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 text-gray-900 rounded-full font-bold">
                                    {{ number_format($calificacion->puntaje_final, 2) }}
                                </span>
                            </td>
                            @if (Auth::user()->esAdmin())
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('calificaciones.destroy', $calificacion->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition" onclick="return confirm('¿Confirmar eliminación?')">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                No hay calificaciones registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen por Equipo -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">📈 Resumen por Equipo</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($promedios as $item)
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 border border-blue-200 rounded-lg p-6 shadow-md">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $item['equipo']->nombre }}</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <p class="text-gray-700">Calificaciones recibidas:</p>
                            <span class="font-bold text-blue-600">{{ $item['calificaciones']->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-gray-700">Promedio final:</p>
                            <span class="text-2xl font-bold text-gradient bg-gradient-to-r from-blue-600 to-purple-600">{{ number_format($item['puntaje_promedio'], 2) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-3">No hay datos para mostrar.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('eventos.show', $evento->id_evento) }}" class="px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition inline-block">
            ⬅️ Volver
        </a>
    </div>
</div>
@endsection
