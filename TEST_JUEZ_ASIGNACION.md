# Guía de Prueba: Asignación de Eventos a Jueces

## 📋 Resumen del Trabajo Completado

### ✅ 1. Base de Datos
- **Migración**: `2025_12_07_100000_add_juez_to_usuarios_tipo_and_create_juez_evento_table.php`
- **Cambios**:
  - Enum `usuarios.tipo` ahora incluye: `administrador`, `participante`, `juez`
  - Nueva tabla `juez_evento` con relación M:M entre usuarios y eventos
  - Columnas: `id`, `usuario_id`, `evento_id`, `created_at`, `updated_at`
  - Constraint única: `unique(usuario_id, evento_id)`

### ✅ 2. Modelos (Relaciones)
- **Usuario.php**:
  - `eventosAsignados()`: BelongsToMany → Evento (via juez_evento)
  - `esJuez()`: Verifica si tipo === 'juez'
  - `scopeJueces()`: Query builder para filtrar jueces

- **Evento.php**:
  - `jueces()`: BelongsToMany → Usuario (via juez_evento con timestamps)

- **Equipo.php**:
  - `jueces()`: Through Evento (para obtener jueces de un equipo)

### ✅ 3. Controlador (AdminController)

#### `asignarEventosJuez(Usuario $juez)`
```php
- Obtiene todos los eventos: Evento::orderBy('nombre')->get()
- Obtiene eventos ya asignados al juez
- Pasa datos a vista 'admin.jueces.asignar'
```

#### `guardarAsignacionEventosJuez(Request $request, Usuario $juez)`
```php
- Valida: 'eventos' array de IDs existentes en tabla eventos
- Sincroniza usando: $juez->eventosAsignados()->sync($eventosIds)
- Redirige a admin.jueces con mensaje de éxito
```

### ✅ 4. Rutas
```
GET  /admin/jueces/{juez}/asignar-eventos      → admin.jueces.asignar-eventos
POST /admin/jueces/{juez}/guardar-asignacion   → admin.jueces.guardar-asignacion
```

### ✅ 5. Vistas
- **admin/jueces/asignar.blade.php**: Formulario con checkboxes de eventos
  - Muestra todos los eventos disponibles
  - Marca como "checked" los eventos ya asignados
  - Incluye descripción, fechas y nota informativa

---

## 🧪 Guía de Prueba Paso a Paso

### Paso 1: Crear un Juez
1. Ir a `/admin/jueces`
2. Clic en "Crear Juez"
3. Llenar formulario:
   - Nombre: `Juan`
   - Apellido Paterno: `Pérez`
   - Apellido Materno: `García`
   - Correo: `juan.perez@test.com`
4. Clic en "Crear Juez"
5. Copiar las credenciales mostradas

### Paso 2: Crear o Verificar Eventos
1. Ir a `/admin/eventos`
2. Verificar que existan al menos 2 eventos (o crear nuevos)
3. Anotar los IDs de los eventos

### Paso 3: Asignar Eventos al Juez
1. Volver a `/admin/jueces`
2. Encontrar el juez creado (Juan Pérez García)
3. Clic en botón "Asignar"
4. En la página de asignación:
   - Marcar checkboxes de 2-3 eventos
   - Clic en "Guardar Asignaciones"
5. Verificar que:
   - Se muestre mensaje verde de éxito
   - La columna "Asignaciones" se actualice mostrando el count

### Paso 4: Verificar desde Panel del Juez
1. Cerrar sesión del admin
2. Ir a `/login`
3. Iniciar sesión con credenciales del juez:
   - Email: `juan.perez@test.com`
   - Password: (la generada en Paso 1)
4. Debe redirigir automáticamente a `/juez/panel`
5. Verificar que:
   - Se muestre el evento asignado
   - Se muestren los equipos de ese evento
   - La tabla de equipos tenga columnas: Nombre, Proyecto, Líder, Miembros, Estado

### Paso 5: Desasignar Eventos
1. Volver a admin como administrador
2. Ir a `/admin/jueces` → Asignar del mismo juez
3. Desmarcar algunos eventos
4. Clic en "Guardar Asignaciones"
5. Verificar que:
   - Los eventos se deseleccionen en el panel del juez
   - El contador de asignaciones disminuya

---

## 🔍 Validaciones Técnicas

### Base de Datos
```sql
-- Verificar migración aplicada:
SHOW COLUMNS FROM usuarios WHERE Field = 'tipo';
-- Debe mostrar: ENUM('administrador','participante','juez')

-- Verificar tabla juez_evento:
DESC juez_evento;
-- Debe tener: id, usuario_id, evento_id, created_at, updated_at
```

### Rutas
```bash
php artisan route:list --name=jueces
# Debe mostrar 5 rutas incluyendo:
# - admin.jueces.asignar-eventos
# - admin.jueces.guardar-asignacion
```

### Caché
```bash
# Si la vista no carga correctamente, limpiar:
php artisan view:clear
```

---

## ⚠️ Posibles Problemas

| Problema | Solución |
|----------|----------|
| Vista de asignación no carga | `php artisan view:clear` |
| Checkboxes no se marcan | Verificar que `eventosAsignados()` retorne array correcto |
| No se guarden asignaciones | Verificar constraint única en tabla `juez_evento` |
| Juez no ve eventos | Verificar relación `eventosAsignados()` en Usuario.php |
| Formulario valida mal los eventos | Verificar que los eventos existan: `events.id_evento` |

---

## 📊 Flujo de Datos

```
Admin clic "Asignar"
    ↓
GET /admin/jueces/{id}/asignar-eventos
    ↓
asignarEventosJuez() obtiene:
  - $eventos = Evento::orderBy('nombre')->get()
  - $eventosAsignados = $juez->eventosAsignados()->pluck('id_evento')->toArray()
    ↓
Vista muestra checkboxes
    ↓
Admin selecciona y hace submit
    ↓
POST /admin/jueces/{id}/guardar-asignacion
    ↓
guardarAsignacionEventosJuez() sincroniza:
  - $juez->eventosAsignados()->sync($eventosIds)
    ↓
Redirige a admin.jueces con éxito
    ↓
Juez accede a /juez/panel
    ↓
JuezController obtiene:
  - $eventosAsignados = $juez->eventosAsignados()->get()
  - $equipos = $evento->equipos()->get()
    ↓
Panel muestra eventos y equipos del juez
```

---

## ✨ Funcionalidad Completada

✅ Crear jueces con credenciales auto-generadas
✅ Mostrar credenciales después de crear
✅ Listar jueces con contador de asignaciones
✅ Asignar eventos a jueces (M:M)
✅ Auto-redirigir jueces a su panel
✅ Mostrar eventos asignados en panel de juez
✅ Mostrar equipos para evaluación

---

## 🚀 Próximos Pasos (No Incluidos)

- [ ] Implementar calificación de equipos por juez
- [ ] Seleccionar ganador de evento
- [ ] Generar certificados/constancias (PDF)
- [ ] Historial de constancias
- [ ] Notificaciones al juez cuando se asigna evento
