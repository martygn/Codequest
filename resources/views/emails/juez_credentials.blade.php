<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <p>Hola {{ $juez->nombre_completo }},</p>

    <p>Se ha creado una cuenta de Juez para ti en <strong>CodeQuest</strong>. A continuación tus credenciales:</p>

    <ul>
        <li><strong>Correo:</strong> {{ $juez->correo }}</li>
        <li><strong>Contraseña:</strong> {{ $password }}</li>
    </ul>

    <p>Por favor inicia sesión en la plataforma y cambia tu contraseña una vez entres al sistema.</p>

    <p>Enlace de acceso: <a href="{{ url('/') }}">{{ url('/') }}</a></p>

    <p>Saludos,<br/>Equipo CodeQuest</p>
</body>
</html>
