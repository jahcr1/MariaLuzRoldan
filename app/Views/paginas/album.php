<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/galeria">Galería</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($album['titulo']) ?></li>
        </ol>
    </nav>
    
    <h1 class="mb-4"><?= htmlspecialchars($album['titulo']) ?></h1>
    <p class="text-muted mb-4">
        <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($album['fecha'])) ?>
    </p>
    
    <?php if (empty($album['imagenes'])): ?>
        <div class="alert alert-info">
            Este álbum no contiene imágenes por el momento.
        </div>
    <?php else: ?>
        <div class="row" id="gallery">
            <?php foreach ($album['imagenes'] as $imagen): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="gallery-item">
                        <a href="<?= htmlspecialchars($imagen['ruta_imagen']) ?>" data-lightbox="album-<?= $album['id'] ?>" data-title="<?= htmlspecialchars($imagen['titulo'] ?? '') ?>">
                            <img src="<?= htmlspecialchars($imagen['ruta_imagen']) ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($imagen['titulo'] ?? 'Imagen sin título') ?>">
                            <div class="gallery-overlay">
                                <i class="bi bi-zoom-in"></i>
                            </div>
                        </a>
                        <?php if (!empty($imagen['titulo'])): ?>
                            <div class="mt-2">
                                <h5 class="h6"><?= htmlspecialchars($imagen['titulo']) ?></h5>
                                <?php if (!empty($imagen['detalle'])): ?>
                                    <p class="small text-muted"><?= htmlspecialchars($imagen['detalle']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="mt-4">
        <a href="<?= BASE_URL ?>/galeria" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i> Volver a la galería
        </a>
    </div>
</div>

<!-- Lightbox JS para la galería (añadir en footer o importar separadamente) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Si se utiliza una biblioteca de lightbox como lightbox2, fancybox, etc.
    // Este es solo un placeholder para cuando se implemente la funcionalidad completa
    
    // Ejemplo de implementación básica (puede ser mejorada con una biblioteca dedicada)
    const galleryLinks = document.querySelectorAll('#gallery a');
    if (galleryLinks.length) {
        galleryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Aquí iría la lógica del lightbox o modal
                // Este es solo un marcador de posición
                console.log('Imagen clickeada:', this.href);
            });
        });
    }
});
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
