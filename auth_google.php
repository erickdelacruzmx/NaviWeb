<?php
session_start();

// Procesar login con Google
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $token = $data['token'];
    
    // Verificar el token con Google (simplificado)
    // En producción, usarías la biblioteca oficial de Google
    
    // Simulación de verificación exitosa
    $_SESSION['user_email'] = "usuario_google@ejemplo.com";
    $_SESSION['user_name'] = "Usuario Google";
    $_SESSION['user_type'] = "Tutor";
    $_SESSION['logged_in'] = true;
    $_SESSION['social_login'] = true;
    
    echo json_encode(['success' => true, 'redirect' => 'app.php']);
    exit;
}
?>