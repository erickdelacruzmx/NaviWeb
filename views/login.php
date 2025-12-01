<?php
// La sesión ya fue iniciada por el controlador
// $login_errors viene del controlador si hay errores
// Cargar config Google (no expone secretos, sólo ID pública si existe)
require_once __DIR__ . '/../config/config_google.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Navi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js"></script>
    <style>
        html, body, *:not(i) {
            font-family: 'Poppins', 'Segoe UI', 'Roboto', Arial, sans-serif !important;
        }
        i {
            font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands' !important;
        }
    </style>
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
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 flex flex-col gap-6 animate-fade-in">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-extrabold text-blue-700 mb-2">¡Hola!</h1>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Iniciar Sesión</h2>
                <p class="text-gray-500">Bienvenido a Navi.</p>
            </div>
            
            <?php if (!empty($login_errors)): ?>
                <?php foreach ($login_errors as $error): ?>
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-2 border-l-4 border-red-500 text-sm"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (empty($login_errors)): ?>

            <?php endif; ?>
            
            <form method="POST" class="flex flex-col gap-4">
                <input type="hidden" name="login" value="1">
                <div>
                    <label for="login-email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" id="login-email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div>
                    <label for="login-password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" id="login-password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50" required>
                </div>
                
                <div class="text-right">
                    <a href="#" class="text-blue-600 hover:underline text-sm">¿Olvidaste tu contraseña?</a>
                </div>
                
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 via-pink-400 to-blue-900 text-white font-bold rounded-full shadow-lg hover:scale-105 hover:from-pink-500 hover:to-blue-800 transition-all duration-300">Ingresar</button>
            </form>
                
            <div class="mt-4">
                <p class="text-center text-gray-500 mb-3">Ingresa con</p>
                
                <div class="flex flex-col gap-3">
                    <!-- Google Sign-In Button (Personalizado) -->
                    <div id="googleSignInDiv"></div>
                    
                    <!-- Facebook Login Button -->
                    <button onclick="loginWithFacebook()" type="button" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-blue-600 transition-all duration-300 shadow-sm">
                        <i class="fab fa-facebook-f text-blue-600"></i>
                        Continuar con Facebook
                    </button>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-gray-500">¿No tienes cuenta? <a href="/NaviWeb/registro.php" class="text-blue-700 hover:underline font-semibold">Regístrate aquí</a></p>
            </div>
            
            <div class="text-center mt-2">
                <a href="/NaviWeb/index.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-700"><i class="fas fa-arrow-left"></i> Volver a la página principal</a>
            </div>
        </div>
    </div>

    <script>
        // Inicializar Facebook SDK
        window.fbAsyncInit = function() {
            FB.init({
                appId      : 'YOUR_FACEBOOK_APP_ID',
                cookie     : true,
                xfbml      : true,
                version    : 'v18.0'
            });
        };
        
        // Inicializar Google Sign-In
        window.onload = function () {
            const GOOGLE_CLIENT_ID = "<?php echo htmlspecialchars(defined('GOOGLE_CLIENT_ID') ? GOOGLE_CLIENT_ID : '', ENT_QUOTES, 'UTF-8'); ?>";
            if (!GOOGLE_CLIENT_ID) {
                console.warn('GOOGLE_CLIENT_ID vacío: define env vars o config_google_local.php');
            }
            google.accounts.id.initialize({
                client_id: GOOGLE_CLIENT_ID,
                callback: handleGoogleSignIn
            });
            google.accounts.id.renderButton(
                document.getElementById('googleSignInDiv'),
                { 
                    theme: 'outline', 
                    size: 'large',
                    width: 400,
                    text: 'continue_with'
                }
            );
        };
        
        // Manejar Google Sign-In
        function handleGoogleSignIn(response) {
            fetch('/NaviWeb/auth_google.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    credential: response.credential
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect || '/NaviWeb/app.php';
                } else {
                    alert('Error en la autenticación: ' + (data.error || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al conectar con el servidor: ' + error.message);
            });
        }
        
        // Manejar Facebook Login
        function loginWithFacebook() {
            FB.login(function(response) {
                if (response.authResponse) {
                    // Usuario autenticado exitosamente
                    FB.api('/me', {fields: 'name,email'}, function(userInfo) {
                        // Enviar datos al servidor
                        fetch('/NaviWeb/auth_facebook.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                accessToken: response.authResponse.accessToken,
                                user: userInfo
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('HTTP error! status: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect || '/NaviWeb/app.php';
                            } else {
                                alert('Error en la autenticación con Facebook');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al conectar con el servidor: ' + error.message);
                        });
                    });
                } else {
                    console.log('Usuario canceló el login de Facebook.');
                }
            }, {scope: 'public_profile,email'});
        }
    </script>
</body>
</html>