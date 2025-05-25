<?php
declare(strict_types=1);

namespace App\Controllers;

// Controlador para la página de tienda. Gestiona la visualización de libros y detalles.

use App\Core\Controller;
use App\Models\Libro;
use PDOException;

class ControladorTienda extends Controller
{
    /**
     * Muestra la página principal de la tienda con todos los libros
     */
    public function index()
    {
        try {
            $libroModel = new Libro();
            $libros = $libroModel->obtenerActivos();
            
            $this->render('paginas/tienda', [
                'pageTitle' => 'Tienda - Libros',
                'pageDescription' => 'Explora y adquiere los libros de María Luz Roldán',
                'libros' => $libros
            ]);
        } catch (PDOException $e) {
            error_log("Error en ControladorTienda::index: " . $e->getMessage());
            $this->render('paginas/tienda', [
                'pageTitle' => 'Tienda - Libros',
                'pageDescription' => 'Explora y adquiere los libros de María Luz Roldán',
                'libros' => []
            ]);
        }
    }
    
    /**
     * Muestra el detalle de un libro específico
     */
    public function libro()
    {
        try {
            // Obtener ID del libro desde la URL como parte del path
            $bookId = (int)($this->getParam('id') ?? 0);
            
            if ($bookId <= 0) {
                $this->redirect('/tienda');
                return;
            }

            $libroModel = new Libro();
            $libro = $libroModel->findById($bookId);

            if (!$libro) {
                // Datos de prueba temporalmente - en producción redireccionar a tienda
                $libro = [
                    'id' => $bookId,
                    'titulo' => 'Libro de Prueba',
                    'imagen' => APP_URL.'/assets/images/libros/default.jpg',
                    'autor' => 'María Luz Roldán',
                    'price' => 1200.00, // Precio en formato numérico
                    'stock' => 10,
                    'resena' => 'Este es un libro de prueba con una descripción breve que muestra el estilo narrativo y la temática principal de la obra. Ideal para los amantes de la literatura contemporánea.',
                    'description' => "Este libro de prueba explora temáticas profundas sobre la condición humana y las relaciones interpersonales en el contexto actual. A través de sus páginas, el lector se sumerge en un mundo de reflexiones y emociones que lo llevarán a cuestionarse su propia existencia.\n\nEscrito con un estilo ágil y envolvente, esta obra combina narrativa contemporánea con elementos de realismo mágico, creando una experiencia única de lectura.\n\nSu estructura en tres partes permite al lector acompañar a los personajes en un viaje de autodescubrimiento y transformación.",
                    'isbn' => '978-3-16-148410-0',
                    'publisher' => 'Editorial Ejemplo',
                    'publication_year' => '2023',
                    'paginas' => '250'
                ];
            }

            // Formatear datos para la vista
            if (!isset($libro['detalles']) || empty($libro['detalles'])) {
                $libro['detalles'] = $this->formatearDetalles($libro);
            }
            
            if (!isset($libro['reviews']) || empty($libro['reviews'])) {
                $libro['reviews'] = $this->obtenerResenas($libro['id']);
            }
            
            // Preparar datos de libros relacionados
            $librosRelacionados = $libroModel->obtenerRelacionados($bookId, 4) ?? [];

            $this->render('paginas/tienda', [
                'pageTitle' => $libro['titulo'],
                'pageDescription' => substr(strip_tags($libro['resena'] ?? ''), 0, 160),
                'libro' => $libro,
                'librosRelacionados' => $librosRelacionados
            ]);
        } catch (PDOException $e) {
            error_log("Error en ControladorTienda::libro: " . $e->getMessage());
            $this->redirect('/tienda');
        }
    }
    
    /**
     * Método alternativo para compatibilidad con enlaces antiguos
     */
    public function mostrarLibro()
    {
        // Obtener ID del libro desde parámetros GET
        $bookId = (int)($_GET['id'] ?? 0);
        if ($bookId > 0) {
            $this->redirect('/tienda/libro/' . $bookId);
        } else {
            $this->redirect('/tienda');
        }
    }
    
    /**
     * Formatea los detalles del libro para mostrar en vista
     */
    private function formatearDetalles(array $libro): string
    {
        $detalles = '';
        
        // Agregar todos los detalles técnicos disponibles
        if (!empty($libro['isbn'])) {
            $detalles .= "<li><strong>ISBN:</strong> {$libro['isbn']}</li>";
        }
        
        if (!empty($libro['publisher'])) {
            $detalles .= "<li><strong>Editorial:</strong> {$libro['publisher']}</li>";
        }
        
        if (!empty($libro['publication_year'])) {
            $detalles .= "<li><strong>Año de publicación:</strong> {$libro['publication_year']}</li>";
        }
        
        if (!empty($libro['paginas'])) {
            $detalles .= "<li><strong>Número de páginas:</strong> {$libro['paginas']}</li>";
        }
        
        if (!empty($libro['idioma'])) {
            $detalles .= "<li><strong>Idioma:</strong> {$libro['idioma']}</li>";
        }
        
        if (!empty($libro['encuadernacion'])) {
            $detalles .= "<li><strong>Encuadernación:</strong> {$libro['encuadernacion']}</li>";
        }
        
        if (empty($detalles)) {
            $detalles = "<li>Información detallada no disponible.</li>";
        }
        
        return $detalles;
    }

    /**
     * Obtiene reseñas del libro (ejemplo - luego implementar modelo Resena)
     */
    private function obtenerResenas(int $libroId): string
    {
        // Esto es temporal - en producción implementar modelo Resena
        $resena1 = '<li class="mb-4 border-bottom pb-3">
                <div class="d-flex mb-2">
                    <div class="me-2">
                        <img src="' . APP_URL . '/assets/images/usuarios/default.jpg" alt="Usuario" class="rounded-circle" width="40">
                    </div>
                    <div>
                        <h5 class="mb-0">Ana Gómez</h5>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <small class="text-muted">Publicado el 15/03/2023</small>
                    </div>
                </div>
                <p>Una lectura increíblemente envolvente. Desde la primera página quedé atrapada por la narrativa y los personajes. Sin duda, uno de los mejores libros que he leído este año.</p>
            </li>';
        
        $resena2 = '<li class="mb-4 border-bottom pb-3">
                <div class="d-flex mb-2">
                    <div class="me-2">
                        <img src="' . APP_URL . '/assets/images/usuarios/default.jpg" alt="Usuario" class="rounded-circle" width="40">
                    </div>
                    <div>
                        <h5 class="mb-0">Carlos Martínez</h5>
                        <div class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <small class="text-muted">Publicado el 02/04/2023</small>
                    </div>
                </div>
                <p>La trama está muy bien construida y los personajes tienen una profundidad notable. Recomiendo este libro a cualquier amante de la buena literatura.</p>
            </li>';
        
        return $resena1 . "\n" . $resena2;
    }
    
    /**
     * Actualiza la vista de tienda principal
     */
    public function buscar()
    {
        $query = trim($_GET['q'] ?? '');
        
        $libroModel = new Libro();
        $libros = [];
        
        if (!empty($query)) {
            $libros = $libroModel->buscar($query);
        } else {
            $libros = $libroModel->obtenerActivos();
        }
        
        $this->render('paginas/tienda', [
            'pageTitle' => 'Resultados de búsqueda: ' . htmlspecialchars($query),
            'pageDescription' => 'Resultados de búsqueda para "' . htmlspecialchars($query) . '" en la tienda de María Luz Roldán',
            'libros' => $libros,
            'query' => $query
        ]);
    }
}
