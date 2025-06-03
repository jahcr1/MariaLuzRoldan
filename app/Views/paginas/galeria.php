<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4">Galería de Fotos</h1>
    
    <?php if (empty($albums)): ?>
        <div class="alert alert-info">
            No hay álbumes disponibles en este momento. ¡Vuelve pronto para ver nuevo contenido!
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($albums as $album): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php
                        // Intentar obtener la primera imagen del álbum como portada
                        $imagenModel = new \App\Models\Imagen();
                        $imagenes = $imagenModel->obtenerPorAlbum($album['id']);
                        $imagenPortada = !empty($imagenes) ? $imagenes[0]['ruta_imagen'] : BASE_URL . '/assets/images/album-placeholder.jpg';
                        ?>
                        <a href="<?= BASE_URL ?>/galeria/album/<?= $album['id'] ?>">
                            <img src="<?= htmlspecialchars($imagenPortada) ?>" class="card-img-top" alt="<?= htmlspecialchars($album['titulo']) ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($album['titulo']) ?></h5>
                            <p class="card-text text-muted">
                                <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($album['fecha'])) ?>
                            </p>
                            <a href="<?= BASE_URL ?>/galeria/album/<?= $album['id'] ?>" class="btn btn-outline-primary">
                                Ver álbum
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
