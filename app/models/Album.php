<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Modelo para interactuar con la tabla 'albums'.
 */
class Album
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene todos los álbumes activos
     * 
     * @return array Lista de álbumes activos
     */
    public function obtenerActivos(): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, titulo, fecha
                FROM albums
                WHERE activo = 1
                ORDER BY fecha DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Album::obtenerActivos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene un álbum específico con sus imágenes
     * 
     * @param int $albumId ID del álbum a obtener
     * @return array|null Datos del álbum con sus imágenes o null si no existe
     */
    public function obtenerConImagenes(int $albumId): ?array
    {
        try {
            // Obtener detalles del álbum
            $stmtAlbum = $this->db->prepare("
                SELECT id, titulo, fecha
                FROM albums
                WHERE id = :id AND activo = 1
            ");
            $stmtAlbum->bindValue(':id', $albumId, PDO::PARAM_INT);
            $stmtAlbum->execute();
            $album = $stmtAlbum->fetch(PDO::FETCH_ASSOC);

            if (!$album) {
                return null;
            }

            // Obtener imágenes del álbum
            $stmtImagenes = $this->db->prepare("
                SELECT id, titulo, detalle, ruta_imagen
                FROM imagenes
                WHERE album_id = :albumId
                ORDER BY orden ASC
            ");
            $stmtImagenes->bindValue(':albumId', $albumId, PDO::PARAM_INT);
            $stmtImagenes->execute();
            $album['imagenes'] = $stmtImagenes->fetchAll(PDO::FETCH_ASSOC);

            return $album;
        } catch (PDOException $e) {
            error_log("Error en Album::obtenerConImagenes: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene todos los álbumes con paginación
     * 
     * @param int $pagina Número de página
     * @param int $porPagina Registros por página
     * @return array Álbumes y total de registros
     */
    public function obtenerPaginados(int $pagina = 1, int $porPagina = 10): array
    {
        try {
            $offset = ($pagina - 1) * $porPagina;
            
            // Obtener álbumes para la página actual
            $stmt = $this->db->prepare("
                SELECT SQL_CALC_FOUND_ROWS 
                    id, titulo, fecha, activo, created_at
                FROM albums
                ORDER BY fecha DESC
                LIMIT :limit OFFSET :offset
            ");
            
            $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            // Obtener el total de registros para la paginación
            $total = $this->db->query("SELECT FOUND_ROWS()")->fetchColumn();
            
            return [
                'albums' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'total' => $total
            ];
        } catch (PDOException $e) {
            error_log("Error en Album::obtenerPaginados: " . $e->getMessage());
            return [
                'albums' => [],
                'total' => 0
            ];
        }
    }

    /**
     * Crea un nuevo álbum
     * 
     * @param array $datos Datos del álbum
     * @return int|false ID del álbum creado o false si falla
     */
    public function crear(array $datos)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO albums (titulo, fecha, activo)
                VALUES (:titulo, :fecha, :activo)
            ");
            
            $stmt->bindValue(':titulo', $datos['titulo'], PDO::PARAM_STR);
            $stmt->bindValue(':fecha', $datos['fecha'], PDO::PARAM_STR);
            $stmt->bindValue(':activo', isset($datos['activo']) ? 1 : 0, PDO::PARAM_BOOL);
            
            if ($stmt->execute()) {
                return (int)$this->db->lastInsertId();
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Error en Album::crear: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza un álbum existente
     * 
     * @param int $id ID del álbum
     * @param array $datos Datos a actualizar
     * @return bool Resultado de la operación
     */
    public function actualizar(int $id, array $datos): bool
    {
        try {
            // Construir SQL dinámicamente según los campos proporcionados
            $campos = [];
            $params = [':id' => $id];
            
            if (isset($datos['titulo'])) {
                $campos[] = "titulo = :titulo";
                $params[':titulo'] = $datos['titulo'];
            }
            
            if (isset($datos['fecha'])) {
                $campos[] = "fecha = :fecha";
                $params[':fecha'] = $datos['fecha'];
            }
            
            if (isset($datos['activo'])) {
                $campos[] = "activo = :activo";
                $params[':activo'] = $datos['activo'] ? 1 : 0;
            }
            
            if (empty($campos)) {
                return true; // Nada que actualizar
            }
            
            $sql = "UPDATE albums SET " . implode(", ", $campos) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en Album::actualizar: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un álbum
     * 
     * @param int $id ID del álbum
     * @return bool Resultado de la operación
     */
    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM albums WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en Album::eliminar: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene un álbum por su ID
     * 
     * @param int $id ID del álbum
     * @return array|null Datos del álbum o null si no existe
     */
    public function obtenerPorId(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, titulo, fecha, activo, created_at
                FROM albums
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $album = $stmt->fetch(PDO::FETCH_ASSOC);
            return $album ?: null;
        } catch (PDOException $e) {
            error_log("Error en Album::obtenerPorId: " . $e->getMessage());
            return null;
        }
    }
}
