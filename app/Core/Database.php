<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Clase Database Singleton
 *
 * Gestiona la conexión a la base de datos usando PDO.
 * Utiliza el patrón Singleton para asegurar una única instancia de la conexión.
 */
class Database
{
    private static ?PDO $instance = null;
    private static array $config = [];

    // El constructor es privado para prevenir instanciación directa.
    private function __construct() {}

    // Prevenir clonación.
    private function __clone() {}

    // Prevenir deserialización.
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * Carga la configuración de la base de datos.
     * Debe llamarse una vez antes de obtener la conexión, típicamente en el punto de entrada.
     *
     * @param array $config Array asociativo con la configuración de la DB (del archivo database.php).
     */
    public static function loadConfig(array $config): void
    {
        if (!empty(self::$config)) {
            // Opcional: Podrías lanzar un error o advertencia si intentan cargar la config de nuevo
            // trigger_error("La configuración de la base de datos ya ha sido cargada.", E_USER_WARNING);
            return; // Evitar recargar si ya está cargada
        }
        self::$config = $config;
    }

    /**
     * Obtiene la instancia única de la conexión PDO (Singleton).
     *
     * @return PDO La instancia de PDO.
     * @throws PDOException Si la conexión falla.
     * @throws \Exception Si la configuración no ha sido cargada previamente.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            if (empty(self::$config)) {
                // Es crucial que la configuración se cargue ANTES de intentar obtener la instancia.
                throw new \Exception("La configuración de la base de datos no ha sido cargada. Llama a Database::loadConfig() primero en tu punto de entrada (index.php).");
            }

            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                self::$config['driver'] ?? 'mysql', // Valor por defecto por si acaso
                self::$config['host'] ?? 'localhost',
                self::$config['port'] ?? '3306',
                self::$config['database'] ?? '', // La base de datos SÍ debería estar definida
                self::$config['charset'] ?? 'utf8mb4'
            );

            // Validar que tenemos los datos mínimos
            if (empty(self::$config['database']) || empty(self::$config['username'])) {
                throw new \Exception("Configuración de base de datos incompleta. Revisa tu archivo .env y config/database.php");
            }

            try {
                self::$instance = new PDO(
                    $dsn,
                    self::$config['username'],
                    self::$config['password'] ?? '', // La contraseña puede ser vacía
                    self::$config['options'] ?? [] // Usar opciones definidas o un array vacío
                );
            } catch (PDOException $e) {
                // En un entorno de producción, loguear el error en lugar de mostrarlo directamente.
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                // Mostrar un mensaje genérico al usuario para no exponer detalles.
                // Podrías tener una página de error dedicada.
                throw new PDOException("Error al conectar con la base de datos. Por favor, inténtelo más tarde o contacte al administrador.", 0, $e);
            }
        }

        return self::$instance;
    }

    /**
     * Cierra la conexión PDO explícitamente.
     * No es estrictamente necesario en la mayoría de los flujos web de PHP,
     * ya que PHP cierra las conexiones al final del script, pero puede ser útil
     * en scripts de larga duración o para liberar recursos inmediatamente.
     */
    public static function closeConnection(): void
    {
        self::$instance = null;
    }
}

?>
