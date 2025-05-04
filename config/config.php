<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtener las variables de entorno
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

// Conexión con MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Error en la conexión MySQLi: " . $mysqli->connect_error);
}

// Conexión con PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}

// Configuración General de la Aplicación

// Habilitar/Deshabilitar reporte de errores (basado en .env)
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Definir constantes útiles desde .env o valores por defecto
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Sitio Web Escritor');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
define('APP_DEBUG', filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN));
define('APP_URL', rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/'));

// Definir la URL base relativa (útil para assets)
$scriptName = $_SERVER['SCRIPT_NAME']; // e.g., /ProyectosWeb/MLR/public/index.php
$basePath = str_replace('/index.php', '', $scriptName);
define('BASE_URL', rtrim($basePath, '/')); // e.g., /ProyectosWeb/MLR/public

// Configuración de zona horaria (opcional pero recomendado)
date_default_timezone_set('America/Argentina/Buenos_Aires'); // Ajusta a tu zona horaria

// Otras configuraciones globales (ej: claves API, etc.)
// define('MERCADOPAGO_PUBLIC_KEY', $_ENV['MERCADOPAGO_PUBLIC_KEY'] ?? '');
// define('MERCADOPAGO_ACCESS_TOKEN', $_ENV['MERCADOPAGO_ACCESS_TOKEN'] ?? '');

?>
