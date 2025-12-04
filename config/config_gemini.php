<?php
// Configuración de Gemini API (sin secretos en el repositorio)
// 1) Crea un archivo opcional no versionado: config/config_gemini_local.php con:
//    <?php
//    define('GEMINI_API_KEY', 'TU_API_KEY_AQUI');
// 2) O define variable de entorno: GEMINI_API_KEY
//    

// Cargar override local si existe (ignorado por git)
$local_config_path = __DIR__ . '/config_gemini_local.php';
if (file_exists($local_config_path)) {
	$local_config = require $local_config_path;
	if (is_array($local_config) && isset($local_config['GEMINI_API_KEY'])) {
		define('GEMINI_API_KEY', $local_config['GEMINI_API_KEY']);
	}
} else {
	// Cargar desde variable de entorno o usar valor vacío
	if (!defined('GEMINI_API_KEY')) {
		define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');
	}
}

// Validar que la API key esté disponible
if (empty(GEMINI_API_KEY)) {
	// No lanzar error aquí - dejar que el endpoint lo maneje
	define('GEMINI_ENABLED', false);
} else {
	define('GEMINI_ENABLED', true);
}

// Parámetros por defecto de Gemini
define('GEMINI_MODEL', 'gemini-pro');
define('GEMINI_TEMPERATURE', 0.7);
define('GEMINI_MAX_TOKENS', 150);
define('GEMINI_TOP_P', 0.9);
define('GEMINI_TOP_K', 40);
define('GEMINI_TOP_P', 0.9);
define('GEMINI_TOP_K', 40);
?>
