# 🔑 GUÍA RÁPIDA: Obtener API Key de Gemini (3 minutos)

## Acceso Directo

🔗 **Abre esta URL:** https://ai.google.dev/

O si eso no funciona:

🔗 **Abre:** https://ai.google.dev/tutorials/setup

---

## Pasos Visuales

### 1️⃣ Página Principal
```
┌─────────────────────────────────────────┐
│  Google AI Studio                       │
│  ┌─────────────────────────────────┐   │
│  │ Welcome to Google AI Studio     │   │
│  │                                 │   │
│  │ [Get API Key] ← CLICK AQUÍ      │   │
│  └─────────────────────────────────┘   │
└─────────────────────────────────────────┘
```

### 2️⃣ Haz Click en "Get API Key"
- Aparecerá una ventana de login de Google
- Inicia sesión con tu cuenta de Google (la que usas para Gmail, YouTube, etc.)

### 3️⃣ Autoriza el Acceso
```
┌──────────────────────────────────────┐
│ Autorizar acceso a Google AI Studio  │
│                                      │
│ ¿Permitir que use tu cuenta?         │
│                                      │
│  [Cancelar]  [✓ Continuar]          │
└──────────────────────────────────────┘
```

### 4️⃣ Crea un Proyecto (si es la primera vez)
```
┌──────────────────────────────────────┐
│ Crear nuevo proyecto                 │
│                                      │
│ Nombre: NaviWeb  [____NaviWeb____]   │
│                                      │
│  [Cancelar]  [✓ Crear]              │
└──────────────────────────────────────┘
```

### 5️⃣ Copia tu API Key
```
┌──────────────────────────────────────┐
│ Your API Key                         │
│                                      │
│ AIzaSyD...xxxxxxxxxxxxxxxxxxxxxx ✏️  │
│                                      │
│ [📋 Copy]  [🗑️ Delete]  [🔄 Rotate] │
└──────────────────────────────────────┘
```

### 6️⃣ Guarda en Seguro
```
Mi API Key de Gemini
====================
AIzaSyD...xxxxxxxxxxxxxxxxxxxxxx

Guardada en:
- Bloc de notas encriptado
- 1Password
- Gestor de contraseñas
- En el archivo: config/config_gemini_local.php

⚠️ NUNCA mostrar públicamente
⚠️ NUNCA subir a GitHub
⚠️ NUNCA compartir por email/chat
```

---

## ✅ Verificación de Éxito

Cuando veas esto, ¡éxito!:

```
API Key                          Status
────────────────────────────────────────
AIzaSyD...xxxxxxxxxxxxxxxxxxxxx  ✅ ACTIVO
Gemini 1.5 Flash (modelo)        ✅ DISPONIBLE
Límite de cuota                  ✅ 60 req/min
```

---

## Qué Hacer Ahora

Tienes dos opciones:

### Opción A: Activación Automática
1. Abre archivo: `config/config_gemini_local.php`
2. Pega tu API key: `'GEMINI_API_KEY' => 'AIzaSyD...'`
3. Guarda
4. ¡Listo! NAVI funciona

### Opción B: Variable de Entorno (Avanzado)
```
GEMINI_API_KEY=AIzaSyD...xxxxxxxxxxxxxx
```

---

## Errores Comunes

### ❌ "No tengo cuenta de Google"
→ Crea una gratis en: https://accounts.google.com/

### ❌ "No me deja crear proyecto"
→ Google Cloud puede bloquear por país/VPN
→ Desactiva VPN y reintentar

### ❌ "La API key tiene límite"
→ Las keys gratis tiene límite: 60 solicitudes por minuto
→ Para producción, agrega una tarjeta de crédito en Google Cloud Console (es gratis hasta cierto uso)

### ❌ "Ya obtuve key, pero ¿dónde está?"
→ Abre: https://ai.google.dev/
→ Haz login
→ Verás tu API key en la pantalla principal
→ O en: Google Cloud Console → API Keys

---

## Una Vez Tengas la API Key

### Crear archivo config/config_gemini_local.php:

```php
<?php
// Reemplaza TU_API_KEY_AQUI con tu API key real

return [
    'GEMINI_API_KEY' => 'TU_API_KEY_AQUI',
];
```

### Ejemplo real:
```php
<?php
return [
    'GEMINI_API_KEY' => 'AIzaSyD123456789abcdefghijklmnop',
];
```

---

## 🎯 Resumen Rápido

```
1. Abre: https://ai.google.dev/
2. Click: "Get API Key"
3. Login con Google
4. Copia tu API key
5. Crea: config/config_gemini_local.php
6. Pega: tu API key en el archivo
7. Guarda el archivo
8. ¡NAVI funciona! 🎉
```

---

**Tiempo total:** 3-5 minutos  
**Dificultad:** ⭐ Muy fácil  
**Resultado:** NAVI con voz completamente operacional
