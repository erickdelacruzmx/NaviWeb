<?php
// Solo carga el router para redirección, pero no muestra el login aquí
require_once __DIR__ . '/app/Router.php';
// El router solo gestiona rutas, no debe renderizar el login aquí
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navi - Plataforma Educativa para Niños Ciegos</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Fuente Poppins de Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Google Fonts: Poppins -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            html, body {
                font-family: 'Poppins', sans-serif !important;
            }
            /* Animación degradado dinámico para CTA */
            .cta-gradient-animated {
                background: linear-gradient(270deg, #ec4899, #3b82f6, #1e3a8a);
                background-size: 600% 600%;
                animation: gradientMove 8s ease-in-out infinite;
            }
            @keyframes gradientMove {
                0% {background-position: 0% 50%;}
                50% {background-position: 100% 50%;}
                100% {background-position: 0% 50%;}
            }
        </style>
 </head>
<body>
    <!-- Navbar adaptado para móvil/tableta -->
    <header class="bg-white shadow sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3 bg-white">
            <div class="flex items-center gap-x-3 h-10 min-w-[40px]">
                <img src="images/NAVI6.png" alt="Logo Navi" class="h-10 w-10 object-contain block" style="min-width:40px;min-height:40px;">
            </div>
            <button id="menu-toggle" class="lg:hidden text-blue-700 text-xl focus:outline-none px-2 py-2 rounded hover:bg-[var(--color-3)] transition-all duration-300">
                <i class="fa-solid fa-bars"></i>
            </button>
            <ul id="navbar-menu" class="hidden lg:flex flex-row items-center gap-x-2 text-sm font-semibold w-auto mt-0 bg-white/80 lg:bg-transparent rounded-xl shadow-lg lg:shadow-none p-2 lg:p-0 backdrop-blur-md">
                <li><a href="#cta" class="navbar-link block py-1 px-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Inicio</a></li>
                <li><a href="#conoce-a-navi" class="navbar-link block py-1 px-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">¿Qué es Navi?</a></li>
                <li><a href="#caracteristicas" class="navbar-link block py-1 px-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Características</a></li>
                <li><a href="#galeria" class="navbar-link block py-1 px-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Galería</a></li>
                <li><a href="#investigacion" class="navbar-link block py-1 px-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Investigación</a></li>
                <li><a href="#objetivos" class="navbar-link block py-1 px-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Objetivos</a></li>
                <li class="lg:hidden"><a href="login.php" class="navbar-btn block w-full py-1 px-3 mt-1 rounded-lg bg-blue-700 text-white text-center font-bold hover:bg-blue-800 hover:text-white">Iniciar Sesión</a></li>
            </ul>
            <div class="hidden lg:block">
                <a href="login.php" class="navbar-btn px-4 py-1 rounded-lg bg-blue-700 text-white font-bold hover:bg-blue-800 hover:text-white">Iniciar Sesión</a>
            </div>
        </nav>
        <!-- Sidebar móvil -->
        <aside id="sidebar-menu" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg z-[100] transform -translate-x-full transition-transform duration-300 lg:hidden">
            <div class="flex flex-col h-full p-6 gap-4">
                <button id="close-sidebar" class="self-end text-blue-700 text-2xl mb-4 focus:outline-none"><i class="fa-solid fa-xmark"></i></button>
                <a href="#cta" class="navbar-link block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Inicio</a>
                <a href="#conoce-a-navi" class="navbar-link block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">¿Qué es Navi?</a>
                <a href="#caracteristicas" class="navbar-link block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Características</a>
                <a href="#galeria" class="navbar-link block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Galería</a>
                <a href="#investigacion" class="navbar-link block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Investigación</a>
                <a href="#objetivos" class="navbar-link block py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-blue-700 font-semibold">Objetivos</a>
                <a href="login.php" class="navbar-btn block py-2 px-4 mt-4 rounded-lg bg-blue-700 text-white text-center font-bold hover:bg-blue-800 hover:text-white">Iniciar Sesión</a>
            </div>
        </aside>
    </header>
    <script>
        // Navbar móvil: sidebar
        const menuToggle = document.getElementById('menu-toggle');
        const sidebarMenu = document.getElementById('sidebar-menu');
        const closeSidebar = document.getElementById('close-sidebar');
        menuToggle.addEventListener('click', () => {
            sidebarMenu.classList.remove('-translate-x-full');
        });
        closeSidebar.addEventListener('click', () => {
            sidebarMenu.classList.add('-translate-x-full');
        });
    </script>

    <!-- CTA: Listo para conocer Navi (primera sección) -->
    <section id="cta" class="min-h-screen flex items-center justify-center text-white animate-fade-in cta-gradient-animated">
        <div class="max-w-3xl mx-auto text-center px-4 flex flex-col items-center gap-6">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-2 drop-shadow">¿Listo para conocer a Navi?</h2>
            <p class="text-lg md:text-xl opacity-90 mb-4">Descubre cómo nuestra plataforma puede transformar la experiencia educativa de niñas y niños con discapacidad visual.</p>
            <a href="login.php" class="navbar-btn bg-white text-blue-700 hover:bg-blue-100">Regístrate gratis</a>
        </div>
    </section>

    <!-- Conoce a NAVI -->
    <section id="conoce-a-navi" class="min-h-screen py-20 bg-[var(--color-1)] animate-fade-in">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Conoce a NAVI</h2>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="flex-1 text-lg text-gray-700">
                    <p class="mb-6"><strong>NAVI</strong> es una plataforma educativa digital inclusiva, diseñada para promover el aprendizaje y desarrollo cognitivo de niñas y niños con discapacidad visual, entre 3 y 7 años. A través de un entorno completamente sonoro, combina actividades guiadas por voz, juegos sensoriales y contenidos adaptados para garantizar una experiencia educativa accesible y significativa.</p>
                    <h3 class="text-blue-600 font-bold text-xl mb-4">¿Por qué NAVI es diferente?</h3>
                    <ul class="space-y-3 pl-4 list-disc">
                        <li><strong>Adaptación individual:</strong> Cada niña y niño es único. NAVI se adapta a sus capacidades, intereses y estilo de aprendizaje.</li>
                        <li><strong>Entorno seguro y controlado:</strong> Un espacio divertido y apropiado que convierte el aprendizaje en un juego.</li>
                        <li><strong>Enfoque multisensorial:</strong> Utiliza el sonido y el tacto como principales vías de exploración y descubrimiento.</li>
                        <li><strong>Ritmo personalizado:</strong> Sin prisa, sin presión. NAVI garantiza que todas y todos avancen con confianza.</li>
                        <li><strong>Interfaz completamente audible:</strong> Navegación intuitiva sin necesidad de elementos visuales.</li>
                    </ul>
                </div>
                <div class="flex-1 flex justify-center">
                    <div class="rounded-2xl overflow-hidden shadow-lg w-80 h-80 bg-cover bg-center transition-transform duration-300 hover:scale-105 animate-fade-in" style="background-image: url('images/portada.jpg');"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Características -->
    <section id="caracteristicas" class="min-h-screen py-20 bg-[var(--color-2)] animate-fade-in">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Características de Navi</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-4xl mb-4 text-blue-700 hover:text-pink-500 transition-colors duration-300"><i class="fa-solid fa-universal-access"></i></div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Completamente Accesible</h3>
                        <p class="text-gray-700">Diseñada desde sus cimientos para ser utilizada por niños con discapacidad visual, con navegación intuitiva y controles adaptados.</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-4xl mb-4 text-blue-700 hover:text-pink-500 transition-colors duration-300"><i class="fa-solid fa-headphones"></i></div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Interfaz Sonora</h3>
                        <p class="text-gray-700">Navegación completamente auditiva con instrucciones claras y feedback sonoro para cada interacción.</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-4xl mb-4 text-blue-700 hover:text-pink-500 transition-colors duration-300"><i class="fa-solid fa-child"></i></div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Adaptada por Edad</h3>
                        <p class="text-gray-700">Contenido y actividades específicamente diseñadas para el rango de edad de 3 a 7 años, considerando sus capacidades cognitivas.</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-4xl mb-4 text-blue-700 hover:text-pink-500 transition-colors duration-300"><i class="fa-solid fa-chart-line"></i></div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Seguimiento Personalizado</h3>
                        <p class="text-gray-700">Monitoreo del progreso individual con ajustes automáticos según el desarrollo de cada niño.</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-4xl mb-4 text-blue-700 hover:text-pink-500 transition-colors duration-300"><i class="fa-solid fa-gamepad"></i></div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Enfoque Lúdico</h3>
                        <p class="text-gray-700">Aprendizaje a través del juego, con actividades divertidas que mantienen el interés y motivación de los niños.</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-4xl mb-4 text-blue-700 hover:text-pink-500 transition-colors duration-300"><i class="fa-solid fa-shield-halved"></i></div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Entorno Seguro</h3>
                        <p class="text-gray-700">Espacio libre de distracciones y contenido inapropiado, diseñado específicamente para niños pequeños.</p>
                    </div>
            </div>
        </div>
    </section>
    <!-- Galería -->
    <section id="galeria" class="min-h-screen py-20 bg-[var(--color-4)] animate-fade-in">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Galería de Navi</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
                <div class="rounded-2xl overflow-hidden shadow-lg h-48 md:h-64 bg-cover bg-center transition-transform duration-300 hover:scale-105 animate-fade-in" style="background-image: url('images/galeria1.jpg');"></div>
                <div class="rounded-2xl overflow-hidden shadow-lg h-48 md:h-64 bg-cover bg-center transition-transform duration-300 hover:scale-105" style="background-image: url('images/galeria2.jpg');"></div>
                <div class="rounded-2xl overflow-hidden shadow-lg h-48 md:h-64 bg-cover bg-center transition-transform duration-300 hover:scale-105" style="background-image: url('images/galeria3.jpg');"></div>
            </div>
        </div>
    </section>
    <!-- Investigación del mercado -->
    <section id="investigacion" class="min-h-screen py-20 bg-[var(--color-5)] animate-fade-in">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Investigación del Mercado</h2>
            </div>
            <div class="flex flex-col items-center gap-8">
                <p class="text-lg text-gray-700 max-w-2xl">En Yucatán, donde más de 1200 niñas y niños viven con discapacidad visual (INEGI 2020), no existen plataformas educativas diseñadas específicamente para la primera infancia que sean completamente accesibles.</p>
                <p class="text-lg text-gray-700 max-w-2xl">Navi cambia este paradigma con una <span class="font-semibold text-blue-700">selección especializada</span> y <span class="font-semibold text-blue-700">adaptación a la edad</span> de los usuarios, llenando un vacío crítico en el mercado educativo inclusivo.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 mt-8">
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-3xl font-extrabold text-blue-700 mb-2">1200+</div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Niñas y niños con discapacidad visual en Yucatán</h3>
                        <p class="text-gray-700">Fuente: INEGI 2020</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-3xl font-extrabold text-blue-700 mb-2">3-7</div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Años, rango de edad objetivo</h3>
                        <p class="text-gray-700">Primera infancia, etapa clave para el desarrollo.</p>
                    </div>
                    <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                        <div class="text-3xl font-extrabold text-blue-700 mb-2">0</div>
                        <h3 class="font-bold text-lg mb-2 text-blue-700">Plataformas similares actualmente</h3>
                        <p class="text-gray-700">No existe competencia directa en el segmento.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Objetivos -->
    <section id="objetivos" class="min-h-screen py-20 bg-[var(--color-6)] animate-fade-in">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-blue-700 mb-2">Objetivos</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4 md:gap-8">
                <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                    <h3 class="font-bold text-lg mb-2 text-blue-700">Crear experiencias para niñas y niños ciegos</h3>
                    <p class="text-gray-700">Desarrollar contenido táctil y auditivo adaptado, con navegación por voz y sonidos direccionales.</p>
                </div>
                <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                    <h3 class="font-bold text-lg mb-2 text-blue-700">Fomentar el desarrollo cognitivo</h3>
                    <p class="text-gray-700">Implementar juegos educativos con retroalimentación auditiva inmediata y dificultad progresiva.</p>
                </div>
                <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                    <h3 class="font-bold text-lg mb-2 text-blue-700">Adaptarse a necesidades individuales</h3>
                    <p class="text-gray-700">Ofrecer personalización según nivel de desarrollo, preferencias y ritmo de aprendizaje.</p>
                </div>
                <div class="rounded-2xl bg-[var(--color-3)] p-8 shadow text-center transition-all duration-300 hover:scale-105 animate-fade-in">
                    <h3 class="font-bold text-lg mb-2 text-blue-700">Promover aprendizaje lúdico</h3>
                    <p class="text-gray-700">Diseñar actividades divertidas y motivadoras con sistema de recompensas auditivas.</p>
                </div>
            </div>
            <a href="registro.php" class="px-6 py-2 rounded-full bg-gradient-to-r from-blue-600 via-blue-400 to-pink-400 text-white font-bold text-base shadow-lg transition-all duration-300 mx-auto mt-8 block text-center drop-shadow-lg max-w-xs hover:bg-gradient-to-r hover:from-pink-500 hover:via-blue-600 hover:to-blue-900 hover:shadow-2xl hover:-translate-y-1 hover:scale-105">Registrarse Gratis</a>
        </div>
    </section>
    <!-- Footer -->
    <footer id="contacto" class="bg-gray-900 text-gray-100 py-12">
        <div class="footer-content" style="max-width:1100px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center;">
            <div class="footer-social" style="flex:1; min-width:220px; margin-bottom:20px;">
                <h3 style="font-weight:bold; font-size:1.1rem; margin-bottom:12px;">Síguenos</h3>
                <div class="social-icons" style="display:flex; gap:15px; margin-top:20px;">
                    <a href="https://www.facebook.com/" target="_blank" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/" target="_blank" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/" target="_blank" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://www.youtube.com/@navimx-oficial" target="_blank" class="social-icon"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div style="flex:1; min-width:220px; margin-bottom:20px;">
                <h3 style="font-weight:bold; font-size:1.1rem; margin-bottom:12px;">Enlaces rápidos</h3>
                <ul style="list-style:none; padding:0; margin:0;">
                    <li><a href="#conoce-a-navi" style="color:#fff; text-decoration:none;">¿Qué es Navi?</a></li>
                    <li><a href="#caracteristicas" style="color:#fff; text-decoration:none;">Características</a></li>
                    <li><a href="#investigacion" style="color:#fff; text-decoration:none;">Investigación</a></li>
                    <li><a href="#objetivos" style="color:#fff; text-decoration:none;">Objetivos</a></li>
                    <li><a href="#galeria" style="color:#fff; text-decoration:none;">Galería</a></li>
                </ul>
            </div>
            <div style="flex:1; min-width:220px; margin-bottom:20px;">
                <h3 style="font-weight:bold; font-size:1.1rem; margin-bottom:12px;">Contacto</h3>
                <p style="margin-bottom:8px;"><i class="fas fa-map-marker-alt"></i> Yucatán, México</p>
                <p style="margin-bottom:8px;"><i class="fas fa-phone"></i> +52 999 123 4567</p>
                <p style="margin-bottom:8px;"><i class="fas fa-envelope"></i> naviacademic@gmail.com</p>
            </div>
        </div>
        <div style="text-align:center; color:#bbb; border-top:1px solid #444; padding-top:18px; font-size:0.95rem; margin-top:20px;">
            &copy; 2023 Navi. Todos los derechos reservados. | Plataforma educativa inclusiva
        </div>
    </footer>

    <script>
        // Efecto de header al hacer scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.padding = '10px 0';
                header.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
            } else {
                header.style.padding = '15px 0';
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
            }
        });
        
        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>