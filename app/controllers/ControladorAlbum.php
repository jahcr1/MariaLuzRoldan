<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Album;

/**
 * Controlador para la gestión de álbumes de la galería
 */
class ControladorAlbum extends Controller
{
    protected $albumModel;
    
    /**
     * Constructor
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->albumModel = new Album();
        
        // Validar sesión para todas las acciones
        $this->validarSesion();
    }
    
    /**
     * Validar sesión de administrador
     */
    protected function validarSesion()
    {
        if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['rol'], ['admin'])) {
            $this->redirect('/admin/login');
            exit;
        }
    }
    
    /**
     * Mostrar formulario para crear un álbum
     */
    public function crear()
    {
        $this->render('admin/galeria/albums/crear', [
            'pageTitle' => 'Crear Nuevo Álbum'
        ]);
    }
    
    /**
     * Procesar el formulario de creación de álbum
     */
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/galeria/albums');
            return;
        }
        
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        $activo = isset($_POST['activo']) ? 1 : 0;
        
        // Validaciones básicas
        if (empty($titulo)) {
            $this->setFlash('error', 'El título del álbum es obligatorio');
            $this->redirect('/admin/galeria/albums/crear');
            return;
        }
        
        // Crear el álbum
        $resultado = $this->albumModel->crear([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'activo' => $activo
        ]);
        
        if ($resultado) {
            $this->setFlash('success', 'Álbum creado correctamente');
            $this->redirect('/admin/galeria/albums');
        } else {
            $this->setFlash('error', 'Error al crear el álbum');
            $this->redirect('/admin/galeria/albums/crear');
        }
    }
    
    /**
     * Mostrar formulario para editar un álbum
     */
    public function editar($id = null)
    {
        if (!$id) {
            $this->redirect('/admin/galeria/albums');
            return;
        }
        
        $album = $this->albumModel->obtener((int)$id);
        
        if (!$album) {
            $this->setFlash('error', 'Álbum no encontrado');
            $this->redirect('/admin/galeria/albums');
            return;
        }
        
        $this->render('admin/galeria/albums/editar', [
            'pageTitle' => 'Editar Álbum',
            'album' => $album
        ]);
    }
    
    /**
     * Procesar el formulario de edición de álbum
     */
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/galeria/albums');
            return;
        }
        
        $id = $_POST['id'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        $activo = isset($_POST['activo']) ? 1 : 0;
        
        // Validaciones básicas
        if (empty($titulo) || empty($id)) {
            $this->setFlash('error', 'El título del álbum es obligatorio');
            $this->redirect('/admin/galeria/albums/editar/' . $id);
            return;
        }
        
        // Actualizar el álbum
        $resultado = $this->albumModel->actualizar($id, [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'activo' => $activo
        ]);
        
        if ($resultado) {
            $this->setFlash('success', 'Álbum actualizado correctamente');
            $this->redirect('/admin/galeria/albums');
        } else {
            $this->setFlash('error', 'Error al actualizar el álbum');
            $this->redirect('/admin/galeria/albums/editar/' . $id);
        }
    }
    
    /**
     * Eliminar un álbum
     */
    public function eliminar($id = null)
    {
        if (!$id) {
            $this->redirect('/admin/galeria/albums');
            return;
        }
        
        // Verificar si el álbum existe
        $album = $this->albumModel->obtener((int)$id);
        
        if (!$album) {
            $this->setFlash('error', 'Álbum no encontrado');
            $this->redirect('/admin/galeria/albums');
            return;
        }
        
        // Eliminar el álbum
        $resultado = $this->albumModel->eliminar((int)$id);
        
        if ($resultado) {
            $this->setFlash('success', 'Álbum eliminado correctamente');
        } else {
            $this->setFlash('error', 'Error al eliminar el álbum');
        }
        
        $this->redirect('/admin/galeria/albums');
    }
}
