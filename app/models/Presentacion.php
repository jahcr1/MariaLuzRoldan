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
            // Obtener la fecha y hora actual en formato SQL
            $ahora = date('Y-m-d H:i:s');

            $sql = "SELECT id, lugar, fecha_evento, descripcion, enlace 
                    FROM presentaciones 
                    WHERE activo = true AND fecha_evento >= :ahora
                    ORDER BY fecha_evento ASC 
                    LIMIT :limite";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ahora', $ahora, PDO::PARAM_STR);
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // En una aplicación real, aquí registraríamos el error.
            error_log("Error al obtener próximas presentaciones: " . $e->getMessage());
            return []; // Devolver array vacío en caso de error
        }
    }

    // --- Métodos Futuros (Opcional) ---
    // Crear Presentación (para un futuro panel de administración)
    // Actualizar Presentación
    // Eliminar Presentación (o marcar como inactivo)
    // Obtener todas las presentaciones (para una sección dedicada)

}
