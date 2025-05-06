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
        $parsedUrl = parse_url($url);
        $urlPath = $parsedUrl['path'] ?? '/';

        // Debug: Loggear la URL recibida
        error_log("Router recibió URL: " . $urlPath);
        
        // Preservar el query string original
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $_GET);
        }

        if ($this->match($urlPath)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\\Controllers\\" . $controller;

            // Debug: Loggear controlador y acción
            error_log("Intentando cargar: " . $controller . "::" . $this->params['action']);

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    error_log("Método no callable: " . $action);
                    $this->notFound();
                }
            } else {
                error_log("Clase no encontrada: " . $controller);
                $this->notFound();
            }
        } else {
            error_log("No hubo match para: " . $urlPath);
            error_log("Rutas registradas: " . print_r(array_keys($this->routes), true));
                $this->notFound();
        }
    }

    protected function match(string $url): bool {
        // Normalizar URL (eliminar query string)
        $cleanUrl = $this->removeQueryStringVariables($url);

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $cleanUrl, $matches)) {
                // Debug: Loggear coincidencia
                error_log("Ruta coincidente: " . $route);
                
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
        
        // 1. Extrae el path antes de cualquier ? o &
        $url = strtok($url, '?'); // <-- Esto maneja tanto ?url= como ?otros_parametros
        
        // 2. Mantiene la normalización existente para barras finales
        if ($url !== '/' && substr($url, -1) === '/') {
            $url = rtrim($url, '/');
        }
        
        return $url ?: '/'; // Devuelve '/' si está vacío (compatibilidad con rutas existentes)
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
