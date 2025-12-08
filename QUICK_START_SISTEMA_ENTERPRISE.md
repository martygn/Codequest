# ⚡ Quick Start - Sistema de Calificaciones y Repositorios

## 🎯 ¿Qué fue implementado?

Un sistema **Enterprise completo** de 3 componentes sin modificar código existente:

1. **📦 Repositorios** - Equipos suben código (GitHub/GitLab/archivos)
2. **⭐ Calificaciones** - Jueces califican 5 criterios (1-10)
3. **🏆 Resultados** - Admin ve ranking y elige ganador

---

## 🚀 Para Empezar (Roles)

### 👥 Líder del Equipo

**Subir repositorio:**
```
1. Ve a "Mi Equipo" 
2. Click "📦 Gestionar Repositorio"
3. Completa URLs o sube ZIP (máx 100MB)
4. Click "Enviar"
5. Espera a que admin verifique
```

**URLs soportadas:**
- GitHub: `https://github.com/usuario/proyecto`
- GitLab: `https://gitlab.com/usuario/proyecto`
- Bitbucket: `https://bitbucket.org/usuario/proyecto`
- Personalizado: Cualquier URL

---

### 👨‍⚖️ Juez

**Calificar equipo:**
```
1. Accede a evento donde eres juez
2. Click "⭐ Calificar Equipo"
3. Mueve sliders (1-10) para cada criterio:
   - 🎨 Creatividad
   - ⚙️ Funcionalidad
   - 🎯 Diseño
   - 🎤 Presentación
   - 📚 Documentación
4. Agrega observaciones (opcional)
5. Click "Enviar Calificación"
```

**Verá:**
- Promedio en tiempo real mientras califica
- Historial de sus calificaciones
- Ranking público si evento finalizó

---

### 🔧 Admin

**Verificar repositorios:**
```
1. Va a "Admin" > "Eventos"
2. Selecciona evento
3. Ve repositorios pendientes
4. ✅ Verifica o ❌ Rechaza
```

**Ver resultados:**
```
1. Va a "Admin" > "Resultados"
2. Ve dashboard con todos eventos
3. Click en evento para detalles
4. Ve tabla completa con jueces
```

**Marcar ganador:**
```
1. En detalles evento
2. Click "Seleccionar Ganador" para un equipo
3. Genera constancia
4. Exporta a PDF
```

---

## 📊 Datos Nuevos en BD

### Tabla: `repositorios`
- Qué sube el equipo (URLs + archivo)
- Estado: no_enviado → enviado → verificado
- Acceso: Equipo líder + Admin

### Tabla: `juez_calificaciones_equipo`
- Puntuaciones de cada juez
- Promedio automático
- Una por juez-equipo-evento

---

## 🔗 Rutas Principales

**Para Equipos:**
```
GET  /equipos/{id}/repositorio          Subir código
```

**Para Jueces:**
```
GET  /equipos/{id}/calificar            Calificar equipo
GET  /eventos/{id}/ranking              Ver ranking
```

**Para Admin:**
```
GET  /admin/resultados                  Dashboard resultados
GET  /admin/eventos/{id}/resultados     Detalles evento
POST /admin/eventos/{id}/marcar-ganador Elegir ganador
```

---

## ⚙️ Criterios de Calificación

| Criterio | Escala | Descripción |
|----------|--------|-------------|
| 🎨 Creatividad | 1-10 | ¿Qué tan innovador? |
| ⚙️ Funcionalidad | 1-10 | ¿Cumple requisitos? |
| 🎯 Diseño | 1-10 | ¿UX/UI de calidad? |
| 🎤 Presentación | 1-10 | ¿Presentación clara? |
| 📚 Documentación | 1-10 | ¿Bien documentado? |

**Cálculo:** Promedio de 5 = Puntaje Final (0.00 - 10.00)

---

## 📁 Archivos Soportados

Para subida de archivo:
- ✅ ZIP
- ✅ RAR
- ✅ 7Z
- ❌ Máximo 100MB

---

## 🔒 Seguridad

- Solo líder puede subir repositorio
- Solo juez asignado puede calificar
- Solo admin puede verificar/rechazar
- Una sola calificación por juez-equipo-evento
- Validaciones en servidor

---

## 📱 Interfaz

### Colores por Criterio
- 🎨 Creatividad: **Azul**
- ⚙️ Funcionalidad: **Verde**
- 🎯 Diseño: **Púrpura**
- 🎤 Presentación: **Naranja**
- 📚 Documentación: **Rojo**

### Podio de Ganadores
- 🥇 1er lugar: **Dorado**
- 🥈 2do lugar: **Plateado**
- 🥉 3er lugar: **Bronce**

---

## 🐛 Troubleshooting

**Q: ¿No veo opción de subir repositorio?**
A: Debes ser líder del equipo e inscrito en un evento

**Q: ¿No puedo calificar?**
A: Debes ser juez asignado al evento

**Q: ¿Por qué se calcula automático mi puntaje?**
A: Sistema promedia los 5 criterios automáticamente

**Q: ¿Se puede cambiar calificación?**
A: Sí, los jueces pueden editar. Admin puede eliminar.

**Q: ¿Se pueden descargar repositorios?**
A: Sí, admin y líder del equipo pueden hacerlo

---

## 📞 Soporte

Si hay issues:
1. Revisa que tengas el rol correcto
2. Verifica permisos en BD
3. Revisa logs en `storage/logs/laravel.log`

---

**Sistema Enterprise v1.0**
*Implementado: 17/12/2025*
