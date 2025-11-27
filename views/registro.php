<?php
    // La sesión ya fue iniciada por el controlador
    // $registro_errors viene del controlador si hay errores
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Tutor - Navi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/NaviWeb/css/styles.css">
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
        /* Forzar que el botón de Google tenga el mismo tamaño que Facebook */
        /* Ocultar One Tap completamente */
        #credential_picker_container,
        #credential_picker_iframe {
            display: none !important;
        }
    </style>
</head>
<body>
    
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-white py-12 px-4">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 flex flex-col gap-6">
                <div class="text-center mb-4">
                    <h1 class="text-3xl font-bold text-blue-700 mb-2">¡Bienvenido a Navi!</h1>
                    <p class="text-gray-500">Aprende escuchando.</p>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Regístrate</h2>
                </div>
                <?php if (!empty($registro_errors)): ?>
                    <?php foreach ($registro_errors as $error): ?>
                        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-2 border-l-4 border-red-500 text-sm"><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form method="POST" class="flex flex-col gap-4">
                    <input type="hidden" name="register" value="1">
                    <div>
                        <label for="register-name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                        <input type="text" id="register-name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div>
                        <label for="register-email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" id="register-email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div>
                        <label for="register-password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" id="register-password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="register-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                        <input type="password" id="register-confirm-password" name="confirm_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-700 text-white font-bold rounded-lg shadow hover:bg-blue-800 transition">Registrarme</button>
                </form>
                <div class="mt-4">
                    <p class="text-center text-gray-500 mb-4">O regístrate con</p>
                    <div class="flex flex-col gap-3">
                        <!-- Google Sign-In Button (Custom) -->
                        <button onclick="handleGoogleLogin()" type="button" class="w-full flex items-center justify-center gap-2 px-4 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-blue-600 transition-all duration-300 shadow-sm" style="height: 52px;">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Registrarse con Google
                        </button>
                        
                        <!-- Facebook Login Button -->
                        <button onclick="registerWithFacebook()" type="button" class="w-full flex items-center justify-center gap-2 px-4 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-blue-600 transition-all duration-300 shadow-sm" style="height: 52px;">
                            <i class="fab fa-facebook-f text-blue-600"></i>
                            Registrarse con Facebook
                        </button>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p class="text-gray-500">¿Ya tienes cuenta? <a href="/NaviWeb/login.php" class="text-blue-700 hover:underline font-semibold">Inicia sesión aquí</a></p>
                </div>
                <div class="text-center mt-2">
                    <a href="/NaviWeb/index.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-700"><i class="fas fa-arrow-left"></i> Volver a la página principal</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializar Google Sign-In (GSI) y renderizar botón nativo
        let tokenClient;
        
        window.onload = function() {
            // Solo usar OAuth popup, sin FedCM
            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: "REDACTED_GOOGLE_CLIENT_ID",
                scope: 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
                callback: (tokenResponse) => {
                    if (tokenResponse.access_token) {
                        getUserInfo(tokenResponse.access_token);
                    } else {
                        console.error('No se recibió access token');
                    }
                },
                error_callback: (error) => {
                    console.error('Error en OAuth:', error);
                    alert('Error al autenticar con Google');
                }
            });
        };
        
        // Función para manejar clic en botón personalizado de Google
        function handleGoogleLogin() {
            // Abrir popup OAuth directamente
            tokenClient.requestAccessToken({prompt: 'select_account'});
        }
        
        // Obtener información del usuario con access token
        function getUserInfo(accessToken) {
            fetch('https://www.googleapis.com/oauth2/v2/userinfo', {
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                }
            })
            .then(response => response.json())
            .then(userInfo => {
                // Enviar info al backend
                fetch('/NaviWeb/auth_google.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: userInfo.email,
                        name: userInfo.name,
                        picture: userInfo.picture,
                        google_id: userInfo.id,
                        access_token: accessToken
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/NaviWeb/app.php';
                    } else {
                        alert('Error al registrarse con Google: ' + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al procesar el registro con Google');
                });
            })
            .catch(error => {
                console.error('Error obteniendo info del usuario:', error);
                alert('Error al obtener información de Google');
            });
        }
        
        // Manejar respuesta de Google Sign-In (por si se usa desde login.php)
        function handleGoogleSignIn(response) {
            fetch('/NaviWeb/auth_google.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'credential=' + response.credential
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/NaviWeb/app.php';
                } else {
                    alert('Error al registrarse con Google: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar el registro con Google');
            });
        }

        // Manejar respuesta de Google Sign-In
        function handleGoogleSignIn(response) {
            fetch('/NaviWeb/auth_google.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'credential=' + response.credential
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_existing_user) {
                        alert('¡Bienvenido de nuevo, ' + data.user.name + '! Ya tenías una cuenta registrada.');
                    } else {
                        alert('¡Registro exitoso! Bienvenido, ' + data.user.name);
                    }
                    setTimeout(() => {
                        window.location.href = '/NaviWeb/app.php';
                    }, 1000);
                } else {
                    alert('Error al registrarse con Google: ' + (data.error || data.message));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar el registro con Google');
            });
        }

        // Inicializar Facebook SDK
        window.fbAsyncInit = function() {
            FB.init({
                appId      : 'YOUR_FACEBOOK_APP_ID', // Reemplazar con tu App ID de Facebook
                cookie     : true,
                xfbml      : true,
                version    : 'v18.0'
            });
        };

        // Función para registrarse con Facebook
        function registerWithFacebook() {
            FB.login(function(response) {
                if (response.authResponse) {
                    FB.api('/me', {fields: 'name,email,picture'}, function(response) {
                        fetch('/NaviWeb/auth_facebook.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                name: response.name,
                                email: response.email,
                                picture: response.picture.data.url
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.is_existing_user) {
                                    alert('¡Bienvenido de nuevo, ' + data.user.name + '! Ya tenías una cuenta registrada.');
                                } else {
                                    alert('¡Registro exitoso! Bienvenido, ' + data.user.name);
                                }
                                setTimeout(() => {
                                    window.location.href = '/NaviWeb/app.php';
                                }, 1000);
                            } else {
                                alert('Error al registrarse con Facebook: ' + (data.error || data.message));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al procesar el registro con Facebook');
                        });
                    });
                }
            }, {scope: 'public_profile,email'});
        }
    </script>
</body>
</html>