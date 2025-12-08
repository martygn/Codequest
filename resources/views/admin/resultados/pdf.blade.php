<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Resultados - {{ $evento->nombre }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007BFF;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            color: #007BFF;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 11px;
            color: #888;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            font-size: 14px;
            color: #007BFF;
            margin-bottom: 10px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px;
            width: 30%;
        }
        .info-value {
            display: table-cell;
            padding: 5px;
        }
        .section-title {
            font-size: 16px;
            color: #007BFF;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
            margin: 20px 0 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background: #007BFF;
            color: white;
        }
        table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        .ganador {
            background: #fff3cd !important;
            font-weight: bold;
        }
        .podium {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .podium-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 10px;
        }
        .podium-box {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            min-height: 120px;
        }
        .podium-box.first {
            border-color: #ffc107;
            background: #fff9e6;
        }
        .podium-box.second {
            border-color: #c0c0c0;
            background: #f5f5f5;
        }
        .podium-box.third {
            border-color: #cd7f32;
            background: #fff5e6;
        }
        .medal {
            font-size: 32px;
            margin-bottom: 5px;
        }
        .podium-name {
            font-size: 13px;
            font-weight: bold;
            margin: 5px 0;
        }
        .podium-score {
            font-size: 18px;
            font-weight: bold;
            color: #007BFF;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-winner {
            background: #ffc107;
            color: #856404;
        }
        .badge-participant {
            background: #e9ecef;
            color: #495057;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>CodeQuest</h1>
        <h2>Resultados del Evento</h2>
        <p>{{ $evento->nombre }}</p>
    </div>

    <!-- Información del Evento -->
    <div class="info-box">
        <h3>Información del Evento</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Evento:</div>
                <div class="info-value">{{ $evento->nombre }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Descripción:</div>
                <div class="info-value">{{ $evento->descripcion ?? 'Sin descripción' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha de inicio:</div>
                <div class="info-value">{{ $evento->fecha_inicio->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha de fin:</div>
                <div class="info-value">{{ $evento->fecha_fin->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Total de equipos:</div>
                <div class="info-value">{{ $ranking->count() }} equipos</div>
            </div>
        </div>
    </div>

    <!-- Top 3 Podio -->
    @if($ranking->count() >= 3)
        <h3 class="section-title">🏆 Top 3 Ganadores</h3>
        <div class="podium">
            @foreach($ranking->take(3) as $index => $item)
                @php
                    $classes = ['first', 'second', 'third'];
                    $medals = ['🥇', '🥈', '🥉'];
                @endphp
                <div class="podium-item">
                    <div class="podium-box {{ $classes[$index] }}">
                        <div class="medal">{{ $medals[$index] }}</div>
                        <div class="podium-name">{{ $item['equipo']->nombre }}</div>
                        <div class="podium-score">{{ number_format($item['puntaje_promedio'], 2) }}</div>
                        <div style="font-size: 10px; color: #666; margin-top: 5px;">
                            {{ $item['calificaciones_count'] }} juez(es)
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Ranking Completo -->
    <h3 class="section-title">📊 Ranking Completo</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Posición</th>
                <th style="width: 35%;">Equipo</th>
                <th style="width: 20%; text-align: center;">Puntuación</th>
                <th style="width: 15%; text-align: center;">Jueces</th>
                <th style="width: 20%; text-align: center;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ranking as $index => $item)
                <tr class="{{ $item['ganador'] ? 'ganador' : '' }}">
                    <td><strong>#{{ $index + 1 }}</strong></td>
                    <td>{{ $item['equipo']->nombre }}</td>
                    <td class="text-center"><strong>{{ number_format($item['puntaje_promedio'], 2) }}</strong></td>
                    <td class="text-center">{{ $item['calificaciones_count'] }}</td>
                    <td class="text-center">
                        @if($item['ganador'])
                            <span class="badge badge-winner">🏆 GANADOR</span>
                        @else
                            <span class="badge badge-participant">Participante</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>CodeQuest - Sistema de Gestión de Eventos de Programación</p>
    </div>
</body>
</html>
