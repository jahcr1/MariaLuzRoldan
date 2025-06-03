<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/presentaciones">Presentaciones</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($presentacion['lugar']) ?></li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title h2 mb-4"><?= htmlspecialchars($presentacion['lugar']) ?></h1>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold">Fecha</p>
                            <p class="mb-0"><?= date('d/m/Y', strtotime($presentacion['fecha_evento'])) ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold">Hora</p>
                            <p class="mb-0"><?= date('H:i', strtotime($presentacion['fecha_evento'])) ?> hs</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <h4 class="mb-3">Detalles del evento</h4>
            <div class="mb-4">
                <?= nl2br(htmlspecialchars($presentacion['descripcion'])) ?>
            </div>
            
            <?php if (!empty($presentacion['enlace'])): ?>
                <div class="mt-4">
                    <a href="<?= htmlspecialchars($presentacion['enlace']) ?>" 
                       class="btn btn-primary" 
                       target="_blank">
                        Más información <i class="bi bi-box-arrow-up-right ms-1"></i>
                    </a>
                    
                    <a href="/presentaciones" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-arrow-left me-1"></i> Volver a presentaciones
                    </a>
                </div>
            <?php else: ?>
                <div class="mt-4">
                    <a href="/presentaciones" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Volver a presentaciones
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
