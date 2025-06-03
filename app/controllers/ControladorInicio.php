<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Noticia;
use App\Models\Slide;
use App\Models\Libro;
use App\Models\Presentacion;
use App\Models\Imagen;

/**
 * Controlador principal para la página de inicio
 */
class ControladorInicio extends Controller
{
    /**
     * Muestra la página de inicio.
     */
    public function index()
    {
        // Cargar todos los datos necesarios para la página principal
        $datos = [
            'titulo' => 'Inicio - Maria Luz Roldan',
            'slides' => $this->obtenerSlides(),
            'noticias' => $this->obtenerNoticias(),
            'presentaciones' => $this->obtenerPresentaciones(),
            'libros' => $this->obtenerLibrosRecientes(),
            'galeria' => $this->obtenerGaleria()
        ];

        // Renderizar vista
        $this->render('paginas/inicio', $datos);
    }
    
    /**
     * Obtiene los slides para el carrusel principal
     * 
     * @return array Slides activos
     */
    private function obtenerSlides(): array
    {
        $modelo = new Slide();
        return $modelo->obtenerActivos();
    }
    
    /**
     * Obtiene las noticias destacadas para la portada
     * 
     * @return array Noticias destacadas
     */
    private function obtenerNoticias(): array
    {
        $modelo = new Noticia();
        return $modelo->obtenerParaPortada();
    }
    
    /**
     * Obtiene las próximas presentaciones
     * 
     * @return array Próximas presentaciones
     */
    private function obtenerPresentaciones(): array
    {
        $modelo = new Presentacion();
        return $modelo->obtenerProximas();
    }
    
    /**
     * Obtiene los últimos libros publicados
     * 
     * @return array Últimos libros publicados
     */
    private function obtenerLibrosRecientes(): array
    {
        $modelo = new Libro();
        return $modelo->obtenerUltimosLanzamientos();
    }
    
    /**
     * Obtiene imágenes para la galería de la página de inicio
     * 
     * @return array Imágenes para mostrar en la galería
     */
    private function obtenerGaleria(): array
    {
        $modelo = new Imagen();
        return $modelo->obtenerParaInicio();
    }
}
