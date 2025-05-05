<?php
// Configuración de logs
declare(strict_types=1);

if (!file_exists(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0755, true);
}
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

require_once __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que el autoload de Composer esté incluido

// Archivo de configuración principal. Define constantes globales como URLs base, rutas de directorios y configuraciones de la aplicación.
// Este archivo es incluido por public/index.php DESPUÉS de cargar .env

// Configuración General de la Aplicación

// Habilitar/Deshabilitar reporte de errores (basado en la variable APP_ENV de .env)
if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Definir constantes útiles desde .env o valores por defecto
// Asegúrate de que estas claves (APP_NAME, APP_ENV, APP_DEBUG, APP_URL) existan en tu archivo .env
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Sitio Web Escritor');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production'); // 'development' o 'production'
define('APP_DEBUG', filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)); // true o false
define('APP_URL', rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/')); // URL base completa de la app

// Definir la URL base relativa (útil para assets como CSS, JS, imágenes)
// Calculada a partir de la ubicación del script index.php
$scriptName = $_SERVER['SCRIPT_NAME'] ?? ''; // e.g., /ProyectosWeb/MLR/public/index.php
// Elimina /index.php si existe al final
$basePath = preg_replace('/\/index\.php$/', '', $scriptName);
// Elimina barras inclinadas al final si las hay, excepto si es solo '/'
$baseUrl = ($basePath === '' || $basePath === '/') ? '/' : rtrim($basePath, '/');
define('BASE_URL', '/ProyectosWeb/MLR/public'); // e.g., /ProyectosWeb/MLR/public o /

// Configuración de zona horaria (recomendado)
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'America/Argentina/Buenos_Aires'); // Puedes añadir APP_TIMEZONE a tu .env

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
