<?php
namespace App\Models;

use App\Core\Database;
use PDO;


class Slide
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene los slides activos para mostrar en el carrusel
     * 
     * @return array Lista de slides activos ordenados por el campo orden
     */
    public function obtenerActivos(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT id, titulo, descripcion, imagen, enlace 
                FROM slides 
                WHERE activo = 1 
                ORDER BY orden ASC 
                LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en Slide::obtenerActivos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * @deprecated Usar obtenerActivos() en su lugar
     */
    public function getActiveSlides()
    {
        return $this->obtenerActivos();
    }

    // Métodos para el panel administrativo
    public function getAllSlides()
    {
        return $this->db->query("SELECT * FROM slides ORDER BY orden ASC")->fetchAll();
    }

    public function saveSlide($data)
    {
        // Implementación para guardar/actualizar slides
    }
}