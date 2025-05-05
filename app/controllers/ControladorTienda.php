<?php
declare(strict_types=1);

namespace App\Controllers;

// Controlador para la página de detalle de la tienda. Gestiona la obtención y muestra de datos de un libro específico.

use App\Core\Controller; // Asumiendo que tienes un Controller base
use App\Models\Libro;

class ControladorTienda extends Controller
{
    public function index()
    {
        error_log("Datos GET recibidos: " . print_r($_GET, true));
        $bookId = (int)($this->getParam('id') ?? $_GET['id'] ?? 0);
        error_log("ID de libro procesado: " . $bookId);
        
        if ($bookId <= 0) {
            error_log("Redireccionando por ID inválido: " . $bookId);
            $this->redirect('/');
            return;
        }

        $libroModel = new Libro();
        $libro = $libroModel->findById($bookId);

        if (!$libro) {
            $this->redirect('/');
            return;
        }

        // Formatear datos para la vista
        $libro['detalles'] = $this->formatearDetalles($libro);
        $libro['reviews'] = $this->obtenerResenas($libro['id']);

        $this->render('paginas/tienda', [
            'pageTitle' => $libro['titulo'],
            'pageDescription' => 'Detalles sobre el libro ' . $libro['titulo'],
            'libro' => $libro
        ]);
    }

    /**
     * Formatea los detalles del libro para mostrar en vista
     */
    private function formatearDetalles(array $libro): string
    {
        $detalles = '';
        if (!empty($libro['paginas'])) {
            $detalles .= "<li>Páginas: {$libro['paginas']}</li>";
        }
        if (!empty($libro['isbn'])) {
            $detalles .= "<li>ISBN: {$libro['isbn']}</li>";
        }
        // Agregar más campos según sea necesario
        return $detalles;
    }

    /**
     * Obtiene reseñas del libro (ejemplo - luego implementar modelo Resena)
     */
    private function obtenerResenas(int $libroId): string
    {
        // Esto es temporal - implementar modelo Resena después
        return '<li><strong>Lector 1:</strong> ¡Excelente libro!</li>';
    }
}
?>