<?php

namespace App\Controllers;

use App\Core\Controller; // Asumiendo que tienes un Controller base

class ControladorTienda extends Controller
{
    public function index()
    {
        // Recoger el ID del libro de la URL
        $bookId = $_GET['id'] ?? null;

        if (!$bookId) {
            // Redirigir o mostrar error si no hay ID
            // header('Location: ' . BASE_URL); // Ejemplo: redirigir a inicio
            echo "Error: ID de libro no especificado.";
            exit;
        }

        // --- Lógica para obtener datos del libro desde el Modelo (FUTURO) ---
        // $libroModel = new \App\Models\Libro();
        // $libro = $libroModel->findById($bookId);
        // if (!$libro) { /* Manejar libro no encontrado */ }

        // --- Datos de ejemplo (Mientras no hay Modelo) ---
        $datosLibro = [
            'id' => $bookId,
            'titulo' => 'Título del Libro ' . $bookId, // Ejemplo dinámico
            'autor' => 'María Luz Roldán',
            'imagen' => 'https://via.placeholder.com/400x600/eee/888?text=Portada+Libro+' . $bookId,
            'quote' => 'Una frase inspiradora o extracto clave del libro va aquí.',
            'etiquetas' => ['Novela', 'Ficción', 'Aventura'], // Ejemplo
            'resena' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Nullam ac erat ante.',
            'detalles' => '<li>Páginas: 350</li><li>ISBN: 978-1234567890</li><li>Editorial: Ediciones Ejemplo</li><li>Idioma: Español</li>',
            'reviews' => '<li><strong>Lector 1:</strong> ¡Increíble! Me mantuvo enganchado de principio a fin.</li><li><strong>Lector 2:</strong> Una historia conmovedora y personajes bien desarrollados.</li>'
        ];
        // --- Fin Datos de ejemplo ---

        $data = [
            'pageTitle' => $datosLibro['titulo'], // Título de la pestaña del navegador
            'pageDescription' => 'Detalles sobre el libro ' . $datosLibro['titulo'],
            'libro' => $datosLibro
        ];

        // Cargar la vista de la tienda, pasando los datos
        $this->view('paginas/tienda', $data);
    }
}
