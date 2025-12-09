<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia de Ganador</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 28px;">🏆 ¡Felicidades!</h1>
    </div>

    <div style="background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            Estimado equipo <strong style="color: #007BFF;">{{ $equipo->nombre }}</strong>,
        </p>

        <p style="font-size: 16px; margin-bottom: 20px;">
            Nos complace informarles que han obtenido el <strong style="color: #ffc107; font-size: 18px;">PRIMER LUGAR</strong> en el evento:
        </p>

        <div style="background: white; padding: 20px; border-left: 4px solid #007BFF; margin: 20px 0; border-radius: 5px;">
            <h2 style="color: #007BFF; margin: 0 0 10px 0; font-size: 22px;">{{ $evento->nombre }}</h2>
            <p style="margin: 0; color: #666;">
                📅 {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
            </p>
        </div>

        <p style="font-size: 16px; margin-bottom: 20px;">
            Adjunto a este correo encontrarán su <strong>constancia oficial</strong> en formato PDF, la cual pueden descargar, imprimir y compartir.
        </p>

        <div style="background: #e3f2fd; border: 2px solid #007BFF; padding: 20px; border-radius: 10px; margin: 25px 0;">
            <h3 style="color: #007BFF; margin: 0 0 15px 0; font-size: 18px;">📋 Detalles del Equipo:</h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="margin: 8px 0;"><strong>Equipo:</strong> {{ $equipo->nombre }}</li>
                <li style="margin: 8px 0;"><strong>Proyecto:</strong> {{ $equipo->nombre_proyecto ?? 'No especificado' }}</li>
                <li style="margin: 8px 0;"><strong>Líder:</strong> {{ $equipo->lider->nombre_completo }}</li>
                <li style="margin: 8px 0;"><strong>Miembros:</strong> {{ $equipo->participantes->count() }} integrantes</li>
            </ul>
        </div>

        <p style="font-size: 16px; margin: 25px 0 15px 0;">
            ¡Felicitaciones por este gran logro! Su dedicación y esfuerzo han sido excepcionales.
        </p>

        <p style="font-size: 14px; color: #666; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <strong>CodeQuest</strong><br>
            Sistema de Gestión de Eventos de Programación<br>
            <em>Este es un correo automático, por favor no responder.</em>
        </p>
    </div>
</body>
</html>
