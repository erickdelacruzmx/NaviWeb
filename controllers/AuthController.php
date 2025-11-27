<?php
class AuthController {
    public function login() {
        session_start();
        require_once __DIR__ . '/../config/config_db.php';
        $login_errors = [];
        
        // Procesar login con redes sociales
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['social_login'])) {
            $provider = $_POST['provider'];
            if ($provider === 'google') {
                // El botón de Google debe usar la API de Google Sign-In
                // Por ahora redirigimos a la vista con el script de Google
                $_SESSION['social_provider'] = 'google';
            } elseif ($provider === 'facebook') {
                // El botón de Facebook debe usar la API de Facebook Login
                $_SESSION['social_provider'] = 'facebook';
            }
        }
        
        // Procesar login normal
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            
            if (empty($email)) {
                $login_errors[] = "El correo electrónico es obligatorio";
            }
            if (empty($password)) {
                $login_errors[] = "La contraseña es obligatoria";
            }
            
            if (empty($login_errors)) {
                $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND tipo = "normal"');
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_name'] = $user['nombre'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_type'] = "Tutor";
                    header('Location: /app.php');
                    exit;
                } else {
                    $login_errors[] = "Credenciales incorrectas";
                }
            }
        }
        require __DIR__ . '/../views/login.php';
    }
    public function registro() {
        session_start();
        require_once __DIR__ . '/../config/config_db.php';
        $registro_errors = [];
        $registro_exito = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            if (empty($nombre)) {
                $registro_errors[] = "El nombre es obligatorio";
            }
            if (empty($email)) {
                $registro_errors[] = "El correo electrónico es obligatorio";
            }
            if (empty($password)) {
                $registro_errors[] = "La contraseña es obligatoria";
            }
            if ($password !== $password2) {
                $registro_errors[] = "Las contraseñas no coinciden";
            }
            // Verificar si el email ya existe
            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $registro_errors[] = "El correo ya está registrado";
            }
            if (empty($registro_errors)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, password_hash, tipo, fecha_registro) VALUES (?, ?, ?, "normal", NOW())');
                $stmt->execute([$nombre, $email, $password_hash]);
                $registro_exito = true;
                header('Location: /login.php');
                exit;
            }
        }
        require __DIR__ . '/../views/registro.php';
    }
}
