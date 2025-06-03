<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Album;
use App\Models\Imagen;

/**
 * Controlador para la sección de galería
 */
class ControladorGaleria extends Controller
{
    /**
     * Muestra la página principal de la galería
     */
    public function index()
    {
        $albumModel = new Album();
        $albums = $albumModel->obtenerActivos();
        
        $datos = [
            'titulo' => 'Galería de Fotos - Maria Luz Roldan',
            'albums' => $albums
        ];
        
        $this->render('paginas/galeria', $datos);
    }
    
    /**
     * Muestra un álbum específico con sus imágenes
     * 
     * @param int $id ID del álbum
     */
    public function album($id = null)
    {
        if (!$id) {
            $this->redirect('/galeria');
        }
        
        $albumModel = new Album();
        $album = $albumModel->obtenerConImagenes((int)$id);
        
        if (!$album) {
            $this->redirect('/galeria');
        }
        
        $datos = [
            'titulo' => $album['titulo'] . ' - Galería - Maria Luz Roldan',
            'album' => $album
        ];
        
        $this->render('paginas/album', $datos);
    }
}
