<?php
session_start();

// Si el usuario ya está logueado, redirigir al index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Procesar formulario de login
$login_errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Validaciones
    if (empty($email)) {
        $login_errors[] = "El correo electrónico es obligatorio";
    }
    
    if (empty($password)) {
        $login_errors[] = "La contraseña es obligatoria";
    }
    
    // Si no hay errores, procesar el login
    if (empty($login_errors)) {
        // Simulación de autenticación - en un caso real, verificarías contra una base de datos
        $valid_email = "usuario@ejemplo.com";
        $valid_password = "password123";
        
        if ($email === $valid_email && $password === $valid_password) {
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = "Usuario Ejemplo";
            $_SESSION['user_type'] = "Tutor";
            $_SESSION['logged_in'] = true;
            header('Location: app.php');
            exit;
        } else {
            $login_errors[] = "Credenciales incorrectas. Use: usuario@ejemplo.com / password123";
        }
    }
}

// Procesar login con redes sociales (simulación)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['social_login'])) {
    $provider = $_POST['provider'];
    
    // Simulación de autenticación con redes sociales
    $_SESSION['user_email'] = "usuario_{$provider}@ejemplo.com";
    $_SESSION['user_name'] = "Usuario {$provider}";
    $_SESSION['user_type'] = "Tutor";
    $_SESSION['logged_in'] = true;
    $_SESSION['social_login'] = true;
    
    header('Location: app.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Navi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estilos para el loading de botones sociales */
        .social-btn.loading {
            position: relative;
            overflow: hidden;
        }
        
        .social-btn.loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }
        
        /* Asegurar que los formularios sociales no tengan margen */
        .social-form {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="container">
            <div class="auth-form-container">
                <div class="form-header">
                    <h1>¡Hola!</h1>
                    <h2>Iniciar Sesión</h2>
                    <p>Bienvenido a Navi.</p>
                </div>
                
                <?php if (!empty($login_errors)): ?>
                    <?php foreach ($login_errors as $error): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="demo-credentials">
                    <strong>Credenciales de prueba:</strong><br>
                    Email: usuario@ejemplo.com<br>
                    Contraseña: password123
                </div>
                
                <form method="POST">
                    <input type="hidden" name="login" value="1">
                    <div class="form-group">
                        <label for="login-email">Correo electrónico</label>
                        <input type="email" id="login-email" name="email" class="form-control" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="login-password">Contraseña</label>
                        <input type="password" id="login-password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                    
                    <button type="submit" class="btn">Ingresar</button>
                </form>
                
                <div class="social-login">
                    <p>Ingresa con</p>
                    
                    <div class="social-buttons">
                        <!-- Formularios separados para cada proveedor -->
                        <form method="POST" class="social-form">
                            <input type="hidden" name="social_login" value="1">
                            <input type="hidden" name="provider" value="google">
                            <button type="submit" class="social-btn google">
                                <i class="fab fa-google"></i>
                                Continuar con Google
                            </button>
                        </form>
                        
                        <form method="POST" class="social-form">
                            <input type="hidden" name="social_login" value="1">
                            <input type="hidden" name="provider" value="facebook">
                            <button type="submit" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                                Continuar con Facebook
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="form-footer">
                    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
                </div>
                
                <div class="back-home">
                    <a href="index.php"><i class="fas fa-arrow-left"></i> Volver a la página principal</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Efectos para botones sociales
        document.addEventListener('DOMContentLoaded', function() {
            const socialForms = document.querySelectorAll('.social-form');
            
            socialForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('.social-btn');
                    const provider = button.classList.contains('google') ? 'Google' : 'Facebook';
                    
                    // Agregar clase de loading
                    button.classList.add('loading');
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                    
                    // El formulario se enviará automáticamente después de este timeout
                    setTimeout(() => {
                        // Si por alguna razón el formulario no se envió, restaurar el botón
                        if (button.disabled) {
                            button.classList.remove('loading');
                            button.disabled = false;
                            button.innerHTML = `<i class="fab fa-${provider.toLowerCase()}"></i> Continuar con ${provider}`;
                        }
                    }, 3000);
                });
            });
        });
    </script>
</body>
</html>