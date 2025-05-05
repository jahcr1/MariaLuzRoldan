<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Noticia;

class ControladorNoticias extends Controller
{
    public function index()
    {
        $modelo = new Noticia();
        $noticias = $modelo->getDestacadas();
        
        $this->render('paginas/noticias', [
            'noticias' => $noticias,
            'pageTitle' => 'Noticias Destacadas',
            'metaDescription' => 'Últimas noticias y publicaciones'
        ]);
    }
}
