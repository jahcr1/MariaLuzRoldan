<?php
namespace App\Controllers;

use App\Models\Slide;
use App\Core\Controller;
use Exception;

class ControladorSlide extends Controller
{
    protected $slideModel;

    public function __construct()
    {
        parent::__construct();
        $this->slideModel = new Slide();
    }

    /**
     * Obtiene slides activos para el frontend
     */
    public function obtenerSlides()
    {
        error_log("Accediendo a obtenerSlides");
        
        try {
            $slides = $this->slideModel->getActiveSlides();
            
            if(count($slides) < 3) {
                $slides = $this->getSlidesPorDefecto();
            }

            // Respuesta JSON
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 200,
                'success' => true,
                'data' => $slides
            ]);
            exit;

        } catch(Exception $e) {
            error_log('Error en obtenerSlides: ' . $e->getMessage());

            // Respuesta JSON de ERROR
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 500,
                'success' => false,
                'message' => 'Error al cargar slides',
                'error' => $e->getMessage() // <-- Solo en desarrollo, no en producción
            ]);
            exit;
        }
    }

    /**
     * Slides por defecto si no hay suficientes en BD
     */
    public function getSlidesPorDefecto()
    {
        return [
            [
                'imagen' => '/assets/images/layout/slider1.jpg',
                'titulo' => 'Título Promoción 1',
                'descripcion' => 'Descripción de la promoción'
            ],
            [
                'imagen' => '/assets/images/layout/slider2.jpg',
                'titulo' => 'Título Promoción 2',
                'descripcion' => 'Descripción de la promoción'
            ],
            [
                'imagen' => '/assets/images/layout/slider3.jpg',
                'titulo' => 'Título Promoción 3',
                'descripcion' => 'Descripción de la promoción'
            ],
            [
                'imagen' => '/assets/images/layout/slider4.jpg',
                'titulo' => 'Título Promoción 4',
                'descripcion' => 'Descripción de la promoción'
            ],
            [
                'imagen' => '/assets/images/layout/slider1.jpg',
                'titulo' => 'Título Promoción 5',
                'descripcion' => 'Descripción de la promoción'
            ],
            // ... agregar más según sea necesario
        ];
    }

    // Métodos para panel administrativo
    public function listar()
    {
        $slides = $this->slideModel->getAllSlides();
        View::render('admin/slides/listar', compact('slides'));
    }

    public function guardar()
    {
        // Lógica para guardar/actualizar slides
    }
}