# 🚀 Guía Completa: Activar NAVI con Voz + Gemini

**Estado:** ✅ Fase 2A (Voz) implementada ✅ Fase 1 (Chat Gemini) lista para activar

---

## 📋 Paso 1: Obtener API Key de Google Gemini (5 minutos)

### ¿Qué es una API Key?
Es una contraseña única que permite que tu app use Gemini. **NO LA COMPARTAS.**

### Pasos:

1. **Ve a:** https://ai.google.dev/
   - Verás una página de Google AI Studio

2. **Haz clic en:** `Get API Key` (botón azul en la esquina superior derecha)
   - O directamente: https://ai.google.dev/tutorials/setup

3. **Google te pedirá:**
   - ✅ Aceptar términos
   - ✅ Crear un proyecto (puedes llamarlo "NaviWeb" o similar)

4. **Copia tu API Key:**
   ```
   AIza...xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  (será algo así)
   ```

5. **Guárdala en un lugar seguro** (Bloc de notas, 1Password, etc.)
   - ⚠️ **NO la compartas en Internet**
   - ⚠️ **NO la subas a GitHub**

---

## 📁 Paso 2: Crear Archivo de Configuración Local

### En Windows (PowerShell):

```powershell
# Navega a tu carpeta del proyecto
cd c:\xampp\htdocs\NaviWeb

# Crea la carpeta config si no existe
mkdir -Force config

# Crea el archivo con tu API key
# Opción A: Usando un editor de texto
notepad config/config_gemini_local.php
```

### Contenido a agregar (copia y pega):

```php
<?php
// config_gemini_local.php
// ⚠️ Este archivo NO debe subirse a GitHub (está en .gitignore)

return [
    'GEMINI_API_KEY' => 'TU_API_KEY_AQUI',  // Reemplaza con tu API key
];

// Ejemplo real:
// return [
//     'GEMINI_API_KEY' => 'AIzaSyDxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
// ];
```

### Pasos:
1. Abre el archivo `config/config_gemini_local.php` (que se creará vacío)
2. Pega el contenido anterior
3. **Reemplaza** `TU_API_KEY_AQUI` con tu API key real
4. **Guarda** el archivo (Ctrl+S)

---

## 🎙️ Paso 3: Verificar que Funciona

### En el navegador:

1. **Abre:** http://localhost/NaviWeb/app.php (o tu URL de app)

2. **En modo "Navicito":**
   - Deberías ver 5 botones nuevos:
     - 🎤 **Hablar** (micrófono - rojo)
     - ⏹️ **Stop** (si está escuchando - naranja)
     - 🔊 **Stop audio** (si Navi está hablando - púrpura)
     - 🔊 **Volumen** (deslizador de control)
     - 📝 Input de texto (fallback)

3. **Prueba 1 - Chat por Texto:**
   - Escribe: "Hola Navi, cuéntame un chiste"
   - Presiona Enter o haz clic en Enviar
   - **Deberías escuchar:** Navi responder por altavoz
   - **Y deberías ver:** El avatar animarse

4. **Prueba 2 - Chat por Voz:**
   - Haz clic en 🎤 **Hablar**
   - **Permite el acceso a micrófono** cuando el navegador lo pida
   - Habla: "¿Qué es un gato?"
   - Espera a que se transcribe automáticamente
   - **Automáticamente** se enviará a Navi
   - **Escucharás:** La respuesta por voz

5. **Prueba 3 - Controlar Volumen:**
   - Desliza el volumen
   - Habla de nuevo
   - **Deberías notar** cambio en el volumen de Navi

---

## 🔧 Solución de Problemas

### ❌ "Tu navegador no soporta voz"
**Solución:** Usa Chrome, Edge o Safari (Firefox tiene soporte limitado)

### ❌ "Error de voz: no-speech"
**Significado:** Navi no escuchó bien tu voz
**Solución:**
- Habla más fuerte
- Acércate al micrófono
- Elimina ruido de fondo
- Intenta de nuevo

### ❌ "Error de voz: network"
**Significado:** Sin conexión a Internet (para Google Cloud)
**Solución:** Verifica tu Internet

### ❌ "No pude procesar tu mensaje"
**Significado:** API key inválida o no encontrada
**Solución:**
1. Verifica que `config_gemini_local.php` existe
2. Verifica que contiene tu API key correcta
3. Reinicia el navegador
4. Vacía caché (Ctrl+Shift+Del)

### ❌ "Navi no habla (sin audio)"
**Significado:** Síntesis de voz deshabilitada en navegador
**Solución:**
1. Verifica que tu navegador permite audio
2. Comprueba que el volumen del sistema no está mudo
3. Prueba en otra pestaña

### ❌ "No se envía el mensaje"
**Significado:** Falta API key de Gemini
**Solución:**
1. Asegúrate de crear `config_gemini_local.php`
2. Asegúrate de poner tu API key
3. Si aún no funciona, revisa la consola (F12 → Console)

---

## 📊 Verificar Configuración (Opcional)

### En Windows PowerShell:

```powershell
# Verifica que el archivo existe
Test-Path "c:\xampp\htdocs\NaviWeb\config\config_gemini_local.php"
# Debería devolver: True

# Ver contenido del archivo (sin mostrar API key)
Get-Content "c:\xampp\htdocs\NaviWeb\config\config_gemini_local.php" | Select-String "GEMINI" -not
```

---

## 🎯 Checklist de Activación

- [ ] Obtuve API key de https://ai.google.dev/
- [ ] Creé carpeta `config/`
- [ ] Creé archivo `config/config_gemini_local.php`
- [ ] Agregué mi API key al archivo
- [ ] Guardé el archivo
- [ ] Abrí app.php en navegador
- [ ] Vi los botones de voz (🎤, 🔊, etc.)
- [ ] Probé escribir un mensaje → Navi respondió por voz
- [ ] Probé hablar al micrófono → Navi escuchó y respondió

---

## 🚀 Así Funciona Ahora (Fase 2A Completa)

```
USUARIO CIEGO              NAVI (TU APP)                    GEMINI (IA)
┌─────────────┐           ┌──────────────┐              ┌──────────────┐
│             │           │              │              │              │
│ "Hola Navi" │──Text──→  │ Web Speech   │─Text Input→  │ Gemini API   │
│ (habla)     │           │ Recognition  │              │              │
│             │           │              │              │ Procesa y    │
│ ←────────── │ ←─Voice─  │ Web Speech   │ ←─Response─ │ genera texto │
│ Escucha:    │ Audio     │ Synthesis    │              │              │
│ "¡Hola      │           │              │              │              │
│  amiguito!" │           │              │              │              │
└─────────────┘           └──────────────┘              └──────────────┘
```

---

## ✨ Características Implementadas - Fase 2A

### ✅ Entrada de Voz (Web Speech API)
- [x] Reconocimiento de voz en español
- [x] Botón "Hablar" (🎤 rojo)
- [x] Indicador "Escuchando..." (pulsante)
- [x] Transcripción en tiempo real
- [x] Envío automático al reconocer

### ✅ Salida de Voz (Web Speech Synthesis)
- [x] Síntesis de voz natural
- [x] Voz en español
- [x] Control de volumen (deslizador)
- [x] Control de velocidad (0.9x = más lento, más claro)
- [x] Control de pitch (altura de voz)
- [x] Animación del avatar mientras "habla"

### ✅ Interfaz
- [x] Botones intuitivos
- [x] Indicadores visuales
- [x] Fallback a texto si falla voz
- [x] Mensajes de error claros
- [x] Historial de conversación

### ✅ Accesibilidad
- [x] Atributos ARIA (aria-label, aria-busy)
- [x] Controles claramente etiquetados
- [x] Diseño responsivo (móvil + escritorio)
- [x] Compatible con lectores de pantalla

---

## 🔄 Próximas Fases (Opcionales)

### Fase 2B: Mejoras UI
- Indicador visual de frecuencia de sonido
- Animación de onda sonora
- Selección de voces (múltiples voces)
- Pausa/reanuda audio

### Fase 3: Google Cloud Premium (Pago)
- Upgrade a Google Cloud Speech-to-Text (más preciso)
- Upgrade a Google Cloud Text-to-Speech (voces naturales WaveNet)
- Mejor precisión para acentos diversos

---

## 📞 Soporte

Si tienes problemas:

1. **Abre la consola** (F12 → Console tab)
2. **Copia los errores** que ves en rojo
3. **Revisa el archivo** `config_gemini_local.php`:
   - ¿Existe?
   - ¿Tiene tu API key?
   - ¿Está bien escrito?

---

## 🎉 ¡Listo!

Ahora tienes NAVI completamente operacional con:
- ✅ Chat con Gemini (Fase 1)
- ✅ Entrada de voz (micrófono)
- ✅ Salida de voz (altavoz)
- ✅ Avatar animado
- ✅ Completamente accesible para niños ciegos

**Fecha de implementación:** 4 de diciembre de 2025  
**Commits incluidos:** 1f56f57 (Fase 2A) + anteriores (Fase 1)

¡Que disfruten NAVI! 🎙️🎯
