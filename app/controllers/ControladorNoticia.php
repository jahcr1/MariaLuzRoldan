<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Noticia;

/**
 * ControladorNoticia
 * 
 * Controlador para gestionar noticias desde el panel de administración
 */
class ControladorNoticia extends Controller
{
    protected $noticiaModel;
    
    /**
     * Constructor
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->noticiaModel = new Noticia();
        
        // Verificar autenticación para todas las acciones
        $this->validarSesion();
    }
    
    /**
     * Formulario para crear noticia
     */
    public function crear()
    {
        $this->render('admin/noticias/crear', [
            'pageTitle' => 'Crear Noticia',
            'noticia' => [
                'titulo' => '',
                'extracto' => '',
                'contenido' => '',
                'fecha_publicacion' => date('Y-m-d'),
                'activo' => true,
                'destacado' => false
            ]
        ]);
    }
    
    /**
     * Guardar nueva noticia
     */
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/noticias');
            return;
        }
        
        // Validar y procesar datos
        $datos = $this->validarDatos($_POST);
        
        if (!empty($datos['errores'])) {
            // Si hay errores, volver al formulario
            $this->render('admin/noticias/crear', [
                'pageTitle' => 'Crear Noticia',
                'noticia' => $datos,
                'errores' => $datos['errores']
            ]);
            return;
        }
        
        // Procesar imagen si se ha subido
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagenPath = $this->procesarImagen($_FILES['imagen']);
            if ($imagenPath) {
                $datos['imagen'] = $imagenPath;
            }
        }
        
        // Generar slug único
        $datos['slug'] = $this->generarSlug($datos['titulo']);
        
        // Guardar noticia en la base de datos
        $resultado = $this->noticiaModel->crear($datos);
        
        if ($resultado) {
            $_SESSION['mensaje'] = 'Noticia creada correctamente';
            $_SESSION['mensaje_tipo'] = 'success';
            $this->redirect('/admin/noticias');
        } else {
            $this->render('admin/noticias/crear', [
                'pageTitle' => 'Crear Noticia',
                'noticia' => $datos,
                'errores' => ['general' => 'Error al crear la noticia. Inténtalo de nuevo.']
            ]);
        }
    }
    
    /**
     * Formulario para editar noticia
     */
    public function editar()
    {
        $id = (int)$this->getParam('id');
        
        if ($id <= 0) {
            $this->redirect('/admin/noticias');
            return;
        }
        
        $noticia = $this->noticiaModel->obtenerPorId($id);
        
        if (!$noticia) {
            $_SESSION['mensaje'] = 'La noticia no existe';
            $_SESSION['mensaje_tipo'] = 'danger';
            $this->redirect('/admin/noticias');
            return;
        }
        
        $this->render('admin/noticias/editar', [
            'pageTitle' => 'Editar Noticia',
            'noticia' => $noticia
        ]);
    }
    
    /**
     * Actualizar noticia existente
     */
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/noticias');
            return;
        }
        
        $id = (int)$_POST['id'] ?? 0;
        
        if ($id <= 0) {
            $this->redirect('/admin/noticias');
            return;
        }
        
        // Validar y procesar datos
        $datos = $this->validarDatos($_POST);
        $datos['id'] = $id;
        
        if (!empty($datos['errores'])) {
            // Si hay errores, volver al formulario
            $this->render('admin/noticias/editar', [
                'pageTitle' => 'Editar Noticia',
                'noticia' => $datos,
                'errores' => $datos['errores']
            ]);
            return;
        }
        
        // Procesar imagen si se ha subido
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagenPath = $this->procesarImagen($_FILES['imagen']);
            if ($imagenPath) {
                $datos['imagen'] = $imagenPath;
            }
        }
        
        // Actualizar slug solo si el título ha cambiado
        $noticiaActual = $this->noticiaModel->obtenerPorId($id);
        if ($noticiaActual && $noticiaActual['titulo'] !== $datos['titulo']) {
            $datos['slug'] = $this->generarSlug($datos['titulo']);
        }
        
        // Actualizar noticia en la base de datos
        $resultado = $this->noticiaModel->actualizar($id, $datos);
        
        if ($resultado) {
            $_SESSION['mensaje'] = 'Noticia actualizada correctamente';
            $_SESSION['mensaje_tipo'] = 'success';
            $this->redirect('/admin/noticias');
        } else {
            $this->render('admin/noticias/editar', [
                'pageTitle' => 'Editar Noticia',
                'noticia' => $datos,
                'errores' => ['general' => 'Error al actualizar la noticia. Inténtalo de nuevo.']
            ]);
        }
    }
    
    /**
     * Eliminar noticia
     */
    public function eliminar()
    {
        $id = (int)$this->getParam('id');
        
        if ($id <= 0) {
            $this->redirect('/admin/noticias');
            return;
        }
        
        // Verificar si la noticia existe
        $noticia = $this->noticiaModel->obtenerPorId($id);
        
        if (!$noticia) {
            $_SESSION['mensaje'] = 'La noticia no existe';
            $_SESSION['mensaje_tipo'] = 'danger';
        } else {
            $resultado = $this->noticiaModel->eliminar($id);
            
            if ($resultado) {
                $_SESSION['mensaje'] = 'Noticia eliminada correctamente';
                $_SESSION['mensaje_tipo'] = 'success';
                
                // Eliminar imagen asociada si existe
                if (!empty($noticia['imagen'])) {
                    $rutaImagen = PUBLIC_PATH . '/' . $noticia['imagen'];
                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }
            } else {
                $_SESSION['mensaje'] = 'Error al eliminar la noticia';
                $_SESSION['mensaje_tipo'] = 'danger';
            }
        }
        
        $this->redirect('/admin/noticias');
    }
    
    /**
     * Validar los datos del formulario
     */
    protected function validarDatos(array $datos): array
    {
        $errores = [];
        
        // Validar título
        if (empty($datos['titulo'])) {
            $errores['titulo'] = 'El título es obligatorio';
        } elseif (strlen($datos['titulo']) > 200) {
            $errores['titulo'] = 'El título no puede tener más de 200 caracteres';
        }
        
        // Validar extracto
        if (strlen($datos['extracto'] ?? '') > 500) {
            $errores['extracto'] = 'El extracto no puede tener más de 500 caracteres';
        }
        
        // Validar contenido
        if (empty($datos['contenido'])) {
            $errores['contenido'] = 'El contenido es obligatorio';
        }
        
        // Validar fecha de publicación
        if (empty($datos['fecha_publicacion'])) {
            $errores['fecha_publicacion'] = 'La fecha de publicación es obligatoria';
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $datos['fecha_publicacion'])) {
            $errores['fecha_publicacion'] = 'Formato de fecha inválido. Debe ser YYYY-MM-DD';
        }
        
        // Procesar campos booleanos
        $datos['activo'] = isset($datos['activo']) ? 1 : 0;
        $datos['destacado'] = isset($datos['destacado']) ? 1 : 0;
        
        $datos['errores'] = $errores;
        return $datos;
    }
    
    /**
     * Procesar la imagen subida
     */
    protected function procesarImagen(array $archivo): ?string
    {
        // Directorio de destino
        $dirDestino = 'assets/images/noticias/';
        $rutaCompleta = PUBLIC_PATH . '/' . $dirDestino;
        
        // Crear directorio si no existe
        if (!is_dir($rutaCompleta)) {
            mkdir($rutaCompleta, 0755, true);
        }
        
        // Validar tipo de archivo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($archivo['type'], $tiposPermitidos)) {
            return null;
        }
        
        // Validar tamaño (max 2MB)
        if ($archivo['size'] > 2 * 1024 * 1024) {
            return null;
        }
        
        // Generar nombre único
        $nombreArchivo = uniqid('noticia_') . '_' . date('Ymd');
        
        // Obtener extensión
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        
        // Ruta completa del archivo
        $rutaArchivo = $rutaCompleta . $nombreArchivo . '.' . $extension;
        
        // Mover archivo subido
        if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            return $dirDestino . $nombreArchivo . '.' . $extension;
        }
        
        return null;
    }
    
    /**
     * Generar slug único a partir del título
     */
    protected function generarSlug(string $titulo): string
    {
        // Convertir a minúsculas y eliminar caracteres especiales
        $slug = strtolower(trim($titulo));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Verificar si el slug ya existe
        $slugBase = $slug;
        $contador = 1;
        
        while ($this->noticiaModel->slugExiste($slug)) {
            $slug = $slugBase . '-' . $contador;
            $contador++;
        }
        
        return $slug;
    }
    
    /**
     * Validar si el usuario está autenticado
     */
    protected function validarSesion()
    {
        // Verificar si existe sesión de usuario
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('/admin/login');
            exit;
        }
    }
}
