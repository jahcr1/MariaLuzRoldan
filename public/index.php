<?php

declare(strict_types=1);

// Constantes de Rutas Principales
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('PUBLIC_PATH', __DIR__);
define('VIEWS_PATH', APP_PATH . '/Views');

// Cargar el autoloader de Composer
require_once BASE_PATH . '/vendor/autoload.php';

// Cargar variables de entorno
try {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    die('Error: No se pudo encontrar el archivo .env. Asegúrate de copiar .env.example a .env y configurarlo.');
}

// Cargar configuración
require_once CONFIG_PATH . '/config.php';
require_once CONFIG_PATH . '/database.php';

// --- Enrutamiento Básico (Placeholder) ---
echo "<h1>Sitio MLR Funcionando!</h1>";
echo "<p>Punto de entrada: index.php</p>";

// Aquí irá la lógica de un Router más sofisticado
// para mapear la URL a un Controlador y Acción.

// Ejemplo futuro:
// $router = new App\Core\Router();

// // Definir rutas
// $router->addRoute('/', ['HomeController', 'index']);
// $router->addRoute('/tienda', ['ShopController', 'index']);
// $router->addRoute('/tienda/libro/{id}', ['ShopController', 'showBook']); // Ruta con parámetro
// $router->addRoute('/contacto', ['ContactController', 'index']);
// $router->addRoute('/admin/productos', ['Admin\ProductController', 'index']); // Ruta admin

// // Obtener la ruta actual y despachar
// $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $requestMethod = $_SERVER['REQUEST_METHOD'];
// $router->dispatch($requestUri, $requestMethod);

?>
