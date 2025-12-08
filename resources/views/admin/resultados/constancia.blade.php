<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Constancia de Ganador - {{ $equipo->nombre }}</title>
    <style>
        @page {
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            min-height: 100vh;
        }
        .certificate-container {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 60px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border: 8px solid #ffc107;
            position: relative;
        }
        .certificate-border {
            border: 3px double #007BFF;
            padding: 40px;
            position: relative;
        }
        .corner-decoration {
            position: absolute;
            width: 50px;
            height: 50px;
            border-color: #ffc107;
            border-style: solid;
        }
        .corner-top-left {
            top: -3px;
            left: -3px;
            border-width: 3px 0 0 3px;
        }
        .corner-top-right {
            top: -3px;
            right: -3px;
            border-width: 3px 3px 0 0;
        }
        .corner-bottom-left {
            bottom: -3px;
            left: -3px;
            border-width: 0 0 3px 3px;
        }
        .corner-bottom-right {
            bottom: -3px;
            right: -3px;
            border-width: 0 3px 3px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 48px;
            color: #007BFF;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .certificate-title {
            font-size: 32px;
            color: #007BFF;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 20px 0;
        }
        .medal-icon {
            font-size: 72px;
            margin: 20px 0;
        }
        .content {
            text-align: center;
            margin: 40px 0;
            line-height: 2;
        }
        .content p {
            font-size: 16px;
            color: #333;
            margin: 15px 0;
        }
        .recipient-name {
            font-size: 36px;
            font-weight: bold;
            color: #007BFF;
            margin: 25px 0;
            text-transform: uppercase;
            border-bottom: 3px solid #ffc107;
            display: inline-block;
            padding: 10px 30px;
        }
        .event-name {
            font-size: 24px;
            font-weight: bold;
            color: #764ba2;
            margin: 20px 0;
        }
        .details-box {
            background: #f8f9fa;
            border: 2px solid #007BFF;
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        .details-title {
            font-size: 18px;
            font-weight: bold;
            color: #007BFF;
            margin-bottom: 15px;
            text-align: center;
        }
        .detail-row {
            display: table;
            width: 100%;
            margin: 10px 0;
            font-size: 14px;
        }
        .detail-label {
            display: table-cell;
            font-weight: bold;
            width: 40%;
            padding: 8px;
            color: #555;
        }
        .detail-value {
            display: table-cell;
            padding: 8px;
            color: #333;
        }
        .scores-grid {
            display: table;
            width: 100%;
            margin-top: 15px;
        }
        .score-item {
            display: table-row;
        }
        .score-label {
            display: table-cell;
            padding: 5px;
            font-size: 13px;
            color: #555;
        }
        .score-value {
            display: table-cell;
            padding: 5px;
            font-weight: bold;
            color: #007BFF;
            text-align: right;
        }
        .score-bar {
            display: table-cell;
            width: 40%;
            padding: 5px;
        }
        .bar {
            background: #e9ecef;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        .bar-fill {
            background: linear-gradient(90deg, #007BFF, #667eea);
            height: 100%;
            border-radius: 4px;
        }
        .final-score {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: white;
            font-size: 28px;
            font-weight: bold;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        .signatures {
            margin-top: 60px;
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            text-align: center;
            padding: 0 20px;
        }
        .signature-line {
            border-top: 2px solid #333;
            margin: 50px 20px 10px 20px;
        }
        .signature-label {
            font-size: 12px;
            color: #666;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(255, 193, 7, 0.1);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-border">
            <!-- Decoraciones de esquina -->
            <div class="corner-decoration corner-top-left"></div>
            <div class="corner-decoration corner-top-right"></div>
            <div class="corner-decoration corner-bottom-left"></div>
            <div class="corner-decoration corner-bottom-right"></div>

            <!-- Marca de agua -->
            <div class="watermark">GANADOR</div>

            <!-- Encabezado -->
            <div class="header">
                <div class="logo">CodeQuest</div>
                <div class="certificate-title">Constancia de Reconocimiento</div>
                <div class="medal-icon">🏆</div>
            </div>

            <!-- Contenido -->
            <div class="content">
                <p style="font-size: 18px;">Por medio de la presente se hace constar que el equipo:</p>

                <div class="recipient-name">{{ $equipo->nombre }}</div>

                <p style="font-size: 16px; margin-top: 20px;">Ha obtenido el <strong style="color: #ffc107; font-size: 20px;">PRIMER LUGAR</strong> en el evento:</p>

                <div class="event-name">{{ $evento->nombre }}</div>

                <p style="font-size: 14px; color: #666;">
                    Realizado del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}
                </p>
            </div>

            <!-- Detalles del equipo -->
            <div class="details-box">
                <div class="details-title">📋 Detalles del Equipo Ganador</div>

                <div class="detail-row">
                    <div class="detail-label">🎯 Nombre del Equipo:</div>
                    <div class="detail-value">{{ $equipo->nombre }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">💡 Proyecto:</div>
                    <div class="detail-value">{{ $equipo->nombre_proyecto ?? 'No especificado' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">👨‍💻 Líder del Equipo:</div>
                    <div class="detail-value">{{ $equipo->lider->nombre_completo }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">📧 Correo del Líder:</div>
                    <div class="detail-value">{{ $equipo->lider->correo }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">👥 Número de Miembros:</div>
                    <div class="detail-value">{{ $equipo->participantes->count() }} integrantes</div>
                </div>

                @if($equipo->participantes->count() > 0)
                    <div class="detail-row" style="margin-top: 15px;">
                        <div class="detail-label">👨‍👩‍👧‍👦 Integrantes:</div>
                        <div class="detail-value">
                            @foreach($equipo->participantes as $participante)
                                {{ $participante->nombre_completo }}@if(!$loop->last), @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Puntuaciones detalladas -->
            @if(isset($calificacion))
                <div class="details-box">
                    <div class="details-title">⭐ Puntuaciones Detalladas</div>

                    <div class="scores-grid">
                        <div class="score-item">
                            <div class="score-label">🎨 Creatividad e Innovación:</div>
                            <div class="score-value">{{ $calificacion->puntaje_creatividad }}/10</div>
                            <div class="score-bar">
                                <div class="bar">
                                    <div class="bar-fill" style="width: {{ $calificacion->puntaje_creatividad * 10 }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="score-item">
                            <div class="score-label">⚙️ Funcionalidad:</div>
                            <div class="score-value">{{ $calificacion->puntaje_funcionalidad }}/10</div>
                            <div class="score-bar">
                                <div class="bar">
                                    <div class="bar-fill" style="width: {{ $calificacion->puntaje_funcionalidad * 10 }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="score-item">
                            <div class="score-label">🎯 Diseño y Usabilidad:</div>
                            <div class="score-value">{{ $calificacion->puntaje_diseño }}/10</div>
                            <div class="score-bar">
                                <div class="bar">
                                    <div class="bar-fill" style="width: {{ $calificacion->puntaje_diseño * 10 }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="score-item">
                            <div class="score-label">🎤 Presentación:</div>
                            <div class="score-value">{{ $calificacion->puntaje_presentacion }}/10</div>
                            <div class="score-bar">
                                <div class="bar">
                                    <div class="bar-fill" style="width: {{ $calificacion->puntaje_presentacion * 10 }}%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="score-item">
                            <div class="score-label">📚 Documentación:</div>
                            <div class="score-value">{{ $calificacion->puntaje_documentacion }}/10</div>
                            <div class="score-bar">
                                <div class="bar">
                                    <div class="bar-fill" style="width: {{ $calificacion->puntaje_documentacion * 10 }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="final-score">
                        🏆 PUNTUACIÓN FINAL: {{ number_format($puntaje_final, 2) }}/10
                    </div>

                    <div class="detail-row" style="margin-top: 15px;">
                        <div class="detail-label">📊 Evaluado por:</div>
                        <div class="detail-value">{{ $calificaciones_count }} juez(es)</div>
                    </div>
                </div>
            @endif

            <!-- Firmas -->
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Coordinador del Evento</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Director Académico</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p><strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y') }}</p>
                <p>Esta constancia certifica la participación y logro del equipo en el evento CodeQuest</p>
                <p style="margin-top: 10px; font-size: 10px;">Documento generado automáticamente por el Sistema CodeQuest</p>
            </div>
        </div>
    </div>
</body>
</html>
