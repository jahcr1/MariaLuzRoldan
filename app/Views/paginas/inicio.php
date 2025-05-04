<?php
// Asegurarse de que las variables están definidas para evitar errores
$pageTitle = $pageTitle ?? 'Bienvenido';
$pageDescription = $pageDescription ?? 'Página de inicio';
?>

<main class="container mt-4">
    <div class="jumbotron bg-light p-5 rounded-lg m-3">
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
