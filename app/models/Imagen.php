<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Modelo para interactuar con la tabla 'imagenes'.
 */
class Imagen
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene imágenes para mostrar en la página de inicio
     * 
     * @param int $limite Número máximo de imágenes a retornar
     * @return array Lista de imágenes
     */
    public function obtenerParaInicio(int $limite = 6): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT i.id, i.titulo, i.detalle, i.ruta_imagen, a.titulo as album_titulo
                FROM imagenes i
                JOIN albums a ON i.album_id = a.id
                WHERE i.mostrar_inicio = 1 AND a.activo = 1
                ORDER BY i.orden ASC
                LIMIT :limite
            ");
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Imagen::obtenerParaInicio: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene imágenes por álbum
     * 
     * @param int $albumId ID del álbum
     * @return array Lista de imágenes del álbum
     */
    public function obtenerPorAlbum(int $albumId): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, titulo, detalle, ruta_imagen, orden
                FROM imagenes
                WHERE album_id = :albumId
                ORDER BY orden ASC
            ");
            $stmt->bindValue(':albumId', $albumId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Imagen::obtenerPorAlbum: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Crea una nueva imagen
     * 
     * @param array $datos Datos de la imagen
     * @return int|false ID de la imagen creada o false si falla
     */
    public function crear(array $datos)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO imagenes (
                    album_id, titulo, detalle, ruta_imagen, 
                    mostrar_inicio, orden
                ) VALUES (
                    :album_id, :titulo, :detalle, :ruta_imagen,
                    :mostrar_inicio, :orden
                )
            ");
            
            $stmt->bindValue(':album_id', $datos['album_id'], PDO::PARAM_INT);
            $stmt->bindValue(':titulo', $datos['titulo'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':detalle', $datos['detalle'] ?? null, PDO::PARAM_STR);
            $stmt->bindValue(':ruta_imagen', $datos['ruta_imagen'], PDO::PARAM_STR);
            $stmt->bindValue(':mostrar_inicio', isset($datos['mostrar_inicio']) ? 1 : 0, PDO::PARAM_BOOL);
            $stmt->bindValue(':orden', $datos['orden'] ?? 0, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return (int)$this->db->lastInsertId();
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Error en Imagen::crear: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza una imagen existente
     * 
     * @param int $id ID de la imagen
     * @param array $datos Datos a actualizar
     * @return bool Resultado de la operación
     */
    public function actualizar(int $id, array $datos): bool
    {
        try {
            // Construir SQL dinámicamente según los campos proporcionados
            $campos = [];
            $params = [':id' => $id];
            
            if (isset($datos['album_id'])) {
                $campos[] = "album_id = :album_id";
                $params[':album_id'] = $datos['album_id'];
            }
            
            if (isset($datos['titulo'])) {
                $campos[] = "titulo = :titulo";
                $params[':titulo'] = $datos['titulo'];
            }
            
            if (isset($datos['detalle'])) {
                $campos[] = "detalle = :detalle";
                $params[':detalle'] = $datos['detalle'];
            }
            
            if (isset($datos['ruta_imagen'])) {
                $campos[] = "ruta_imagen = :ruta_imagen";
                $params[':ruta_imagen'] = $datos['ruta_imagen'];
            }
            
            if (isset($datos['mostrar_inicio'])) {
                $campos[] = "mostrar_inicio = :mostrar_inicio";
                $params[':mostrar_inicio'] = $datos['mostrar_inicio'] ? 1 : 0;
            }
            
            if (isset($datos['orden'])) {
                $campos[] = "orden = :orden";
                $params[':orden'] = $datos['orden'];
            }
            
            if (empty($campos)) {
                return true; // Nada que actualizar
            }
            
            $sql = "UPDATE imagenes SET " . implode(", ", $campos) . " WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en Imagen::actualizar: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una imagen
     * 
     * @param int $id ID de la imagen
     * @return bool Resultado de la operación
     */
    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM imagenes WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en Imagen::eliminar: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene una imagen por su ID
     * 
     * @param int $id ID de la imagen
     * @return array|null Datos de la imagen o null si no existe
     */
    public function obtenerPorId(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT id, album_id, titulo, detalle, ruta_imagen, 
                       mostrar_inicio, orden
                FROM imagenes
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
            return $imagen ?: null;
        } catch (PDOException $e) {
            error_log("Error en Imagen::obtenerPorId: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Actualiza el orden de las imágenes
     * 
     * @param array $ordenes Array asociativo [id => orden]
     * @return bool Resultado de la operación
     */
    public function actualizarOrdenes(array $ordenes): bool
    {
        try {
            $this->db->beginTransaction();
            
            $stmt = $this->db->prepare("
                UPDATE imagenes 
                SET orden = :orden
                WHERE id = :id
            ");
            
            foreach ($ordenes as $id => $orden) {
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':orden', $orden, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error en Imagen::actualizarOrdenes: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza imágenes para mostrar en inicio
     * 
     * @param array $idsMostrar IDs de imágenes para mostrar en inicio
     * @return bool Resultado de la operación
     */
    public function actualizarMostrarInicio(array $idsMostrar): bool
    {
        try {
            $this->db->beginTransaction();
            
            // Primero desmarcamos todas
            $stmtReset = $this->db->prepare("UPDATE imagenes SET mostrar_inicio = 0");
            $stmtReset->execute();
            
            if (!empty($idsMostrar)) {
                // Luego marcamos las seleccionadas
                $placeholders = implode(',', array_fill(0, count($idsMostrar), '?'));
                $stmtUpdate = $this->db->prepare("
                    UPDATE imagenes 
                    SET mostrar_inicio = 1
                    WHERE id IN ($placeholders)
                ");
                
                foreach ($idsMostrar as $index => $id) {
                    $stmtUpdate->bindValue($index + 1, $id, PDO::PARAM_INT);
                }
                
                $stmtUpdate->execute();
            }
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error en Imagen::actualizarMostrarInicio: " . $e->getMessage());
            return false;
        }
    }
}
