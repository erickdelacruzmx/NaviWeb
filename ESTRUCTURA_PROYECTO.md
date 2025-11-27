# Estructura del Proyecto NaviWeb (Limpio - MVC)

## 📁 Archivos Principales (Raíz)

### Controladores de Entrada (Front Controllers)
- **index.php** - Landing page principal con información de Navi
- **login.php** - Controlador de entrada para inicio de sesión → AuthController::login()
- **registro.php** - Controlador de entrada para registro → AuthController::registro()
- **app.php** - Controlador de entrada para la aplicación → AppController::index()
- **perfil.php** - Controlador de entrada para perfil → AppController::perfil()
- **configuracion.php** - Controlador de entrada para configuración → AppController::configuracion()
- **logout.php** - Cierre de sesión

### Autenticación Social
- **auth_google.php** - Manejo de autenticación con Google OAuth
- **auth_facebook.php** - Manejo de autenticación con Facebook

### Configuración
- **.htaccess** - Configuración del servidor Apache
- **composer.json** - Dependencias de PHP
- **db.sql** - Esquema de la base de datos

## 📁 Directorios

### /app
- **Router.php** - Sistema de enrutamiento

### /config
- **config_db.php** - Configuración de la base de datos
- **config_google.php** - Credenciales de Google OAuth

### /controllers
- **AuthController.php** - Controlador de autenticación (login, registro)
- **AppController.php** - Controlador de la aplicación (index, perfil, configuración)

### /models
- **Usuario.php** - Modelo de datos de usuario

### /views
- **login.php** - Vista de inicio de sesión
- **registro.php** - Vista de registro
- **app.php** - Vista de la aplicación principal (dashboard)
- **perfil.php** - Vista del perfil de usuario
- **configuracion.php** - Vista de configuración de cuenta

### /css
- **styles.css** - Estilos personalizados y paleta de colores

### /images
Imágenes del proyecto (logos, galería, etc.)

### /icon
Iconos y recursos SVG

### /vendor
Dependencias de Composer (Google OAuth, etc.)

## 🗑️ Archivos Eliminados (Ya no se usan)

- ❌ app_backup.php
- ❌ app_new.php
- ❌ app_refactored.php
- ❌ test_db_connection.php
- ❌ tailwind-setup.html
- ❌ generar_contenido.php
- ❌ views/login.php (duplicado)
- ❌ views/app.php (vacío)
- ❌ views/registro.php (duplicado)
- ❌ views/perfil.php (vacío)

## 🔄 Flujo de Autenticación (MVC)

1. Usuario visita **index.php** (landing page)
2. Click en "Iniciar Sesión" → **login.php** (Front Controller)
   - login.php → AuthController::login() → views/login.php
3. Login exitoso → **app.php** (Front Controller)
   - app.php → AppController::index() → views/app.php
4. Desde app.php puede acceder a:
   - **perfil.php** → AppController::perfil() → views/perfil.php
   - **configuracion.php** → AppController::configuracion() → views/configuracion.php
   - **logout.php** - Cerrar sesión

## 📋 Patrón MVC Aplicado

**Modelo (Model)**
- `/models/Usuario.php` - Lógica de datos de usuario

**Vista (View)**
- `/views/*.php` - Todas las interfaces de usuario (HTML + CSS + JS)

**Controlador (Controller)**
- `/controllers/AuthController.php` - Lógica de autenticación
- `/controllers/AppController.php` - Lógica de la aplicación

**Front Controllers (Raíz)**
- Archivos en la raíz que invocan los controladores correspondientes
- Mantienen URLs limpias y amigables

## 🎨 Tecnologías

- **PHP 7.4+** - Backend
- **MySQL** - Base de datos
- **Tailwind CSS** - Framework CSS
- **FontAwesome 6.4.0** - Iconos
- **Google Fonts (Poppins)** - Tipografía
- **Google OAuth 2.0** - Autenticación social
- **Vue.js 3** - Interactividad en app.php

## 📝 Notas Importantes

- **Patrón MVC implementado**: Los archivos en la raíz son Front Controllers que invocan los controladores
- **URLs limpias**: `/login.php`, `/app.php`, `/perfil.php`, etc.
- **Vistas en views/**: Todas las interfaces están en el directorio `/views/`
- **Rutas absolutas**: Todos los enlaces usan rutas absolutas (`/login.php` en lugar de `login.php`)
- **Separación de responsabilidades**: Lógica en controllers/, presentación en views/
