<?php
// Verificar si existe sesión de usuario
if (!isset($_SESSION['usuario'])) {
    header('Location: ' . APP_URL . '/admin/login');
    exit;
}
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Panel de Administración') ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="<?= APP_URL ?>/assets/css/admin.css" rel="stylesheet">
    <style>
        /* Estilos básicos para el panel */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        
        .sidebar.active {
            margin-left: -250px;
        }
        
        .sidebar .sidebar-header {
            padding: 15px;
            background: #212529;
        }
        
        .sidebar ul li a {
            padding: 10px 15px;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: 0.3s;
        }
        
        .sidebar ul li a:hover {
            background: #495057;
            color: #fff;
        }
        
        .sidebar ul li a.active {
            background: #007bff;
            color: #fff;
        }
        
        .sidebar ul li a i {
            margin-right: 10px;
        }
        
        .sidebar ul.components {
            padding: 0;
            border-bottom: 1px solid #4b545c;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        
        #content {
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-toggler {
            background-color: #fff;
        }
        
        .breadcrumb {
            background-color: #e9ecef;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        /* Estilos para tarjetas y tablas */
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            font-weight: 500;
        }
        
        .table th {
            font-weight: 500;
            background-color: #f8f9fa;
        }
        
        /* Estilos para los botones de acción */
        .btn-group-action .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h3 class="mb-0">MLR Admin</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="<?= APP_URL ?>/admin" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin') !== false && substr_count($_SERVER['REQUEST_URI'], '/') === 1 ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= APP_URL ?>/admin/libros" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/libros') !== false ? 'active' : '' ?>">
                        <i class="fas fa-book"></i> Libros
                    </a>
                </li>
                <li>
                    <a href="<?= APP_URL ?>/admin/noticias" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/noticias') !== false ? 'active' : '' ?>">
                        <i class="fas fa-newspaper"></i> Noticias
                    </a>
                </li>
                <li>
                    <a href="<?= APP_URL ?>/admin/presentaciones" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/presentaciones') !== false ? 'active' : '' ?>">
                        <i class="fas fa-calendar-alt"></i> Presentaciones
                    </a>
                </li>
                <li>
                    <a href="<?= APP_URL ?>/admin/slides" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/slides') !== false ? 'active' : '' ?>">
                        <i class="fas fa-images"></i> Slides
                    </a>
                </li>
                <li>
                    <a href="<?= APP_URL ?>/admin/pedidos" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/pedidos') !== false ? 'active' : '' ?>">
                        <i class="fas fa-shopping-cart"></i> Pedidos
                    </a>
                </li>
                <?php if ($usuario['rol'] === 'admin'): ?>
                <li>
                    <a href="<?= APP_URL ?>/admin/usuarios" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/usuarios') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users"></i> Usuarios
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="<?= APP_URL ?>/admin/configuracion" class="<?= strpos($_SERVER['REQUEST_URI'], '/admin/configuracion') !== false ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i> Configuración
                    </a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="<?= APP_URL ?>" class="article" target="_blank">
                        <i class="fas fa-eye"></i> Ver sitio
                    </a>
                </li>
                <li>
                    <a href="<?= APP_URL ?>/admin/logout" class="article text-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <div id="content">
            <!-- Barra de navegación superior -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="d-flex ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> <?= htmlspecialchars($usuario['nombre']) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?= APP_URL ?>/admin/perfil"><i class="fas fa-id-card me-2"></i> Mi perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= APP_URL ?>/admin/logout"><i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Contenido de la página -->
            <div class="container-fluid px-4">
                <!-- El contenido específico se cargará aquí -->
