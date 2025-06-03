<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4">Presentaciones y Eventos</h1>
    
    <?php if (empty($presentaciones)): ?>
        <div class="alert alert-info">
            No hay presentaciones programadas por el momento. ¡Vuelve pronto para conocer las novedades!
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($presentaciones as $presentacion): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($presentacion['lugar']) ?></h5>
                            
                            <p class="card-text text-muted mb-2">
                                <i class="bi bi-calendar-event me-2"></i>
                                <?= date('d/m/Y', strtotime($presentacion['fecha_evento'])) ?>
                                <i class="bi bi-clock ms-3 me-2"></i>
                                <?= date('H:i', strtotime($presentacion['fecha_evento'])) ?> hs
                            </p>
                            
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars($presentacion['descripcion'])) ?>
                            </p>
                            
                            <?php if (!empty($presentacion['enlace'])): ?>
                                <a href="<?= htmlspecialchars($presentacion['enlace']) ?>" 
                                   class="btn btn-outline-primary mt-2" 
                                   target="_blank">
                                    Más información <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Paginación -->
        <?php if ($totalPaginas > 1): ?>
            <nav aria-label="Paginación de presentaciones" class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php if ($paginaActual > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="/presentaciones/pagina/<?= $paginaActual - 1 ?>">
                                <i class="bi bi-chevron-left"></i> Anterior
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                            <a class="page-link" href="/presentaciones/pagina/<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($paginaActual < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="/presentaciones/pagina/<?= $paginaActual + 1 ?>">
                                Siguiente <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
