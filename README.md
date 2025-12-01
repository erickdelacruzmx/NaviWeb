# NAVI

Plataforma educativa inclusiva para niños con discapacidad visual.

## Estructura

- `index.php`: Landing informativa con enlaces a registro/login
- `login.php` / `registro.php`: Autenticación simulada (demo)
- `perfil.php`: Área del usuario autenticado (protegida)
- `configuracion.php`: Panel de configuración del usuario (protegido)
- `app.php`: Interfaz de juegos/biblioteca (Vue 3, standalone)
- `icons.css`: Definiciones de iconos por máscaras SVG
- `css/styles.css`: Estilos compartidos para login/registro y layout
- `icon/`: SVGs de iconos
- `images/`: Imágenes

## Cambios recientes

- Correcciones de rutas y assets: favicon y logo en `app.php`, eliminación de `session_start` duplicado en `index.php`.
- Unificación de sesión: `perfil.php` y `configuracion.php` ahora requieren sesión (`$_SESSION['logged_in']`).
- Arreglo de plantillas Vue en `app.php` (uso correcto de `v-if`/`v-else` en Biblioteca) y mensaje de favoritos.
- Limpieza de `icons.css`: reemplazo de `icon/juegos.svg` por `icon/comunicativa.svg`, corrección de rutas a `Libro.svg` y `canciones.svg`.

## Responsivo

- Se incluyen reglas para móvil (<768px) y tablet (~<=992px) en las hojas de estilo.
- Grids usan `auto-fit` o colapsan a una columna en móvil.

## Autenticación (demo)

- Credenciales de prueba en `login.php`:
  - Email: `usuario@ejemplo.com`
  - Password: `password123`

## Requisitos

- XAMPP con PHP >= 8.0
- Colocar la carpeta `NAVI` en `C:\xampp\htdocs\` y arrancar Apache.

## Verificación rápida

Desde PowerShell, puede validar sintaxis:

```
C:\xampp\php\php.exe -l C:\xampp\htdocs\NAVI\*.php
```

## Notas

- Para producción en Linux/Apache, mantener mayúsculas/minúsculas en rutas SVG como en `icons.css` (p. ej. `Libro.svg`).
- Si faltan SVGs adicionales, reutilizamos iconos existentes hasta contar con los definitivos.

## Configuración de Google OAuth

Los secretos no deben estar en el repositorio.

- Crea `config/config_google_local.php` copiando desde `config/config_google_local.example.php` y coloca tus credenciales:
  - `GOOGLE_CLIENT_ID`
  - `GOOGLE_CLIENT_SECRET`
  - `GOOGLE_REDIRECT_URI`
  Este archivo ya está ignorado por `.gitignore`.

- Alternativamente, define variables de entorno en el servidor:
  - `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`

- El frontend usa `GOOGLE_CLIENT_ID` inyectado por `config/config_google.php` en `views/login.php` y `views/registro.php`.

- Si alguna vez se expone un secreto, rota el `Client Secret` en Google Cloud Console y limpia el historial con BFG.
