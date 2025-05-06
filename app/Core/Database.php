<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use RuntimeException;
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
     * @param string $configPath Ruta al archivo de configuración de la DB.
     */
    public static function loadConfig(string $configPath): void
    {
        $absolutePath = realpath($configPath) ?: $configPath;
        if (!file_exists($absolutePath)) {
            throw new RuntimeException("Archivo de configuración de DB no encontrado: $absolutePath");
        }
        self::$config = require $absolutePath;

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
        // CAMBIO CLAVE: Validación mejorada de configuración
        if (empty(self::$config)) { // Cambiado de === null a empty()
            throw new Exception("Configuración no cargada. Llama a loadConfig() primero");
        }

        if (empty(self::$config['database'])) {
            throw new Exception("Nombre de base de datos no configurado. Verifique DB_NAME en .env");
        }

        if (self::$instance === null) {
            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                self::$config['driver'] ?? 'mysql', // Valor por defecto por si acaso
                self::$config['host'] ?? 'localhost',
                self::$config['port'] ?? '3306',
                self::$config['database'] ?? '', // La base de datos SÍ debería estar definida
                self::$config['charset'] ?? 'utf8mb4'
            );

            // CAMBIO CLAVE: Validación más completa
            $required = ['database', 'username', 'host'];
            foreach ($required as $key) {
                if (empty(self::$config[$key])) {
                    throw new Exception("Falta configuración requerida: $key");
                }
            }

            try {
                self::$instance = new PDO(
                    $dsn,
                    self::$config['username'],
                    self::$config['password'] ?? '',
                    self::$config['options'] ?? [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                throw new PDOException("Error al conectar con la base de datos", 0, $e);
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
