<?php
session_start();
require_once __DIR__ . '/config/config_db.php';

// Procesar login con Facebook
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $facebook_name = $data['name'] ?? 'Usuario Facebook';
    $facebook_email = $data['email'] ?? null;
    
    if (!$facebook_email) {
        echo json_encode(['success' => false, 'error' => 'Email no proporcionado por Facebook']);
        exit;
    }
    
    // Buscar usuario en la base de datos
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND tipo = "facebook"');
    $stmt->execute([$facebook_email]);
    $user = $stmt->fetch();
    
    $is_existing_user = false;
    if (!$user) {
        // Crear usuario nuevo
        $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, tipo) VALUES (?, ?, "facebook")');
        $stmt->execute([$facebook_name, $facebook_email]);
    } else {
        $is_existing_user = true;
    }
    
    // Guardar datos en sesión
    $_SESSION['user_email'] = $facebook_email;
    $_SESSION['user_name'] = $facebook_name;
    $_SESSION['user_type'] = "Tutor";
    $_SESSION['logged_in'] = true;
    $_SESSION['social_login'] = true;
    $_SESSION['auth_provider'] = 'facebook';
    
    echo json_encode([
        'success' => true, 
        'redirect' => '/NaviWeb/app.php',
        'is_existing_user' => $is_existing_user,
        'user' => [
            'name' => $facebook_name,
            'email' => $facebook_email
        ]
    ]);
    exit;
}

// Si no es POST, responder con error
header('Content-Type: application/json');
echo json_encode(['success' => false, 'error' => 'Método no permitido']);
?>