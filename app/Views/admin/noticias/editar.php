<?php
// Vista para editar noticia existente
$noticia = $noticia ?? [];
$errores = $errores ?? [];

// Verificar que tengamos una noticia válida
if (empty($noticia) || !isset($noticia['id'])) {
    header('Location: ' . APP_URL . '/admin/noticias');
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-edit me-2"></i>Editar Noticia</h1>
    <a href="<?= APP_URL ?>/admin/noticias" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
</div>

<?php if(isset($errores['general'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $errores['general'] ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= APP_URL ?>/admin/noticias/actualizar" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($noticia['id']) ?>">
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Título -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= isset($errores['titulo']) ? 'is-invalid' : '' ?>" 
                               id="titulo" name="titulo" value="<?= htmlspecialchars($noticia['titulo'] ?? '') ?>" required>
                        <?php if(isset($errores['titulo'])): ?>
                            <div class="invalid-feedback"><?= $errores['titulo'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Extracto -->
                    <div class="mb-3">
                        <label for="extracto" class="form-label">Extracto <small class="text-muted">(Máx. 500 caracteres)</small></label>
                        <textarea class="form-control <?= isset($errores['extracto']) ? 'is-invalid' : '' ?>" 
                                  id="extracto" name="extracto" rows="3"><?= htmlspecialchars($noticia['extracto'] ?? '') ?></textarea>
                        <div class="form-text">Breve resumen que aparecerá en las vistas previas.</div>
                        <?php if(isset($errores['extracto'])): ?>
                            <div class="invalid-feedback"><?= $errores['extracto'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Contenido completo -->
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido <span class="text-danger">*</span></label>
                        <textarea class="form-control <?= isset($errores['contenido']) ? 'is-invalid' : '' ?>" 
                                  id="contenido" name="contenido" rows="10" required><?= htmlspecialchars($noticia['contenido'] ?? '') ?></textarea>
                        <?php if(isset($errores['contenido'])): ?>
                            <div class="invalid-feedback"><?= $errores['contenido'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Imagen -->
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <?php if(!empty($noticia['imagen'])): ?>
                            <div class="mb-2">
                                <div class="card">
                                    <img src="<?= APP_URL ?>/<?= htmlspecialchars($noticia['imagen']) ?>" 
                                         class="card-img-top" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                                    <div class="card-body p-2 text-center">
                                        <small class="text-muted">Imagen actual</small>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" class="form-control <?= isset($errores['imagen']) ? 'is-invalid' : '' ?>" 
                               id="imagen" name="imagen" accept="image/*">
                        <div class="form-text">Formatos: JPG, PNG. Tamaño máx: 2MB</div>
                        <?php if(isset($errores['imagen'])): ?>
                            <div class="invalid-feedback"><?= $errores['imagen'] ?></div>
                        <?php endif; ?>
                        <div class="form-text">Deja en blanco para mantener la imagen actual.</div>
                        <div class="mt-2" id="imagen-preview"></div>
                    </div>

                    <!-- Fecha de publicación -->
                    <div class="mb-3">
                        <label for="fecha_publicacion" class="form-label">Fecha de publicación <span class="text-danger">*</span></label>
                        <input type="date" class="form-control <?= isset($errores['fecha_publicacion']) ? 'is-invalid' : '' ?>" 
                               id="fecha_publicacion" name="fecha_publicacion" 
                               value="<?= htmlspecialchars($noticia['fecha_publicacion'] ?? '') ?>" required>
                        <?php if(isset($errores['fecha_publicacion'])): ?>
                            <div class="invalid-feedback"><?= $errores['fecha_publicacion'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Estado y opciones -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Estado y opciones</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                      <?= isset($noticia['activo']) && $noticia['activo'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="activo">Publicar noticia</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="destacado" name="destacado" 
                                      <?= isset($noticia['destacado']) && $noticia['destacado'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="destacado">Destacar en portada</label>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Información adicional</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Slug:</strong> <?= htmlspecialchars($noticia['slug'] ?? '') ?></p>
                            <p class="mb-1"><strong>Creada:</strong> <?= isset($noticia['created_at']) ? date('d/m/Y H:i', strtotime($noticia['created_at'])) : 'N/A' ?></p>
                            <p class="mb-0"><strong>Última actualización:</strong> <?= isset($noticia['updated_at']) ? date('d/m/Y H:i', strtotime($noticia['updated_at'])) : 'N/A' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="<?= APP_URL ?>/admin/noticias" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Vista previa de la imagen seleccionada
    document.getElementById('imagen').addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('imagen-preview');
                preview.innerHTML = `
                    <div class="card">
                        <img src="${event.target.result}" class="card-img-top" alt="Vista previa">
                        <div class="card-body p-2 text-center">
                            <small class="text-muted">Vista previa nueva imagen</small>
                        </div>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        }
    });

    // Mejorar el editor de texto (puede implementarse con librerías como TinyMCE o CKEditor)
    document.addEventListener('DOMContentLoaded', function() {
        // Aquí se podría inicializar un editor enriquecido
        // Por ejemplo: tinymce.init({ selector: '#contenido' });
    });
</script>
