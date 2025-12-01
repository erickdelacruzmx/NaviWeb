<?php
// Archivo de ejemplo: NO subas credenciales reales al repositorio.
// Copia este archivo a config_google_local.php y rellena con tus valores.
// Este archivo debe estar ignorado por git (.gitignore ya lo incluye).

// ID de cliente de OAuth de Google (público, pero no lo subas al repo)
define('GOOGLE_CLIENT_ID', 'TU_CLIENT_ID.apps.googleusercontent.com');

// Secreto de cliente de OAuth de Google (sensible): rota si se expone
define('GOOGLE_CLIENT_SECRET', 'TU_CLIENT_SECRET');

// URI de redirección para el flujo OAuth server-side
// Asegúrate que coincide con lo configurado en Google Cloud Console
define('GOOGLE_REDIRECT_URI', 'http://localhost/NaviWeb/auth_google.php');
