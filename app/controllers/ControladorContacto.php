<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

/**
 * ControladorContacto
 * 
 * Maneja la sección de contacto del sitio web
 */
class ControladorContacto extends Controller
{
    /**
     * Muestra el formulario de contacto
     */
    public function index()
    {
        $this->render('paginas/contacto', [
            'pageTitle' => 'Contacto',
            'pageDescription' => 'Contáctate con María Luz Roldán',
        ]);
    }
    
    /**
     * Procesa el envío del formulario de contacto
     */
    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contacto');
            return;
        }
        
        // Validar datos del formulario
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $asunto = trim($_POST['asunto'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');
        
        $errores = [];
        
        if (empty($nombre)) {
            $errores['nombre'] = 'El nombre es obligatorio';
        }
        
        if (empty($email)) {
            $errores['email'] = 'El email es obligatorio';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'El email no es válido';
        }
        
        if (empty($asunto)) {
            $errores['asunto'] = 'El asunto es obligatorio';
        }
        
        if (empty($mensaje)) {
            $errores['mensaje'] = 'El mensaje es obligatorio';
        }
        
        if (!empty($errores)) {
            // Si hay errores, volver al formulario con los datos y errores
            $this->render('paginas/contacto', [
                'pageTitle' => 'Contacto',
                'pageDescription' => 'Contáctate con María Luz Roldán',
                'datos' => [
                    'nombre' => $nombre,
                    'email' => $email,
                    'asunto' => $asunto,
                    'mensaje' => $mensaje
                ],
                'errores' => $errores
            ]);
            return;
        }
        
        // Aquí se implementaría el envío de email
        // Por ahora, simulamos que el email se envió correctamente
        
        // Guardar mensaje en la sesión
        $_SESSION['mensaje_exito'] = 'Tu mensaje ha sido enviado correctamente. Pronto nos pondremos en contacto contigo.';
        
        // Redirigir a la página de contacto
        $this->redirect('/contacto');
    }
}
