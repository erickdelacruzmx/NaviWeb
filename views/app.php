<?php
// La sesión ya fue iniciada por el controlador
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /login.php');
    exit;
}
$app_user_name = $_SESSION['user_name'] ?? 'Usuario';
$app_user_email = $_SESSION['user_email'] ?? 'usuario@ejemplo.com';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVI: Aprender Escuchando</title>
    <!-- Icono y hoja de íconos: rutas absoluta y relativa -->
    <link rel="icon" href="/NaviWeb/icon/Navi.svg" type="image/svg+xml">
    <link rel="icon" href="../icon/Navi.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/NaviWeb/icons.css">
    <link rel="stylesheet" href="../icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- CSS principal: intenta ruta absoluta y luego relativa para robustez en distintos despliegues -->
    <link rel="stylesheet" href="/NaviWeb/css/styles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body, html {
            font-family: 'Inter', 'Segoe UI', 'Roboto', Arial, sans-serif !important;
        }

        /* Switch Toggle Tutor/Navicito */
        .mode-switch {
            display: inline-flex !important;
            background: white !important;
            border: 4px solid #2B308B !important;
            border-radius: 50px !important;
            padding: 5px !important;
            box-shadow: 0 4px 16px rgba(43, 48, 139, 0.2) !important;
        }

        .mode-btn {
            padding: 14px 48px !important;
            border: none !important;
            border-radius: 50px !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            background: transparent !important;
            color: #2B308B !important;
        }

        .mode-btn.active {
            background: #2B308B !important;
            color: white !important;
            box-shadow: 0 3px 10px rgba(43, 48, 139, 0.4) !important;
        }

        .mode-btn:hover:not(.active) {
            background: rgba(43, 48, 139, 0.05) !important;
        }

        /* Efecto de pulso al hacer clic en el círculo */
        @keyframes pulse-circle {
            0% {
                transform: scale(1);
                box-shadow: 0 12px 40px rgba(43, 48, 139, 0.25);
            }
            50% {
                transform: scale(1.08);
                box-shadow: 0 0 0 25px rgba(43, 48, 139, 0.1), 0 0 0 50px rgba(43, 48, 139, 0.05), 0 12px 40px rgba(43, 48, 139, 0.4);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 12px 40px rgba(43, 48, 139, 0.25);
            }
        }

        .navi-circle-pulse {
            animation: pulse-circle 2s ease-in-out infinite;
        }

        .navi-circle:active {
            transform: scale(0.95);
        }

        /* Botón de acción en modal de juego */
        .modal-action-btn {
            background: linear-gradient(135deg,#1d4ed8,#2B308B);
            color: #fff;
            width: 100%;
            border: none;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: .5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all .35s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 6px 18px -4px rgba(43,48,139,.35), 0 2px 6px -1px rgba(0,0,0,.15);
            position: relative;
            overflow: hidden;
        }
        .modal-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px -6px rgba(43,48,139,.45), 0 4px 10px -2px rgba(0,0,0,.2);
            background: linear-gradient(135deg,#1e50d5,#232a7c);
        }
        .modal-action-btn:active {
            transform: translateY(0) scale(.98);
            box-shadow: 0 4px 14px -4px rgba(43,48,139,.4),0 2px 6px -2px rgba(0,0,0,.25);
        }
        .modal-action-btn:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 3px;
        }
        .modal-action-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 20%, rgba(255,255,255,.35), transparent 70%);
            opacity: .4;
            transition: opacity .35s;
            pointer-events: none;
        }
        .modal-action-btn:hover::after { opacity: .55; }
        .card-rosa {
            background: var(--color-2);
        }
        .card-verde {
            background: var(--color-3);
        }
        .card-amarillo {
            background: var(--color-4);
        }
        .card-azul {
            background: var(--color-6);
        }
    </style>
</head>
<body class="min-h-screen">
    <div id="app">
        
        <!-- Toast Notification -->
        <div class="toast-notification" :class="{ 'show': showToast }" v-text="toastMessage"></div>

        <!-- ============================================
             DESKTOP NAVIGATION - TOP BAR (>= 1024px)
             Solo visible en modo TUTOR
             ============================================ -->
        <nav v-if="currentMode === 'tutor' && currentSection !== 'navi'" class="hidden lg:flex items-center justify-between px-8 xl:px-12 py-3 bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="#" @click.prevent="changeSection('navi')" class="flex items-center">
                    <img src="/NaviWeb/images/NAVI2.png" alt="NAVI" class="h-12 w-12 object-contain hover:scale-105 transition-transform">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center gap-2">
                <a href="#" @click.prevent="changeSection('navi')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'navi' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-home text-lg"></i>
                    <span>Inicio</span>
                </a>
                <a href="#" @click.prevent="changeSection('juegos')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'juegos' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-gamepad text-lg"></i>
                    <span>Juegos</span>
                </a>
                <a href="#" @click.prevent="changeSection('biblioteca')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'biblioteca' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-book text-lg"></i>
                    <span>Biblioteca</span>
                </a>
                <a href="#" @click.prevent="changeSection('estadisticas')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'estadisticas' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span>Estadísticas</span>
                </a>
                <a href="#" @click.prevent="changeSection('configuracion')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'configuracion' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-cog text-lg"></i>
                    <span>Configuración</span>
                </a>
                <a href="#" @click.prevent="changeSection('perfil')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'perfil' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-user text-lg"></i>
                    <span>Perfil</span>
                </a>
            </div>

            <!-- User Info and Logout -->
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Hola, <strong class="text-gray-800"><?php echo htmlspecialchars($app_user_name); ?></strong></span>
                <a href="/NaviWeb/logout.php" class="text-red-500 hover:text-red-600 font-medium text-sm flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Salir</span>
                </a>
            </div>
        </nav>

        <!-- ============================================
             SECCIÓN: PERFIL
             ============================================ -->
        <div v-if="currentSection === 'perfil'" class="container mx-auto px-4 py-8 max-w-[95%] lg:max-w-[1200px]">
            <!-- Cabecera de perfil -->
            <section class="bg-white rounded-2xl shadow-lg p-4 md:p-6 lg:p-10 mb-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-4 md:gap-6 lg:gap-10 border-b border-gray-200 pb-4 md:pb-6 lg:pb-8 mb-4 md:mb-6 lg:mb-8">
                    <div class="w-20 md:w-28 h-20 md:h-28 rounded-full bg-navi-light flex items-center justify-center text-navi-blue text-3xl md:text-4xl shadow"><i class="fas fa-user"></i></div>
                    <div class="text-center md:text-left w-full">
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-navi-blue mb-2"><?php echo htmlspecialchars($app_user_name); ?></h1>
                        <p class="text-gray-600 mb-4 text-xs md:text-base"><?php echo htmlspecialchars($app_user_email); ?> • Miembro desde Enero 2024</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 md:gap-4">
                            <div class="text-center">
                                <div class="text-navi-blue font-bold text-lg md:text-xl">12</div>
                                <div class="text-gray-500 text-xs md:text-sm">Proyectos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-navi-blue font-bold text-lg md:text-xl">5</div>
                                <div class="text-gray-500 text-xs md:text-sm">Colaboradores</div>
                            </div>
                            <div class="text-center">
                                <div class="text-navi-blue font-bold text-lg md:text-xl">98%</div>
                                <div class="text-gray-500 text-xs md:text-sm">Actividad</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 md:gap-3">
                    <a href="#" class="bg-white text-navi-blue border-2 border-navi-blue px-4 md:px-5 py-2 md:py-3 rounded-xl font-semibold hover:bg-blue-700 hover:border-blue-700 hover:text-white hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-blue-400"><i class="fas fa-edit mr-2"></i>Editar Perfil</a>
                    <a href="#" class="bg-gray-100 text-gray-800 px-4 md:px-5 py-2 md:py-3 rounded-xl font-semibold hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400"><i class="fas fa-share-alt mr-2"></i>Compartir</a>
                    <a href="/NaviWeb/logout.php" class="bg-red-500 text-white px-4 md:px-5 py-2 md:py-3 rounded-xl font-semibold hover:bg-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-400"><i class="fas fa-sign-out-alt mr-2"></i>Salir</a>
                </div>
            </section>

            <!-- Preferencias -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-palette mr-2"></i>Personalización</h2>
                    <p class="text-gray-500 mb-4 md:mb-6">Personaliza tu experiencia en la plataforma.</p>
                    <div class="space-y-2 md:space-y-4">
                        <label class="flex items-center gap-2 md:gap-3"><input type="radio" name="theme" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue" checked> <span>Modo claro</span></label>
                        <label class="flex items-center gap-2 md:gap-3"><input type="radio" name="theme" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue"> <span>Modo oscuro</span></label>
                        <label class="flex items-center gap-2 md:gap-3"><input type="radio" name="theme" class="w-4 md:w-5 h-4 md:h-5 accent-navi-blue"> <span>Automático (según sistema)</span></label>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-language mr-2"></i>Idioma</h2>
                    <p class="text-gray-500 mb-4 md:mb-6">Selecciona tu idioma preferido.</p>
                    <select class="w-full border border-gray-300 rounded-xl px-3 md:px-4 py-2 md:py-3 focus:outline-none focus:ring-2 focus:ring-navi-blue">
                        <option>Español</option>
                        <option>English</option>
                    </select>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-volume-up mr-2"></i>Volumen</h2>
                    <p class="text-gray-500 mb-4 md:mb-6">Ajusta los niveles de audio del sistema.</p>
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
                <div class="bg-white rounded-2xl shadow p-6 lg:p-8">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-bold text-navi-blue mb-2 md:mb-4"><i class="fas fa-shield-alt mr-2"></i>Cuenta</h2>
                    <p class="text-gray-500 mb-4 md:mb-6">Acciones rápidas de cuenta</p>
                    <div class="flex flex-wrap gap-2 md:gap-3">
                        <a href="/configuracion.php" class="px-3 md:px-4 py-2 md:py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-gray-400">Ajustes</a>
                        <a href="/index.php" class="px-3 md:px-4 py-2 md:py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-gray-400">Inicio</a>
                    </div>
                </div>
            </section>
        </div>

        <!-- ============================================
             TOP BAR PARA INICIO EN MODO TUTOR
             Solo visible cuando estamos en inicio + modo tutor
             ============================================ -->
        <nav v-if="currentMode === 'tutor' && currentSection === 'navi'" class="hidden lg:flex items-center justify-between px-8 xl:px-12 py-3 bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="#" @click.prevent="changeSection('navi')" class="flex items-center">
                    <img src="/NaviWeb/images/NAVI2.png" alt="NAVI" class="h-12 w-12 object-contain hover:scale-105 transition-transform">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center gap-2">
                <a href="#" @click.prevent="changeSection('navi')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all bg-[#2B308B] text-white shadow-md">
                    <i class="fas fa-home text-lg"></i>
                    <span>Inicio</span>
                </a>
                <a href="#" @click.prevent="changeSection('juegos')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-gamepad text-lg"></i>
                    <span>Juegos</span>
                </a>
                <a href="#" @click.prevent="changeSection('biblioteca')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-book text-lg"></i>
                    <span>Biblioteca</span>
                </a>
                <a href="#" @click.prevent="changeSection('estadisticas')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span>Estadísticas</span>
                </a>
                <a href="#" @click.prevent="changeSection('configuracion')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-cog text-lg"></i>
                    <span>Configuración</span>
                </a>
                <a href="#" @click.prevent="changeSection('perfil')" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-medium text-base transition-all"
                   :class="currentSection === 'perfil' ? 'bg-[#2B308B] text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i class="fas fa-user text-lg"></i>
                    <span>Perfil</span>
                </a>
            </div>

            <!-- User Info and Logout -->
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Hola, <strong class="text-gray-800"><?php echo htmlspecialchars($app_user_name); ?></strong></span>
                <a href="/NaviWeb/logout.php" class="text-red-500 hover:text-red-600 font-medium text-sm flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Salir</span>
                </a>
            </div>
        </nav>

        <!-- ============================================
             SECCIÓN DEDICADA NAVI - Vista principal
             ============================================ -->
        <!-- ============================================
             SECCIÓN INICIO - Agente NAVI
             Siempre visible cuando currentSection === 'navi'
             ============================================ -->
        <div v-if="currentSection === 'navi'" 
             class="flex flex-col items-center bg-white px-4"
             :style="currentMode === 'tutor' ? 'height: calc(100vh - 73px); justify-content: space-evenly;' : 'height: 100vh; justify-content: space-evenly;'">
            
            <!-- Switch Tutor/Navicito - SIEMPRE VISIBLE -->
            <div class="flex-shrink-0">
                <div class="mode-switch">
                    <button class="mode-btn" :class="{active: currentMode === 'tutor'}" @click="currentMode = 'tutor'">
                        Tutor
                    </button>
                    <button class="mode-btn" :class="{active: currentMode === 'navicito'}" @click="currentMode = 'navicito'">
                        Navicito
                    </button>
                </div>
            </div>

            <!-- Avatar NAVI - SIEMPRE VISIBLE Y CLICKEABLE -->
            <div class="cursor-pointer rounded-full bg-white flex-shrink-0 navi-circle transition-transform" 
                 :class="{'talking': isTalking, 'navi-circle-pulse': isPulsing}"
                 @click="triggerPulse"
                 style="width: 250px; height: 250px; border: 10px solid #2B308B; box-shadow: 0 12px 40px rgba(43, 48, 139, 0.25);">
            </div>
            
            <!-- Texto descriptivo -->
            <p class="text-gray-600 text-center text-base md:text-lg lg:text-xl max-w-xl px-4 leading-relaxed flex-shrink-0">
                {{ naviMessage }}
            </p>
            
            <!-- Chat Input - SOLO EN MODO NAVICITO -->
            <div v-if="currentMode === 'navicito'" class="w-full max-w-md px-4 flex-shrink-0 mb-4 md:mb-6">
                <div class="flex gap-2">
                    <input 
                        v-model="navichatInput"
                        @keyup.enter="sendMessageToNavi"
                        type="text"
                        placeholder="Pregunta a Navi..."
                        :disabled="navichatLoading"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navi-blue focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed transition-all"
                        aria-label="Mensaje para Navi">
                    <button 
                        @click="sendMessageToNavi"
                        :disabled="navichatLoading || !navichatInput.trim()"
                        class="px-5 py-3 bg-navi-blue text-white rounded-lg font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
                        :aria-busy="navichatLoading"
                        title="Enviar mensaje a Navi">
                        <i :class="navichatLoading ? 'fas fa-spinner fa-spin' : 'fas fa-send'"></i>
                    </button>
                </div>
                <p v-if="navichatError" class="text-red-500 text-sm mt-2 text-center">{{ navichatError }}</p>
            </div>
            
            <!-- Historial de chat compacto (últimos 5 mensajes) -->
            <div v-if="currentMode === 'navicito' && navichatHistory.length > 0" class="w-full max-w-md px-4 flex-shrink-0 mb-4 bg-gray-50 rounded-lg p-4 max-h-32 overflow-y-auto border border-gray-200">
                <div v-for="(msg, idx) in navichatHistory.slice(-5)" :key="idx" class="mb-3 text-xs md:text-sm">
                    <span v-if="msg.role === 'user'" class="font-semibold text-navi-blue">Tú:</span>
                    <span v-else class="font-semibold text-green-600">Navi:</span>
                    <p class="text-gray-700 mt-1">{{ msg.content }}</p>
                </div>
            </div>
        </div>

        <!-- ============================================
             MAIN CONTENT AREA
             ============================================ -->
        <main class="container mx-auto px-4 md:px-6 lg:px-8 py-6 md:py-8 lg:py-10 pb-24 lg:pb-10 max-w-full md:max-w-[95%] lg:max-w-6xl xl:max-w-7xl 2xl:max-w-[1600px]" v-show="currentMode === 'tutor' && currentSection !== 'navi'">

            <!-- SECCIÓN: JUEGOS -->
            <div v-if="currentMode === 'tutor' && currentSection === 'juegos'" class="bg-white rounded-2xl shadow-lg p-5 md:p-6 lg:p-8 xl:p-10">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-navi-blue mb-3 md:mb-4 lg:mb-6">¡Vamos a jugar!</h2>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-8 lg:mb-10 leading-relaxed">
                    Selecciona una de las habilidades para ver y gestionar las actividades de juego disponibles.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-5 lg:gap-6">
                    
                    <!-- CATEGORÍA: Habilidad Comunicativa -->
                    <div class="category-card categoria-comunicativa rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col"
                        @click="openCategoryModal('habilidadComunicativa')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-comunicativa text-purple-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Habilidad Comunicativa</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Mejora tu expresión y comprensión</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                    <!-- CATEGORÍA: Exploración Auditiva -->
                    <div class="category-card categoria-auditiva rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col"
                        @click="openCategoryModal('exploracionAuditiva')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-auditiva text-pink-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Exploración Auditiva</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Reconoce y discrimina sonidos</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                    <!-- CATEGORÍA: Desarrollo Motor -->
                    <div class="category-card categoria-motor rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col"
                        @click="openCategoryModal('desarrolloMotor')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-motor text-yellow-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Desarrollo Motor</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Mejora tu orientación espacial</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                    <!-- CATEGORÍA: Habilidades Socioemocionales -->
                    <div class="category-card categoria-socioemocional rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col"
                        @click="openCategoryModal('habilidadesSocioemocionales')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-socioemocional text-teal-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Habilidades Socioemocionales</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Desarrolla empatía y habilidades sociales</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                </div>
            </div>

            <!-- SECCIÓN: BIBLIOTECA -->
            <div v-if="currentMode === 'tutor' && currentSection === 'biblioteca'" class="bg-white rounded-2xl shadow-lg p-5 md:p-6 lg:p-8 xl:p-10">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-navi-blue mb-3 md:mb-4 lg:mb-6">Biblioteca</h2>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-8 lg:mb-10 leading-relaxed">
                    Explora nuestra colección de recursos educativos.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-5 lg:gap-6">
                    
                    <!-- CANCIONES -->
                    <div class="category-card rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 categoria-canciones shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col" 
                         @click="openLibraryModal('canciones')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-canciones text-purple-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Canciones</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Para cantar y aprender</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                    <!-- CUENTOS -->
                    <div class="category-card rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 categoria-cuentos shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col" 
                         @click="openLibraryModal('cuentos')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-cuentos text-pink-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Cuentos</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Historias para escuchar</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                    <!-- SONIDOS DEL MUNDO -->
                    <div class="category-card rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 categoria-sonidos shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col" 
                         @click="openLibraryModal('sonidosdelmundo')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-sonidos text-yellow-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Sonidos del Mundo</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Explora diferentes sonidos</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                    <!-- FAVORITOS -->
                    <div class="category-card rounded-2xl p-5 lg:p-5 xl:p-6 2xl:p-7 categoria-favoritos shadow-md cursor-pointer hover:shadow-xl transition-shadow flex flex-col" 
                         @click="openLibraryModal('favoritos')">
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="category-icon-mask icon-favoritos text-teal-800 mb-4 lg:mb-5 xl:mb-5 2xl:mb-6"></div>
                            <h3 class="text-sm md:text-base lg:text-base xl:text-base 2xl:text-lg font-bold text-navi-blue mb-2 lg:mb-3 xl:mb-3 2xl:mb-4">Favoritos</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-sm xl:text-sm 2xl:text-sm">Tus favoritos guardados</p>
                        </div>
                        <div class="flex justify-end mt-4 lg:mt-4 xl:mt-5 2xl:mt-5">
                            <i class="fas fa-arrow-right text-navi-blue text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl"></i>
                        </div>
                    </div>

                </div>
            </div>

            <!-- SECCIÓN: ESTADÍSTICAS -->
            <div v-if="currentMode === 'tutor' && currentSection === 'estadisticas'" class="bg-white rounded-2xl shadow-lg p-5 md:p-6 lg:p-8 xl:p-10">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-navi-blue mb-3 md:mb-4 lg:mb-6">Estadísticas y Progreso</h2>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-8 lg:mb-10 leading-relaxed">
                    Visualiza el progreso y estadísticas de aprendizaje.
                </p>
                <div class="text-center text-gray-400 py-12 md:py-16 lg:py-20">
                    <i class="fas fa-chart-bar text-6xl md:text-7xl lg:text-8xl mb-4 md:mb-6 opacity-30"></i>
                    <p class="text-base md:text-lg lg:text-xl">Panel de estadísticas en desarrollo...</p>
                </div>
            </div>

            <!-- SECCIÓN: CONFIGURACIÓN -->
            <div v-if="currentMode === 'tutor' && currentSection === 'configuracion'" class="bg-white rounded-2xl shadow-lg p-5 md:p-6 lg:p-8 xl:p-10">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-navi-blue mb-3 md:mb-4 lg:mb-6">Configuración</h2>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-8 lg:mb-10 leading-relaxed">
                    Ajusta las preferencias de la aplicación.
                </p>
                <div class="text-center text-gray-400 py-12 md:py-16 lg:py-20">
                    <i class="fas fa-cog text-6xl md:text-7xl lg:text-8xl mb-4 md:mb-6 opacity-30 animate-spin-slow"></i>
                    <p class="text-base md:text-lg lg:text-xl">Panel de configuración en desarrollo...</p>
                </div>
            </div>

        </main>

        <!-- ============================================
             BOTTOM NAVIGATION - MOBILE/TABLET (< 1024px)
             Solo visible en modo TUTOR
             ============================================ -->
        <nav v-if="currentMode === 'tutor'" class="lg:hidden fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t border-gray-200 z-50 backdrop-blur-sm bg-opacity-95">
            <div class="flex justify-around items-center py-2 px-2 safe-area-inset-bottom">
                <a href="#" @click.prevent="changeSection('navi')" 
                   class="bottom-nav-link flex flex-col items-center gap-0.5 px-2 py-2 rounded-lg transition-all duration-200 flex-1 max-w-[80px]"
                   :class="{active: currentSection === 'navi'}">
                    <i class="fas fa-home text-xl md:text-2xl"></i>
                    <span class="text-[10px] md:text-xs font-medium mt-1">Inicio</span>
                </a>
                <a href="#" @click.prevent="changeSection('juegos')" 
                   class="bottom-nav-link flex flex-col items-center gap-0.5 px-2 py-2 rounded-lg transition-all duration-200 flex-1 max-w-[80px]"
                   :class="{active: currentSection === 'juegos'}">
                    <i class="fas fa-gamepad text-xl md:text-2xl"></i>
                    <span class="text-[10px] md:text-xs font-medium mt-1">Juegos</span>
                </a>
                <a href="#" @click.prevent="changeSection('biblioteca')" 
                   class="bottom-nav-link flex flex-col items-center gap-0.5 px-2 py-2 rounded-lg transition-all duration-200 flex-1 max-w-[80px]"
                   :class="{active: currentSection === 'biblioteca'}">
                    <i class="fas fa-book text-xl md:text-2xl"></i>
                    <span class="text-[10px] md:text-xs font-medium mt-1">Biblioteca</span>
                </a>
                <a href="#" @click.prevent="changeSection('estadisticas')" 
                   class="bottom-nav-link flex flex-col items-center gap-0.5 px-2 py-2 rounded-lg transition-all duration-200 flex-1 max-w-[80px]"
                   :class="{active: currentSection === 'estadisticas'}">
                    <i class="fas fa-chart-bar text-xl md:text-2xl"></i>
                    <span class="text-[10px] md:text-xs font-medium mt-1">Stats</span>
                </a>
                <a href="#" @click.prevent="changeSection('configuracion')" 
                   class="bottom-nav-link flex flex-col items-center gap-0.5 px-2 py-2 rounded-lg transition-all duration-200 flex-1 max-w-[80px]"
                   :class="{active: currentSection === 'configuracion'}">
                    <i class="fas fa-cog text-xl md:text-2xl"></i>
                    <span class="text-[10px] md:text-xs font-medium mt-1">Config</span>
                </a>
                <a href="#" @click.prevent="changeSection('perfil')" 
                   class="bottom-nav-link flex flex-col items-center gap-0.5 px-2 py-2 rounded-lg transition-all duration-200 flex-1 max-w-[80px]"
                   :class="{active: currentSection === 'perfil'}">
                    <i class="fas fa-user text-xl md:text-2xl"></i>
                    <span class="text-[10px] md:text-xs font-medium mt-1">Perfil</span>
                </a>
            </div>
        </nav>

        <!-- ============================================
             MODAL DE JUEGO
             ============================================ -->
           <div v-if="showModal" @click="closeGameModal" 
               class="fixed inset-0 bg-white bg-opacity-100 flex items-center justify-center p-4 z-[9999] backdrop-blur-sm">
              <div @click.stop class="rounded-2xl p-6 md:p-8 lg:p-10 max-w-sm md:max-w-md lg:max-w-lg w-full shadow-2xl transform transition-all" :class="getCategoryModalClass()">
                <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-navi-blue mb-3 md:mb-4 lg:mb-6">{{ selectedGame }}</h3>
                <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-8 lg:mb-10 leading-relaxed">{{ gameDescription }}</p>
                <button @click="closeGameModal"
                        class="modal-action-btn py-3 md:py-4 lg:py-5 px-6 text-base md:text-lg lg:text-xl"
                        aria-label="Comenzar juego {{ selectedGame }}">
                    <i class="fas fa-play"></i>
                    <span>Comenzar {{ selectedGame }}</span>
                </button>
            </div>
        </div>

        <!-- ============================================
             MODAL DE CATEGORÍA
             ============================================ -->
        <div v-if="showCategoryModal" @click="closeCategoryModal" 
             class="fixed inset-0 bg-white bg-opacity-100 flex items-center justify-center p-4 overflow-y-auto z-[9999] backdrop-blur-sm">
            <div @click.stop class="rounded-2xl p-5 md:p-6 lg:p-8 max-w-full md:max-w-3xl lg:max-w-5xl xl:max-w-6xl w-full shadow-2xl my-4 md:my-8" :class="getCategoryModalClass()">
                <!-- Header del Modal -->
                <div class="flex items-center justify-between mb-5 md:mb-6 lg:mb-8">
                    <div class="flex items-center gap-3 md:gap-4 lg:gap-5">
                        <div class="category-icon-mask flex-shrink-0" :class="getCategoryIcon()"></div>
                        <div class="min-w-0">
                            <h3 class="text-lg md:text-2xl lg:text-3xl font-bold text-navi-blue truncate">{{ getCategoryTitle() }}</h3>
                            <p class="text-gray-600 text-xs md:text-sm lg:text-base">{{ getCategoryDescription() }}</p>
                        </div>
                    </div>
                    <button @click="closeCategoryModal" class="text-gray-400 hover:text-gray-600 transition-colors min-w-[36px] md:min-w-[44px] min-h-[36px] md:min-h-[44px] flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-times text-xl md:text-2xl lg:text-3xl"></i>
                    </button>
                </div>

                <!-- Lista de Actividades -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-5">
                    <template v-for="(item, index) in getCategoryGames()" :key="index">
                        <div v-if="item.content"
                             class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 md:p-5 lg:p-6 border-2 border-gray-200 hover:border-navi-blue hover:shadow-lg transition-all cursor-pointer group active:scale-95"
                             @click="openGameModal(item.content, getCategoryGameDescription())">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="item-icon-mask flex-shrink-0" :class="getIconClass(item)"></div>
                                <span class="text-sm md:text-base lg:text-lg font-semibold text-navi-blue flex-1 group-hover:text-blue-700 transition-colors line-clamp-2">{{ item.content }}</span>
                                <i class="fas fa-play-circle text-navi-blue text-lg md:text-xl group-hover:text-blue-700 group-hover:scale-110 transition-all flex-shrink-0"></i>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- MODAL DE BIBLIOTECA -->
    <div v-if="showLibraryModal" @click="closeLibraryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" style="z-index: 9999;">
        <div @click.stop class="rounded-2xl shadow-2xl max-w-4xl lg:max-w-7xl xl:max-w-[90rem] 2xl:max-w-[100rem] w-full max-h-[85vh] overflow-y-auto" :class="getLibraryModalClass()">
            <div class="sticky top-0 border-b border-gray-200 p-6 lg:p-10 xl:p-12 2xl:p-16 flex items-center justify-between" :class="getLibraryModalClass()">
                <div class="flex items-center gap-4 lg:gap-6 xl:gap-8 2xl:gap-10">
                    <div class="category-icon-mask" :class="getLibraryIcon()"></div>
                    <div>
                        <h3 class="text-2xl lg:text-4xl xl:text-4xl 2xl:text-5xl font-bold text-navi-blue">{{ getLibraryTitle() }}</h3>
                        <p class="text-gray-600 text-sm lg:text-lg xl:text-xl 2xl:text-2xl">{{ getLibraryDescription() }}</p>
                    </div>
                </div>
                <button @click="closeLibraryModal" class="text-gray-400 hover:text-gray-600 transition-colors min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-2xl lg:text-4xl xl:text-4xl 2xl:text-5xl"></i>
                </button>
            </div>

            <!-- Lista de Contenido -->
            <div class="p-6 lg:p-10 xl:p-12 2xl:p-16">
                <!-- Estado vacío para favoritos -->
                <div v-if="currentLibraryCategory === 'favoritos' && getLibraryItems().length === 0" class="text-center text-gray-400 py-12 lg:py-20 xl:py-24 2xl:py-32">
                    <div class="category-icon-mask icon-favoritos mx-auto mb-3 lg:mb-6 xl:mb-8 2xl:mb-10 opacity-30"></div>
                    <p class="text-base md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">No tienes favoritos aún.<br>Marca algunos elementos en otras categorías.</p>
                </div>

                <!-- Grid de elementos -->
                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 xl:gap-8 2xl:gap-10">
                    <template v-for="(item, index) in getLibraryItems()" :key="index">
                        <div v-if="item.content"
                             class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 lg:p-6 xl:p-8 2xl:p-10 border-2 border-gray-200 hover:border-navi-blue hover:shadow-lg transition-all min-h-[70px] md:min-h-[80px] lg:min-h-[100px] xl:min-h-[120px] 2xl:min-h-[140px] active:scale-95">
                            <div class="flex items-center gap-3 lg:gap-5 xl:gap-6 2xl:gap-8">
                                <div class="item-icon-mask" :class="getIconClass(item)"></div>
                                <span class="text-base md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl font-semibold text-navi-blue flex-1">{{ item.content }}</span>
                                          <i :class="item.isFavorite ? 'fas fa-heart text-red-500' : 'far fa-heart text-gray-400'"
                                   class="cursor-pointer hover:scale-110 transition-transform text-lg md:text-xl lg:text-xl xl:text-2xl 2xl:text-2xl min-w-[44px] min-h-[44px] flex items-center justify-center active:scale-95"
                                   @click="toggleFavorite(item)"></i>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script>
    const { createApp } = Vue;

    // Datos iniciales
    const initialSongs = ["Uno, dos, tres", "ABC", "Cabeza, hombros, rodillas y pies", "A la Víbora de la Mar", "El Trenecito", "Si estás Feliz y lo sabes", "La Canción del Enojo", "Saco una Manita"];
    const initialStories = ["Los Tres Cerditos", "La Gallinita Roja", "La Liebre y la Tortuga", "El León y el Ratón"];
    const initialSounds = ["Animales", "Transporte", "Objetos Cotidianos", "Naturaleza"];
    
    createApp({
        data() {
            return {
                currentMode: 'tutor',
                currentSection: 'navi',
                activeCategory: null,
                showModal: false,
                showCategoryModal: false,
                showLibraryModal: false,
                currentCategory: null,
                currentLibraryCategory: null,
                selectedGame: '',
                gameDescription: '',
                showToast: false,
                toastMessage: '',
                isTalking: false,
                isPulsing: false,
                naviMessage: 'Hola, ¿en qué puedo ayudarte hoy?',
                
                // Chat con Gemini
                navichatEnabled: true,
                navichatLoading: false,
                navichatInput: '',
                navichatHistory: [],
                navichatError: null,
                navichatMaxHistory: 10,
                navichatAbortController: null,
                
                juegos: {
                    habilidadComunicativa: Array(8).fill(null).map(() => ({ content: '', editing: false, originalContent: '' })),
                    exploracionAuditiva: Array(6).fill(null).map(() => ({ content: '', editing: false, originalContent: '' })),
                    desarrolloMotor: Array(4).fill(null).map(() => ({ content: '', editing: false, originalContent: '' })),
                    habilidadesSocioemocionales: Array(3).fill(null).map(() => ({ content: '', editing: false, originalContent: '' }))
                },
                
                biblioteca: {
                    canciones: [],
                    cuentos: [],
                    sonidosdelmundo: [],
                    favoritos: []
                }
            }
        },
        
        methods: {
            triggerPulse() {
                // Activar efecto de pulso
                this.isPulsing = true;
                
                // Quitar el pulso después de 10 segundos (simulando escucha)
                setTimeout(() => {
                    this.isPulsing = false;
                }, 10000);
                
                // Ejecutar la lógica de clic
                this.handleNaviClick();
            },
            
            handleNaviClick() {
                // Activar animación de "hablando"
                this.isTalking = true;
                
                // Mensajes de respuesta aleatorios
                const messages = [
                    '¡Hola! Estoy aquí para ayudarte a aprender.',
                    '¿Quieres explorar alguna actividad?',
                    '¡Me encanta aprender contigo!',
                    '¿En qué te puedo ayudar hoy?',
                    '¡Vamos a divertirnos aprendiendo!',
                    'Puedes explorar juegos, canciones y mucho más.',
                    '¡Estoy listo para ayudarte!'
                ];
                
                // Cambiar mensaje aleatoriamente
                this.naviMessage = messages[Math.floor(Math.random() * messages.length)];
                
                // Desactivar animación después de 3 segundos
                setTimeout(() => {
                    this.isTalking = false;
                    this.naviMessage = 'Hola, ¿en qué puedo ayudarte hoy?';
                }, 3000);
            },
            
            /**
             * Enviar mensaje a NAVI vía Gemini API
             */
            async sendMessageToNavi() {
                const message = this.navichatInput.trim();
                if (!message || this.navichatLoading) return;
                
                // Agregar mensaje del usuario al historial
                this.navichatHistory.push({
                    role: 'user',
                    content: message
                });
                
                // Limpiar input y mostrar loading
                this.navichatInput = '';
                this.navichatLoading = true;
                this.isPulsing = true;
                this.isTalking = true;
                this.navichatError = null;
                
                try {
                    // Preparar payload
                    const payload = {
                        message: message,
                        history: this.navichatHistory.slice(-this.navichatMaxHistory)
                    };
                    
                    // Crear AbortController para permitir cancelar
                    this.navichatAbortController = new AbortController();
                    
                    // Llamar backend
                    const response = await fetch('/NaviWeb/api/navi-chat.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload),
                        signal: this.navichatAbortController.signal
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    
                    const data = await response.json();
                    
                    if (!data.success) {
                        throw new Error(data.error || 'Error desconocido');
                    }
                    
                    // Agregar respuesta de NAVI al historial
                    const naviResponse = data.response;
                    this.navichatHistory.push({
                        role: 'assistant',
                        content: naviResponse
                    });
                    
                    // Mostrar respuesta en el avatar
                    this.naviMessage = naviResponse;
                    
                } catch (error) {
                    // Si fue cancelado por el usuario, no mostrar error
                    if (error.name === 'AbortError') {
                        this.navichatError = 'Solicitud cancelada';
                    } else {
                        console.error('Error en chat:', error);
                        this.navichatError = 'No pude procesar tu mensaje. Intenta de nuevo.';
                        this.naviMessage = this.navichatError;
                    }
                } finally {
                    this.navichatLoading = false;
                    this.isTalking = false;
                    
                    // Quitar pulso después de 5 segundos
                    setTimeout(() => {
                        this.isPulsing = false;
                    }, 5000);
                }
            },
            
            /**
             * Cancelar solicitud en progreso
             */
            cancelNaviChat() {
                if (this.navichatAbortController) {
                    this.navichatAbortController.abort();
                }
                this.navichatLoading = false;
                this.isPulsing = false;
                this.isTalking = false;
            },
            
            /**
             * Limpiar historial de chat
             */
            clearNaviHistory() {
                this.navichatHistory = [];
                this.navichatError = null;
                this.naviMessage = 'Hola, ¿en qué puedo ayudarte hoy?';
            },
            
            changeSection(section) {
                this.currentSection = section;
                this.activeCategory = null;
            },
            
            // Métodos para modal de biblioteca
            openLibraryModal(category) {
                this.currentLibraryCategory = category;
                this.showLibraryModal = true;
            },
            
            closeLibraryModal() {
                this.showLibraryModal = false;
                this.currentLibraryCategory = null;
            },
            
            getLibraryTitle() {
                const titles = {
                    'canciones': 'Canciones',
                    'cuentos': 'Cuentos',
                    'sonidosdelmundo': 'Sonidos del Mundo',
                    'favoritos': 'Favoritos'
                };
                return titles[this.currentLibraryCategory] || '';
            },
            
            getLibraryDescription() {
                const descriptions = {
                    'canciones': 'Explora canciones interactivas para aprender y divertirte',
                    'cuentos': 'Descubre historias mágicas y educativas',
                    'sonidosdelmundo': 'Escucha y aprende sonidos del entorno',
                    'favoritos': 'Tus elementos favoritos guardados'
                };
                return descriptions[this.currentLibraryCategory] || '';
            },
            
            getLibraryIcon() {
                const icons = {
                    'canciones': 'icon-canciones',
                    'cuentos': 'icon-cuentos',
                    'sonidosdelmundo': 'icon-sonidos',
                    'favoritos': 'icon-favoritos'
                };
                return icons[this.currentLibraryCategory] || '';
            },
            
            getLibraryItems() {
                if (!this.currentLibraryCategory) return [];
                return this.biblioteca[this.currentLibraryCategory] || [];
            },
            
            toggleCategory(categoryKey) {
                this.activeCategory = this.activeCategory === categoryKey ? null : categoryKey;
            },
            
            openCategoryModal(category) {
                this.currentCategory = category;
                this.showCategoryModal = true;
            },
            
            closeCategoryModal() {
                this.showCategoryModal = false;
                this.currentCategory = null;
            },
            
            getCategoryTitle() {
                const titles = {
                    'habilidadComunicativa': 'Habilidad Comunicativa',
                    'exploracionAuditiva': 'Exploración Auditiva',
                    'desarrolloMotor': 'Desarrollo Motor',
                    'habilidadesSocioemocionales': 'Habilidades Socioemocionales'
                };
                return titles[this.currentCategory] || '';
            },
            
            getCategoryDescription() {
                const descriptions = {
                    'habilidadComunicativa': 'Mejora tu expresión y comprensión',
                    'exploracionAuditiva': 'Reconoce y discrimina sonidos',
                    'desarrolloMotor': 'Mejora tu orientación espacial',
                    'habilidadesSocioemocionales': 'Desarrolla empatía y habilidades sociales'
                };
                return descriptions[this.currentCategory] || '';
            },
            
            getCategoryIcon() {
                const icons = {
                    'habilidadComunicativa': 'icon-comunicativa text-purple-800',
                    'exploracionAuditiva': 'icon-auditiva text-pink-800',
                    'desarrolloMotor': 'icon-motor text-yellow-800',
                    'habilidadesSocioemocionales': 'icon-socioemocional text-teal-800'
                };
                return icons[this.currentCategory] || '';
            },
            
            getCategoryGames() {
                return this.juegos[this.currentCategory] || [];
            },
            
            getCategoryGameDescription() {
                const descriptions = {
                    'habilidadComunicativa': 'Actividad para fomentar la expresión verbal y comunicación efectiva.',
                    'exploracionAuditiva': 'Actividad para mejorar la identificación y discriminación sonora.',
                    'desarrolloMotor': 'Actividad para mejorar la orientación espacial y coordinación.',
                    'habilidadesSocioemocionales': 'Actividad para desarrollar inteligencia emocional y habilidades sociales.'
                };
                return descriptions[this.currentCategory] || '';
            },
            
            getCategoryModalClass() {
                const classes = {
                    'habilidadComunicativa': 'categoria-comunicativa',
                    'exploracionAuditiva': 'categoria-auditiva',
                    'desarrolloMotor': 'categoria-motor',
                    'habilidadesSocioemocionales': 'categoria-socioemocional'
                };
                return classes[this.currentCategory] || 'bg-white';
            },
            
            getLibraryModalClass() {
                const classes = {
                    'canciones': 'categoria-canciones',
                    'cuentos': 'categoria-cuentos',
                    'sonidosdelmundo': 'categoria-sonidos',
                    'favoritos': 'categoria-favoritos'
                };
                return classes[this.currentLibraryCategory] || 'bg-white';
            },
            
            openGameModal(gameTitle, description) {
                if (!gameTitle) return;
                this.selectedGame = gameTitle;
                this.gameDescription = description;
                this.showModal = true;
                this.showCategoryModal = false;
            },
            
            closeGameModal() {
                this.showModal = false;
                this.selectedGame = '';
                this.gameDescription = '';
            },
            
            toggleFavorite(item) {
                item.isFavorite = !item.isFavorite;
                
                if (item.isFavorite) {
                    this.biblioteca.favoritos.push(item);
                    this.toastMessage = `"${item.content}" ha sido guardado a tus Favoritos.`;
                } else {
                    const index = this.biblioteca.favoritos.findIndex(fav => fav.id === item.id);
                    if (index !== -1) {
                        this.biblioteca.favoritos.splice(index, 1);
                    }
                    this.toastMessage = `"${item.content}" ha sido eliminado de tus Favoritos.`;
                }
                
                this.showToast = true;
                setTimeout(() => {
                    this.showToast = false;
                }, 3000);
            },
            
            getIconClass(item) {
                const normalize = (str) => (str || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                const content = normalize(item.content);
                
                // Iconos de juegos - Habilidad Comunicativa
                if (content.includes('sonoros')) return 'icon-sonido';
                if (content.includes('tactil')) return 'icon-tactil';
                if (content.includes('navi') || content.includes('conversacion')) return 'icon-robot';
                if (content.includes('rimas')) return 'icon-ritmo';
                if (content.includes('dictado')) return 'icon-escritura';
                if (content.includes('lectura')) return 'icon-libro';
                if (content.includes('karaoke')) return 'icon-karaoke';
                if (content.includes('preguntas')) return 'icon-preguntas';
                
                // Iconos de juegos - Exploración Auditiva
                if (content.includes('ambiental')) return 'icon-ambiental';
                if (content.includes('secuencia')) return 'icon-secuencia';
                if (content.includes('asociacion')) return 'icon-asociacion';
                if (content.includes('espacial')) return 'icon-espacial';
                if (content.includes('persecusion') || content.includes('ritmo')) return 'icon-persecusion';
                if (content.includes('instrumentos')) return 'icon-instrumentos';
                
                // Iconos de juegos - Desarrollo Motor
                if (content.includes('seguimiento')) return 'icon-seguimiento';
                if (content.includes('cubos')) return 'icon-cubos';
                if (content.includes('bloques') || content.includes('braille')) return 'icon-bloques';
                if (content.includes('descubriendo') || content.includes('medio')) return 'icon-descubriendo';
                
                // Iconos de juegos - Habilidades Socioemocionales
                if (content.includes('diario')) return 'icon-diario';
                if (content.includes('emocional')) return 'icon-emocional';
                if (content.includes('equipo')) return 'icon-equipo';
                
                // Iconos de biblioteca - Canciones
                if (content.includes('unodos') || content.includes('uno')) return 'icon-unodos';
                if (content.includes('abc')) return 'icon-abc';
                if (content.includes('cabeza') || content.includes('hombros')) return 'icon-cabeza';
                if (content.includes('vibora')) return 'icon-vibora';
                if (content.includes('trenecito') || content.includes('tren')) return 'icon-trenecito';
                if (content.includes('feliz')) return 'icon-feliz';
                if (content.includes('enojo')) return 'icon-enojo';
                if (content.includes('manita') || content.includes('mano')) return 'icon-manita';
                
                // Iconos de biblioteca - Cuentos
                if (content.includes('cerditos') || content.includes('cerdo')) return 'icon-cerditos';
                if (content.includes('gallinita') || content.includes('gallina')) return 'icon-gallinita';
                if (content.includes('liebre') || content.includes('tortuga')) return 'icon-liebre';
                if (content.includes('leon') || content.includes('raton')) return 'icon-raton';
                
                // Iconos de biblioteca - Sonidos del Mundo
                if (content.includes('animales')) return 'icon-animales';
                if (content.includes('transporte')) return 'icon-transporte';
                if (content.includes('objetos') || content.includes('cotidiano')) return 'icon-objetos';
                if (content.includes('natural') || content.includes('naturaleza')) return 'icon-natural';
                
                // Default - usar icono de categoría según el contexto
                return 'icon-default';
            },
            
            initializeLibraryData(contentArray, categoryKey) {
                return contentArray.map((content, index) => ({
                    id: `${categoryKey}-${index}`,
                    content: content,
                    category: categoryKey,
                    editing: false,
                    originalContent: content,
                    isFavorite: false
                }));
            }
        },
        
        watch: {
            currentMode(newMode) {
                // Cuando se cambia a modo Navicito, ir a la sección NAVI
                if (newMode === 'navicito') {
                    this.currentSection = 'navi';
                }
            }
        },
        
        mounted() {
            // Leer sección inicial desde query ?section= o hash #perfil
            try {
                const url = new URL(window.location.href);
                const sectionParam = url.searchParams.get('section');
                const hash = window.location.hash ? window.location.hash.replace('#','') : null;
                const target = sectionParam || hash;
                const valid = ['navi','juegos','biblioteca','estadisticas','configuracion','perfil'];
                if (target && valid.includes(target)) {
                    this.currentSection = target;
                }
            } catch (e) { /* noop */ }

            // Inicializar juegos
            this.juegos.habilidadComunicativa[0].content = "Juegos Sonoros";
            this.juegos.habilidadComunicativa[1].content = "Exploración Táctil Sonora";
            this.juegos.habilidadComunicativa[2].content = "Conversación con Navi";
            this.juegos.habilidadComunicativa[3].content = "Rimas Auditivas";
            this.juegos.habilidadComunicativa[4].content = "Dictado Rítmico";
            this.juegos.habilidadComunicativa[5].content = "Lectura Auditiva";
            this.juegos.habilidadComunicativa[6].content = "Karaoke";
            this.juegos.habilidadComunicativa[7].content = "Preguntas y Respuestas";

            this.juegos.exploracionAuditiva[0].content = "Sonidos Ambientales";
            this.juegos.exploracionAuditiva[1].content = "Secuencias Sonoras";
            this.juegos.exploracionAuditiva[2].content = "Asociación Sonido-Emoción";
            this.juegos.exploracionAuditiva[3].content = "Sonido Espacial";
            this.juegos.exploracionAuditiva[4].content = "Ritmo y Persecusión";
            this.juegos.exploracionAuditiva[5].content = "Instrumentos Musicales";

            this.juegos.desarrolloMotor[0].content = "Seguimiento Sonoro";
            this.juegos.desarrolloMotor[1].content = "Cubos y Prismas";
            this.juegos.desarrolloMotor[2].content = "Bloques Braille";
            this.juegos.desarrolloMotor[3].content = "Descubriendo el Medio";
            
            this.juegos.habilidadesSocioemocionales[0].content = "Diario Personal";
            this.juegos.habilidadesSocioemocionales[1].content = "Navi Emocional";
            this.juegos.habilidadesSocioemocionales[2].content = "Actividades de Equipo";

            // Inicializar biblioteca
            this.biblioteca.canciones = this.initializeLibraryData(initialSongs, 'canciones');
            this.biblioteca.cuentos = this.initializeLibraryData(initialStories, 'cuentos');
            this.biblioteca.sonidosdelmundo = this.initializeLibraryData(initialSounds, 'sonidosdelmundo');
        }
    }).mount('#app');
    </script>
</body>
</html>


















































































