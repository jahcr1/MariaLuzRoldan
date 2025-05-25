<?php // Vista de la tienda y detalle de productos. Muestra el catálogo o el detalle de un libro específico. ?>
<?php
// Verificar que tenemos datos necesarios
$libros = $libros ?? [];
$libro = $libro ?? null;
$modoDetalle = isset($libro) && !empty($libro);

// Incluir header usando rutas relativas desde la vista
require_once __DIR__ . '/../templates/header.php';
?>

<!-- Banner Superior -->
<div class="container-fluid bg-dark text-white py-3 mb-5 shadow-sm">
    <div class="container">
        <h1 class="display-4" style="font-family: 'Arial', sans-serif;">María Luz Roldán</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= APP_URL ?>" class="text-white">Inicio</a></li>
                <li class="breadcrumb-item <?= !$modoDetalle ? 'active' : '' ?>"><a href="<?= APP_URL ?>/tienda" class="<?= !$modoDetalle ? 'text-white fw-bold' : 'text-white' ?>">Tienda</a></li>
                <?php if($modoDetalle): ?>
                <li class="breadcrumb-item active text-white fw-bold" aria-current="page"><?= htmlspecialchars($libro['titulo'] ?? 'Detalle') ?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<?php if($modoDetalle): // MODO DETALLE DE LIBRO ?>

<div class="container product-detail-page">
    <div class="row">
        <!-- Columna Izquierda: Imagen -->
        <div class="col-lg-5 mb-4 text-center">
            <img src="<?= htmlspecialchars($libro['imagen'] ?? APP_URL . '/assets/images/libros/default.jpg') ?>" 
                 class="img-fluid rounded shadow-lg mb-4" 
                 alt="Portada de <?= htmlspecialchars($libro['titulo'] ?? 'Libro') ?>" 
                 style="max-height: 600px; width: auto;">
            
            <?php if (!empty($libro['quote'])): ?>
            <blockquote class="blockquote fst-italic text-muted">
                <p>"<?= htmlspecialchars($libro['quote']) ?>"</p>
            </blockquote>
            <?php endif; ?>
        </div>

        <!-- Columna Derecha: Detalles -->
        <div class="col-lg-7">
            <h2 class="display-5 fw-bold mb-2"><?= htmlspecialchars($libro['titulo'] ?? 'Título no disponible') ?></h2>
            <p class="lead text-muted mb-4">Por: <?= htmlspecialchars($libro['autor'] ?? 'María Luz Roldán') ?></p>

            <?php if(isset($libro['price'])): ?>
            <div class="mb-4">
                <h3 class="text-primary mb-0">$<?= number_format($libro['price'], 2, ',', '.') ?></h3>
                <?php if(isset($libro['precio_anterior']) && $libro['precio_anterior'] > $libro['price']): ?>
                    <p class="text-muted">
                        <small><del>$<?= number_format($libro['precio_anterior'], 2, ',', '.') ?></del></small>
                        <span class="badge bg-danger ms-2">Oferta</span>
                    </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

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
                <a href="<?= APP_URL ?>/contacto" class="btn btn-success btn-lg">Consultar Disponibilidad</a>
            </div>
        </div>
    </div>
</div>

<?php else: // MODO CATÁLOGO DE LIBROS ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="display-5 fw-bold mb-4">Catálogo de Libros</h2>
            
            <!-- Buscador -->
            <form action="<?= APP_URL ?>/tienda/buscar" method="GET" class="mb-5">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar por título, autor o palabra clave..." name="q" value="<?= htmlspecialchars($query ?? '') ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <?php if(empty($libros)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> No se encontraron libros disponibles.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach($libros as $libro): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= htmlspecialchars($libro['imagen'] ?? APP_URL . '/assets/images/libros/default.jpg') ?>" 
                             class="card-img-top" alt="<?= htmlspecialchars($libro['titulo']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($libro['titulo']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($libro['resena'] ?? '', 0, 100)) ?>...</p>
                            <?php if(isset($libro['price'])): ?>
                                <p class="text-primary fw-bold mb-3">$<?= number_format($libro['price'], 2, ',', '.') ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a href="<?= APP_URL ?>/tienda/libro/<?= $libro['id'] ?>" class="btn btn-outline-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php endif; ?>

<!-- El footer se incluye automáticamente desde el controlador -->