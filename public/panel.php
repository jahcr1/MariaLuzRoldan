<?php
/**
 * Panel de Administración - Punto de entrada
 * 
 * Este archivo es el punto de entrada para el panel de administración.
 * Redirige al usuario al controlador del panel de administración.
 */

// Redirigir al controlador del panel (simplifica la URL)
header('Location: index.php?url=admin');
exit;
