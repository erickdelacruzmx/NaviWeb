# 🧪 INSTRUCCIONES PARA PROBAR NAVI CON VOZ AHORA MISMO

**Tu API Key ya está configurada ✅**

Sigue estos pasos para ver NAVI en acción:

---

## 🚀 PRUEBA INMEDIATA (2 minutos)

### Paso 1: Abre NAVI
```
URL: http://localhost/NaviWeb/app.php
```

### Paso 2: Cambia a Modo "Navicito"
- Arriba verás dos botones: "Tutor" y "Navicito"
- **Click en "Navicito"** (azul)

### Paso 3: Verás los botones de voz
```
[🎤 Hablar]  [🔊 Vol...]  [Input de texto]
```

---

## 📝 PRUEBA 1: Chat por Texto

```
1. En el input de texto, escribe: "Hola Navi"
2. Presiona: ENTER
3. ✓ Deberías oír un audio por altavoz

¿Qué pasará?
- Navi procesa: "Hola Navi"
- Gemini genera: "¡Hola amiguito! ¿En qué puedo ayudarte?"
- Síntesis: Convierte a voz
- Audio: Sale por altavoz
- Avatar: Se anima mientras habla
```

---

## 🎤 PRUEBA 2: Chat por Voz (Micrófono)

```
1. Click en: [🎤 Hablar]
2. Popup del navegador: "¿Permitir acceso a micrófono?"
   → Click: "Permitir"
3. Verás: "Escuchando..." (pulsante)
4. Habla al micrófono: "¿Cuéntame un chiste?"
5. Espera a que transcribe
6. ✓ Automáticamente enviará a Navi
7. ✓ Escucharás respuesta por voz
```

---

## 🔊 PRUEBA 3: Control de Volumen

```
1. Haz clic en [🎤 Hablar]
2. Habla: "Hola"
3. Mientras Navi responde, desliza el volumen
4. ✓ Verás que el volumen cambia
```

---

## ⏹️ PRUEBA 4: Detener Audio

```
1. Durante la respuesta de Navi:
2. Click en: [🔊 Stop] (botón púrpura, si aparece)
3. ✓ Se detiene inmediatamente
```

---

## ✨ RESULTADO ESPERADO

Después de cada prueba deberías:

- ✅ Oír sonido por altavoz/headphones
- ✅ Ver el avatar pulsando/animándose
- ✅ Ver el historial de mensajes
- ✅ Poder interactuar nuevamente

---

## ❌ SI ALGO FALLA

### No escucho nada (sin audio)
```
1. Verifica volumen del sistema (no esté mudo)
2. Usa Chrome o Edge
3. Abre F12 → Console (busca errores)
4. Reinicia navegador (Ctrl+R)
```

### No aparecen botones de voz
```
1. Haz refresh completo: Ctrl+Shift+R (hard refresh)
2. Borra caché: F12 → Network → Clear
3. Cierra navegador y reabre
4. Verifica consola (F12) por errores
```

### Navi no responde
```
1. F12 → Console (busca "Error")
2. F12 → Network (ve si /api/navi-chat.php responde)
3. Verifica que config_gemini_local.php existe:
   c:\xampp\htdocs\NaviWeb\config\config_gemini_local.php
4. Lee: FASE_2A_ACTIVACION_VOZ.md → Solución de Problemas
```

### No me permite hablar (micrófono no funciona)
```
1. Usa Chrome o Edge (Firefox limitado)
2. Da permisos de micrófono cuando pida
3. Habla más fuerte
4. Sin ruido de fondo
5. Prueba en otra pestaña del navegador
```

---

## 🎯 CASOS DE USO PARA PROBAR

### Para aprender:
```
Pregunta: "¿Cuál es la capital de Francia?"
Respuesta esperada: "La capital de Francia es París"
```

### Para diversión:
```
Pregunta: "¿Puedes contar un chiste?"
Respuesta esperada: [Chiste aleatorio]
```

### Para conversación:
```
Pregunta: "¿Cuál es tu nombre?"
Respuesta: "Soy Navi, tu asistente de aprendizaje"
Pregunta: "¿Cuál es mi nombre?"
Respuesta: "[Tu nombre del perfil]"
```

### Para educación:
```
Pregunta: "Explícame qué es la fotosíntesis"
Respuesta esperada: [Explicación clara y lenta]
```

---

## 📊 INFORMACIÓN TÉCNICA

### API Key:
- ✅ Guardada en: `config/config_gemini_local.php`
- ✅ Protegida en: `.gitignore` (no se sube a GitHub)
- ✅ Estado: ACTIVA y FUNCIONAL

### Tecnologías:
- ✅ Web Speech Recognition (micrófono)
- ✅ Google Gemini API (IA)
- ✅ Web Speech Synthesis (altavoz)
- ✅ Vue 3 (frontend)
- ✅ PHP (backend)

### Límites:
- 60 solicitudes por minuto (gratis)
- Respuestas de máximo 150 tokens
- Historial de 10 últimos mensajes

---

## 📞 DOCUMENTACIÓN

Si necesitas ayuda:

1. **Rápido:** [`VERIFICACION_API_KEY.md`](VERIFICACION_API_KEY.md)
   - Checklist de verificación

2. **Completo:** [`FASE_2A_ACTIVACION_VOZ.md`](FASE_2A_ACTIVACION_VOZ.md)
   - Sección "Solución de Problemas"

3. **Técnico:** [`FASE_2A_RESUMEN_TECNICO.md`](FASE_2A_RESUMEN_TECNICO.md)
   - Detalles de implementación

4. **Todo:** [`INDICE_COMPLETO.md`](INDICE_COMPLETO.md)
   - Navegación maestra

---

## 🎉 ¡DISFRUTA NAVI!

Ahora tienes un asistente de IA completamente operacional con:
- 🎤 Entrada de voz
- 🔊 Salida de voz
- 🤖 Inteligencia artificial
- ♿ Accesibilidad total

---

**Fecha:** 4 de diciembre de 2025  
**Estado:** ✅ LISTO PARA USAR  
**Tiempo de prueba:** ~5 minutos
