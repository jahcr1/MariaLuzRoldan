<?php
// Vista para listar noticias en el panel de administración
$noticias = $noticias ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-newspaper me-2"></i>Gestión de Noticias</h1>
    <a href="<?= APP_URL ?>/admin/noticias/crear" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Nueva Noticia
    </a>
</div>

<?php if(isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?? 'success' ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['mensaje'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">Listado de Noticias</h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="buscar-noticia" class="form-control" placeholder="Buscar noticia...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col" width="60">ID</th>
                        <th scope="col" width="80">Imagen</th>
                        <th scope="col">Título</th>
                        <th scope="col">Fecha Publicación</th>
                        <th scope="col">Destacado</th>
                        <th scope="col">Estado</th>
                        <th scope="col" width="140">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($noticias)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay noticias registradas aún</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($noticias as $noticia): ?>
                            <tr>
                                <td><?= htmlspecialchars($noticia['id']) ?></td>
                                <td>
                                    <?php if(!empty($noticia['imagen'])): ?>
                                        <img src="<?= APP_URL ?>/<?= htmlspecialchars($noticia['imagen']) ?>" 
                                             alt="<?= htmlspecialchars($noticia['titulo']) ?>" 
                                             class="img-thumbnail" width="50">
                                    <?php else: ?>
                                        <div class="bg-light text-center p-1 rounded">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($noticia['titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?></td>
                                <td>
                                    <span class="badge <?= $noticia['destacado'] ? 'bg-warning' : 'bg-secondary' ?>">
                                        <?= $noticia['destacado'] ? 'Destacado' : 'Normal' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $noticia['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $noticia['activo'] ? 'Publicada' : 'Borrador' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= APP_URL ?>/admin/noticias/editar/<?= $noticia['id'] ?>" 
                                           class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="confirmarEliminar('<?= APP_URL ?>/admin/noticias/eliminar/<?= $noticia['id'] ?>', 'noticia')" 
                                           class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?= APP_URL ?>/noticias/<?= $noticia['slug'] ?>" target="_blank" 
                                           class="btn btn-outline-info" data-bs-toggle="tooltip" title="Ver en sitio">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">Mostrando <?= count($noticias) ?> noticias</p>
            </div>
            <div class="col-md-6">
                <!-- Aquí se implementaría la paginación si fuera necesario -->
            </div>
        </div>
    </div>
</div>

<script>
    // Script para filtrar la tabla
    document.addEventListener('DOMContentLoaded', function() {
        const buscarInput = document.getElementById('buscar-noticia');
        if (buscarInput) {
            buscarInput.addEventListener('keyup', function() {
                const valor = this.value.toLowerCase();
                const tabla = document.querySelector('table');
                const filas = tabla.querySelectorAll('tbody tr');
                
                filas.forEach(function(fila) {
                    const texto = fila.textContent.toLowerCase();
                    if(texto.indexOf(valor) > -1) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
