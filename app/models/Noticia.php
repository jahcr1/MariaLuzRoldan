<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Modelo para interactuar con la tabla 'noticias'.
 */
class Noticia
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
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

    /**
     * Obtiene noticias destacadas para portada
     */
    public function getDestacadas(int $limit = 2): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                id, 
                titulo, 
                url_origen,
                plataforma,
                COALESCE(imagen_preview, 'default-news.jpg') AS imagen,
                resumen,
                fecha_publicacion
            FROM noticias 
            WHERE activo = 1 AND es_destacada = 1
            ORDER BY fecha_publicacion DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Genera código embed según la plataforma
     */
    public function generarEmbed(string $url, string $plataforma): string
    {
        switch($plataforma) {
            case 'youtube':
                return "<div class='video-container'><iframe src='{$url}' frameborder='0' allowfullscreen></iframe></div>";
            case 'facebook':
            case 'instagram':
                return "<div class='social-embed' data-platform='{$plataforma}' data-url='{$url}'></div>";
            default:
                return "<a href='{$url}' class='btn btn-outline-primary' target='_blank'>Ver en {$plataforma}</a>";
        }
    }

    /**
     * Obtiene noticias paginadas
     */
    public function getPaginadas(int $pagina = 1, int $porPagina = 5): array
    {
        $offset = ($pagina - 1) * $porPagina;
        
        $stmt = $this->db->prepare("
            SELECT SQL_CALC_FOUND_ROWS 
                id, titulo, resumen, imagen_preview as imagen,
                fecha_publicacion, plataforma, url_origen
            FROM noticias 
            WHERE activo = 1
            ORDER BY es_destacada DESC, fecha_publicacion DESC
            LIMIT :limit OFFSET :offset
        ");
        
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return [
            'noticias' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $this->db->query("SELECT FOUND_ROWS()")->fetchColumn()
        ];
    }

    /**
     * Obtiene noticias para portada (2 destacadas)
     * 
     * @param int $limite Cantidad de noticias a obtener
     * @return array Lista de noticias para mostrar en la portada
     */
    public function obtenerParaPortada(int $limite = 3): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, titulo, slug, extracto as resumen, contenido, imagen, 
                       fecha_publicacion
                FROM noticias 
                WHERE activo = 1
                ORDER BY fecha_publicacion DESC
                LIMIT :limite
            ");
            
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en Noticia::obtenerParaPortada: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtiene noticias para portada (2 destacadas)
     * @deprecated Usar obtenerParaPortada() en su lugar
     */
    public function getParaPortada(): array
    {
        return $this->obtenerParaPortada(2);
    }

    // --- Métodos Futuros (Opcional) ---
    // Crear Noticia (para un futuro panel de administración)
    // Actualizar Noticia
    // Eliminar Noticia (o marcar como inactivo)
    // Obtener todas las noticias (para paginación en una sección /blog)

}
