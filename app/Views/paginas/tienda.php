<?php // Vista de detalle del producto (libro). Muestra información específica de un libro seleccionado. ?>
<?php
// Incluir header usando rutas relativas desde la vista
require_once __DIR__ . '/../templates/header.php';
?>

<!-- Banner Superior -->
<div class="container-fluid bg-dark text-white py-3 mb-5 shadow-sm">
    <div class="container">
        <h1 class="display-4" style="font-family: 'Arial', sans-serif;">María Luz Roldán</h1>
    </div>
</div>

<div class="container product-detail-page">
    <div class="row">
        <!-- Columna Izquierda: Imagen -->
        <div class="col-lg-5 mb-4 text-center">
            <img src="<?= htmlspecialchars($libro['imagen'] ?? APP_URL . '/assets/images/libros/default.jpg') ?>" 
                 class="img-fluid rounded shadow-lg mb-4" 
                 alt="Portada de <?= htmlspecialchars($libro['titulo']) ?>" 
                 style="max-height: 600px; width: auto;">
            
            <?php if (!empty($libro['quote'])): ?>
            <blockquote class="blockquote fst-italic text-muted">
                <p>"<?= htmlspecialchars($libro['quote']) ?>"</p>
            </blockquote>
            <?php endif; ?>
        </div>

        <!-- Columna Derecha: Detalles -->
        <div class="col-lg-7">
            <h2 class="display-5 fw-bold mb-2"><?= htmlspecialchars($libro['titulo']) ?></h2>
            <p class="lead text-muted mb-4">Por: <?= htmlspecialchars($libro['autor'] ?? 'Autor no especificado') ?></p>

            <!-- Pestañas -->
            <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                <?php if (!empty($libro['resena'])): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="resena-tab" data-bs-toggle="tab" data-bs-target="#resena" type="button" role="tab">Reseña</button>
                </li>
                <?php endif; ?>
                
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= empty($libro['resena']) ? 'active' : '' ?>" id="detalles-tab" data-bs-toggle="tab" data-bs-target="#detalles" type="button" role="tab">Detalles</button>
                </li>
                
                <?php if (!empty($libro['reviews'])): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
                </li>
                <?php endif; ?>
            </ul>

            <div class="tab-content" id="productTabsContent">
                <?php if (!empty($libro['resena'])): ?>
                <div class="tab-pane fade show active" id="resena" role="tabpanel">
                    <p><?= nl2br(htmlspecialchars($libro['resena'])) ?></p>
                </div>
                <?php endif; ?>
                
                <div class="tab-pane fade <?= empty($libro['resena']) ? 'show active' : '' ?>" id="detalles" role="tabpanel">
                    <ul><?= $libro['detalles'] ?? '<li>No hay detalles disponibles</li>' ?></ul>
                </div>
                
                <?php if (!empty($libro['reviews'])): ?>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <ul><?= $libro['reviews'] ?></ul>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Botón de compra -->
            <div class="mt-4">
                <a href="<?= BASE_URL ?>/contacto" class="btn btn-success btn-lg">Consultar Disponibilidad</a>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir footer usando rutas relativas
require_once __DIR__ . '/../templates/footer.php';
?>