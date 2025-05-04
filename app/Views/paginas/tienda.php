<?php // Vista de detalle del producto (libro). Muestra información específica de un libro seleccionado. ?>
<?php
// Incluir header
require_once APPROOT . '/Views/templates/header.php';
?>

<!-- Banner Superior -->
<div class="container-fluid bg-dark text-white py-3 mb-5 shadow-sm">
    <div class="container">
        <h1 class="display-4" style="font-family: 'Arial', sans-serif;">María Luz Roldán</h1>
        <!-- Podrías añadir un subtítulo o tagline aquí -->
    </div>
</div>

<div class="container product-detail-page">
    <div class="row">
        <!-- Columna Izquierda: Imagen y Quote -->
        <div class="col-lg-5 mb-4 text-center">
            <img src="<?= htmlspecialchars($libro['imagen']) ?>" class="img-fluid rounded shadow-lg mb-4" alt="Portada de <?= htmlspecialchars($libro['titulo']) ?>" style="max-height: 600px; width: auto;">
            <blockquote class="blockquote fst-italic text-muted">
                <p>"<?= htmlspecialchars($libro['quote']) ?>"</p>
            </blockquote>
        </div>

        <!-- Columna Derecha: Detalles y Pestañas -->
        <div class="col-lg-7">
            <h2 class="display-5 fw-bold mb-2"><?= htmlspecialchars($libro['titulo']) ?></h2>
            <p class="lead text-muted mb-4">Por: <?= htmlspecialchars($libro['autor']) ?></p>

            <!-- Sección de Etiquetas/Detalles Importantes (Ejemplo) -->
            <div class="mb-4">
                <?php if (!empty($libro['etiquetas'])) : ?>
                    <?php foreach ($libro['etiquetas'] as $etiqueta) : ?>
                        <span class="badge bg-secondary me-1"><?= htmlspecialchars($etiqueta) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- Puedes añadir más detalles aquí -->
            </div>

            <!-- Pestañas con Contenido -->
            <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="resena-tab" data-bs-toggle="tab" data-bs-target="#resena" type="button" role="tab" aria-controls="resena" aria-selected="true">Reseña</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="detalles-tab" data-bs-toggle="tab" data-bs-target="#detalles" type="button" role="tab" aria-controls="detalles" aria-selected="false">Detalles del Producto</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="resena" role="tabpanel" aria-labelledby="resena-tab">
                    <p><?= nl2br(htmlspecialchars($libro['resena'])) ?></p>
                </div>
                <div class="tab-pane fade" id="detalles" role="tabpanel" aria-labelledby="detalles-tab">
                    <ul><?= $libro['detalles'] // Asumiendo que ya es HTML seguro ?></ul>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <ul><?= $libro['reviews'] // Asumiendo que ya es HTML seguro ?></ul>
                </div>
            </div>
            
             <!-- Botón de compra o añadir al carrito (opcional, placeholder) -->
            <div class="mt-4">
                 <button class="btn btn-success btn-lg">Comprar Ahora</button>
                 <!-- O <button class="btn btn-outline-primary btn-lg">Añadir al Carrito</button> -->
            </div>

        </div>
    </div>
</div>

<?php
// Incluir footer
require_once APPROOT . '/Views/templates/footer.php';
?>
