# 🚀 NAVI INTERACTIVO - FASE 1: LISTA PARA ACTIVAR

## ¡Tu implementación de Fase 1 está lista! ✅

Todo el código de backend, frontend y configuración está implementado y committeado.

---

## 📋 Lo que debes hacer ahora (3 pasos)

### Paso 1: Obtener API Key Gratis (2 minutos)

1. Ve a: **https://ai.google.dev/**
2. Haz clic en **"Get API Key"**
3. Inicia sesión con tu cuenta Google
4. Haz clic en **"Create API key"**
5. **COPIA** la clave (empieza con "AIza...")
6. Guárdala en un lugar seguro

### Paso 2: Configurar Localmente (1 minuto)

En PowerShell desde `c:\xampp\htdocs\NaviWeb`:

```powershell
# Copiar archivo de ejemplo
Copy-Item config/config_gemini_local.example.php config/config_gemini_local.php

# Editar el archivo (abre con tu editor)
notepad config/config_gemini_local.php
```

Reemplaza esto:
```php
define('GEMINI_API_KEY', 'PEGA_TU_API_KEY_AQUI');
```

Con tu API key real:
```php
define('GEMINI_API_KEY', 'AIzaSyDxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
```

Guarda (Ctrl+S) y cierra.

### Paso 3: Probar en Navegador (1 minuto)

1. Abre en navegador: `http://localhost/NaviWeb/views/app.php`
2. Inicia sesión (usa cualquier credencial de prueba)
3. Verás la pantalla de NAVI con dos botones: "Tutor" y "Navicito"
4. **Haz clic en "Navicito"**
5. Deberías ver:
   - Avatar azul de NAVI (círculo grande)
   - Mensaje: "Hola, ¿en qué puedo ayudarte hoy?"
   - **Input de texto** con placeholder "Pregunta a Navi..."
   - Botón para enviar

6. **Prueba escribiendo:**
   ```
   Pregunta: "Hola Navi, ¿cómo estás?"
   Presiona Enter
   
   Navi debería responder algo como:
   "¡Hola amiguito! Estoy aquí para ayudarte. ¿En qué te puedo ayudar hoy?"
   ```

---

## 🎯 Qué Debería Pasar

```
┌─────────────────────────────────────────┐
│  AVATAR NAVI (círculo azul grande)      │
│                                         │
│  "¡Hola amiguito! Estoy aquí para..."  │
│                                         │
│  ┌─────────────────────────────────┐   │
│  │ Pregunta a Navi...             │ ▶  │
│  └─────────────────────────────────┘   │
│                                         │
│  Historial:                            │
│  Tú: Hola                              │
│  Navi: ¡Hola! ¿Cómo estás?             │
└─────────────────────────────────────────┘
```

---

## 🧪 Tests Rápidos

### Test 1: Conversación Básica
```
Tú: Hola Navi
Navi: ¡Hola! Estoy aquí para ayudarte...
✅ Funciona si Navi responde
```

### Test 2: Conversación con Contexto
```
Tú: Mi nombre es Juan
Navi: ¡Encantado de conocerte, Juan!

Tú: ¿Recuerdas mi nombre?
Navi: ¡Por supuesto! Tu nombre es Juan...
✅ Funciona si Navi recuerda el nombre
```

### Test 3: Tareas Educativas
```
Tú: Cuéntame una historia corta
Navi: Érase una vez un gatito...
✅ Funciona si Navi cuenta una historia
```

### Test 4: Cambio de Modo
```
Click en botón "Tutor"
→ Deberías ver la interfaz completa (Juegos, Biblioteca, etc)
→ Avatar desaparece del centro

Click en "Navicito"
→ Avatar vuelve a aparecer con input de chat
✅ Funciona si puedes cambiar de modo
```

---

## 🆘 Si Algo No Funciona

### El input no aparece
- ✅ ¿Estás en modo "Navicito"? (click en botón Navicito)
- ✅ ¿Está la sesión activa? (¿Iniciaste sesión?)

### Navi no responde (error "No pude procesar tu mensaje")
- ✅ ¿Creaste el archivo `config/config_gemini_local.php`?
- ✅ ¿Copiaste la API key correctamente (sin comillas extra)?
- ✅ ¿La API key comienza con "AIza"?
- ✅ Abre F12 → Console y busca mensajes de error

### Error "Servicio de IA no disponible"
- ✅ El archivo de configuración no existe
- ✅ Sigue el **Paso 2** nuevamente

### Límite de requests alcanzado
- ✅ Espera 1 minuto (límite free tier: 60 req/min)
- ✅ O crea una nueva API key en Google

---

## 📚 Documentación Disponible

En el repositorio encontrarás:

1. **`FASE_1_GUIA_TESTING.md`** - Setup detallado + debugging
2. **`FASE_1_RESUMEN.md`** - Resumen técnico completo
3. **`PROPUESTA_NAVI_INTERACTIVO_GEMINI.md`** - Arquitectura y diseño
4. **`api/navi-chat.php`** - Código backend comentado

---

## 🔐 Seguridad

✅ Tu API key **NO se subió a Git**
- El archivo `config/config_gemini_local.php` está en `.gitignore`
- Solo existe localmente en tu máquina
- Nadie más puede verla

---

## 🎉 ¡Listo!

Sigue los 3 pasos arriba y NAVI comenzará a interactuar con los usuarios de verdad usando Gemini AI. 

**Tiempo total:** ~5 minutos

**Resultado:** Avatar educativo interactivo para niños con discapacidad visual

---

## 🚀 Próximas Fases

Cuando termines de probar Fase 1:

- **Fase 2:** Guardar historial en BD + Modal para tutores
- **Fase 3:** Síntesis de voz + Reconocimiento de voz

---

**¿Preguntas o problemas?**
- Revisa `FASE_1_GUIA_TESTING.md` sección "Debugging"
- Abre la consola del navegador (F12) para ver errores
- Revisa logs de Apache: `C:\xampp\apache\logs\error.log`

---

**¡A disfrutar de NAVI interactivo! 🎈**
