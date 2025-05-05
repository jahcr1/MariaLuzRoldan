<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Libro
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene un libro por ID
     */
    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    id,
                    titulo,
                    autor,
                    descripcion,
                    descripcion_corta,
                    imagen,
                    activo,
                    created_at
                FROM libros 
                WHERE id = :id AND activo = 1
            ");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error en Libro::findById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene los últimos libros publicados
     */
    public function getUltimosLanzamientos(int $limit = 4): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    id,
                    title AS titulo,
                    author AS autor,
                    cover_image_main AS imagen,
                    short_description AS descripcion_corta
                FROM libros
                WHERE is_active = 1
                ORDER BY created_at DESC
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Libro::getUltimosLanzamientos: " . $e->getMessage());
            return [];
        }
    }
}