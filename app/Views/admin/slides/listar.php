<?php
// Vista para listar slides en el panel de administración
$slides = $slides ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-images me-2"></i>Gestión de Slides</h1>
    <a href="<?= APP_URL ?>/admin/slides/crear" class="btn btn-warning text-white">
        <i class="fas fa-plus me-1"></i> Nuevo Slide
    </a>
</div>

<?php if(isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?? 'success' ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['mensaje'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">Listado de Slides</h5>
            </div>
            <div class="col-md-6 text-end">
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle me-1"></i> Los slides se muestran según su orden en el carrusel
                </p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if(empty($slides)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No hay slides registrados. Crea uno nuevo para empezar.
            </div>
        <?php else: ?>
            <div class="row slides-container">
                <?php foreach($slides as $slide): ?>
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="<?= APP_URL ?>/<?= htmlspecialchars($slide['imagen']) ?>" 
                                     class="card-img-top" alt="<?= htmlspecialchars($slide['titulo']) ?>"
                                     style="height: 180px; object-fit: cover;">
                                
                                <div class="position-absolute top-0 start-0 p-2">
                                    <span class="badge <?= $slide['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $slide['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </div>
                                
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-dark">
                                        Orden: <?= $slide['orden'] ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($slide['titulo']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($slide['descripcion']) ?></p>
                            </div>
                            
                            <div class="card-footer bg-white border-0">
                                <div class="btn-group w-100" role="group">
                                    <a href="<?= APP_URL ?>/admin/slides/editar/<?= $slide['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </a>
                                    <a href="#" onclick="confirmarEliminar('<?= APP_URL ?>/admin/slides/eliminar/<?= $slide['id'] ?>', 'slide')" 
                                       class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-info-circle me-2 text-primary"></i> Instrucciones
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">Dimensiones recomendadas</h6>
                <p>Para obtener mejores resultados, utiliza imágenes con las siguientes características:</p>
                <ul>
                    <li>Ancho: 1920px</li>
                    <li>Alto: 800px</li>
                    <li>Formato: JPG o PNG</li>
                    <li>Tamaño máximo: 2MB</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Consejos para slides efectivos</h6>
                <ul>
                    <li>Usa textos cortos y claros</li>
                    <li>Imágenes de alta calidad</li>
                    <li>Contraste adecuado entre texto y fondo</li>
                    <li>Limita el carrusel a 5 slides para mejor rendimiento</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    // Funcionalidad para reordenar slides (implementación básica)
    document.addEventListener('DOMContentLoaded', function() {
        // Aquí se implementaría la funcionalidad de arrastrar y soltar para reordenar
        // Usando librerías como SortableJS
    });
</script>
