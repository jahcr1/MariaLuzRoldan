<?php // Vista principal de la página de inicio. Muestra las diferentes secciones como slider, sobre mí, tienda, etc. ?>
<?php
// Asegurarse de que las variables están definidas para evitar errores
$pageTitle = $pageTitle ?? 'Bienvenido';
$pageDescription = $pageDescription ?? 'Página de inicio';
?>

<!-- ==========================
     SECCIÓN SLIDER PROPAGANDA
     =========================== -->
<section id="slider-propaganda">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 (Activo) -->
            <div class="carousel-item active">
                <!-- Reemplaza '...' con la ruta a tu imagen. Tamaño recomendado: ~1920x800 -->
                <img src="<?= APP_URL ?>/assets/images/layout/slider1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 1</h5>
                    <p>Descripción breve o llamada a la acción para el slide 1.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="<?= APP_URL ?>/assets/images/layout/slider2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 2</h5>
                    <p>Descripción breve o llamada a la acción para el slide 2.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="<?= APP_URL ?>/assets/images/layout/slider3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 3</h5>
                    <p>Descripción breve o llamada a la acción para el slide 3.</p>
                </div>
            </div>
             <!-- Slide 4 -->
            <div class="carousel-item">
                <img src="<?= APP_URL ?>/assets/images/layout/slider4.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 4</h5>
                    <p>Descripción breve o llamada a la acción para el slide 4.</p>
                </div>
            </div>
             <!-- Slide 5 -->
            <div class="carousel-item">
                <img src="<?= APP_URL ?>/assets/images/layout/slider1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 5</h5>
                    <p>Descripción breve o llamada a la acción para el slide 5.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- ==========================
     SECCIÓN NUEVOS LANZAMIENTOS
     =========================== -->
<section id="nuevos-lanzamientos" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5" data-aos="fade-right">
                <!-- Portada del Libro (Placeholder) -->
                <!-- Reemplaza '...' con la ruta a la imagen. Tamaño ~400x600 -->
                <img src="<?= APP_URL ?>/assets/images/libros/cantares0.jpg" class="img-fluid rounded shadow-lg" alt="Portada Último Lanzamiento">
            </div>
            <div class="col-md-7" data-aos="fade-left" data-aos-delay="200">
                <h2 class="display-5 fw-bold mb-3">Título del Último Lanzamiento</h2>
                <p class="text-muted mb-2">Fecha de Lanzamiento: DD/MM/AAAA</p>
                <p class="lead">Aquí va una breve reseña o descripción cautivadora del libro. Este texto será modificable desde el panel de administración en el futuro, permitiendo destacar las novedades más recientes de forma sencilla.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <!-- Enlace a la futura página nuevoslanzamientos.php -->
                <a href="#" class="btn btn-primary btn-lg mt-3">Más Información</a>
                <!-- Deberíamos crear nuevoslanzamientos.php y enlazarlo así: -->
                <!-- <a href="<?= BASE_URL ?>/nuevoslanzamientos" class="btn btn-primary btn-lg mt-3">Más Información</a> -->
            </div>
        </div>
    </div>
</section>

<!-- ==========================
     SECCIÓN SOBRE MÍ
     =========================== -->
<section id="sobre-mi" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <!-- Columna de Imagen (Ahora orden 1 por defecto, 2 en lg) -->
            <div class="col-lg-4 text-center order-1 order-lg-2" data-aos="fade-left">
                <!-- Imagen de la Autora (Placeholder) -->
                <!-- Reemplaza '...' con la ruta a la imagen. Tamaño cuadrado ~300x300 o similar -->
                <img src="<?= APP_URL ?>/assets/images/autora/autora1.png" class="img-fluid rounded-circle shadow" alt="Foto de la Autora">
            </div>
            <!-- Columna de Texto (Ahora orden 2 por defecto, 1 en lg) -->
            <div class="col-lg-8 order-2 order-lg-1 mb-4 mb-lg-0" data-aos="fade-right">
                <h2 class="display-5 fw-bold mb-3">Sobre Mí</h2>
                <p class="lead">Un breve párrafo introductorio sobre la autora. Aquí puedes destacar tu pasión por la escritura, tu trayectoria o lo que te inspira.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Nullam ac erat ante. Vivamus cursus odio non nisi semper, et dictum nisl fermentum. Sed eget ipsum sit amet metus finibus laoreet.</p>
                
                <!-- Iconos Redes Sociales (Solo iconos - Necesitas Font Awesome u otra librería) -->
                <div class="mt-4 mb-4">
                    <h5 class="mb-2">Sígueme en:</h5>
                    <a href="#" class="btn btn-outline-primary btn-sm me-2" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm me-2" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:tuemail@ejemplo.com" class="btn btn-outline-secondary btn-sm" aria-label="Enviar Correo"><i class="fas fa-envelope"></i></a>
                    <!-- Añade más redes si es necesario -->
                </div>

                <!-- Botón Ver Más con clase personalizada -->
                <a href="#" class="btn btn-marilu1-gradiente">Conoce Más Detalles</a>
                <!-- Deberíamos crear sobre-mi-detalle.php y enlazarlo así: -->
                <!-- <a href="<?= BASE_URL ?>/sobre-mi-detalle" class="btn btn-marilu1-gradiente">Conoce Más Detalles</a> -->
            </div>
        </div>
    </div>
</section>

<!-- ==========================
     SECCIÓN TIENDA
     =========================== -->
     <section id="tienda" class="py-5">
    <div class="container">
        <h2 class="text-center display-5 fw-bold mb-5">Explora Mis Libros</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            
            <?php 
            // --- Datos de ejemplo para la tienda (reemplazar con datos reales del Modelo) ---
            $librosTienda = [
                ['id' => 1, 'titulo' => 'Libro de Ejemplo 1', 'imagen' => 'https://via.placeholder.com/300x450/ddd/888?text=Libro+1', 'descripcion_corta' => 'Una breve descripción del primer libro.' ],
                ['id' => 2, 'titulo' => 'Aventuras en Código', 'imagen' => 'https://via.placeholder.com/300x450/ddd/888?text=Libro+2', 'descripcion_corta' => 'Descubre los secretos de la programación.' ],
                ['id' => 3, 'titulo' => 'El Misterio del CSS', 'imagen' => 'https://via.placeholder.com/300x450/ddd/888?text=Libro+3', 'descripcion_corta' => 'Estilos que te atraparán.' ],
                ['id' => 4, 'titulo' => 'PHP: Más Allá del Eco', 'imagen' => 'https://via.placeholder.com/300x450/ddd/888?text=Libro+4', 'descripcion_corta' => 'Lógica del lado del servidor revelada.' ],
                // Añade más libros aquí
            ];
            // --- Fin datos de ejemplo ---
            ?>

            <?php foreach ($librosTienda as $index => $libro): ?>
            <div class="col" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                <div class="card h-100 shadow-sm">
                    <a href="<?= BASE_URL ?>/tienda?id=<?= htmlspecialchars($libro['id']) ?>">
                        <img src="<?= htmlspecialchars($libro['imagen']) ?>" class="card-img-top" alt="Portada de <?= htmlspecialchars($libro['titulo']) ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($libro['titulo']) ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($libro['descripcion_corta']) ?></p>
                        <a href="<?= BASE_URL ?>/tienda?id=<?= $libro['id'] ?>" class="btn btn-marilu1-gradiente mt-auto align-self-start">Ver Detalles</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div> <!-- fin .row -->
    </div> <!-- fin .container -->
</section>

<!-- ==========================
     SECCIÓN NOTICIAS Y PRESENTACIONES
     =========================== -->
<section id="noticias" class="py-5">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-5">Últimas Noticias y Presentaciones</h2>
        <div class="row">
            <!-- Columna Noticias (Contenido Dinámico PHP) -->
            <div class="col-lg-7 mb-4 mb-lg-0" data-aos="fade-up">
                <h3 class="mb-4">
                    <a href="<?= APP_URL ?>/noticias" class="text-decoration-none">
                        Noticias Recientes
                    </a>
                </h3>
                <article class="mb-4 border-bottom pb-3">
                    <h4><a href="#">Título Noticia 1 (Cargado desde DB)</a></h4>
                    <p class="text-muted">Fecha Noticia 1</p>
                    <p>Extracto de la noticia cargada desde la base de datos...</p>
                    <a href="#" class="btn btn-sm btn-outline-secondary">Leer Más</a>
                </article>
                <article class="mb-4 border-bottom pb-3">
                    <h4><a href="#">Título Noticia 2 (Cargado desde DB)</a></h4>
                    <p class="text-muted">Fecha Noticia 2</p>
                    <p>Otro extracto de noticia cargada dinámicamente...</p>
                    <a href="#" class="btn btn-sm btn-outline-secondary">Leer Más</a>
                </article>
                <!-- Aquí iría la lógica PHP para cargar noticias -->
                <p class="text-center fst-italic">[Placeholder: Aquí se cargarán dinámicamente las noticias]</p>
            </div>

            <!-- Columna Presentaciones -->
            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="100">
            <a href="<?= APP_URL ?>/noticias" class="mb-4 text-decoration-none">
                    Próximas Presentaciones
                </a>
                <div class="list-group">
                    <div class="list-group-item list-group-item-action flex-column align-items-start mb-3 shadow-sm">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Lugar Presentación 1</h5>
                            <small class="text-muted">DD/MM/AAAA</small>
                        </div>
                        <p class="mb-1">Breve descripción o detalles del evento 1. Dirección, horario, etc.</p>
                    </div>
                    <div class="list-group-item list-group-item-action flex-column align-items-start mb-3 shadow-sm">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Lugar Presentación 2</h5>
                            <small class="text-muted">DD/MM/AAAA</small>
                        </div>
                        <p class="mb-1">Breve descripción o detalles del evento 2.</p>
                    </div>
                    <div class="list-group-item list-group-item-action flex-column align-items-start mb-3 shadow-sm">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Lugar Presentación 3</h5>
                            <small class="text-muted">DD/MM/AAAA</small>
                        </div>
                        <p class="mb-1">Breve descripción o detalles del evento 3.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================
     SECCIÓN TEASER GALERÍA
     =========================== -->
<section id="galeria-index" class="py-5 bg-light">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-5">Galería de Fotos</h2>
        <div class="row g-3 gallery-teaser">
            <!-- Imagen 1 (más grande) -->
            <div class="col-lg-6 col-md-12" data-aos="zoom-in">
                <div class="gallery-item position-relative overflow-hidden rounded shadow">
                    <img src="<?= APP_URL ?>/assets/images/gallery/placeholder1_large.jpg" class="img-fluid" alt="Galería Imagen 1">
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center opacity-0">
                        <i class="fas fa-search-plus fa-3x text-white"></i> <!-- Icono placeholder -->
                    </div>
                </div>
            </div>
            <!-- Imagen 2 (pequeña) -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                 <div class="gallery-item position-relative overflow-hidden rounded shadow">
                    <img src="<?= APP_URL ?>/assets/images/gallery/placeholder2_small.jpg" class="img-fluid" alt="Galería Imagen 2">
                     <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center opacity-0">
                        <i class="fas fa-search-plus fa-3x text-white"></i>
                    </div>
                </div>
            </div>
            <!-- Imagen 3 (pequeña) -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                 <div class="gallery-item position-relative overflow-hidden rounded shadow">
                    <img src="<?= APP_URL ?>/assets/images/gallery/placeholder3_small.jpg" class="img-fluid" alt="Galería Imagen 3">
                     <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center opacity-0">
                        <i class="fas fa-search-plus fa-3x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <!-- Enlace a la futura página galeria.php -->
            <a href="#" class="btn btn-primary btn-lg">Ver Galería Completa</a>
            <!-- Debería ser algo como <a href="<?= APP_URL ?>/galeria" class="btn btn-primary btn-lg">Ver Galería Completa</a> -->
        </div>
    </div>
</section>



<main class="container mt-4">
    <div class="jumbotron bg-light p-5 rounded-lg m-3" data-aos="fade-up">
        <h1 class="display-4"><?= htmlspecialchars($pageTitle ?? APP_NAME) ?></h1>
        <p class="lead"><?= htmlspecialchars($pageDescription) ?></p>
        <hr class="my-4">
        <p>Este es el contenido principal de la página de inicio. ¡El Router y el Controlador funcionan!</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Llamada a la acción</a>
    </div>

    <section class="mt-5 container">
        <h2>Últimos Libros</h2>
        <p>(Aquí iría una lista dinámica de libros cargados desde la base de datos `libros`)</p>
        <!-- Ejemplo de cómo podría verse (requiere CSS o Bootstrap para estilos): -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <!-- <img src="/ruta/a/imagen1.jpg" class="card-img-top" alt="Libro 1"> -->
                    <div class="card-body">
                        <h5 class="card-title">Título del Libro 1</h5>
                        <p class="card-text">Breve descripción del libro...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Ver Detalles</a>
                            <span class="text-muted">$Precio</span>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <!-- <img src="/ruta/a/imagen2.jpg" class="card-img-top" alt="Libro 2"> -->
                     <div class="card-body">
                        <h5 class="card-title">Título del Libro 2</h5>
                        <p class="card-text">Otra descripción interesante...</p>
                         <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Ver Detalles</a>
                            <span class="text-muted">$Precio</span>
                        </div>
                    </div>
                </div>
            </div>
           </div>
    </section>

</main>
