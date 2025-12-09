# 📧 Configuración de Envío de Correos - CodeQuest

## ✅ Dependencias Incluidas

Laravel 12 ya incluye todas las dependencias necesarias para el envío de correos:
- `symfony/mailer` - Motor de envío de correos
- `symfony/mime` - Procesamiento de MIME para correos HTML
- No se requiere instalación adicional

## 🔧 Configuración del Archivo `.env`

Para enviar correos reales, debes configurar las siguientes variables en tu archivo `.env`:

### Opción 1: Gmail (Recomendado para pruebas)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@codequest.com
MAIL_FROM_NAME="CodeQuest"
```

**IMPORTANTE para Gmail:**
1. Debes habilitar la "Verificación en 2 pasos" en tu cuenta de Google
2. Generar una "Contraseña de aplicación" desde: https://myaccount.google.com/apppasswords
3. Usar esa contraseña generada en `MAIL_PASSWORD` (no tu contraseña normal)

### Opción 2: Mailtrap (Para desarrollo/testing)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-username-mailtrap
MAIL_PASSWORD=tu-password-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@codequest.com
MAIL_FROM_NAME="CodeQuest"
```

### Opción 3: Modo LOG (Actual - Solo para desarrollo)

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

En modo `log`, los correos se guardan en `storage/logs/laravel.log` en lugar de enviarse.

## 🧪 Cómo Probar el Envío de Correos

### 1. Verificar Configuración
Ejecuta este comando para ver la configuración actual:
```bash
php artisan config:show mail
```

### 2. Probar Envío con Tinker
```bash
php artisan tinker
```

Luego ejecuta:
```php
Mail::raw('Correo de prueba desde CodeQuest', function ($message) {
    $message->to('tu-correo@ejemplo.com')
            ->subject('Prueba de Correo');
});
```

### 3. Enviar Constancia Real
1. Ve al panel de Resultados
2. Marca un equipo como ganador
3. Haz clic en "Ver Detalles" del evento
4. Clic en "Enviar por Correo"
5. Confirma en el modal
6. Verifica que llegó el correo al líder del equipo

## 📋 Checklist de Verificación

- [ ] Variables `MAIL_*` configuradas en `.env`
- [ ] Si usas Gmail: Contraseña de aplicación generada
- [ ] Ejecutar `php artisan config:clear` después de cambiar `.env`
- [ ] Probar envío con tinker
- [ ] Verificar que el líder del equipo tiene correo registrado
- [ ] Verificar logs en `storage/logs/laravel.log` si hay errores

## 🐛 Solución de Problemas

### Error: "Failed to authenticate"
- Verifica que usas una contraseña de aplicación en Gmail
- Revisa que el usuario/contraseña sean correctos

### Error: "Connection refused"
- Verifica el `MAIL_HOST` y `MAIL_PORT`
- Asegúrate de tener conexión a internet
- Verifica que tu firewall permite conexiones SMTP

### Error: "No líder registrado"
- El equipo debe tener un líder asignado
- El líder debe tener un correo válido en la base de datos

### Los correos no llegan
- Revisa la carpeta de SPAM
- Verifica que `MAIL_FROM_ADDRESS` sea válido
- Usa Mailtrap para debugging

## 📚 Recursos Adicionales

- [Laravel Mail Documentation](https://laravel.com/docs/12.x/mail)
- [Gmail App Passwords](https://support.google.com/accounts/answer/185833)
- [Mailtrap.io](https://mailtrap.io) - Servicio de testing de emails

## 🔐 Seguridad

**NUNCA** compartas tu `.env` o publiques contraseñas en repositorios públicos.
El archivo `.env` ya está en `.gitignore` para proteger tus credenciales.
