<?php
// Vista para listar libros en el panel de administración
$libros = $libros ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-book me-2"></i>Gestión de Libros</h1>
    <a href="<?= APP_URL ?>/admin/libros/crear" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nuevo Libro
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
                <h5 class="mb-0">Listado de Libros</h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="buscar-libro" class="form-control" placeholder="Buscar libro...">
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
                        <th scope="col">ISBN</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Estado</th>
                        <th scope="col" width="140">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($libros)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">No hay libros registrados aún</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($libros as $libro): ?>
                            <tr>
                                <td><?= htmlspecialchars($libro['id']) ?></td>
                                <td>
                                    <?php if(!empty($libro['cover_image_main'])): ?>
                                        <img src="<?= APP_URL ?>/assets/images/books/<?= htmlspecialchars($libro['cover_image_main']) ?>" 
                                             alt="<?= htmlspecialchars($libro['title']) ?>" 
                                             class="img-thumbnail" width="50">
                                    <?php else: ?>
                                        <div class="bg-light text-center p-1 rounded">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($libro['title']) ?></td>
                                <td><?= htmlspecialchars($libro['isbn'] ?? 'N/A') ?></td>
                                <td>$<?= number_format($libro['price'], 2) ?></td>
                                <td>
                                    <span class="badge <?= $libro['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $libro['stock'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $libro['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $libro['is_active'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= APP_URL ?>/admin/libros/editar/<?= $libro['id'] ?>" 
                                           class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="confirmarEliminar('<?= APP_URL ?>/admin/libros/eliminar/<?= $libro['id'] ?>', 'libro')" 
                                           class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="<?= APP_URL ?>/tienda/libro/<?= $libro['id'] ?>" target="_blank" 
                                           class="btn btn-outline-info" data-bs-toggle="tooltip" title="Ver en tienda">
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
                <p class="mb-0">Mostrando <?= count($libros) ?> libros</p>
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
        const buscarInput = document.getElementById('buscar-libro');
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
