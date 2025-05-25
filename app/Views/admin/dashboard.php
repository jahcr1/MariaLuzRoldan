<?php
// Asegurarse de que exista un usuario de sesión
$usuario = $usuario ?? null;
if (!$usuario) {
    header('Location: ' . APP_URL . '/admin/login');
    exit;
}
?>
<!-- Vista principal del panel de administración -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">
                <i class="fas fa-tachometer-alt me-2"></i> Panel de Administración
            </h1>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Bienvenido/a <strong><?= htmlspecialchars($usuario['nombre']) ?></strong>. 
                Desde aquí puedes administrar el contenido del sitio web.
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Tarjeta de libros -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-bg bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                        <h5 class="card-title mb-0">Libros</h5>
                    </div>
                    <p class="card-text">Administra los libros disponibles en la tienda, actualiza stock, precios e imágenes.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= APP_URL ?>/admin/libros" class="btn btn-primary btn-sm">
                        <i class="fas fa-cog me-1"></i> Administrar
                    </a>
                    <a href="<?= APP_URL ?>/admin/libros/crear" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de noticias -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-bg bg-success text-white rounded-circle p-3 me-3">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                        <h5 class="card-title mb-0">Noticias</h5>
                    </div>
                    <p class="card-text">Gestiona las noticias y artículos que aparecen en la página principal y sección de noticias.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= APP_URL ?>/admin/noticias" class="btn btn-success btn-sm">
                        <i class="fas fa-cog me-1"></i> Administrar
                    </a>
                    <a href="<?= APP_URL ?>/admin/noticias/crear" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Nueva
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de presentaciones -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-bg bg-info text-white rounded-circle p-3 me-3">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <h5 class="card-title mb-0">Presentaciones</h5>
                    </div>
                    <p class="card-text">Administra los eventos y presentaciones programadas que se mostrarán en el sitio.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= APP_URL ?>/admin/presentaciones" class="btn btn-info btn-sm text-white">
                        <i class="fas fa-cog me-1"></i> Administrar
                    </a>
                    <a href="<?= APP_URL ?>/admin/presentaciones/crear" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-plus me-1"></i> Nueva
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de slides -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-bg bg-warning text-white rounded-circle p-3 me-3">
                            <i class="fas fa-images fa-2x"></i>
                        </div>
                        <h5 class="card-title mb-0">Slides</h5>
                    </div>
                    <p class="card-text">Gestiona las imágenes del carrusel que se muestra en la página principal.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= APP_URL ?>/admin/slides" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-cog me-1"></i> Administrar
                    </a>
                    <a href="<?= APP_URL ?>/admin/slides/crear" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de pedidos -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-bg bg-danger text-white rounded-circle p-3 me-3">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                        <h5 class="card-title mb-0">Pedidos</h5>
                    </div>
                    <p class="card-text">Visualiza y gestiona los pedidos realizados en la tienda online.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= APP_URL ?>/admin/pedidos" class="btn btn-danger btn-sm">
                        <i class="fas fa-list me-1"></i> Ver pedidos
                    </a>
                </div>
            </div>
        </div>

        <?php if ($usuario['rol'] === 'admin'): ?>
        <!-- Tarjeta de usuarios (solo para administradores) -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-bg bg-secondary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h5 class="card-title mb-0">Usuarios</h5>
                    </div>
                    <p class="card-text">Administra los usuarios que tienen acceso al panel de administración.</p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="<?= APP_URL ?>/admin/usuarios" class="btn btn-secondary btn-sm">
                        <i class="fas fa-cog me-1"></i> Administrar
                    </a>
                    <a href="<?= APP_URL ?>/admin/usuarios/crear" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-user-plus me-1"></i> Nuevo
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Resumen de estadísticas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Estadísticas del sitio</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                            <div class="p-3 border rounded">
                                <h3 class="display-6 fw-bold text-primary">0</h3>
                                <p class="mb-0">Libros publicados</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                            <div class="p-3 border rounded">
                                <h3 class="display-6 fw-bold text-success">0</h3>
                                <p class="mb-0">Noticias activas</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                            <div class="p-3 border rounded">
                                <h3 class="display-6 fw-bold text-info">0</h3>
                                <p class="mb-0">Eventos próximos</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="p-3 border rounded">
                                <h3 class="display-6 fw-bold text-danger">0</h3>
                                <p class="mb-0">Pedidos pendientes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales para el panel -->
<style>
    .icon-bg {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
