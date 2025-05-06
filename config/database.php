<?php

declare(strict_types=1);

// Configuración de la Base de Datos (leída desde .env)
return [
    'driver' => 'mysql',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_NAME'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'options' => [
        // Opciones de PDO
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Siempre lanzar excepciones en errores SQL
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devolver arrays asociativos por defecto
        PDO::ATTR_EMULATE_PREPARES   => false                 // Usar preparaciones nativas reales
    ]
];

?>
