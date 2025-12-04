# NAVI Interactivo - Fase 1: Guía de Configuración y Testing

## ✅ Lo que se ha implementado

- ✓ Backend: `api/navi-chat.php` (endpoint REST)
- ✓ Configuración: `config/config_gemini.php` + `config/config_gemini_local.example.php`
- ✓ Frontend: Input de chat en modo Navicito
- ✓ Vue 3: Métodos de conversación y historial
- ✓ Seguridad: API key fuera del repositorio

---

## 🚀 Pasos para Activar NAVI Interactivo

### 1. **Obtener API Key de Gemini (GRATUITO)**

Ir a: https://ai.google.dev/

```
1. Click en "Get API Key"
2. Sign in con tu cuenta Google (o crea una)
3. Click en "Create API key"
4. Copiar la API key (empieza con "AI...")
5. Guardar en lugar seguro
```

### 2. **Crear archivo local de configuración**

```powershell
# En PowerShell, desde c:\xampp\htdocs\NaviWeb:

Copy-Item config/config_gemini_local.example.php config/config_gemini_local.php
```

### 3. **Editar config_gemini_local.php**

Abre el archivo `config/config_gemini_local.php` y reemplaza:

```php
<?php
define('GEMINI_API_KEY', 'PEGA_TU_API_KEY_AQUI');
?>
```

Con tu API key real:

```php
<?php
define('GEMINI_API_KEY', 'AIzaSyDxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
?>
```

### 4. **Verificar que el archivo está protegido**

```powershell
# Verificar que .gitignore contiene config_gemini_local.php
Get-Content .gitignore | Select-String "config_gemini_local.php"

# Debes ver: config/config_gemini_local.php
```

---

## 🧪 Testing

### Test 1: Verificar endpoint backend

```bash
# Desde la terminal en el directorio raíz del proyecto

# Test de autenticación (debería devolver 401)
curl -X POST http://localhost/NaviWeb/api/navi-chat.php \
  -H "Content-Type: application/json" \
  -d '{"message": "Hola"}'
```

Esperado: `{"success": false, "error": "No autenticado"}`

### Test 2: Interfaz en navegador

1. **Abrir app:**
   ```
   http://localhost/NaviWeb/views/app.php
   ```

2. **Iniciar sesión** (credenciales de prueba si lo prefieres)

3. **Verificar modo Navicito:**
   - Deberías ver botones "Tutor" y "Navicito"
   - Click en "Navicito"
   - Avatar de NAVI debe mostrarse
   - Debajo debe aparecer un input que dice "Pregunta a Navi..."

4. **Probar conversación:**
   - Escribe: "Hola Navi"
   - Presiona Enter o click en botón enviar
   - Avatar debe parpadear (pulso por 10s)
   - Esperado: Navi responde con texto (ej: "¡Hola amiguito! ¿Cómo estás?")
   - El mensaje se agrega al historial debajo

### Test 3: Flujo completo

```
Escribir: "Cuéntame una historia corta"
↓
Click Enviar
↓
Avatar con animación
↓
Respuesta: "Érase una vez un gatito muy travieso..."
↓
Escribir: "¿Qué pasó después?"
↓
Navi continúa la historia (mantiene contexto)
```

---

## 🔍 Debugging

### Error 1: "Servicio de IA no disponible"
**Causa:** `GEMINI_API_KEY` no está configurada  
**Solución:** Asegúrate de que `config/config_gemini_local.php` existe y tiene la key

### Error 2: "HTTP 401"
**Causa:** No estás autenticado  
**Solución:** Primero inicia sesión en `http://localhost/NaviWeb/views/login.php`

### Error 3: "Error al procesar tu mensaje"
**Causa:** API key inválida o límite de requests alcanzado  
**Solución:**
- Verifica que la API key esté correcta
- Gemini free tier: 60 requests/min
- Espera un minuto y vuelve a intentar

### Error 4: Input no aparece en Navicito
**Causa:** Estás en modo Tutor  
**Solución:** Click en botón "Navicito" para cambiar de modo

### Ver logs del servidor

```powershell
# Los errores se registran en los logs de PHP/Apache
Get-Content "C:\xampp\apache\logs\error.log" -Tail 20
```

---

## 📊 Información de la API

### Endpoint
```
POST /NaviWeb/api/navi-chat.php
```

### Headers requeridos
```
Content-Type: application/json
```

### Request body
```json
{
  "message": "Tu pregunta aquí",
  "history": [
    {"role": "user", "content": "Primer mensaje"},
    {"role": "assistant", "content": "Primera respuesta"}
  ]
}
```

### Response (éxito)
```json
{
  "success": true,
  "response": "Respuesta de Navi aquí",
  "timestamp": 1701676800
}
```

### Response (error)
```json
{
  "success": false,
  "error": "Descripción del error"
}
```

---

## 🛡️ Seguridad

✅ **API Key protegida:**
- No aparece en repositorio (está en .gitignore)
- Solo existe en `config/config_gemini_local.php` local

✅ **Validaciones:**
- Requiere autenticación (sesión activa)
- Máximo 500 caracteres por mensaje
- Rate limiting en Google (60 req/min free tier)

✅ **Safety guardrails:**
- Filtros de contenido activos en Gemini
- Detección de acoso, discurso de odio, etc.

---

## 📋 Checklist Configuración

- [ ] API key de Gemini obtenida (https://ai.google.dev/)
- [ ] Archivo `config/config_gemini_local.php` creado
- [ ] API key pegada en el archivo local
- [ ] Verified en .gitignore: `config/config_gemini_local.php`
- [ ] Servidor Apache reiniciado (o cambios guardados)
- [ ] Sesión activa en app.php
- [ ] Cambié a modo "Navicito"
- [ ] Input aparece bajo el avatar
- [ ] Envié mensaje de prueba
- [ ] Navi respondió correctamente

---

## 🎯 Próximos Pasos (Fase 2)

- Guardar historial en BD
- Modal de chat para tutores
- Botón para limpiar historial
- Exportar conversación a PDF

---

## 📞 Soporte

Si hay problemas:

1. Verifica el navegador console (F12 → Console)
2. Revisa logs de Apache: `C:\xampp\apache\logs\error.log`
3. Confirma que `api/navi-chat.php` existe y es accesible
4. Verifica que la sesión está activa (`$_SESSION['logged_in']`)

---

**Última actualización:** 4 de diciembre de 2025  
**Estado:** Fase 1 ✅ Implementada y lista para testing
