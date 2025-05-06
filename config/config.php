<?php

declare(strict_types=1);

// 1. Cargar autoloader primero
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

// 2. Helper function para variables de entorno
function env(string $key, $default = null) {
    $value = $_ENV[$key] ?? $default;
    
    // Convertir valores string 'true'/'false' a boolean
    if ($value === 'true') return true;
    if ($value === 'false') return false;
    
    return $value;
}

// 3. Cargar Dotenv
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->safeLoad();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USERNAME'])->notEmpty();

// Configuración de logs
if (!file_exists(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0755, true);
}
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Debugging: Mostrar variables de entorno antes de cargar la DB
echo "<!-- Pre-DB Load: ENV=" . ($_ENV['DB_NAME'] ?? 'NULL') . " -->";

// Carga de configuración DB al inicio
Database::loadConfig(__DIR__ . '/database.php');



// Manejo de entorno (explicación detallada abajo)
$env = $_ENV['APP_ENV'] ?? 'production';
define('APP_ENV', $env);
define('APP_DEBUG', filter_var(
    $_ENV['APP_DEBUG'] ?? ($env === 'development'), FILTER_VALIDATE_BOOLEAN));

// Configuración de errores
error_reporting(APP_DEBUG ? E_ALL : 0);
ini_set('display_errors', APP_DEBUG ? '1' : '0');

// Constantes principales
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Sitio Web Escritor');
define('APP_URL', rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/')); // URL base completa de la app
define('BASE_URL', '/ProyectosWeb/MLR/public'); // O sea-> /ProyectosWeb/MLR/public
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'America/Argentina/Buenos_Aires');

// Definir la URL base relativa (útil para assets como CSS, JS, imágenes)
// Calculada a partir de la ubicación del script index.php
$scriptName = $_SERVER['SCRIPT_NAME'] ?? ''; // e.g., /ProyectosWeb/MLR/public/index.php
// Elimina /index.php si existe al final
$basePath = preg_replace('/\/index\.php$/', '', $scriptName);
// Elimina barras inclinadas al final si las hay, excepto si es solo '/'
$baseUrl = ($basePath === '' || $basePath === '/') ? '/' : rtrim($basePath, '/');


// Otras configuraciones globales que puedas necesitar (ej: claves API)
// define('STRIPE_SECRET_KEY', $_ENV['STRIPE_SECRET_KEY'] ?? '');
// define('MAILER_DSN', $_ENV['MAILER_DSN'] ?? ''); // Para Symfony Mailer u otros

// Configuración Específica (Ejemplos, adaptar según necesidad)
// define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
// define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
// define('DB_NAME', $_ENV['DB_NAME'] ?? '');
// define('DB_USER', $_ENV['DB_USER'] ?? '');
// define('DB_PASS', $_ENV['DB_PASS'] ?? '');

// define('STRIPE_SECRET_KEY', $_ENV['STRIPE_SECRET_KEY'] ?? '');
// define('MAILER_DSN', $_ENV['MAILER_DSN'] ?? ''); // Para Symfony Mailer u otros

?>
