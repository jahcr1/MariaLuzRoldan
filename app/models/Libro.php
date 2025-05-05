<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Libro
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtiene un libro por ID
     */
    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM libros 
                WHERE id = :id AND activo = 1
            ");
            $stmt->execute(['id' => $id]);
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
                SELECT id, titulo, imagen 
                FROM libros 
                WHERE activo = 1 
                ORDER BY fecha_publicacion DESC 
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