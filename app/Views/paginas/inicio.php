<?php
// Asegurarse de que las variables están definidas para evitar errores
$pageTitle = $pageTitle ?? 'Bienvenido';
$pageDescription = $pageDescription ?? 'Página de inicio';
?>

<!-- ==========================
     SECCIÓN SLIDER PROPAGANDA
     =========================== -->
<section id="slider-propaganda" class="mb-5">
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
                <img src="https://via.placeholder.com/1920x600/eee/888?text=Slider+Imagen+1" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 1</h5>
                    <p>Descripción breve o llamada a la acción para el slide 1.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1920x600/ddd/777?text=Slider+Imagen+2" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 2</h5>
                    <p>Descripción breve o llamada a la acción para el slide 2.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1920x600/ccc/666?text=Slider+Imagen+3" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 3</h5>
                    <p>Descripción breve o llamada a la acción para el slide 3.</p>
                </div>
            </div>
             <!-- Slide 4 -->
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1920x600/bbb/555?text=Slider+Imagen+4" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                    <h5>Título Slide 4</h5>
                    <p>Descripción breve o llamada a la acción para el slide 4.</p>
                </div>
            </div>
             <!-- Slide 5 -->
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1920x600/aaa/444?text=Slider+Imagen+5" class="d-block w-100" alt="...">
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
<section id="nuevos-lanzamientos" class="container my-5 py-5">
    <div class="row align-items-center">
        <div class="col-md-5" data-aos="fade-right">
            <!-- Portada del Libro (Placeholder) -->
            <!-- Reemplaza '...' con la ruta a la imagen. Tamaño ~400x600 -->
            <img src="https://via.placeholder.com/400x600/eee/888?text=Portada+Libro" class="img-fluid rounded shadow-lg" alt="Portada Último Lanzamiento">
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
</section>

<main class="container mt-4">
    <div class="jumbotron bg-light p-5 rounded-lg m-3" data-aos="fade-up">
        <h1 class="display-4"><?= htmlspecialchars($pageTitle) ?></h1>
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
