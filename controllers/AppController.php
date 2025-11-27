<?php
class AppController {
    public function index() {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /login.php');
            exit;
        }
        require_once __DIR__ . '/../views/app.php';
    }
    public function perfil() {
        session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /login.php');
            exit;
        }
        require_once __DIR__ . '/../views/perfil.php';
    }
    public function configuracion() {
        session_start();
        require_once __DIR__ . '/../config/config_db.php';
        $config_errors = [];
        $config_exito = false;
        // Cambiar nombre
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_nombre'])) {
            $nuevo_nombre = trim($_POST['nuevo_nombre'] ?? '');
            $user_email = $_SESSION['user_email'] ?? '';
            if (empty($nuevo_nombre)) {
                $config_errors[] = "El nombre no puede estar vacío";
            }
            if ($user_email && empty($config_errors)) {
                $stmt = $pdo->prepare('UPDATE usuarios SET nombre = ? WHERE email = ?');
                $stmt->execute([$nuevo_nombre, $user_email]);
                $_SESSION['user_name'] = $nuevo_nombre;
                $config_exito = true;
            }
        }
        // Cambiar email
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_email'])) {
            $nuevo_email = filter_var($_POST['nuevo_email'], FILTER_SANITIZE_EMAIL);
            $user_email = $_SESSION['user_email'] ?? '';
            if (empty($nuevo_email)) {
                $config_errors[] = "El correo no puede estar vacío";
            } elseif (!filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) {
                $config_errors[] = "El correo no es válido";
            } else {
                // Verificar si el email ya existe
                $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
                $stmt->execute([$nuevo_email]);
                if ($stmt->fetch()) {
                    $config_errors[] = "El correo ya está registrado";
                }
            }
            if ($user_email && empty($config_errors)) {
                $stmt = $pdo->prepare('UPDATE usuarios SET email = ? WHERE email = ?');
                $stmt->execute([$nuevo_email, $user_email]);
                $_SESSION['user_email'] = $nuevo_email;
                $config_exito = true;
            }
        }
        // Cambiar contraseña
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_password'])) {
            $nueva_password = $_POST['nueva_password'] ?? '';
            $nueva_password2 = $_POST['nueva_password2'] ?? '';
            $user_email = $_SESSION['user_email'] ?? '';
            if (empty($nueva_password)) {
                $config_errors[] = "La nueva contraseña no puede estar vacía";
            }
            if ($nueva_password !== $nueva_password2) {
                $config_errors[] = "Las contraseñas no coinciden";
            }
            if ($user_email && empty($config_errors)) {
                $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE usuarios SET password_hash = ? WHERE email = ?');
                $stmt->execute([$password_hash, $user_email]);
                $config_exito = true;
            }
        }
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /login.php');
            exit;
        }
        require __DIR__ . '/../views/configuracion.php';
    }
}
