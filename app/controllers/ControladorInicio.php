<?php
declare(strict_types=1);

namespace App\Controllers;

// Controlador principal para la página de inicio. Define la acción 'index' que carga la vista principal.

use App\Core\Controller;
use App\Models\Noticia; // Agregar el uso del modelo Noticia

class ControladorInicio extends Controller {

    /**
     * Muestra la página de inicio.
     */
    public function index(): void {
        // Aquí podríamos cargar datos del modelo si fuera necesario
        $pageTitle = "Inicio - Mi Sitio Web";
        $pageDescription = "Bienvenido a mi sitio web personal.";

        $noticiaModel = new Noticia();
        $noticiasDestacadas = $noticiaModel->getParaPortada();
        
        // Cargar la vista
        $this->render('paginas/inicio', [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'noticiasDestacadas' => $noticiasDestacadas,
            // Pasar más datos a la vista si es necesario
        ]);
    }

    /**
     * Renderiza una vista con su layout (header/footer).
     *
     * @param string $view La ruta de la vista relativa a app/Views/.
     * @param array $data Datos para pasar a la vista.
     */
    protected function render(string $view, array $data = []): void {
        // Extrae los datos para que estén disponibles como variables en la vista
        extract($data, EXTR_SKIP);

        $viewFile = "../app/Views/{$view}.php";

        if (is_readable($viewFile)) {
            require '../app/Views/templates/header.php';
            require $viewFile;
            require '../app/Views/templates/footer.php';
        } else {
            // Podríamos lanzar una excepción o mostrar un error
            echo "Error: No se pudo encontrar la vista {$viewFile}";
            // O usar el método notFound del Router si estuviera disponible aquí
        }
    }
}
