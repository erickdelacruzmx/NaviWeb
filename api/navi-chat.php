<?php
/**
 * NAVI Chat API Endpoint
 * Procesa conversaciones con Gemini para el avatar educativo NAVI
 * 
 * Método: POST
 * Content-Type: application/json
 * Body: { "message": "string", "history": [ { "role": "user|assistant", "content": "string" } ] }
 * 
 * Respuesta: { "success": true, "response": "string", "timestamp": number }
 */

session_start();
require_once __DIR__ . '/../config/config_db.php';
require_once __DIR__ . '/../config/config_gemini.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

/**
 * Validaciones iniciales
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['success' => false, 'error' => 'Método no permitido']);
	exit;
}

// Verificar autenticación
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	http_response_code(401);
	echo json_encode(['success' => false, 'error' => 'No autenticado']);
	exit;
}

// Verificar que Gemini esté configurado
if (!GEMINI_ENABLED) {
	http_response_code(503);
	echo json_encode(['success' => false, 'error' => 'Servicio de IA no disponible. Configura GEMINI_API_KEY']);
	exit;
}

/**
 * Parsear input
 */
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
	http_response_code(400);
	echo json_encode(['success' => false, 'error' => 'JSON inválido']);
	exit;
}

$user_message = trim($data['message'] ?? '');
$conversation_history = $data['history'] ?? [];
$user_name = $_SESSION['user_name'] ?? 'Amiguito';
$user_email = $_SESSION['user_email'] ?? 'usuario@ejemplo.com';

// Validar mensaje
if (empty($user_message)) {
	http_response_code(400);
	echo json_encode(['success' => false, 'error' => 'Mensaje vacío']);
	exit;
}

if (strlen($user_message) > 500) {
	http_response_code(400);
	echo json_encode(['success' => false, 'error' => 'Mensaje demasiado largo (máximo 500 caracteres)']);
	exit;
}

// Validar historial
if (!is_array($conversation_history)) {
	$conversation_history = [];
}

// Limitar historial a últimos 10 mensajes
$conversation_history = array_slice($conversation_history, -10);

try {
	// Construir system prompt personalizado
	$system_prompt = "Eres NAVI, un asistente educativo amigable y motivador para niños con discapacidad visual. " .
		"Tu objetivo es hacer que el aprendizaje sea divertido y accesible. " .
		"El usuario se llama: {$user_name}.\n\n" .
		"Instrucciones:\n" .
		"- Responde siempre en español\n" .
		"- Usa un lenguaje simple, claro y amigable\n" .
		"- Mantén respuestas cortas (máximo 1-2 oraciones, idealmente < 140 caracteres)\n" .
		"- Sé comprensivo, paciente y motivador\n" .
		"- Fomenta el aprendizaje haciendo preguntas\n" .
		"- Haz referencia al nombre del usuario ocasionalmente\n" .
		"- Evita contenido inapropiado o violento\n" .
		"- Si no sabes algo, di que lo desconoces\n" .
		"- Sé lúdico y divertido, como amigo del usuario\n";
	
	// Preparar mensajes para Gemini (formato de partes)
	$messages = [];
	
	// Agregar historial previo
	foreach ($conversation_history as $msg) {
		if (isset($msg['role']) && isset($msg['content'])) {
			$messages[] = [
				'role' => ($msg['role'] === 'user') ? 'user' : 'model',
				'parts' => [['text' => $msg['content']]]
			];
		}
	}
	
	// Agregar mensaje actual del usuario
	$messages[] = [
		'role' => 'user',
		'parts' => [['text' => $user_message]]
	];
	
	// Llamar API de Gemini
	$gemini_response = callGeminiAPI($system_prompt, $messages);
	
	if (!$gemini_response) {
		throw new Exception('Gemini API retornó respuesta vacía');
	}
	
	// Limitar respuesta a 150 caracteres para pantalla
	$response_text = trim($gemini_response);
	if (strlen($response_text) > 200) {
		$response_text = substr($response_text, 0, 200) . '...';
	}
	
	// Log de conversación (opcional - para estadísticas futura)
	// $stmt = $pdo->prepare('INSERT INTO navi_conversations (user_email, user_message, navi_response, created_at) VALUES (?, ?, ?, NOW())');
	// $stmt->execute([$user_email, $user_message, $gemini_response]);
	
	// Responder con éxito
	http_response_code(200);
	echo json_encode([
		'success' => true,
		'response' => $response_text,
		'timestamp' => time()
	]);
	
} catch (Exception $e) {
	error_log('NAVI Chat Error: ' . $e->getMessage());
	http_response_code(500);
	echo json_encode([
		'success' => false,
		'error' => 'Error al procesar tu mensaje. Intenta de nuevo.'
	]);
}

exit;

/**
 * Llamar a Gemini API (REST)
 * 
 * @param string $system_prompt Instrucciones del sistema
 * @param array $messages Historial de conversación
 * @return string|null Texto de respuesta o null si error
 */
function callGeminiAPI($system_prompt, $messages) {
	$api_key = GEMINI_API_KEY;
	$model = GEMINI_MODEL;
	$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
	
	// Construir request body según Gemini API v1beta
	$request_body = [
		'system_instruction' => [
			'parts' => [['text' => $system_prompt]]
		],
		'contents' => $messages,
		'generation_config' => [
			'temperature' => GEMINI_TEMPERATURE,
			'maxOutputTokens' => GEMINI_MAX_TOKENS,
			'topP' => GEMINI_TOP_P,
			'topK' => GEMINI_TOP_K
		],
		'safety_settings' => [
			[
				'category' => 'HARM_CATEGORY_HARASSMENT',
				'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
			],
			[
				'category' => 'HARM_CATEGORY_HATE_SPEECH',
				'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
			],
			[
				'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
				'threshold' => 'BLOCK_ONLY_HIGH'
			],
			[
				'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
				'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
			]
		]
	];
	
	// Hacer request con curl
	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL => "{$endpoint}?key={$api_key}",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => [
			'Content-Type: application/json'
		],
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => json_encode($request_body),
		CURLOPT_TIMEOUT => 15,
		CURLOPT_CONNECTTIMEOUT => 10,
		CURLOPT_SSL_VERIFYPEER => true,
		CURLOPT_SSL_VERIFYHOST => 2
	]);
	
	$response = curl_exec($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$curl_error = curl_error($ch);
	curl_close($ch);
	
	// Verificar errores de conexión
	if ($curl_error) {
		error_log("Gemini cURL Error: {$curl_error}");
		return null;
	}
	
	// Verificar código HTTP
	if ($http_code !== 200) {
		error_log("Gemini API Error (HTTP {$http_code}): {$response}");
		return null;
	}
	
	// Parsear respuesta JSON
	$result = json_decode($response, true);
	
	if (!is_array($result)) {
		error_log("Gemini API: JSON inválido");
		return null;
	}
	
	// Extraer texto de respuesta
	if (isset($result['candidates']) && is_array($result['candidates']) && count($result['candidates']) > 0) {
		$candidate = $result['candidates'][0];
		if (isset($candidate['content']['parts']) && is_array($candidate['content']['parts']) && count($candidate['content']['parts']) > 0) {
			$text = $candidate['content']['parts'][0]['text'] ?? null;
			if ($text) {
				return $text;
			}
		}
	}
	
	error_log("Gemini API: Respuesta sin contenido");
	return null;
}
?>
