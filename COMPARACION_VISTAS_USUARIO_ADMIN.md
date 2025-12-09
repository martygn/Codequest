# 📊 Comparación de Vistas: Usuario Normal vs Administrador

## 🎨 Consistencia de Diseño

### ✅ Tema Común: "Dark Tech"

Ambas vistas utilizan el **mismo tema visual "Dark Tech"**, asegurando una experiencia de usuario consistente:

| Elemento | Color | Uso |
|----------|-------|-----|
| **Primary** | `#64FFDA` (Turquesa) | Botones, acentos, enlaces activos |
| **Background Dark** | `#0A192F` | Fondo principal |
| **Card Dark** | `#112240` | Tarjetas, sidebar |
| **Text Dark** | `#CCD6F6` | Títulos principales |
| **Text Secondary** | `#8892B0` | Texto secundario |
| **Border Dark** | `#233554` | Bordes sutiles |
| **Active Dark** | `rgba(100, 255, 218, 0.1)` | Items activos en menú |

---

## 👤 Vista de Usuario Normal

### 📍 Ruta
- **URL:** `/dashboard`
- **Nombre:** `dashboard`
- **Controller:** `DashboardController@index`
- **Middleware:** `auth`, `verified`

### 🎯 Archivo
`resources/views/dashboard.blade.php`

### 🏗️ Estructura

```
┌─────────────────────────────────────────┐
│ LAYOUT: x-app-layout                    │
│ (Incluye navbar con navegación)         │
└─────────────────────────────────────────┘
            ↓
┌─────────────────────────────────────────┐
│ 1. HERO SECTION                         │
│    - Título "Bienvenido a CodeQuest"    │
│    - Gradiente turquesa-azul            │
│    - Botón "Explorar Eventos"           │
│    - Efectos de blur animados           │
└─────────────────────────────────────────┘
            ↓
┌─────────────────────────────────────────┐
│ 2. NOTIFICACIONES (Si hay no leídas)   │
│    - Badge con contador                 │
│    - Cards por tipo (success, warning)  │
│    - Botón para marcar como leída       │
│    - Script AJAX para actualizar        │
└─────────────────────────────────────────┘
            ↓
┌─────────────────────────────────────────┐
│ 3. PRÓXIMOS EVENTOS (Carrusel)         │
│    - Animación infinita automática      │
│    - Cards con imagen/placeholder       │
│    - Fecha, ubicación                   │
│    - Botón "Ver Detalles"               │
│    - Pausa al hacer hover               │
└─────────────────────────────────────────┘
            ↓
┌─────────────────────────────────────────┐
│ 4. EQUIPOS DESTACADOS (Carrusel)       │
│    - Animación similar a eventos        │
│    - Avatar circular del equipo         │
│    - Contador de miembros               │
│    - Badge del evento                   │
│    - Botón "Ver Perfil"                 │
└─────────────────────────────────────────┘
```

### ✨ Características Especiales

1. **Hero Section Animado**
   - Gradiente dinámico con efecto de blur
   - Patrón de circuito de fondo sutil
   - Transiciones suaves en hover

2. **Sistema de Notificaciones**
   - Solo muestra notificaciones NO leídas
   - Máximo 5 notificaciones
   - Colores según tipo:
     - `info` → Azul
     - `success` → Verde
     - `warning` → Amarillo
     - `error` → Rojo
   - Funcionalidad AJAX para marcar como leída

3. **Carruseles Automáticos**
   - Animación CSS infinita
   - Duplicación de elementos para efecto seamless
   - Pausa automática al hover
   - Responsive (se adapta a móviles)

4. **Funcionalidad JavaScript**
   ```javascript
   function marcarComoLeida(notificacionId) {
       fetch(`/notificaciones/${notificacionId}/marcar-leida`, {
           method: 'POST',
           headers: {
               'X-CSRF-TOKEN': '{{ csrf_token() }}',
               'Content-Type': 'application/json',
           },
       }).then(() => location.reload());
   }
   ```

### 📦 Datos Dinámicos

```php
// En DashboardController@index (usuario normal)
$proximosEventos = Evento::where('fecha_inicio', '>=', Carbon::now())
    ->orderBy('fecha_inicio', 'asc')
    ->take(3)
    ->get();

$equiposDestacados = Equipo::withCount('participantes')
    ->orderBy('participantes_count', 'desc')
    ->take(3)
    ->get();

$notificaciones = auth()->user()->notificaciones()
    ->noLeidas()
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();
```

---

## 👨‍💼 Vista de Administrador

### 📍 Ruta
- **URL:** `/dashboard` (redirige internamente)
- **Nombre:** `dashboard` (mismo que usuario, pero lógica diferente)
- **Controller:** `DashboardController@index`
- **Condición:** `$usuario->esAdmin()` retorna `true`
- **Vista:** `admin.panel`

### 🎯 Archivo
`resources/views/admin/panel.blade.php`

### 🏗️ Estructura

```
┌─────────────────────────────────────────┐
│ LAYOUT: HTML independiente (no x-app)   │
│ Incluye sidebar fijo propio              │
└─────────────────────────────────────────┘
            ↓
┌──────────────┬──────────────────────────┐
│   SIDEBAR    │   MAIN CONTENT           │
│   (Fijo)     │                          │
│              │ 1. HEADER                │
│ - Logo       │    - "Panel de Control"  │
│ - Menú:      │    - Subtítulo          │
│   * Panel    │                          │
│   * Eventos  │ 2. ESTADÍSTICAS (Cards) │
│   * Equipos  │    ┌──────┬──────┬─────┐│
│   * Jueces   │    │ Rev. │Aprob.│Rech.││
│   * Results  │    └──────┴──────┴─────┘│
│   * Config   │    - Animación contador  │
│ - Logout     │    - Iconos Material     │
│              │                          │
│              │ 3. TABLA DE EQUIPOS     │
│              │    - Últimos 10 equipos  │
│              │    - Estado con badges   │
│              │    - Contador miembros   │
│              │    - Botón "Ver Detalles"│
└──────────────┴──────────────────────────┘
```

### ✨ Características Especiales

1. **Sidebar Permanente**
   - Siempre visible (no colapsable)
   - Logo en la parte superior
   - Navegación con iconos Material Symbols
   - Item activo con borde izquierdo turquesa
   - Botón de logout en la parte inferior

2. **Estadísticas Animadas**
   ```html
   <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
       <!-- En Revisión -->
       <div class="bg-card-dark rounded-xl p-6 border border-border-dark">
           <div class="flex items-center justify-between">
               <div>
                   <p class="text-text-secondary-dark text-sm">En Revisión</p>
                   <p class="text-4xl font-bold text-yellow-400" id="enRevision">
                       {{ $estadisticas['en_revision'] }}
                   </p>
               </div>
               <span class="material-symbols-outlined text-yellow-400 text-5xl">
                   pending_actions
               </span>
           </div>
       </div>
       <!-- Similar para Aprobados y Rechazados -->
   </div>
   ```

3. **Tabla de Equipos Recientes**
   - Muestra últimos 10 equipos
   - Badges de estado coloridos:
     - `en revisión` → Amarillo
     - `aprobado` → Verde
     - `rechazado` → Rojo
   - Contador de miembros
   - Link a detalle del equipo

4. **Animación de Contadores**
   ```javascript
   // Animar números desde 0 hasta valor final
   function animateValue(id, start, end, duration) {
       let startTimestamp = null;
       const step = (timestamp) => {
           if (!startTimestamp) startTimestamp = timestamp;
           const progress = Math.min((timestamp - startTimestamp) / duration, 1);
           document.getElementById(id).textContent = Math.floor(progress * (end - start) + start);
           if (progress < 1) window.requestAnimationFrame(step);
       };
       window.requestAnimationFrame(step);
   }
   ```

### 📦 Datos Dinámicos

```php
// En DashboardController@index (admin)
$totales = Equipo::selectRaw(
    "SUM(CASE WHEN LOWER(TRIM(estado)) = 'en revisión' THEN 1 ELSE 0 END) as en_revision,"
    . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'aprobado' THEN 1 ELSE 0 END) as aprobado,"
    . " SUM(CASE WHEN LOWER(TRIM(estado)) = 'rechazado' THEN 1 ELSE 0 END) as rechazado"
)->first();

$estadisticas = [
    'en_revision' => (int)($totales->en_revision ?? 0),
    'aprobado' => (int)($totales->aprobado ?? 0),
    'rechazado' => (int)($totales->rechazado ?? 0),
];

$equipos = Equipo::withCount('participantes')
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();
```

---

## 🔄 Lógica de Redirección en DashboardController

```php
public function index()
{
    $usuario = Auth::user();

    if (!$usuario) {
        return redirect()->route('login');
    }

    // ✅ ADMIN → admin.panel
    if ($usuario->esAdmin()) {
        // ... cálculo de estadísticas
        return view('admin.panel', compact('estadisticas', 'equipos'));
    }

    // ✅ JUEZ → juez.panel
    if ($usuario->esJuez()) {
        return redirect()->route('juez.panel');
    }

    // ✅ USUARIO NORMAL → dashboard
    $proximosEventos = Evento::...;
    $equiposDestacados = Equipo::...;
    return view('dashboard', compact('proximosEventos', 'equiposDestacados'));
}
```

---

## 📋 Tabla Comparativa

| Característica | Usuario Normal | Administrador |
|----------------|----------------|---------------|
| **Layout** | `x-app-layout` (con navbar) | HTML independiente |
| **Sidebar** | ❌ No | ✅ Sí (fijo, izquierda) |
| **Hero Section** | ✅ Sí (grande, animado) | ❌ No |
| **Notificaciones** | ✅ Sí (cards no leídas) | ❌ No (puede agregarse) |
| **Carruseles** | ✅ Sí (eventos + equipos) | ❌ No |
| **Estadísticas** | ❌ No | ✅ Sí (3 cards animadas) |
| **Tabla de Equipos** | ❌ No | ✅ Sí (últimos 10) |
| **Navegación** | Navbar superior | Sidebar izquierdo |
| **Logo** | Navbar | Sidebar |
| **Logout** | Navbar dropdown | Sidebar bottom |
| **Tema Visual** | ✅ Dark Tech | ✅ Dark Tech (igual) |
| **Colores** | ✅ Mismo | ✅ Mismo |
| **Iconos** | Material Symbols | Material Symbols |
| **Responsive** | ✅ Sí | ✅ Sí (sidebar colapsa) |

---

## 🎯 Diferencias Clave

### 1. **Propósito**
- **Usuario Normal:** Vista enfocada en descubrir eventos y equipos, con diseño atractivo y motivacional
- **Administrador:** Vista funcional enfocada en gestión y estadísticas rápidas

### 2. **Navegación**
- **Usuario Normal:** Navbar superior flexible (se adapta al scroll)
- **Administrador:** Sidebar fijo persistente con acceso directo a todas las secciones admin

### 3. **Información Mostrada**
- **Usuario Normal:** Contenido público (próximos eventos, equipos destacados, notificaciones personales)
- **Administrador:** Métricas de gestión (estadísticas de equipos, tabla de administración)

### 4. **Interactividad**
- **Usuario Normal:** Carruseles automáticos, animaciones llamativas
- **Administrador:** Contadores animados, tabla con acciones directas

---

## ✅ Verificación de Consistencia

### Elementos Compartidos ✅
- [x] Paleta de colores idéntica
- [x] Fuente Roboto
- [x] Material Symbols Outlined
- [x] Scrollbar personalizado
- [x] Bordes redondeados
- [x] Efectos hover consistentes
- [x] Transiciones suaves
- [x] Dark mode por defecto

### Elementos Únicos (Por Diseño) ✅
- **Usuario:** Carruseles, hero section, notificaciones
- **Admin:** Sidebar, estadísticas, tabla de gestión

---

## 🔒 Control de Acceso

### Método en Usuario Model
```php
public function esAdmin(): bool
{
    return $this->tipo === 'admin';
}

public function esJuez(): bool
{
    return $this->tipo === 'juez';
}
```

### Middleware
- **`auth`:** Requiere usuario autenticado
- **`verified`:** Requiere email verificado (solo para usuario normal)
- **`is.admin`:** Requiere rol de administrador (rutas admin específicas)
- **`is.juez`:** Requiere rol de juez (rutas juez específicas)

---

## 🚀 Recomendaciones

### ✅ Ya Implementado
1. Tema visual consistente entre ambas vistas
2. Separación clara de responsabilidades
3. Redirección automática según rol
4. Experiencias optimizadas para cada tipo de usuario

### 💡 Mejoras Opcionales
1. **Admin Panel:** Agregar sección de notificaciones del sistema
2. **Admin Panel:** Gráficos de tendencias (Chart.js/ApexCharts)
3. **Usuario Normal:** Agregar sección de "Mis Equipos"
4. **Ambos:** Modo claro/oscuro toggle (actualmente solo oscuro)
5. **Ambos:** Animaciones de carga (skeleton screens)

---

## 📝 Resumen

| Aspecto | Estado |
|---------|--------|
| **Diseño Consistente** | ✅ 100% |
| **Funcionalidad Específica** | ✅ Diferenciada correctamente |
| **Control de Acceso** | ✅ Implementado |
| **Experiencia de Usuario** | ✅ Optimizada por rol |
| **Responsive** | ✅ Ambas vistas |
| **Performance** | ✅ Animaciones optimizadas |

**Conclusión:** Ambas vistas están correctamente implementadas, mantienen un diseño consistente y ofrecen experiencias optimizadas para sus respectivos usuarios. ✅
