<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use App\Models\Libro;
use App\Models\Noticia;
use App\Models\Slide;
use App\Models\Presentacion;

/**
 * ControladorPanel
 * 
 * Controlador para el panel de administración
 */
class ControladorPanel extends Controller
{
    protected $usuarioModel;
    protected $libroModel;
    protected $noticiaModel;
    protected $slideModel;
    protected $presentacionModel;
    
    /**
     * Constructor - inicializa modelos necesarios
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->usuarioModel = new Usuario();
        
        // Validar sesión para todas las acciones excepto login
        $currentAction = $this->params['action'] ?? '';
        if ($currentAction !== 'login' && $currentAction !== 'autenticar') {
            $this->validarSesion();
        }
    }
    
    /**
     * Página principal del panel
     */
    public function index()
    {
        $this->render('admin/dashboard', [
            'pageTitle' => 'Panel de Administración',
            'usuario' => $_SESSION['usuario'] ?? null
        ]);
    }
    
    /**
     * Formulario de login
     */
    public function login()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['usuario'])) {
            $this->redirect('/admin');
            return;
        }
        
        $this->renderSinPlantilla('admin/login', [
            'pageTitle' => 'Iniciar Sesión',
            'error' => $_SESSION['error_login'] ?? null
        ]);
        
        // Limpiar mensaje de error si existe
        if (isset($_SESSION['error_login'])) {
            unset($_SESSION['error_login']);
        }
    }
    
    /**
     * Procesar formulario de login
     */
    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/login');
            return;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error_login'] = 'Todos los campos son obligatorios';
            $this->redirect('/admin/login');
            return;
        }
        
        $usuario = $this->usuarioModel->autenticar($email, $password);
        
        if ($usuario) {
            // Guardar datos de sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['login_time'] = time();
            
            // Redirigir al panel
            $this->redirect('/admin');
        } else {
            $_SESSION['error_login'] = 'Credenciales incorrectas';
            $this->redirect('/admin/login');
        }
    }
    
    /**
     * Cerrar sesión
     */
    public function logout()
    {
        session_destroy();
        $this->redirect('/admin/login');
    }
    
    /**
     * Validar si el usuario está autenticado
     */
    protected function validarSesion()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si existe sesión de usuario
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('/admin/login');
            exit;
        }
        
        // Opcional: validar tiempo de sesión (30 minutos)
        $maxInactiveTime = 30 * 60; // 30 minutos en segundos
        if (time() - ($_SESSION['login_time'] ?? 0) > $maxInactiveTime) {
            session_destroy();
            $this->redirect('/admin/login');
            exit;
        }
        
        // Actualizar tiempo de sesión
        $_SESSION['login_time'] = time();
    }
    
    /**
     * Renderizar vista sin plantilla (para login)
     */
    protected function renderSinPlantilla(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = $this->viewsPath . $view . '.php';
        
        if (!is_readable($viewFile)) {
            throw new \RuntimeException("Vista no encontrada: {$view}");
        }
        
        require $viewFile;
    }
    
    /*
     * GESTIÓN DE LIBROS
     */
    
    /**
     * Listar libros
     */
    public function libros()
    {
        if (!$this->libroModel) {
            $this->libroModel = new Libro();
        }
        
        $libros = $this->libroModel->obtenerTodos();
        
        $this->render('admin/libros/listar', [
            'pageTitle' => 'Administrar Libros',
            'libros' => $libros
        ]);
    }
    
    /*
     * GESTIÓN DE NOTICIAS
     */
    
    /**
     * Listar noticias
     */
    public function noticias()
    {
        if (!$this->noticiaModel) {
            $this->noticiaModel = new Noticia();
        }
        
        $noticias = $this->noticiaModel->obtenerTodas();
        
        $this->render('admin/noticias/listar', [
            'pageTitle' => 'Administrar Noticias',
            'noticias' => $noticias
        ]);
    }
    
    /*
     * GESTIÓN DE SLIDES
     */
    
    /**
     * Listar slides
     */
    public function slides()
    {
        if (!$this->slideModel) {
            $this->slideModel = new Slide();
        }
        
        $slides = $this->slideModel->getAllSlides();
        
        $this->render('admin/slides/listar', [
            'pageTitle' => 'Administrar Slides',
            'slides' => $slides
        ]);
    }
    
    /*
     * GESTIÓN DE PRESENTACIONES
     */
    
    /**
     * Listar presentaciones
     */
    public function presentaciones()
    {
        if (!$this->presentacionModel) {
            $this->presentacionModel = new Presentacion();
        }
        
        $presentaciones = $this->presentacionModel->obtenerTodas();
        
        $this->render('admin/presentaciones/listar', [
            'pageTitle' => 'Administrar Presentaciones',
            'presentaciones' => $presentaciones
        ]);
    }
    
    /*
     * GESTIÓN DE USUARIOS
     */
    
    /**
     * Listar usuarios
     */
    public function usuarios()
    {
        // Verificar si el usuario actual tiene rol de admin
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            $this->redirect('/admin');
            return;
        }
        
        $usuarios = $this->usuarioModel->listarTodos();
        
        $this->render('admin/usuarios/listar', [
            'pageTitle' => 'Administrar Usuarios',
            'usuarios' => $usuarios
        ]);
    }
}
