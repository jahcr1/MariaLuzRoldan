<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Noticia;

class ControladorNoticias extends Controller
{
    public function index()
    {
        $paginaActual = (int)($_GET['pagina'] ?? 1);
        $porPagina = 5;
        
        $modelo = new Noticia();
        $resultado = $modelo->getPaginadas($paginaActual, $porPagina);
        
        $this->render('paginas/noticias', [
            'noticias' => $resultado['noticias'],
            'paginaActual' => $paginaActual,
            'totalPaginas' => ceil($resultado['total'] / $porPagina),
            'pageTitle' => 'Noticias'
        ]);
    }
}
