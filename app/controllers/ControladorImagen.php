<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Imagen;
use App\Models\Album;

/**
 * Controlador para la gestión de imágenes de la galería
 */
class ControladorImagen extends Controller
{
    protected $imagenModel;
    protected $albumModel;
    
    /**
     * Constructor
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->imagenModel = new Imagen();
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
     * Mostrar formulario para crear una imagen
     */
    public function crear()
    {
        // Obtener todos los álbumes para el selector
        $albums = $this->albumModel->obtenerTodos();
        
        // Si no hay álbumes, redireccionar a crear álbum primero
        if (empty($albums)) {
            $this->setFlash('info', 'Primero debes crear al menos un álbum para subir imágenes');
            $this->redirect('/admin/galeria/albums/crear');
            return;
        }
        
        // Preseleccionar álbum si viene en GET
        $albumId = isset($_GET['album_id']) ? (int)$_GET['album_id'] : null;
        
        $this->render('admin/galeria/imagenes/crear', [
            'pageTitle' => 'Subir Nueva Imagen',
            'albums' => $albums,
            'albumId' => $albumId
        ]);
    }
    
    /**
     * Procesar el formulario de creación de imagen
     */
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        $album_id = $_POST['album_id'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $detalle = $_POST['detalle'] ?? '';
        $mostrar_en_inicio = isset($_POST['mostrar_en_inicio']) ? 1 : 0;
        $orden = $_POST['orden'] ?? 0;
        
        // Validaciones básicas
        if (empty($album_id)) {
            $this->setFlash('error', 'Debes seleccionar un álbum');
            $this->redirect('/admin/galeria/imagenes/crear');
            return;
        }
        
        // Procesar la imagen
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            $this->setFlash('error', 'Debes seleccionar una imagen válida');
            $this->redirect('/admin/galeria/imagenes/crear');
            return;
        }
        
        // Validar tipo de archivo
        $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $tipoArchivo = $_FILES['imagen']['type'];
        
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            $this->setFlash('error', 'El tipo de archivo no es válido. Se permiten: JPG, PNG y GIF');
            $this->redirect('/admin/galeria/imagenes/crear');
            return;
        }
        
        // Generar nombre único para la imagen
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('img_') . '.' . $extension;
        
        // Directorio de destino
        $directorioDestino = PUBLIC_PATH . '/uploads/galeria/';
        
        // Crear directorio si no existe
        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }
        
        // Ruta completa del archivo
        $rutaCompleta = $directorioDestino . $nombreArchivo;
        
        // Mover el archivo
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
            $this->setFlash('error', 'Error al subir la imagen');
            $this->redirect('/admin/galeria/imagenes/crear');
            return;
        }
        
        // Ruta relativa para guardar en la base de datos
        $rutaRelativa = '/uploads/galeria/' . $nombreArchivo;
        
        // Crear la imagen en la base de datos
        $resultado = $this->imagenModel->crear([
            'album_id' => $album_id,
            'titulo' => $titulo,
            'detalle' => $detalle,
            'ruta_imagen' => $rutaRelativa,
            'mostrar_en_inicio' => $mostrar_en_inicio,
            'orden' => $orden
        ]);
        
        if ($resultado) {
            $this->setFlash('success', 'Imagen subida correctamente');
            $this->redirect('/admin/galeria/imagenes?album_id=' . $album_id);
        } else {
            // Si falla, eliminar la imagen subida
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
            
            $this->setFlash('error', 'Error al guardar la información de la imagen');
            $this->redirect('/admin/galeria/imagenes/crear');
        }
    }
    
    /**
     * Mostrar formulario para editar una imagen
     */
    public function editar($id = null)
    {
        if (!$id) {
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        $imagen = $this->imagenModel->obtener((int)$id);
        
        if (!$imagen) {
            $this->setFlash('error', 'Imagen no encontrada');
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        // Obtener todos los álbumes para el selector
        $albums = $this->albumModel->obtenerTodos();
        
        $this->render('admin/galeria/imagenes/editar', [
            'pageTitle' => 'Editar Imagen',
            'imagen' => $imagen,
            'albums' => $albums
        ]);
    }
    
    /**
     * Procesar el formulario de edición de imagen
     */
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        $id = $_POST['id'] ?? 0;
        $album_id = $_POST['album_id'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $detalle = $_POST['detalle'] ?? '';
        $mostrar_en_inicio = isset($_POST['mostrar_en_inicio']) ? 1 : 0;
        $orden = $_POST['orden'] ?? 0;
        
        // Validaciones básicas
        if (empty($id) || empty($album_id)) {
            $this->setFlash('error', 'Información incompleta');
            $this->redirect('/admin/galeria/imagenes/editar/' . $id);
            return;
        }
        
        // Obtener imagen actual
        $imagenActual = $this->imagenModel->obtener((int)$id);
        
        if (!$imagenActual) {
            $this->setFlash('error', 'Imagen no encontrada');
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        $rutaRelativa = $imagenActual['ruta_imagen'];
        
        // Procesar nueva imagen si se ha subido una
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Validar tipo de archivo
            $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $tipoArchivo = $_FILES['imagen']['type'];
            
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                $this->setFlash('error', 'El tipo de archivo no es válido. Se permiten: JPG, PNG y GIF');
                $this->redirect('/admin/galeria/imagenes/editar/' . $id);
                return;
            }
            
            // Generar nombre único para la imagen
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('img_') . '.' . $extension;
            
            // Directorio de destino
            $directorioDestino = PUBLIC_PATH . '/uploads/galeria/';
            
            // Crear directorio si no existe
            if (!file_exists($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }
            
            // Ruta completa del archivo
            $rutaCompleta = $directorioDestino . $nombreArchivo;
            
            // Mover el archivo
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
                $this->setFlash('error', 'Error al subir la nueva imagen');
                $this->redirect('/admin/galeria/imagenes/editar/' . $id);
                return;
            }
            
            // Ruta relativa para guardar en la base de datos
            $rutaRelativa = '/uploads/galeria/' . $nombreArchivo;
            
            // Eliminar imagen anterior si existe
            if (!empty($imagenActual['ruta_imagen'])) {
                $rutaAnterior = PUBLIC_PATH . $imagenActual['ruta_imagen'];
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }
        }
        
        // Actualizar la imagen en la base de datos
        $resultado = $this->imagenModel->actualizar($id, [
            'album_id' => $album_id,
            'titulo' => $titulo,
            'detalle' => $detalle,
            'ruta_imagen' => $rutaRelativa,
            'mostrar_en_inicio' => $mostrar_en_inicio,
            'orden' => $orden
        ]);
        
        if ($resultado) {
            $this->setFlash('success', 'Imagen actualizada correctamente');
            $this->redirect('/admin/galeria/imagenes?album_id=' . $album_id);
        } else {
            $this->setFlash('error', 'Error al actualizar la información de la imagen');
            $this->redirect('/admin/galeria/imagenes/editar/' . $id);
        }
    }
    
    /**
     * Eliminar una imagen
     */
    public function eliminar($id = null)
    {
        if (!$id) {
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        // Verificar si la imagen existe
        $imagen = $this->imagenModel->obtener((int)$id);
        
        if (!$imagen) {
            $this->setFlash('error', 'Imagen no encontrada');
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        // Guardar el album_id para redireccionar después
        $albumId = $imagen['album_id'];
        
        // Eliminar el archivo físico
        if (!empty($imagen['ruta_imagen'])) {
            $rutaCompleta = PUBLIC_PATH . $imagen['ruta_imagen'];
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
        }
        
        // Eliminar el registro de la base de datos
        $resultado = $this->imagenModel->eliminar((int)$id);
        
        if ($resultado) {
            $this->setFlash('success', 'Imagen eliminada correctamente');
        } else {
            $this->setFlash('error', 'Error al eliminar la imagen');
        }
        
        // Redireccionar a la lista de imágenes del mismo álbum
        $this->redirect('/admin/galeria/imagenes' . ($albumId ? '?album_id=' . $albumId : ''));
    }
    
    /**
     * Cambiar visibilidad en inicio
     */
    public function cambiarVisibilidadInicio($id = null)
    {
        if (!$id) {
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        // Verificar si la imagen existe
        $imagen = $this->imagenModel->obtener((int)$id);
        
        if (!$imagen) {
            $this->setFlash('error', 'Imagen no encontrada');
            $this->redirect('/admin/galeria/imagenes');
            return;
        }
        
        // Cambiar la visibilidad
        $nuevaVisibilidad = $imagen['mostrar_en_inicio'] ? 0 : 1;
        $resultado = $this->imagenModel->actualizarVisibilidadInicio((int)$id, $nuevaVisibilidad);
        
        if ($resultado) {
            $this->setFlash('success', 'Visibilidad en inicio cambiada correctamente');
        } else {
            $this->setFlash('error', 'Error al cambiar la visibilidad');
        }
        
        // Redireccionar a la lista de imágenes del mismo álbum
        $this->redirect('/admin/galeria/imagenes' . ($imagen['album_id'] ? '?album_id=' . $imagen['album_id'] : ''));
    }
}
