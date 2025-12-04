# 🎙️ NAVI con VOZ: Propuesta Fase 2+

## 🎯 Objetivo

Permitir que los niños con discapacidad visual **hables directamente con NAVI** usando micrófono y **NAVI responda por voz**, creando una experiencia completamente accesible y natural.

---

## 🔊 Casos de Uso

### Antes (Fase 1 - Texto)
```
Niño → Escribe: "Hola Navi"
Navi → Muestra texto: "¡Hola amiguito!"
```

### Después (Con Voz)
```
Niño → Habla: "Hola Navi" (micrófono)
Navi → Escucha, entiende y habla: "¡Hola amiguito!" (altavoz)
```

---

## 🛠️ Tecnologías Disponibles

### 1. **Entrada de Voz: Web Speech API (GRATIS)**
- ✅ Funciona en Chrome, Edge, Safari
- ✅ Reconocimiento de voz integrado
- ✅ Soporte para español
- ✅ No requiere configuración extra
- ✅ Funciona offline

```javascript
const recognition = new webkitSpeechRecognition();
recognition.language = 'es-ES';
recognition.start();
recognition.onresult = (event) => {
  const text = event.results[0][0].transcript;
  // Enviar 'text' a Navi
};
```

### 2. **Salida de Voz: Web Speech API (GRATIS)**
- ✅ Síntesis de voz natural
- ✅ Múltiples voces disponibles
- ✅ Control de velocidad, pitch, volumen
- ✅ Soporte español

```javascript
const synthesis = window.speechSynthesis;
const utterance = new SpeechSynthesisUtterance("¡Hola amiguito!");
utterance.lang = 'es-ES';
utterance.rate = 0.9; // velocidad
synthesis.speak(utterance);
```

### 3. **Alternative: Google Cloud Speech-to-Text (PAGO)**
- Más precisión que Web Speech API
- Mejor para acentos diversos
- Costo: $0.006 por minuto

### 4. **Alternative: Google Cloud Text-to-Speech (PAGO)**
- Voces naturales de alta calidad
- Múltiples idiomas y acentos
- Costo: $0.30 por millón de caracteres

---

## 📋 Propuesta: Fase 2+ (VOZ GRATIS con Web Speech API)

### Arquitectura

```
┌─────────────────────────────────────────────────────────┐
│                    NAVEGADOR                             │
│                                                           │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Interfaz NAVI (Vue 3)                          │   │
│  │                                                  │   │
│  │  [🎤 Hablar] [🔊 Volumen] [⏹️ Detener]          │   │
│  │                                                  │   │
│  │  Escuchando... (animación pulsante)             │   │
│  │  "Hola Navi" (texto reconocido)                 │   │
│  │                                                  │   │
│  │  Navi respondiendo...                           │   │
│  │  [AUDIO REPRODUCIÉNDOSE]                        │   │
│  │  "¡Hola amiguito! ¿Cómo estás?"                 │   │
│  └──────────────────────────────────────────────────┘   │
│                        ↑                                  │
│       ┌────────────────┼────────────────┐               │
│       ↓                ↓                ↓               │
│   ┌────────┐  ┌──────────────┐  ┌──────────────┐       │
│   │ Web    │  │ Web Speech   │  │ Web Speech   │       │
│   │ Audio  │  │ Recogn.      │  │ Synthesis    │       │
│   │ API    │  │ (Entrada)    │  │ (Salida)     │       │
│   └────────┘  └──────────────┘  └──────────────┘       │
│                                                           │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Backend API (ya existe)                        │   │
│  │  POST /api/navi-chat.php                        │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

---

## 🎤 Flujo de Conversación con Voz

### Paso a Paso

```
1. Usuario hace click en [🎤 Hablar]
   ↓
2. Navegador solicita permiso de micrófono
   ↓
3. Usuario habla: "¿Cuéntame una historia?"
   ↓
4. Web Speech Recognition convierte a texto
   ↓
5. Texto enviado a Backend (/api/navi-chat.php)
   ↓
6. Gemini genera respuesta
   ↓
7. Respuesta enviada al Frontend
   ↓
8. Web Speech Synthesis convierte a voz
   ↓
9. NAVI habla la respuesta en altavoz
   ↓
10. Texto + Audio mostrado en pantalla
   ↓
11. Usuario puede hablar de nuevo (loop)
```

---

## 💻 Implementación: Estructura de Código

### Frontend (Vue 3 en app.php)

#### Data adicionales
```javascript
data() {
  return {
    // ... datos existentes ...
    
    // Voz entrada
    voiceRecognitionActive: false,
    voiceRecognitionListening: false,
    voiceRecognitionText: '',
    voiceRecognitionError: null,
    voiceRecognitionSupported: false,
    
    // Voz salida
    voiceSynthesisSupported: false,
    voiceSynthesisPlaying: false,
    voiceSpeaking: false,
    voiceVolume: 1,
    voiceRate: 0.9,
    voicePitch: 1,
    selectedVoice: 0,
    availableVoices: []
  }
}
```

#### Métodos de voz entrada
```javascript
methods: {
  /**
   * Inicializar reconocimiento de voz
   */
  initializeVoiceRecognition() {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
      this.voiceRecognitionSupported = false;
      return;
    }
    
    this.voiceRecognition = new SpeechRecognition();
    this.voiceRecognition.lang = 'es-ES';
    this.voiceRecognition.continuous = false;
    this.voiceRecognition.interimResults = true;
    
    this.voiceRecognition.onstart = () => {
      this.voiceRecognitionListening = true;
      this.voiceRecognitionError = null;
    };
    
    this.voiceRecognition.onresult = (event) => {
      let interimTranscript = '';
      for (let i = event.resultIndex; i < event.results.length; i++) {
        const transcript = event.results[i][0].transcript;
        if (event.results[i].isFinal) {
          this.voiceRecognitionText += transcript + ' ';
        } else {
          interimTranscript += transcript;
        }
      }
      // Mostrar texto provisional mientras habla
      if (interimTranscript) {
        this.navichatInput = this.voiceRecognitionText + interimTranscript;
      }
    };
    
    this.voiceRecognition.onerror = (event) => {
      this.voiceRecognitionError = `Error de voz: ${event.error}`;
    };
    
    this.voiceRecognition.onend = () => {
      this.voiceRecognitionListening = false;
      // Enviar el texto reconocido
      if (this.voiceRecognitionText.trim()) {
        this.navichatInput = this.voiceRecognitionText.trim();
        this.sendMessageToNavi();
        this.voiceRecognitionText = '';
      }
    };
    
    this.voiceRecognitionSupported = true;
  },
  
  /**
   * Iniciar escucha de voz
   */
  startVoiceRecognition() {
    if (!this.voiceRecognitionSupported) {
      this.voiceRecognitionError = 'Tu navegador no soporta reconocimiento de voz';
      return;
    }
    
    this.voiceRecognitionText = '';
    this.voiceRecognition.start();
  },
  
  /**
   * Detener escucha de voz
   */
  stopVoiceRecognition() {
    if (this.voiceRecognition) {
      this.voiceRecognition.abort();
    }
  }
}
```

#### Métodos de voz salida
```javascript
methods: {
  /**
   * Inicializar síntesis de voz
   */
  initializeVoiceSynthesis() {
    const synthesis = window.speechSynthesis;
    if (!synthesis) {
      this.voiceSynthesisSupported = false;
      return;
    }
    
    this.voiceSynthesis = synthesis;
    
    // Cargar voces disponibles
    const loadVoices = () => {
      this.availableVoices = synthesis.getVoices();
      // Seleccionar voz en español si existe
      this.selectedVoice = this.availableVoices.findIndex(v => 
        v.lang.startsWith('es')
      );
    };
    
    loadVoices();
    synthesis.onvoiceschanged = loadVoices;
    
    this.voiceSynthesisSupported = true;
  },
  
  /**
   * Hacer que Navi hable una respuesta
   */
  speakResponse(text) {
    if (!this.voiceSynthesisSupported) {
      console.warn('Síntesis de voz no soportada');
      return;
    }
    
    // Cancelar cualquier audio anterior
    this.voiceSynthesis.cancel();
    
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'es-ES';
    utterance.rate = this.voiceRate;  // 0.9 (más lento, más claro)
    utterance.pitch = this.voicePitch;
    utterance.volume = this.voiceVolume;
    
    if (this.availableVoices.length > this.selectedVoice) {
      utterance.voice = this.availableVoices[this.selectedVoice];
    }
    
    utterance.onstart = () => {
      this.voiceSpeaking = true;
      this.voiceSynthesisPlaying = true;
    };
    
    utterance.onend = () => {
      this.voiceSpeaking = false;
      this.voiceSynthesisPlaying = false;
    };
    
    utterance.onerror = (event) => {
      console.error('Error en síntesis de voz:', event.error);
    };
    
    this.voiceSynthesis.speak(utterance);
  },
  
  /**
   * Detener audio actual
   */
  stopSpeaking() {
    if (this.voiceSynthesis) {
      this.voiceSynthesis.cancel();
      this.voiceSpeaking = false;
    }
  }
}
```

#### Modificar sendMessageToNavi() para incluir voz
```javascript
async sendMessageToNavi() {
  const message = this.navichatInput.trim();
  if (!message || this.navichatLoading) return;
  
  // ... código existente ...
  
  try {
    // ... llamada API ...
    
    if (data.success) {
      const naviResponse = data.response;
      this.navichatHistory.push({
        role: 'assistant',
        content: naviResponse
      });
      
      this.naviMessage = naviResponse;
      
      // ✨ NUEVO: Hacer que Navi hable la respuesta
      this.speakResponse(naviResponse);
    }
  } catch (error) {
    // ... manejo de error ...
  }
}
```

### Frontend (HTML en app.php)

#### Controles de voz en modo Navicito
```html
<!-- Chat Input - SOLO EN MODO NAVICITO -->
<div v-if="currentMode === 'navicito'" class="w-full max-w-md px-4 flex-shrink-0 mb-4">
  
  <!-- Botones de voz y configuración -->
  <div class="flex gap-2 mb-3">
    <!-- Botón de micrófono -->
    <button 
      @click="startVoiceRecognition"
      :disabled="voiceRecognitionListening || navichatLoading"
      class="px-4 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 disabled:opacity-50 transition-colors flex items-center gap-2"
      title="Hablar con Navi"
      v-if="voiceRecognitionSupported">
      <i :class="voiceRecognitionListening ? 'fas fa-circle fa-pulse text-white' : 'fas fa-microphone'"></i>
      <span v-if="!voiceRecognitionListening">Hablar</span>
      <span v-else>Escuchando...</span>
    </button>
    
    <!-- Botón detener entrada de voz -->
    <button 
      v-if="voiceRecognitionListening"
      @click="stopVoiceRecognition"
      class="px-3 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors"
      title="Detener micrófono">
      <i class="fas fa-stop"></i>
    </button>
    
    <!-- Botón detener audio de respuesta -->
    <button 
      v-if="voiceSpeaking"
      @click="stopSpeaking"
      class="px-3 py-3 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600 transition-colors"
      title="Detener Navi">
      <i class="fas fa-stop-circle"></i>
    </button>
    
    <!-- Indicador de volumen -->
    <div v-if="voiceSynthesisSupported" class="flex items-center gap-2 px-3 py-3 bg-gray-100 rounded-lg">
      <i class="fas fa-volume-up text-gray-600"></i>
      <input 
        v-model.number="voiceVolume" 
        type="range" 
        min="0" 
        max="1" 
        step="0.1"
        class="w-20 accent-purple-600"
        title="Volumen de Navi">
    </div>
  </div>
  
  <!-- Texto input tradicional (como alternativa) -->
  <div class="flex gap-2">
    <input 
      v-model="navichatInput"
      @keyup.enter="sendMessageToNavi"
      type="text"
      placeholder="O escribe tu pregunta..."
      :disabled="navichatLoading"
      class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navi-blue"
      aria-label="Mensaje para Navi">
    <button 
      @click="sendMessageToNavi"
      :disabled="navichatLoading || !navichatInput.trim()"
      class="px-5 py-3 bg-navi-blue text-white rounded-lg font-semibold hover:bg-blue-700 disabled:opacity-50 transition-colors flex items-center gap-2">
      <i :class="navichatLoading ? 'fas fa-spinner fa-spin' : 'fas fa-send'"></i>
    </button>
  </div>
  
  <!-- Mostrar errores de voz -->
  <p v-if="voiceRecognitionError" class="text-red-500 text-sm mt-2">{{ voiceRecognitionError }}</p>
</div>
```

---

## 🎨 Interfaz Visual

```
┌─────────────────────────────────────────┐
│  AVATAR NAVI (círculo azul)              │
│                                          │
│  "¡Hola amiguito! Estoy escuchando..."  │
│                                          │
│  ┌──────────────────────────────────┐   │
│  │ [🎤 Hablar] [⏹️] [🔊 Vol] [📝]  │   │
│  │ Escuchando... (animación pulsante)│  │
│  │                                   │   │
│  │ Navi respondiendo por voz...      │   │
│  │ [Visualización de onda sonora]    │   │
│  │                                   │   │
│  │ Historial de conversación:        │   │
│  │ Tú: "Cuéntame una historia"      │   │
│  │ Navi: "Érase una vez..."         │   │
│  └──────────────────────────────────┘   │
│                                          │
│ ✅ Micrófono soportado                  │
│ ✅ Síntesis de voz soportada            │
└─────────────────────────────────────────┘
```

---

## 📊 Comparación de Opciones

| Feature | Web Speech API | Google Cloud API |
|---------|---|---|
| **Costo** | Gratis | $0.006/min entrada |
| **Reconocimiento** | Bueno | Excelente |
| **Síntesis** | Gratis | $0.30/1M chars |
| **Síntesis calidad** | Natural | Ultra natural |
| **Requiere API key** | No | Sí |
| **Offline** | Sí (reconocimiento parcial) | No |
| **Setup** | Inmediato | Requiere config |
| **Latencia** | Baja | Baja |

**Recomendación:** Empezar con **Web Speech API (gratis)** y migrar a Google Cloud si necesitas mejor calidad.

---

## 🎯 Fases de Implementación

### Fase 2A (MVP Voz - 1 semana)
- [x] Entrada de voz con Web Speech API
- [x] Salida de voz con Web Speech Synthesis
- [x] Botones en interfaz
- [x] Control de volumen y velocidad
- [ ] Tests en navegadores principales

### Fase 2B (Mejoras)
- [ ] Indicador visual de frecuencia de sonido
- [ ] Selección de voz (múltiples voces)
- [ ] Pausa/reanuda audio
- [ ] Exportar conversación con audio

### Fase 3 (Premium - Google Cloud)
- [ ] Upgrade a Google Cloud Speech-to-Text
- [ ] Upgrade a Google Cloud Text-to-Speech
- [ ] Mejor precisión para acentos
- [ ] Voces más naturales

---

## ✅ Checklist Implementación

**Fase 2A:**
- [ ] Agregar data de voz en Vue 3
- [ ] Inicializar Web Speech Recognition
- [ ] Inicializar Web Speech Synthesis
- [ ] Agregar métodos de escucha
- [ ] Agregar métodos de síntesis
- [ ] Crear controles en HTML
- [ ] Conectar voz entrada → texto → API
- [ ] Conectar API respuesta → síntesis de voz
- [ ] Testing en Chrome, Edge, Safari
- [ ] Documentar configuración de micrófono

---

## 🔐 Consideraciones de Privacidad

⚠️ **Web Speech API:**
- Requiere permiso del usuario (popup)
- Audio se procesa localmente (parcialmente)
- Chrome: algunos datos se envían a Google
- Informar al usuario: "Respetamos tu privacidad"

✅ **Medidas:**
- Avisar que se solicita micrófono
- Permitir deshabilitar voz
- Opción de usar solo texto
- No guardar audio (solo texto)

---

## 🚀 Próximos Pasos

1. **Decidir si implementar Fase 2A** (voz gratis)
2. **Si sí:** Comenzar desarrollo siguiente semana
3. **Testing:** Chrome, Edge, Safari, Firefox
4. **Mejoras:** Basadas en feedback de usuarios

---

## 💡 Caso de Uso Real

```
Niño ciego: "Hola Navi" (habla al micrófono)

Navi escucha + entiende

Navi responde: "¡Hola mi amor! ¿Cómo estás hoy? 
               ¿Quieres jugar o escuchar una historia?" 
               (por altavoz, con voz clara y lenta)

Niño: "Una historia" (habla)

Navi: "Perfecto. Érase una vez un gatito muy travieso 
       que vivía en una casa con un perro muy amigable..." 
       (continúa narrando)

Niño: "¿Qué pasó después?" (habla)

Navi: "El gatito decidió hacer una broma..." 
      (continúa la historia basada en contexto)
```

---

## 📞 Contacto para Dudas

¿Preguntas sobre implementación de voz?
- Web Speech API: bien documentado en MDN
- Testing: usar navegador Chrome en Windows/Mac/Linux
- Debugging: F12 → Console para errores de micrófono

---

**Propuesta fecha:** 4 de diciembre de 2025  
**Estado:** Lista para decisión de implementación  
**Estimado:** Fase 2A: 5-7 días de desarrollo
