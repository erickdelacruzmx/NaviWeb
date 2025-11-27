<?php
session_start();
require_once __DIR__ . '/config/config_db.php';
require_once __DIR__ . '/config/config_google.php';

$CLIENT_ID = GOOGLE_CLIENT_ID;
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Nuevo flujo: Recibir info del usuario directamente del frontend
    if (isset($data['name']) && isset($data['email'])) {
        $google_name = $data['name'];
        $google_email = $data['email'];
        
        // Buscar usuario en la base de datos
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND tipo = "google"');
        $stmt->execute([$google_email]);
        $user = $stmt->fetch();
        
        $is_existing_user = false;
        if (!$user) {
            // Crear usuario nuevo
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, tipo) VALUES (?, ?, "google")');
            $stmt->execute([$google_name, $google_email]);
        } else {
            $is_existing_user = true;
        }
        
        // Guardar datos en sesión
        $_SESSION['user_email'] = $google_email;
        $_SESSION['user_name'] = $google_name;
        $_SESSION['user_type'] = "Tutor";
        $_SESSION['logged_in'] = true;
        $_SESSION['social_login'] = true;
        $_SESSION['auth_provider'] = 'google';
        
        echo json_encode([
            'success' => true,
            'redirect' => 'app.php',
            'is_existing_user' => $is_existing_user,
            'user' => [
                'name' => $google_name,
                'email' => $google_email
            ]
        ]);
        exit;
    }
    
    // Flujo antiguo: Validar token de Google
    $token = $data['credential'] ?? $data['token'] ?? $_POST['credential'] ?? $_POST['token'] ?? null;

    if (!$token) {
        echo json_encode(['success' => false, 'error' => 'Token o datos de usuario no proporcionados']);
        exit;
    }

    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($token);
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo json_encode(['success' => false, 'error' => 'Token inválido o error de conexión con Google']);
        exit;
    }

    $payload = json_decode($response, true);

    if (isset($payload['aud']) && $payload['aud'] === $CLIENT_ID) {
        // --- AUTENTICACIÓN EXITOSA ---
        $google_name = $payload['name'];
        $google_email = $payload['email'];
        // Buscar usuario en la base de datos
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND tipo = "google"');
        $stmt->execute([$google_email]);
        $user = $stmt->fetch();
        
        $is_existing_user = false;
        if (!$user) {
            // Crear usuario nuevo
            $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, tipo) VALUES (?, ?, "google")');
            $stmt->execute([$google_name, $google_email]);
        } else {
            $is_existing_user = true;
        }
        // Guardar datos en sesión
        $_SESSION['user_email'] = $google_email;
        $_SESSION['user_name'] = $google_name;
        $_SESSION['user_type'] = "Tutor";
        $_SESSION['logged_in'] = true;
        $_SESSION['social_login'] = true;
        $_SESSION['auth_provider'] = 'google';
        echo json_encode([
            'success' => true,
            'redirect' => 'app.php',
            'is_existing_user' => $is_existing_user,
            'user' => [
                'name' => $google_name,
                'email' => $google_email
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Token no corresponde a esta aplicación']);
    }
    exit;
}
?>