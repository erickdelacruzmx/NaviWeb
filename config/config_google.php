<?php
// Configuración de Google OAuth (sin secretos en el repositorio)
// 1) Crea un archivo opcional no versionado: config/config_google_local.php con:
//    <?php
//    define('GOOGLE_CLIENT_ID', '...');
//    define('GOOGLE_CLIENT_SECRET', '...');
//    define('GOOGLE_REDIRECT_URI', 'http://localhost/NaviWeb/auth_google.php');
// 2) O define variables de entorno: GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI
//    

//Cargar override local si existe (ignorado por git)
if (file_exists(__DIR__ . '/config_google_local.php')) {
	require __DIR__ . '/config_google_local.php';
} else {
	// Cargar desde variables de entorno o usar valores vacíos por defecto
	if (!defined('GOOGLE_CLIENT_ID')) {
		define('GOOGLE_CLIENT_ID', getenv('GOOGLE_CLIENT_ID') ?: '');
	}
	if (!defined('GOOGLE_CLIENT_SECRET')) {
		define('GOOGLE_CLIENT_SECRET', getenv('GOOGLE_CLIENT_SECRET') ?: '');
	}
	if (!defined('GOOGLE_REDIRECT_URI')) {
		define('GOOGLE_REDIRECT_URI', getenv('GOOGLE_REDIRECT_URI') ?: 'http://localhost/NaviWeb/auth_google.php');
	}
}
?>
