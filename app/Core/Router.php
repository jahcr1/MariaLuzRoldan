<?php
declare(strict_types=1);

namespace App\Core;

// Clase Router: maneja las rutas de la aplicación, asociando URLs y métodos HTTP a controladores y acciones.

class Router {
    protected array $routes = [];
    protected array $params = [];

    public function add(string $route, array $params = []): void {
        // Convierte la ruta a una expresión regular: escapa barras inclinadas
        $route = preg_replace('/\//', '\\/', $route);

        // Convierte variables como {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convierte variables con expresiones regulares personalizadas como {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Añade delimitadores de inicio y fin, y opción de distinción entre mayúsculas y minúsculas
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function dispatch(string $url): void {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\Controllers\\" . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    // Acción no encontrada
                    $this->notFound();
                }
            } else {
                // Controlador no encontrado
                $this->notFound();
            }
        } else {
            // Ruta no encontrada
            $this->notFound();
        }
    }

    protected function match(string $url): bool {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Obtener los nombres de los parámetros capturados
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    protected function removeQueryStringVariables(string $url): string {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        // Quita también el query string si existe (ej: /pagina?id=1)
        if (($pos = strpos($url, '?')) !== false) {
             $url = substr($url, 0, $pos);
        }
        // Asegurarse de quitar la barra final si no es la ruta raíz
        if ($url != '/' && substr($url, -1) == '/') {
            $url = rtrim($url, '/');
        }

        return $url ?: '/'; // Devuelve '/' si la URL resultante está vacía
    }

    protected function convertToStudlyCaps(string $string): string {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase(string $string): string {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    protected function notFound(): void {
        // Simplemente envía un código 404. Podríamos mostrar una vista específica.
        http_response_code(404);
        // Opcional: incluir una vista de error 404
        // require '../app/Views/errors/404.php'; 
        echo "<h1>404 - Página no encontrada</h1>";
        exit;
    }
}
