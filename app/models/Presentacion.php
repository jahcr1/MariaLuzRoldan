<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modelo para interactuar con la tabla 'presentaciones'.
 */
class Presentacion
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtiene las próximas N presentaciones activas que aún no han pasado,
     * ordenadas por fecha del evento ascendente.
     *
     * @param int $limite El número máximo de presentaciones a obtener.
     * @return array Lista de presentaciones o array vacío si no hay.
     */
    public function obtenerProximas(int $limite = 3): array
    {
        try {
            $ahora = date('Y-m-d H:i:s');
            $stmt = $this->db->prepare("
                SELECT id, lugar, fecha_evento, descripcion, enlace 
                FROM presentaciones 
                WHERE activo = true AND fecha_evento >= :ahora
                ORDER BY fecha_evento ASC 
                LIMIT :limite");
            $stmt->bindParam(':ahora', $ahora, PDO::PARAM_STR);
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Error en Presentacion::obtenerProximas: " . $e->getMessage());
            return [];
        }
    }

    // --- Métodos Futuros (Opcional) ---
    // Crear Presentación (para un futuro panel de administración)
    // Actualizar Presentación
    // Eliminar Presentación (o marcar como inactivo)
    // Obtener todas las presentaciones (para una sección dedicada)

}
