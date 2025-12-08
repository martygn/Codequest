# 🔗 Referencia de Rutas - Sistema Enterprise

## Rutas para Equipo (Líder)

### Subir/Editar Repositorio
```
GET  /equipos/{equipo_id}/repositorio
     Mostrar formulario de subida
     
POST /equipos/{equipo_id}/repositorio
     Guardar repositorio
     
POST /repositorios/{repositorio_id}/descargar
     Descargar archivo ZIP
```

**Ejemplo:**
```
http://localhost:8000/equipos/5/repositorio
```

---

## Rutas para Juez

### Calificar Equipo
```
GET  /equipos/{equipo_id}/calificar
     Mostrar formulario de calificación
     
POST /equipos/{equipo_id}/calificar
     Guardar calificación
     
POST /calificaciones/{calificacion_id}
     Actualizar calificación existente
```

**Ejemplo:**
```
http://localhost:8000/equipos/5/calificar
```

### Ver Ranking
```
GET /eventos/{evento_id}/ranking
    Ver ranking público del evento
    
GET /eventos/{evento_id}/calificaciones
    Listar todas las calificaciones
```

**Ejemplo:**
```
http://localhost:8000/eventos/3/ranking
http://localhost:8000/eventos/3/calificaciones
```

---

## Rutas para Admin (middleware: is.admin)

### Gestionar Repositorios
```
POST   /repositorios/{repositorio_id}/verificar
       Marcar repositorio como verificado
       
POST   /repositorios/{repositorio_id}/rechazar
       Rechazar repositorio (requiere motivo)
       
DELETE /repositorios/{repositorio_id}
       Eliminar repositorio
```

**Ejemplo:**
```
POST /repositorios/15/verificar
POST /repositorios/15/rechazar
DELETE /repositorios/15
```

### Gestionar Calificaciones
```
DELETE /calificaciones/{calificacion_id}
       Eliminar calificación
```

### Dashboard de Resultados
```
GET /admin/resultados
    Dashboard con todos los eventos
    
GET /admin/eventos/{evento_id}/resultados
    Detalles completos de un evento
    
POST /admin/eventos/{evento_id}/marcar-ganador
     Marcar equipo como ganador
     (body: equipo_id)
     
GET /admin/eventos/{evento_id}/exportar-resultados
    Exportar resultados a PDF
    
GET /admin/eventos/{evento_id}/constancia
    Generar constancia de ganador
```

**Ejemplo:**
```
http://localhost:8000/admin/resultados
http://localhost:8000/admin/eventos/3/resultados
POST /admin/eventos/3/marcar-ganador {equipo_id: 5}
```

---

## Parámetros en URL

### Equipo
- `{equipo}` o `{equipo_id}` - ID del equipo (primary key: `id_equipo`)
- Tipo: INTEGER

### Evento
- `{evento}` o `{evento_id}` - ID del evento (primary key: `id_evento`)
- Tipo: INTEGER

### Repositorio
- `{repositorio}` o `{repositorio_id}` - ID del repositorio
- Tipo: INTEGER

### Calificación
- `{calificacion}` o `{calificacion_id}` - ID de calificación
- Tipo: INTEGER

---

## Request Bodies (POST)

### Subir Repositorio
```json
{
  "url_github": "https://github.com/usuario/proyecto",
  "url_gitlab": null,
  "url_bitbucket": null,
  "url_personalizado": null,
  "archivo": "<archivo binario>",
  "rama_produccion": "main",
  "descripcion": "Descripción del proyecto..."
}
```

### Calificar
```json
{
  "puntaje_creatividad": 8,
  "puntaje_funcionalidad": 9,
  "puntaje_diseño": 7,
  "puntaje_presentacion": 8,
  "puntaje_documentacion": 6,
  "observaciones": "Buen proyecto, faltó...",
  "recomendaciones": "Podrían mejorar..."
}
```

### Marcar Ganador
```json
{
  "equipo_id": 5
}
```

### Rechazar Repositorio
```json
{
  "motivo": "El archivo está corrupto"
}
```

---

## Estados HTTP Esperados

### Success
```
200 OK              - GET exitoso
201 Created         - POST exitoso (creación)
204 No Content      - DELETE exitoso
```

### Errores
```
400 Bad Request     - Validación fallida
403 Forbidden       - Sin permisos
404 Not Found       - Recurso no existe
409 Conflict        - Conflicto de datos
422 Unprocessable   - Datos inválidos
```

---

## Nombres de Rutas en Blade

### Para usar en vistas ({{ route() }})

```blade
<!-- Repositorios -->
route('repositorios.show', $equipo->id_equipo)
route('repositorios.store', $equipo->id_equipo)
route('repositorios.descargar', $repositorio->id)
route('repositorios.verificar', $repositorio->id)
route('repositorios.rechazar', $repositorio->id)
route('repositorios.destroy', $repositorio->id)

<!-- Calificaciones -->
route('calificaciones.show', $equipo->id_equipo)
route('calificaciones.store', $equipo->id_equipo)
route('calificaciones.update', $calificacion->id)
route('calificaciones.destroy', $calificacion->id)
route('calificaciones.listar', $evento->id_evento)
route('calificaciones.ranking', $evento->id_evento)

<!-- Resultados -->
route('admin.resultados.index')
route('admin.resultados.show', $evento->id_evento)
route('admin.resultados.marcar-ganador', $evento->id_evento)
route('admin.resultados.exportar', $evento->id_evento)
route('admin.resultados.constancia', $evento->id_evento)
```

---

## Ejemplo: Flujo Completo

### 1. Equipo sube repositorio
```
GET  /equipos/5/repositorio
     ↓ User completa formulario
POST /equipos/5/repositorio
     ✓ Guardado con estado 'enviado'
```

### 2. Admin verifica
```
GET  /admin/eventos/3/resultados
     ↓ Admin ve repositorio pendiente
POST /repositorios/15/verificar
     ✓ Estado cambia a 'verificado'
```

### 3. Juez califica
```
GET  /equipos/5/calificar
     ↓ Juez completa sliders
POST /equipos/5/calificar
     ✓ Guardado, puntaje_final calculado
```

### 4. Ver ranking
```
GET  /admin/eventos/3/resultados
     ↓ Admin ve ranking completo
POST /admin/eventos/3/marcar-ganador {equipo_id: 5}
     ✓ Equipo marcado como ganador
```

### 5. Generar constancia
```
GET  /admin/eventos/3/constancia
     ↓ Sistema genera PDF
     ✓ Descargable
```

---

## Testing con cURL

### Subir repositorio
```bash
curl -X POST "http://localhost:8000/equipos/5/repositorio" \
  -H "Authorization: Bearer {token}" \
  -F "url_github=https://github.com/test/repo" \
  -F "rama_produccion=main" \
  -F "descripcion=Mi proyecto"
```

### Calificar
```bash
curl -X POST "http://localhost:8000/equipos/5/calificar" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "puntaje_creatividad": 8,
    "puntaje_funcionalidad": 9,
    "puntaje_diseño": 7,
    "puntaje_presentacion": 8,
    "puntaje_documentacion": 6
  }'
```

### Marcar ganador
```bash
curl -X POST "http://localhost:8000/admin/eventos/3/marcar-ganador" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"equipo_id": 5}'
```

---

## Middleware Requeridos

| Ruta | Middleware |
|------|-----------|
| `/equipos/{}/repositorio` | `auth` |
| `/repositorios/{}/descargar` | `auth` |
| `/equipos/{}/calificar` | `auth` |
| `/eventos/{}/ranking` | `auth` (opcional public) |
| `/admin/*` | `auth`, `is.admin` |

---

## Notas

- **Base URL**: `http://localhost:8000` (desarrollo)
- **Token**: Se obtiene en login
- **CSRF**: Requerido para POST/PUT/DELETE en formularios
- **IDs**: Verificar que existan en BD antes de usar

---

*Referencia de Rutas - Sistema Enterprise v1.0*
