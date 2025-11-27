<?php
require_once __DIR__ . '/config/config_db.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /login.php');
    exit();
}

$usuario = [
    'nombre' => $_SESSION['user_name'] ?? 'Usuario',
    'email' => $_SESSION['user_email'] ?? 'usuario@ejemplo.com',
    'fecha_registro' => $_SESSION['fecha_registro'] ?? 'Enero 2024',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración | NAVI</title>
    <link rel="icon" href="/icon/Navi.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html, body, * {
            font-family: 'Poppins', 'Segoe UI', 'Roboto', Arial, sans-serif !important;
        }
        .desktop-nav-link {
            transition: all 0.3s ease;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            color: #666;
            text-decoration: none;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
        }
    </style>
        @media (min-width: 1280px) {
            .desktop-nav-link {
                padding: 14px 32px;
                border-radius: 12px;
                min-height: 56px;
            }
        }
        .desktop-nav-link:hover {
            background: #E8EBFF;
            color: #2B308B;
        }
        .desktop-nav-link.active {
            background: #2B308B;
            color: white !important;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white" style="font-family: Poppins, system-ui, -apple-system, Segoe UI, Roboto, sans-serif;">
    <!-- Top bar -->
    <nav class="flex flex-col lg:flex-row items-center justify-between px-4 md:px-8 xl:px-12 py-4 md:py-5 xl:py-6 bg-white shadow-md sticky top-0 z-50 gap-2 md:gap-0">
        <div class="flex items-center gap-6 xl:gap-8">
            <a href="/app.php" class="group">
                <div class="w-10 md:w-12 xl:w-16 h-10 md:h-12 xl:h-16 rounded-full bg-white shadow-md flex items-center justify-center group-hover:shadow-lg transition-shadow">
                    <img src="/images/NAVI2.png" alt="NAVI" class="w-8 md:w-10 xl:w-14 h-8 md:h-10 xl:h-14 object-contain">
                </div>
            </a>
            <div class="flex gap-3 xl:gap-4">
                <a href="/app.php" class="desktop-nav-link text-sm md:text-base xl:text-xl 2xl:text-2xl"><i class="fas fa-home mr-1 md:mr-2 xl:mr-3 2xl:mr-4"></i>Inicio</a>
                <a href="/app.php" class="desktop-nav-link text-sm md:text-base xl:text-xl 2xl:text-2xl"><i class="fas fa-gamepad mr-1 md:mr-2 xl:mr-3 2xl:mr-4"></i>Juegos</a>
                <a href="/app.php" class="desktop-nav-link text-sm md:text-base xl:text-xl 2xl:text-2xl"><i class="fas fa-book mr-1 md:mr-2 xl:mr-3 2xl:mr-4"></i>Biblioteca</a>
                <a href="/configuracion.php" class="desktop-nav-link active text-sm md:text-base xl:text-xl 2xl:text-2xl"><i class="fas fa-cog mr-1 md:mr-2 xl:mr-3 2xl:mr-4"></i>Configuración</a>
                <a href="/NaviWeb/app.php?section=perfil" class="desktop-nav-link text-sm md:text-base xl:text-xl 2xl:text-2xl"><i class="fas fa-user mr-1 md:mr-2 xl:mr-3 2xl:mr-4"></i>Perfil</a>
            </div>
        </div>
        <div class="flex items-center gap-4 xl:gap-5 2xl:gap-6">
            <span class="text-xs md:text-sm xl:text-base 2xl:text-lg text-gray-600">Hola, <strong><?php echo htmlspecialchars($usuario['nombre']); ?></strong></span>
            <a href="/logout.php" class="text-red-500 hover:underline text-xs md:text-sm xl:text-base 2xl:text-lg focus:outline-none focus:ring-2 focus:ring-red-400 rounded"><i class="fas fa-sign-out-alt mr-1"></i>Salir</a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container mx-auto px-4 py-8 max-w-[95%] lg:max-w-[1200px]">
        <!-- Encabezado simple de configuración -->
        <section class="bg-white rounded-2xl shadow-lg p-4 md:p-6 lg:p-10 mb-8">
            <div class="flex items-center md:items-start gap-3 md:gap-5 lg:gap-8">
                <div class="w-10 md:w-14 h-10 md:h-14 rounded-xl bg-navi-light text-navi-blue flex items-center justify-center text-xl md:text-2xl"><i class="fas fa-cog"></i></div>
                <div>
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-navi-blue mb-1 md:mb-2">Configuración</h1>
                    <p class="text-gray-600 text-xs md:text-base">Ajusta tus preferencias y la apariencia de la plataforma</p>
                </div>
            </div>
        </section>

        <!-- Tarjetas de configuración -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <!-- General -->
            <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-sliders-h mr-2"></i>General</h2>
                <p class="text-gray-500 mb-4 md:mb-6">Opciones básicas de seguridad y preferencias.</p>
                <div class="space-y-2 md:space-y-4">
                    <label class="flex items-center gap-2 md:gap-3"><input type="checkbox" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue"> <span>Autenticación de dos factores</span></label>
                    <label class="flex items-center gap-2 md:gap-3"><input type="checkbox" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue" checked> <span>Mostrar sesiones activas</span></label>
                </div>
                <div class="mt-4 md:mt-6">
                    <button class="bg-navi-blue text-white px-4 md:px-5 py-2 md:py-3 rounded-xl font-semibold hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-400"><i class="fas fa-save mr-2"></i>Guardar</button>
                </div>
            </div>

            <!-- Personalización -->
            <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-palette mr-2"></i>Personalización</h2>
                <p class="text-gray-500 mb-4 md:mb-6">Elige tema y ajustes visuales.</p>
                <div class="space-y-2 md:space-y-4">
                    <label class="flex items-center gap-2 md:gap-3"><input type="radio" name="theme" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue" checked> <span>Modo claro</span></label>
                    <label class="flex items-center gap-2 md:gap-3"><input type="radio" name="theme" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue"> <span>Modo oscuro</span></label>
                    <label class="flex items-center gap-2 md:gap-3"><input type="radio" name="theme" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue"> <span>Automático (según sistema)</span></label>
                </div>
            </div>

            <!-- Idioma -->
            <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-language mr-2"></i>Idioma</h2>
                <p class="text-gray-500 mb-4 md:mb-6">Selecciona tu idioma preferido</p>
                <select class="w-full border border-gray-300 rounded-xl px-3 md:px-4 py-2 md:py-3 focus:outline-none focus:ring-2 focus:ring-navi-blue">
                    <option>Español</option>
                    <option>English</option>
                    <option>Français</option>
                    <option>Português</option>
                </select>
            </div>

            <!-- Volumen -->
            <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-volume-up mr-2"></i>Volumen</h2>
                <p class="text-gray-500 mb-4 md:mb-6">Ajusta niveles de audio del sistema</p>
                <div class="space-y-4 md:space-y-6">
                    <div>
                        <div class="font-semibold mb-1 md:mb-2">Volumen principal</div>
                        <input type="range" min="0" max="100" value="75" class="w-full accent-navi-blue focus:outline-none focus:ring-2 focus:ring-navi-blue">
                    </div>
                    <div>
                        <div class="font-semibold mb-1 md:mb-2">Notificaciones</div>
                        <input type="range" min="0" max="100" value="60" class="w-full accent-navi-blue focus:outline-none focus:ring-2 focus:ring-navi-blue">
                    </div>
                    <div>
                        <div class="font-semibold mb-1 md:mb-2">Sonidos del sistema</div>
                        <input type="range" min="0" max="100" value="40" class="w-full accent-navi-blue focus:outline-none focus:ring-2 focus:ring-navi-blue">
                    </div>
                </div>
            </div>

            <!-- Cuenta -->
            <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-user-cog mr-2"></i>Cuenta</h2>
                <p class="text-gray-500 mb-4 md:mb-6">Accesos y acciones de cuenta</p>
                <div class="flex flex-wrap gap-2 md:gap-3">
                    <a href="/NaviWeb/app.php?section=perfil" class="px-3 md:px-4 py-2 md:py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-gray-400"><i class="fas fa-user mr-2"></i>Ir a Perfil</a>
                    <a href="/logout.php" class="px-3 md:px-4 py-2 md:py-3 rounded-xl bg-red-500 text-white hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400"><i class="fas fa-sign-out-alt mr-2"></i>Salir</a>
                </div>
            </div>
        </section>

        <footer class="text-center text-gray-500 text-sm mt-10">&copy; 2025 NAVI. Todos los derechos reservados.</footer>
        <footer class="text-center text-gray-500 text-xs md:text-sm mt-8 md:mt-10">&copy; 2025 NAVI. Todos los derechos reservados.</footer>
    </main>
</body>
</html>