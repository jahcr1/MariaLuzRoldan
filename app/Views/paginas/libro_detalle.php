<?php
// Vista para mostrar detalles de un libro específico
$libro = $libro ?? [];

// Si no hay libro o no tiene ID, redirigir
if (empty($libro) || !isset($libro['id'])) {
    header('Location: ' . APP_URL . '/tienda');
    exit;
}
?>

<div class="container py-5">
    <div class="row">
        <!-- Breadcrumb -->
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= APP_URL ?>/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= APP_URL ?>/tienda">Tienda</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($libro['titulo']) ?></li>
                </ol>
            </nav>
        </div>

        <!-- Imagen del libro -->
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <img src="<?= $libro['imagen'] ?>" alt="<?= htmlspecialchars($libro['titulo']) ?>" class="img-fluid w-100 rounded">
                </div>
            </div>
            
            <!-- Galería de imágenes (si hay adicionales) -->
            <?php if(isset($libro['imagenes_adicionales']) && !empty($libro['imagenes_adicionales'])): ?>
                <div class="row mt-3">
                    <?php foreach($libro['imagenes_adicionales'] as $index => $imagen): ?>
                        <div class="col-3">
                            <a href="#" class="thumbnail-link" data-index="<?= $index ?>">
                                <img src="<?= $imagen['thumbnail'] ?>" alt="Vista previa <?= $index + 1 ?>" class="img-fluid rounded">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Información del libro -->
        <div class="col-md-7">
            <h1 class="mb-2"><?= htmlspecialchars($libro['titulo']) ?></h1>
            
            <p class="text-muted mb-3">
                <span class="fw-bold">Autor:</span> <?= htmlspecialchars($libro['autor'] ?? 'María Luz Roldán') ?>
            </p>
            
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
            
            <div class="mb-4">
                <p class="lead"><?= htmlspecialchars($libro['resena'] ?? 'Sin descripción disponible.') ?></p>
            </div>
            
            <!-- Detalles técnicos del libro -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Detalles del libro</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <?php if(!empty($libro['detalles'])): ?>
                            <?= $libro['detalles'] ?>
                        <?php else: ?>
                            <li><strong>ISBN:</strong> <?= htmlspecialchars($libro['isbn'] ?? 'No disponible') ?></li>
                            <li><strong>Editorial:</strong> <?= htmlspecialchars($libro['publisher'] ?? 'No disponible') ?></li>
                            <li><strong>Año:</strong> <?= htmlspecialchars($libro['publication_year'] ?? 'No disponible') ?></li>
                            <li><strong>Páginas:</strong> <?= htmlspecialchars($libro['paginas'] ?? 'No disponible') ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Disponibilidad y opciones de compra -->
            <div class="mb-4">
                <?php if(isset($libro['stock']) && $libro['stock'] > 0): ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <strong>Disponible para entrega inmediata</strong>
                            <br>Stock: <?= $libro['stock'] ?> unidades
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Agotado temporalmente</strong>
                            <br>Consultar disponibilidad
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Botones de acción -->
            <div class="d-grid gap-2 d-md-flex">
                <button class="btn btn-primary btn-lg flex-grow-1" <?= (isset($libro['stock']) && $libro['stock'] <= 0) ? 'disabled' : '' ?>>
                    <i class="fas fa-shopping-cart me-2"></i> Agregar al carrito
                </button>
                <button class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-heart"></i>
                </button>
                <button class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-share-alt"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Pestañas de información adicional -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="libroTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="descripcion-tab" data-bs-toggle="tab" data-bs-target="#descripcion" type="button" role="tab" aria-controls="descripcion" aria-selected="true">Descripción completa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="opiniones-tab" data-bs-toggle="tab" data-bs-target="#opiniones" type="button" role="tab" aria-controls="opiniones" aria-selected="false">Opiniones</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="autor-tab" data-bs-toggle="tab" data-bs-target="#autor" type="button" role="tab" aria-controls="autor" aria-selected="false">Sobre el autor</button>
                </li>
            </ul>
            <div class="tab-content pt-4" id="libroTabsContent">
                <!-- Tab Descripción -->
                <div class="tab-pane fade show active" id="descripcion" role="tabpanel" aria-labelledby="descripcion-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Descripción completa</h4>
                            <?php if(isset($libro['description']) && !empty($libro['description'])): ?>
                                <div class="description-content">
                                    <?= nl2br(htmlspecialchars($libro['description'])) ?>
                                </div>
                            <?php else: ?>
                                <p class="fst-italic text-muted">Descripción detallada no disponible para este título.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Tab Opiniones -->
                <div class="tab-pane fade" id="opiniones" role="tabpanel" aria-labelledby="opiniones-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Opiniones de lectores</h4>
                            
                            <?php if(!empty($libro['reviews'])): ?>
                                <ul class="list-unstyled">
                                    <?= $libro['reviews'] ?>
                                </ul>
                            <?php else: ?>
                                <p class="fst-italic text-muted">No hay opiniones registradas para este libro.</p>
                            <?php endif; ?>
                            
                            <hr class="my-4">
                            
                            <h5>Comparte tu opinión</h5>
                            <form action="#">
                                <div class="mb-3">
                                    <label class="form-label" for="nombre_opinion">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_opinion" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email_opinion">Email</label>
                                    <input type="email" class="form-control" id="email_opinion" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="texto_opinion">Tu opinión</label>
                                    <textarea class="form-control" id="texto_opinion" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar opinión</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Tab Autor -->
                <div class="tab-pane fade" id="autor" role="tabpanel" aria-labelledby="autor-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center mb-4 mb-md-0">
                                    <img src="<?= APP_URL ?>/assets/images/autora/autora1.png" class="img-fluid rounded-circle shadow" alt="Foto del autor" style="max-width: 180px;">
                                </div>
                                <div class="col-md-9">
                                    <h4 class="mb-3">María Luz Roldán</h4>
                                    <p class="lead mb-3">Escritora argentina, nacida en Buenos Aires.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl id aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nisl nisl sit amet nisl. Nullam auctor, nisl id aliquam tincidunt, nunc nisl aliquam nisl, eget aliquam nisl nisl sit amet nisl.</p>
                                    <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    <div class="mt-3">
                                        <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-facebook-f me-1"></i> Facebook</a>
                                        <a href="#" class="btn btn-outline-danger btn-sm me-2"><i class="fab fa-instagram me-1"></i> Instagram</a>
                                        <a href="#" class="btn btn-outline-info btn-sm"><i class="fab fa-twitter me-1"></i> Twitter</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Libros relacionados -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-4">También te puede interesar</h3>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <!-- Libro relacionado 1 (Ejemplo) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= APP_URL ?>/assets/images/libros/default.jpg" class="card-img-top" alt="Libro relacionado 1">
                        <div class="card-body">
                            <h5 class="card-title">Título Libro Relacionado 1</h5>
                            <p class="card-text">Breve descripción del libro relacionado...</p>
                            <p class="text-primary fw-bold mb-0">$1.200,00</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?= APP_URL ?>/tienda/libro/1" class="btn btn-outline-primary btn-sm d-block">Ver detalles</a>
                        </div>
                    </div>
                </div>
                
                <!-- Libro relacionado 2 (Ejemplo) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= APP_URL ?>/assets/images/libros/default.jpg" class="card-img-top" alt="Libro relacionado 2">
                        <div class="card-body">
                            <h5 class="card-title">Título Libro Relacionado 2</h5>
                            <p class="card-text">Breve descripción del libro relacionado...</p>
                            <p class="text-primary fw-bold mb-0">$1.500,00</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?= APP_URL ?>/tienda/libro/2" class="btn btn-outline-primary btn-sm d-block">Ver detalles</a>
                        </div>
                    </div>
                </div>
                
                <!-- Libro relacionado 3 (Ejemplo) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= APP_URL ?>/assets/images/libros/default.jpg" class="card-img-top" alt="Libro relacionado 3">
                        <div class="card-body">
                            <h5 class="card-title">Título Libro Relacionado 3</h5>
                            <p class="card-text">Breve descripción del libro relacionado...</p>
                            <p class="text-primary fw-bold mb-0">$1.350,00</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?= APP_URL ?>/tienda/libro/3" class="btn btn-outline-primary btn-sm d-block">Ver detalles</a>
                        </div>
                    </div>
                </div>
                
                <!-- Libro relacionado 4 (Ejemplo) -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= APP_URL ?>/assets/images/libros/default.jpg" class="card-img-top" alt="Libro relacionado 4">
                        <div class="card-body">
                            <h5 class="card-title">Título Libro Relacionado 4</h5>
                            <p class="card-text">Breve descripción del libro relacionado...</p>
                            <p class="text-primary fw-bold mb-0">$1.400,00</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?= APP_URL ?>/tienda/libro/4" class="btn btn-outline-primary btn-sm d-block">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para manejar la galería de imágenes
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnailLinks = document.querySelectorAll('.thumbnail-link');
        if (thumbnailLinks.length > 0) {
            thumbnailLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Aquí se implementaría la lógica para cambiar la imagen principal
                });
            });
        }
    });
</script>
