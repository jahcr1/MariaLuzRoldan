<?php
declare(strict_types=1);

// Configuración de errores
ini_set('display_errors', '1');
ini_set('error_log', 'c:\xampp\htdocs\ProyectosWeb\MLR\logs\debug.log');
error_reporting(E_ALL);

// Verificar y crear archivo de log si no existe
$logFile = 'c:\xampp\htdocs\ProyectosWeb\MLR\logs\debug.log';
if (!file_exists($logFile)) {
    file_put_contents($logFile, "Archivo de log creado: " . date('Y-m-d H:i:s') . "\n");
}
error_log("Prueba de log - Acceso a index.php");


use Dotenv\Dotenv;
use App\Core\Router;

// Punto de entrada principal (Front Controller). Inicializa la aplicación y dirige las solicitudes al Router.

// Constantes de Rutas Principales
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('PUBLIC_PATH', __DIR__);
define('VIEWS_PATH', APP_PATH . '/Views');

// Iniciar sesión para todo el sitio
session_start();

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
// Rutas principales del sitio
$router->add('/', ['controller' => 'ControladorInicio', 'action' => 'index']);
$router->add('/tienda', ['controller' => 'ControladorTienda', 'action' => 'index']);
$router->add('/tienda/libro/{id}', ['controller' => 'ControladorTienda', 'action' => 'libro']); // Ruta con parámetro
$router->add('/tienda/buscar', ['controller' => 'ControladorTienda', 'action' => 'buscar']); // Búsqueda de libros
$router->add('/contacto', ['controller' => 'ControladorContacto', 'action' => 'index']);
$router->add('/contacto/enviar', ['controller' => 'ControladorContacto', 'action' => 'enviar']); // Envío de formulario
$router->add('/noticias', ['controller' => 'ControladorNoticias', 'action' => 'index']);
$router->add('/noticias/{slug}', ['controller' => 'ControladorNoticias', 'action' => 'mostrar']); // Detalle de noticia
$router->add('/slides/obtener', ['controller' => 'ControladorSlide', 'action' => 'obtenerSlides']);

// Rutas del panel de administración
$router->add('/admin', ['controller' => 'ControladorPanel', 'action' => 'index']);
$router->add('/admin/login', ['controller' => 'ControladorPanel', 'action' => 'login']);
$router->add('/admin/autenticar', ['controller' => 'ControladorPanel', 'action' => 'autenticar']);
$router->add('/admin/logout', ['controller' => 'ControladorPanel', 'action' => 'logout']);

// Rutas de administración de libros
$router->add('/admin/libros', ['controller' => 'ControladorPanel', 'action' => 'libros']);
$router->add('/admin/libros/crear', ['controller' => 'ControladorLibro', 'action' => 'crear']);
$router->add('/admin/libros/editar/{id}', ['controller' => 'ControladorLibro', 'action' => 'editar']);
$router->add('/admin/libros/eliminar/{id}', ['controller' => 'ControladorLibro', 'action' => 'eliminar']);

// Rutas de administración de noticias
$router->add('/admin/noticias', ['controller' => 'ControladorPanel', 'action' => 'noticias']);
$router->add('/admin/noticias/crear', ['controller' => 'ControladorNoticia', 'action' => 'crear']);
$router->add('/admin/noticias/editar/{id}', ['controller' => 'ControladorNoticia', 'action' => 'editar']);
$router->add('/admin/noticias/eliminar/{id}', ['controller' => 'ControladorNoticia', 'action' => 'eliminar']);

// Rutas de administración de presentaciones
$router->add('/admin/presentaciones', ['controller' => 'ControladorPanel', 'action' => 'presentaciones']);
$router->add('/admin/presentaciones/crear', ['controller' => 'ControladorPresentacion', 'action' => 'crear']);
$router->add('/admin/presentaciones/editar/{id}', ['controller' => 'ControladorPresentacion', 'action' => 'editar']);
$router->add('/admin/presentaciones/eliminar/{id}', ['controller' => 'ControladorPresentacion', 'action' => 'eliminar']);

// Rutas de administración de slides
$router->add('/admin/slides', ['controller' => 'ControladorPanel', 'action' => 'slides']);
$router->add('/admin/slides/crear', ['controller' => 'ControladorSlide', 'action' => 'crear']);
$router->add('/admin/slides/editar/{id}', ['controller' => 'ControladorSlide', 'action' => 'editar']);
$router->add('/admin/slides/eliminar/{id}', ['controller' => 'ControladorSlide', 'action' => 'eliminar']);

// Rutas de administración de usuarios (solo para admin)
$router->add('/admin/usuarios', ['controller' => 'ControladorPanel', 'action' => 'usuarios']);
$router->add('/admin/usuarios/crear', ['controller' => 'ControladorUsuario', 'action' => 'crear']);
$router->add('/admin/usuarios/editar/{id}', ['controller' => 'ControladorUsuario', 'action' => 'editar']);
$router->add('/admin/usuarios/eliminar/{id}', ['controller' => 'ControladorUsuario', 'action' => 'eliminar']);

// Debug: Loggear las rutas registradas
error_log("Rutas registradas");

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
