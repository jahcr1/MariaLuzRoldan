<?php

declare(strict_types=1);

// Configuración de la Base de Datos (leída desde .env)
return [
    'driver'    => 'mysql', // O el driver que uses (pgsql, etc.)
    'host'      => $_ENV['DB_HOST'] ?? 'localhost',
    'port'      => $_ENV['DB_PORT'] ?? '3306',
    'database'  => $_ENV['DB_NAME'] ?? '', // Lee DB_NAME de .env pero la asigna a la clave 'database'
    'username'  => $_ENV['DB_USERNAME'] ?? 'root',
    'password'  => $_ENV['DB_PASSWORD'] ?? '',
    'charset'   => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
    'options'   => [
        // Opciones de PDO
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Siempre lanzar excepciones en errores SQL
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devolver arrays asociativos por defecto
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Usar preparaciones nativas reales
        PDO::ATTR_PERSISTENT         => false                   // Deshabilitar conexiones persistentes (generalmente mejor)
    ],
];

?>
