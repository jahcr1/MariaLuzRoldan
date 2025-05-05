<?php
/** @var array $noticias */
/** @var string $pageTitle */
/** @var string $metaDescription */
?>

<?php require_once __DIR__ . '/../templates/header.php'; ?>

<main class="container py-5">
    <h1 class="mb-4 text-center">Noticias Destacadas</h1>
    
    <div class="row g-4">
        <?php foreach ($noticias as $noticia): ?>
        <div class="col-md-6">
            <article class="card h-100 shadow-sm">
                <?php if (!empty($noticia['imagen'])): ?>
                <img src="<?= htmlspecialchars($noticia['imagen']) ?>" 
                     class="card-img-top" 
                     alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                <?php endif; ?>
                
                <div class="card-body">
                    <h2 class="h5 card-title"><?= htmlspecialchars($noticia['titulo']) ?></h2>
                    <p class="card-text text-muted">
                        <small><?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?></small>
                    </p>
                    <p class="card-text"><?= htmlspecialchars($noticia['resumen'] ?? '') ?></p>
                </div>
                
                <div class="card-footer bg-transparent">
                    <a href="<?= htmlspecialchars($noticia['url_origen']) ?>" 
                       target="_blank" 
                       class="btn btn-outline-primary">
                        Ver en <?= ucfirst($noticia['plataforma']) ?>
                    </a>
                </div>
            </article>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
