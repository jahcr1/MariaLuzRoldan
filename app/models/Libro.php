<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

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
                    descripcion AS description,
                    descripcion_corta AS resena,
                    imagen,
                    precio AS price,
                    isbn,
                    editorial AS publisher,
                    anio_publicacion AS publication_year,
                    paginas,
                    stock,
                    idioma,
                    encuadernacion,
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
                    titulo,
                    autor,
                    imagen,
                    descripcion_corta AS resena,
                    precio AS price
                FROM libros
                WHERE activo = 1
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
    
    /**
     * Obtiene todos los libros activos
     */
    public function obtenerActivos(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    id,
                    titulo,
                    autor,
                    imagen,
                    descripcion_corta AS resena,
                    precio AS price
                FROM libros
                WHERE activo = 1
                ORDER BY titulo ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Libro::obtenerActivos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Busca libros por término de búsqueda
     */
    public function buscar(string $query): array
    {
        try {
            $searchTerm = "%$query%";
            $stmt = $this->db->prepare("
                SELECT 
                    id,
                    titulo,
                    autor,
                    imagen,
                    descripcion_corta AS resena,
                    precio AS price
                FROM libros
                WHERE activo = 1
                  AND (titulo LIKE :search 
                       OR autor LIKE :search 
                       OR descripcion LIKE :search
                       OR descripcion_corta LIKE :search)
                ORDER BY titulo ASC
            ");
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Libro::buscar: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtiene libros relacionados a un libro específico
     * 
     * @param int $libroId ID del libro para el que se buscan relacionados
     * @param int $limit Número máximo de libros a devolver
     * @return array Lista de libros relacionados
     */
    public function obtenerRelacionados(int $libroId, int $limit = 4): array
    {
        try {
            // En un sistema real, se debería implementar una lógica más avanzada
            // para encontrar libros relacionados basados en categorías, etiquetas, etc.
            // Por ahora, simplemente devolvemos otros libros activos excepto el actual
            
            $stmt = $this->db->prepare("
                SELECT 
                    id,
                    titulo,
                    autor,
                    imagen,
                    descripcion_corta AS resena,
                    precio AS price
                FROM libros
                WHERE activo = 1
                  AND id != :libroId
                ORDER BY RAND()
                LIMIT :limit
            ");
            $stmt->bindValue(':libroId', $libroId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Libro::obtenerRelacionados: " . $e->getMessage());
            return [];
        }
    }
}