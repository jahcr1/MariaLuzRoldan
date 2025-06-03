<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Presentacion;

/**
 * Controlador para la página de presentaciones/eventos
 */
class ControladorPresentaciones extends Controller
{
    /**
     * Muestra la página de presentaciones con paginación
     * 
     * @param int $pagina Número de página
     */
    public function index($pagina = 1)
    {
        $porPagina = 6; // Presentaciones por página
        
        $presentacionModel = new Presentacion();
        $resultado = $presentacionModel->obtenerPaginadas($pagina, $porPagina);
        
        $totalPaginas = ceil($resultado['total'] / $porPagina);
        
        // Asegurar que la página solicitada es válida
        if ($pagina < 1) {
            $this->redirect('/presentaciones');
        }
        
        if ($pagina > $totalPaginas && $totalPaginas > 0) {
            $this->redirect('/presentaciones/pagina/' . $totalPaginas);
        }
        
        $datos = [
            'titulo' => 'Presentaciones y Eventos - Maria Luz Roldan',
            'presentaciones' => $resultado['presentaciones'],
            'paginaActual' => $pagina,
            'totalPaginas' => $totalPaginas
        ];
        
        $this->render('paginas/presentaciones', $datos);
    }
    
    /**
     * Muestra una página específica de presentaciones
     * 
     * @param int $pagina Número de página
     */
    public function pagina($pagina = 1)
    {
        // Redirigir a la acción index con el número de página
        $this->index((int)$pagina);
    }
    
    /**
     * Muestra el detalle de una presentación
     * 
     * @param int $id ID de la presentación
     */
    public function detalle($id = null)
    {
        if (!$id) {
            $this->redirect('/presentaciones');
        }
        
        $presentacionModel = new Presentacion();
        $presentacion = $presentacionModel->obtenerPorId($id);
        
        if (!$presentacion) {
            $this->redirect('/presentaciones');
        }
        
        $datos = [
            'titulo' => $presentacion['lugar'] . ' - Maria Luz Roldan',
            'presentacion' => $presentacion
        ];
        
        $this->render('paginas/detalle-presentacion', $datos);
    }
}
