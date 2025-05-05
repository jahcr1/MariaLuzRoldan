<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Clase base para todos los controladores
 */
class Controller
{
    protected array $params;
    protected string $viewsPath = '../app/Views/';

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * Renderiza una vista con su layout
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = $this->viewsPath . $view . '.php';

        if (!is_readable($viewFile)) {
            throw new \RuntimeException("Vista no encontrada: {$view}");
        }

        require $this->viewsPath . 'templates/header.php';
        require $viewFile;
        require $this->viewsPath . 'templates/footer.php';
    }

    /**
     * Redirige a otra URL
     */
    protected function redirect(string $url): void
    {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Obtiene parámetros de la ruta
     */
    protected function getParam(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }
}
