<?php
/** @var array $noticias */
/** @var int $paginaActual */
/** @var int $totalPaginas */
/** @var string $pageTitle */
/** @var string $metaDescription */
?>

<?php require_once __DIR__ . '/../templates/header.php'; ?>

<main class="container py-5">
    <h1 class="page-title text-center">Noticias</h1>
    
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($noticias as $noticia): ?>
        <div class="col">
            <article class="noticia-card card h-100 shadow-sm">
                <?php if (!empty($noticia['imagen'])): ?>
                <div class="card-img-container position-relative" style="height: 200px; overflow: hidden;">
                    <img src="<?= htmlspecialchars($noticia['imagen']) ?>" 
                         class="card-img-top h-100 w-100 object-fit-cover" 
                         alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                    <div class="plataforma-badge">
                        <span class="badge bg-dark"><?= ucfirst($noticia['plataforma']) ?></span>
                    </div>
                </div>
                <?php else: ?>
                <div class="card-img-container bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                    <div class="plataforma-badge">
                        <span class="badge bg-dark"><?= ucfirst($noticia['plataforma']) ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="card-body">
                    <h2 class="h5 card-title"><?= htmlspecialchars($noticia['titulo']) ?></h2>
                    <p class="card-text text-muted mb-2">
                        <small><?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?></small>
                    </p>
                    <p class="card-text line-clamp-3"><?= htmlspecialchars($noticia['resumen'] ?? '') ?></p>
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
    
    <?php if ($totalPaginas > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <?php if ($paginaActual > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>">Anterior</a>
            </li>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?= $i === $paginaActual ? 'active' : '' ?>">
                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            
            <?php if ($paginaActual < $totalPaginas): ?>
            <li class="page-item">
                <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>">Siguiente</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</main>
