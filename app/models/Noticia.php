<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Modelo para interactuar con la tabla 'noticias'.
 */
class Noticia
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtiene las últimas N noticias activas, ordenadas por fecha de publicación descendente.
     *
     * @param int $limite El número máximo de noticias a obtener.
     * @return array Lista de noticias o array vacío si no hay.
     */
    public function obtenerUltimas(int $limite = 3): array
    {
        try {
            $sql = "SELECT id, titulo, slug, extracto, imagen, fecha_publicacion 
                    FROM noticias 
                    WHERE activo = true 
                    ORDER BY fecha_publicacion DESC 
                    LIMIT :limite";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // En una aplicación real, aquí registraríamos el error.
            error_log("Error al obtener últimas noticias: " . $e->getMessage());
            return []; // Devolver array vacío en caso de error
        }
    }

    /**
     * Obtiene una noticia por su slug.
     *
     * @param string $slug El slug de la noticia.
     * @return array|false Los datos de la noticia o false si no se encuentra.
     */
    public function obtenerPorSlug(string $slug): array|false
    {
         try {
            $sql = "SELECT * FROM noticias WHERE slug = :slug AND activo = true";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error al obtener noticia por slug: " . $e->getMessage());
            return false;
        }
    }

    // --- Métodos Futuros (Opcional) ---
    // Crear Noticia (para un futuro panel de administración)
    // Actualizar Noticia
    // Eliminar Noticia (o marcar como inactivo)
    // Obtener todas las noticias (para paginación en una sección /blog)

}
