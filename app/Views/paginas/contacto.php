<?php
// Vista de la página de contacto
$datos = $datos ?? [];
$errores = $errores ?? [];
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="display-4 mb-4 text-center">Contacto</h1>
            
            <?php if(isset($_SESSION['mensaje_exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['mensaje_exito'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['mensaje_exito']); ?>
            <?php endif; ?>
            
            <div class="row g-5">
                <!-- Formulario de contacto -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">Envíame un mensaje</h3>
                            
                            <form action="<?= APP_URL ?>/contacto/enviar" method="post">
                                <!-- Nombre -->
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>" 
                                           id="nombre" name="nombre" value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>" required>
                                    <?php if(isset($errores['nombre'])): ?>
                                        <div class="invalid-feedback"><?= $errores['nombre'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?= isset($errores['email']) ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= htmlspecialchars($datos['email'] ?? '') ?>" required>
                                    <?php if(isset($errores['email'])): ?>
                                        <div class="invalid-feedback"><?= $errores['email'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Asunto -->
                                <div class="mb-3">
                                    <label for="asunto" class="form-label">Asunto <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= isset($errores['asunto']) ? 'is-invalid' : '' ?>" 
                                           id="asunto" name="asunto" value="<?= htmlspecialchars($datos['asunto'] ?? '') ?>" required>
                                    <?php if(isset($errores['asunto'])): ?>
                                        <div class="invalid-feedback"><?= $errores['asunto'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Mensaje -->
                                <div class="mb-4">
                                    <label for="mensaje" class="form-label">Mensaje <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?= isset($errores['mensaje']) ? 'is-invalid' : '' ?>" 
                                              id="mensaje" name="mensaje" rows="5" required><?= htmlspecialchars($datos['mensaje'] ?? '') ?></textarea>
                                    <?php if(isset($errores['mensaje'])): ?>
                                        <div class="invalid-feedback"><?= $errores['mensaje'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Enviar mensaje
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Información de contacto -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">Información de contacto</h3>
                            
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary text-white rounded-circle p-3">
                                        <i class="fas fa-envelope fa-fw"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5>Email</h5>
                                    <p class="mb-0"><a href="mailto:contacto@marialuzroldan.com" class="text-decoration-none">contacto@marialuzroldan.com</a></p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary text-white rounded-circle p-3">
                                        <i class="fas fa-map-marker-alt fa-fw"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5>Ubicación</h5>
                                    <p class="mb-0">Buenos Aires, Argentina</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary text-white rounded-circle p-3">
                                        <i class="fas fa-share-alt fa-fw"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5>Redes sociales</h5>
                                    <div class="d-flex gap-2 mt-2">
                                        <a href="#" class="btn btn-outline-primary" title="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger" title="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-info" title="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="text-center">
                                <h5 class="mb-3">Horario de atención</h5>
                                <p class="mb-0">Lunes a Viernes: 9:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de preguntas frecuentes -->
<div class="bg-light py-5 mt-5">
    <div class="container">
        <h2 class="text-center mb-5">Preguntas frecuentes</h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="accordionFAQ">
                    <!-- Pregunta 1 -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                ¿Dónde puedo comprar tus libros?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                Mis libros están disponibles en la sección de <a href="<?= APP_URL ?>/tienda">Tienda</a> de este sitio web, así como en las principales librerías del país y plataformas de venta online.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pregunta 2 -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                ¿Realizas envíos al exterior?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                Sí, realizamos envíos internacionales. Los costos y tiempos de entrega varían según el país de destino. Durante el proceso de compra podrás ver las opciones disponibles.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pregunta 3 -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                ¿Cómo puedo solicitar una presentación o charla?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                Puedes enviarme un mensaje a través del formulario de contacto de esta página con los detalles de tu propuesta: lugar, fecha, tipo de evento y público esperado. Te responderé a la brevedad para coordinar los detalles.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pregunta 4 -->
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                ¿Firmas ejemplares por correo?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                En ocasiones especiales organizo campañas de firma de ejemplares. Para consultar sobre la próxima oportunidad, escríbeme a través del formulario de contacto o mantente atento/a a mis redes sociales.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
