<?php
class Router {
    public function handleRequest() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $route = ltrim(str_replace($base, '', $uri), '/');

        switch ($route) {
            case 'login':
            case 'login.php':
                require_once __DIR__ . '/../controllers/AuthController.php';
                $controller = new AuthController();
                $controller->login();
                break;
            case 'registro':
            case 'registro.php':
                require_once __DIR__ . '/../controllers/AuthController.php';
                $controller = new AuthController();
                $controller->registro();
                break;
            case 'app':
            case 'app.php':
                require_once __DIR__ . '/../controllers/AppController.php';
                $controller = new AppController();
                $controller->index();
                break;
            case 'perfil':
            case 'perfil.php':
                require_once __DIR__ . '/../controllers/AppController.php';
                $controller = new AppController();
                $controller->perfil();
                break;
            case 'configuracion':
            case 'configuracion.php':
                require_once __DIR__ . '/../controllers/AppController.php';
                $controller = new AppController();
                $controller->configuracion();
                break;
            case '':
            case '/':
                require_once __DIR__ . '/../index.php';
                break;
            default:
                // Si la ruta no existe, muestra la landing
                require_once __DIR__ . '/../index.php';
                break;
        }
    }
}
