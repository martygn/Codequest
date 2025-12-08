# 📊 Sistema Enterprise de Calificaciones y Repositorios - Documentación Técnica

## 🎯 Resumen Ejecutivo

Se ha implementado exitosamente el **Sistema Enterprise Completo** para gestión de calificaciones de jueces y repositorios de equipos, sin modificar ninguna funcionalidad existente del sistema.

### ✅ Componentes Implementados

1. **Repositorios (Subida de código)**
2. **Calificaciones de Jueces (Scoring 1-10)**
3. **Resultados y Rankings (Dashboards)**

---

## 🗄️ Base de Datos

### Tablas Nuevas

#### 1. **repositorios**
```sql
CREATE TABLE repositorios (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    equipo_id BIGINT UNIQUE NOT NULL,
    evento_id BIGINT NOT NULL,
    url_github VARCHAR(500),
    url_gitlab VARCHAR(500),
    url_bitbucket VARCHAR(500),
    url_personalizado VARCHAR(500),
    archivo_path VARCHAR(500),
    archivo_nombre VARCHAR(255),
    archivo_tamaño INT,
    descripcion TEXT,
    rama_produccion VARCHAR(100) DEFAULT 'main',
    estado ENUM('no_enviado', 'enviado', 'verificado', 'rechazado') DEFAULT 'no_enviado',
    verificado_por BIGINT,
    enviado_en TIMESTAMP,
    vencimiento_envio TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (equipo_id) REFERENCES equipos(id_equipo),
    FOREIGN KEY (evento_id) REFERENCES eventos(id_evento),
    FOREIGN KEY (verificado_por) REFERENCES usuarios(id)
)
```

#### 2. **juez_calificaciones_equipo**
```sql
CREATE TABLE juez_calificaciones_equipo (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    juez_id BIGINT NOT NULL,
    equipo_id BIGINT NOT NULL,
    evento_id BIGINT NOT NULL,
    puntaje_creatividad INT DEFAULT 5,
    puntaje_funcionalidad INT DEFAULT 5,
    puntaje_diseño INT DEFAULT 5,
    puntaje_presentacion INT DEFAULT 5,
    puntaje_documentacion INT DEFAULT 5,
    puntaje_final DECIMAL(3,2) DEFAULT 5.00,
    promedio_jueces DECIMAL(3,2),
    observaciones TEXT,
    recomendaciones TEXT,
    ganador BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY unique_juez_equipo_evento (juez_id, equipo_id, evento_id),
    FOREIGN KEY (juez_id) REFERENCES usuarios(id),
    FOREIGN KEY (equipo_id) REFERENCES equipos(id_equipo),
    FOREIGN KEY (evento_id) REFERENCES eventos(id_evento)
)
```

---

## 📦 Modelos

### Modelo: Repositorio
**Archivo**: `app/Models/Repositorio.php`

**Atributos**:
- `id`, `equipo_id`, `evento_id`
- `url_github`, `url_gitlab`, `url_bitbucket`, `url_personalizado`
- `archivo_path`, `archivo_nombre`, `archivo_tamaño`
- `descripcion`, `rama_produccion`, `estado`
- `verificado_por`, `enviado_en`, `vencimiento_envio`

**Relaciones**:
```php
- equipo()          → BelongsTo Equipo
- evento()          → BelongsTo Evento
- verificador()     → BelongsTo Usuario (verificado_por)
```

**Métodos**:
```php
estaEnviado()               // bool - Verifica si estado = 'enviado'
estaVerificado()            // bool - Verifica si estado = 'verificado'
obtenerUrl()                // string - Retorna URL más relevante
obtenerTipo()               // string - Identifica tipo de repositorio
marcarEnviado()             // void - Cambia estado a 'enviado'
marcarVerificado($usuarioId) // void - Marca como verificado
marcarRechazado()           // void - Cambia estado a 'rechazado'
```

---

### Modelo: CalificacionEquipo
**Archivo**: `app/Models/CalificacionEquipo.php`

**Atributos**:
- `id`, `juez_id`, `equipo_id`, `evento_id`
- `puntaje_creatividad`, `puntaje_funcionalidad`, `puntaje_diseño`
- `puntaje_presentacion`, `puntaje_documentacion`
- `puntaje_final` (auto-calculado)
- `promedio_jueces`, `observaciones`, `recomendaciones`
- `ganador` (boolean)

**Relaciones**:
```php
- juez()            → BelongsTo Usuario
- equipo()          → BelongsTo Equipo
- evento()          → BelongsTo Evento
```

**Métodos**:
```php
calcularPuntajeFinal()      // decimal - Promedio de 5 criterios
estaCompleta()              // bool - Verifica si todos puntajes > 0
obtenerColor()              // string - Color según desempeño
```

**Scopes**:
```php
delEvento($eventoId)        // Filtra por evento
delJuez($juezId)            // Filtra por juez
delEquipo($equipoId)        // Filtra por equipo
```

**Auto-Cálculo**:
- El `puntaje_final` se calcula automáticamente en el hook `boot()` como promedio de los 5 criterios
- Se actualiza automáticamente en cada guardado

---

### Modelos Existentes (Sin Cambios Destructivos)

#### Equipo - Nuevas Relaciones
```php
public function repositorio()
    return $this->hasOne(Repositorio::class, 'equipo_id');

public function calificaciones()
    return $this->hasMany(CalificacionEquipo::class, 'equipo_id');
```

#### Usuario - Nueva Relación
```php
public function calificacionesJuez()
    return $this->hasMany(CalificacionEquipo::class, 'juez_id');
```

#### Evento - Nuevas Relaciones
```php
public function repositorios()
    return $this->hasMany(Repositorio::class, 'evento_id');

public function calificaciones()
    return $this->hasMany(CalificacionEquipo::class, 'evento_id');
```

---

## 🎮 Controladores

### RepositorioController
**Archivo**: `app/Http/Controllers/RepositorioController.php`

**Métodos**:

1. **show(Equipo $equipo)**
   - Muestra formulario para líder del equipo
   - Carga o crea repositorio

2. **store(Request $request, Equipo $equipo)**
   - Guarda/actualiza repositorio
   - Valida URLs o archivo ZIP/RAR/7Z (máx 100MB)
   - Requiere al menos una URL o archivo

3. **descargar(Repositorio $repositorio)**
   - Descarga archivo del repositorio
   - Acceso: Admin o Líder del equipo

4. **destroy(Repositorio $repositorio)**
   - Elimina repositorio (solo Admin)
   - Elimina archivo del storage

5. **verificar(Repositorio $repositorio)**
   - Marca como verificado (solo Admin)
   - Registra usuario que verifica

6. **rechazar(Request $request, Repositorio $repositorio)**
   - Rechaza repositorio (solo Admin)
   - Permite agregar motivo

---

### CalificacionController
**Archivo**: `app/Http/Controllers/CalificacionController.php`

**Métodos**:

1. **show(Equipo $equipo)**
   - Muestra formulario de calificación para juez

2. **store(Request $request, Equipo $equipo)**
   - Guarda calificación (1-10 para cada criterio)
   - Cálculo automático de puntaje final

3. **update(Request $request, CalificacionEquipo $calificacion)**
   - Actualiza calificación existente

4. **destroy(CalificacionEquipo $calificacion)**
   - Elimina calificación (solo Admin)

5. **listar(Evento $evento)**
   - Lista todas las calificaciones del evento
   - Calcula promedios por equipo

6. **ranking(Evento $evento)**
   - Genera ranking ordenado por puntaje
   - Acceso: Admin o cuando evento finaliza

---

### ResultadoController
**Archivo**: `app/Http/Controllers/ResultadoController.php`

**Métodos**:

1. **index()**
   - Dashboard de resultados (Admin)
   - Muestra eventos con calificaciones

2. **show(Evento $evento)**
   - Resultados detallados de evento
   - Calcula desviación estándar

3. **marcarGanador(Request $request, Evento $evento)**
   - Marca equipo como ganador
   - Desactiva ganador anterior

4. **exportarPDF(Evento $evento)**
   - Exporta resultados a PDF (Admin)

5. **generarConstancia(Evento $evento)**
   - Genera constancia para ganador

6. **calcularDesviacion($puntajes)** (privado)
   - Calcula desviación estándar

---

## 🛣️ Rutas

### Rutas Públicas (Autenticadas)

```php
// Repositorios - Equipo Leader
GET     /equipos/{equipo}/repositorio           → repositorios.show
POST    /equipos/{equipo}/repositorio           → repositorios.store
POST    /repositorios/{repositorio}/descargar   → repositorios.descargar

// Calificaciones - Juez
GET     /equipos/{equipo}/calificar             → calificaciones.show
POST    /equipos/{equipo}/calificar             → calificaciones.store
POST    /calificaciones/{calificacion}          → calificaciones.update
GET     /eventos/{evento}/calificaciones        → calificaciones.listar
GET     /eventos/{evento}/ranking               → calificaciones.ranking
```

### Rutas Admin (`middleware: is.admin`)

```php
// Repositorios - Verificación
POST    /repositorios/{repositorio}/verificar   → repositorios.verificar
POST    /repositorios/{repositorio}/rechazar    → repositorios.rechazar
DELETE  /repositorios/{repositorio}             → repositorios.destroy

// Calificaciones - Gestión
DELETE  /calificaciones/{calificacion}          → calificaciones.destroy

// Resultados
GET     /admin/resultados                       → admin.resultados.index
GET     /admin/eventos/{evento}/resultados      → admin.resultados.show
POST    /admin/eventos/{evento}/marcar-ganador  → admin.resultados.marcar-ganador
GET     /admin/eventos/{evento}/exportar        → admin.resultados.exportar
GET     /admin/eventos/{evento}/constancia      → admin.resultados.constancia
```

---

## 🎨 Vistas

### Vista: repositorios.show
**Archivo**: `resources/views/repositorios/show.blade.php`

Formulario para que líder del equipo suba repositorio:
- Campos de URLs (GitHub, GitLab, Bitbucket, personalizado)
- Campo rama de producción
- Descripción del proyecto
- Subida de archivo ZIP/RAR/7Z (máx 100MB)
- Información del estado actual

---

### Vista: calificaciones.show
**Archivo**: `resources/views/calificaciones/show.blade.php`

Formulario interactivo para calificar:
- Sliders 1-10 para cada criterio
- Vista en tiempo real del promedio
- Campos para observaciones y recomendaciones
- Información del equipo a calificar

---

### Vista: calificaciones.listar
**Archivo**: `resources/views/calificaciones/listar.blade.php`

Tabla de todas las calificaciones:
- Datos de juez, equipo, puntajes
- Resumen por equipo
- Opciones admin para eliminar

---

### Vista: calificaciones.ranking
**Archivo**: `resources/views/calificaciones/ranking.blade.php`

Ranking visual del evento:
- Podio con Top 3 ganadores
- Tabla completa de ranking
- Estadísticas generales
- Opciones admin

---

### Vista: admin.resultados.index
**Archivo**: `resources/views/admin/resultados/index.blade.php`

Dashboard principal de resultados:
- Top 3 por evento
- Tabla resumen de cada evento
- Links a detalles

---

### Vista: admin.resultados.show
**Archivo**: `resources/views/admin/resultados/show.blade.php`

Detalles completos de evento:
- Estadísticas de resumen
- Ranking completo con opciones
- Tabla de calificaciones por juez
- Opciones para exportar y generar constancias

---

## 🔐 Validaciones y Permisos

### Repositorios
- **show/store**: Solo líder del equipo o admin
- **descargar**: Admin o líder del equipo
- **verificar/rechazar/destroy**: Solo admin

### Calificaciones
- **show/store**: Solo juez del evento
- **update**: Juez que creó o admin
- **destroy**: Solo admin
- **listar**: Juez del evento o admin
- **ranking**: Public si evento finalizado, else admin

### Resultados
- **index/show/marcar-ganador/exportar/constancia**: Solo admin

---

## 📝 Validaciones de Entrada

### Repositorio
```php
url_github          → URL válida (nullable)
url_gitlab          → URL válida (nullable)
url_bitbucket       → URL válida (nullable)
url_personalizado   → URL válida (nullable)
archivo             → ZIP/RAR/7Z, máx 100MB (nullable)
rama_produccion     → String, máx 100 (nullable)
descripcion         → String, máx 1000 (nullable)

Regla: Al menos una URL o archivo debe estar presente
```

### Calificación
```php
puntaje_creatividad     → Integer 1-10 (required)
puntaje_funcionalidad   → Integer 1-10 (required)
puntaje_diseño          → Integer 1-10 (required)
puntaje_presentacion    → Integer 1-10 (required)
puntaje_documentacion   → Integer 1-10 (required)
observaciones           → String máx 1000 (nullable)
recomendaciones         → String máx 1000 (nullable)
```

---

## 💾 Almacenamiento de Archivos

**Ubicación**: `storage/app/public/repositorios/`

**Acceso**: Via ruta `/storage/repositorios/...`

**Limpieza**: Los archivos anteriores se eliminan al actualizar o eliminar repositorio

---

## 🔄 Flujos de Trabajo

### Flujo: Subida de Repositorio
1. Líder del equipo accede a `/equipos/{id}/repositorio`
2. Completa formulario (URLs + descripción + archivo)
3. Sistema valida y guarda en BD
4. Estado: `no_enviado` → `enviado`
5. Admin puede verificar o rechazar
6. Estado final: `verificado` o `rechazado`

### Flujo: Calificación
1. Juez accede a `/equipos/{id}/calificar`
2. Completa 5 criterios (1-10)
3. Sistema calcula automáticamente puntaje final
4. Se guarda en BD
5. Promedio se calcula en ranking

### Flujo: Resultados
1. Admin accede a `/admin/resultados`
2. Ve dashboard con todos los eventos
3. Puede hacer click en evento para ver detalles
4. Puede marcar ganador
5. Puede exportar PDF o generar constancia

---

## ✅ Garantías de Integridad

### Sin Cambios Destructivos
- ✅ Todas las nuevas funcionalidades en tablas/modelos nuevos
- ✅ Relaciones añadidas a modelos existentes (no reemplazo)
- ✅ Métodos existentes sin modificación
- ✅ Rutas existentes sin cambios

### Validaciones Garantizadas
- ✅ Solo una calificación por juez-equipo-evento (UNIQUE constraint)
- ✅ Solo un repositorio por equipo-evento (UNIQUE constraint)
- ✅ Foreign keys validan referencias
- ✅ Auto-cálculo de puntajes
- ✅ Permisos granulares por rol

---

## 🚀 Próximos Pasos Opcionales

1. **Notificaciones**: Alertar a líderes cuando repo se rechaza
2. **Exportación**: Mejorar PDF con branding/firmas
3. **Constancias**: Diseño personalizado
4. **Métricas**: Dashboard con gráficas avanzadas
5. **API**: Endpoints REST para acceso programático

---

## 📊 Estadísticas del Proyecto

- **Tablas nuevas**: 2
- **Modelos nuevos**: 2
- **Controladores nuevos**: 3
- **Vistas nuevas**: 6
- **Rutas nuevas**: 15+
- **Métodos totales**: 30+
- **Líneas de código**: 1,500+

---

*Documentación generada el 2025-12-17*
*Sistema Enterprise v1.0 - Producción*
