<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use App\Core\Router;

// Punto de entrada principal (Front Controller). Inicializa la aplicación y dirige las solicitudes al Router.

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
    $dotenv = Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    error_log('Error Dotenv: ' . $e->getMessage()); 
    die('Error crítico de configuración. No se pudo cargar el archivo .env. Revisa los logs del servidor.');
}

// Cargar configuración
require_once CONFIG_PATH . '/config.php';

// Cargar configuración de la base de datos
require_once __DIR__ . '/../app/Core/Database.php';
App\Core\Database::loadConfig(__DIR__ . '/../config/database.php');

// Instanciar y usar el nuevo Router para manejar las solicitudes
$router = new App\Core\Router();

// Definir las rutas de la aplicación
$router->add('/', ['controller' => 'ControladorInicio', 'action' => 'index']);
$router->add('/tienda', ['controller' => 'ControladorTienda', 'action' => 'index']);
$router->add('/tienda/libro/{id}', ['controller' => 'ShopController', 'action' => 'showBook']); // Ruta con parámetro
$router->add('/contacto', ['controller' => 'ContactController', 'action' => 'index']);
$router->add('/admin/productos', ['controller' => 'Admin\ProductController', 'action' => 'index']); // Ruta admin

// Obtener la URL solicitada (quitando el nombre del directorio base si es necesario)
$url = $_SERVER['REQUEST_URI'];

// Determinar el path base si la app no está en la raíz del dominio
$scriptName = $_SERVER['SCRIPT_NAME']; // Usualmente /ProyectosWeb/MLR/public/index.php
$basePath = dirname($scriptName); // Usualmente /ProyectosWeb/MLR/public

// Si la URL empieza con el basePath, quitarlo
if ($basePath !== '/' && $basePath !== '\\' && strpos($url, $basePath) === 0) {
    $url = substr($url, strlen($basePath));
}

// Asegurarse de que la URL empiece con / si no está vacía
if (empty($url)) {
    $url = '/';
}

// Despachar la ruta
$router->dispatch($url);

?>
