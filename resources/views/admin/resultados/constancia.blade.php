@php
    // Definir colores según la posición
    $posicion = $posicion ?? 1;
    $colores = [
        1 => [
            'principal' => '#D4AF37', // Oro
            'secundario' => '#FFC107',
            'borde' => '#B8860B',
            'texto' => 'PRIMER LUGAR',
            'emoji' => '🥇',
            'numero' => '1°'
        ],
        2 => [
            'principal' => '#C0C0C0', // Plata
            'secundario' => '#E8E8E8',
            'borde' => '#A9A9A9',
            'texto' => 'SEGUNDO LUGAR',
            'emoji' => '🥈',
            'numero' => '2°'
        ],
        3 => [
            'principal' => '#CD7F32', // Bronce
            'secundario' => '#D2691E',
            'borde' => '#A0522D',
            'texto' => 'TERCER LUGAR',
            'emoji' => '🥉',
            'numero' => '3°'
        ]
    ];
    $config = $colores[$posicion] ?? $colores[1];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Constancia de {{ $config['texto'] }} - {{ $equipo->nombre }}</title>
    <style>
        @page {
            margin: 8mm;
            size: A4 portrait;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #2c3e50;
            background: white;
        }

        /* Contenedor principal */
        .certificate {
            position: relative;
            padding: 15px;
            border: 6px solid {{ $config['borde'] }};
            background: white;
        }

        /* Borde decorativo interno */
        .inner-border {
            border: 2px solid {{ $config['principal'] }};
            padding: 12px;
        }

        /* Header elegante */
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid {{ $config['borde'] }};
            margin-bottom: 12px;
        }

        .logo {
            font-size: 28pt;
            font-weight: bold;
            color: {{ $config['borde'] }};
            font-family: 'Georgia', serif;
            letter-spacing: 2px;
        }

        .certificate-type {
            font-size: 11pt;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 5px;
            font-weight: normal;
        }

        /* Premio destacado */
        .award-section {
            text-align: center;
            margin: 12px 0;
            background: {{ $config['secundario'] }};
            padding: 12px;
            border-radius: 8px;
            border: 2px solid {{ $config['principal'] }};
        }

        .award-icon {
            font-size: 42pt;
            color: {{ $config['borde'] }};
            margin: 0;
            line-height: 1;
            font-weight: bold;
        }

        .award-text {
            font-size: 16pt;
            font-weight: bold;
            color: {{ $config['borde'] }};
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        /* Presentación del ganador */
        .presentation {
            text-align: center;
            margin: 12px 0;
        }

        .presentation-text {
            font-size: 10pt;
            color: #555;
            margin-bottom: 8px;
            font-style: italic;
        }

        .team-name {
            font-size: 22pt;
            font-weight: bold;
            color: {{ $config['borde'] }};
            text-transform: uppercase;
            padding: 8px 25px;
            border-top: 2px solid {{ $config['principal'] }};
            border-bottom: 2px solid {{ $config['principal'] }};
            display: inline-block;
            margin: 8px 0;
            letter-spacing: 2px;
        }

        .event-info {
            margin-top: 10px;
        }

        .event-name {
            font-size: 13pt;
            color: #2c3e50;
            font-weight: bold;
            margin: 5px 0;
        }

        .event-date {
            font-size: 9pt;
            color: #666;
        }

        /* Información en columnas */
        .info-grid {
            display: table;
            width: 100%;
            margin: 12px 0;
            border: 2px solid #e0e0e0;
            background: #f9f9f9;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 5px 10px;
            font-weight: bold;
            color: {{ $config['borde'] }};
            width: 30%;
            border-bottom: 1px solid #e0e0e0;
            background: #f0f4f8;
            font-size: 9pt;
        }

        .info-value {
            display: table-cell;
            padding: 5px 10px;
            color: #333;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9pt;
        }

        /* Sección de puntuaciones */
        .scores-section {
            margin: 20px 0;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: {{ $config['borde'] }};
            text-align: center;
            margin-bottom: 12px;
            padding: 8px;
            background: #e8f1f8;
            border-left: 4px solid {{ $config['borde'] }};
        }

        .score-item {
            margin: 8px 0;
            padding: 8px;
            border-left: 3px solid {{ $config['borde'] }};
            background: white;
        }

        .score-label {
            display: inline-block;
            width: 50%;
            font-weight: bold;
            color: #333;
            font-size: 10pt;
        }

        .score-value {
            display: inline-block;
            width: 15%;
            text-align: center;
            font-weight: bold;
            color: {{ $config['borde'] }};
            font-size: 11pt;
        }

        .score-bar {
            display: inline-block;
            width: 30%;
            height: 10px;
            background: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            vertical-align: middle;
        }

        .score-fill {
            height: 100%;
            background: {{ $config['borde'] }};
            border-radius: 5px;
        }

        /* Puntuación final destacada */
        .final-score-box {
            text-align: center;
            background: {{ $config['secundario'] }};
            color: {{ $config['borde'] }};
            padding: 10px;
            margin: 12px 0;
            border-radius: 5px;
            font-size: 16pt;
            font-weight: bold;
        }

        /* Firmas */
        .signatures {
            margin-top: 20px;
            text-align: center;
        }

        .signature-line {
            display: inline-block;
            width: 40%;
            margin: 0 4%;
            vertical-align: top;
        }

        .signature-line hr {
            border: none;
            border-top: 1px solid #333;
            margin-bottom: 3px;
        }

        .signature-label {
            font-size: 8pt;
            color: #555;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px solid #e0e0e0;
            font-size: 7pt;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="inner-border">
            <!-- Header -->
            <div class="header">
                <div class="logo">CodeQuest</div>
                <div class="certificate-type">Constancia de Reconocimiento</div>
            </div>

            <!-- Premio -->
            <div class="award-section">
                <div class="award-icon">{{ $config['numero'] }}</div>
                <div class="award-text">{{ $config['texto'] }}</div>
            </div>

            <!-- Presentación -->
            <div class="presentation">
                <p class="presentation-text">Por medio de la presente se certifica que el equipo:</p>
                <div class="team-name">{{ $equipo->nombre }}</div>
                <div class="event-info">
                    <p class="presentation-text">Ha obtenido el <strong>{{ strtoupper($config['texto']) }}</strong> en:</p>
                    <div class="event-name">{{ $evento->nombre }}</div>
                    <p class="event-date">Realizado del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Información del equipo -->
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Equipo</div>
                    <div class="info-value">{{ $equipo->nombre }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Proyecto</div>
                    <div class="info-value">{{ $equipo->nombre_proyecto ?? 'No especificado' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Líder</div>
                    <div class="info-value">{{ $equipo->lider->nombre_completo }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Integrantes</div>
                    <div class="info-value">
                        @if($equipo->participantes->count() > 0)
                            @foreach($equipo->participantes as $participante)
                                {{ $participante->nombre_completo }}@if(!$loop->last), @endif
                            @endforeach
                        @else
                            Sin integrantes registrados
                        @endif
                    </div>
                </div>
            </div>

            <!-- Puntuación Final -->
            @if(isset($calificacion))
            <div class="final-score-box" style="margin-top: 30px;">
                PUNTUACIÓN FINAL: {{ number_format($puntaje_final, 2) }}/10
            </div>

            <p style="text-align: center; font-size: 9pt; color: #666; margin-top: 12px;">
                Evaluado por {{ $calificaciones_count }} juez{{ $calificaciones_count > 1 ? 'es' : '' }}
            </p>
            @endif

            <!-- Firmas -->
            <div class="signatures">
                <div class="signature-line">
                    <hr>
                    <div class="signature-label">Coordinador del Evento</div>
                </div>
                <div class="signature-line">
                    <hr>
                    <div class="signature-label">Director Académico</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p><strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y') }}</p>
                <p>Documento generado por el Sistema CodeQuest</p>
            </div>
        </div>
    </div>
</body>
</html>
