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

    public function getActiveSlides()
    {
        $stmt = $this->db->prepare("SELECT id, titulo, descripcion, imagen 
            FROM slides 
            WHERE activo = 1 
            ORDER BY orden ASC 
            LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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