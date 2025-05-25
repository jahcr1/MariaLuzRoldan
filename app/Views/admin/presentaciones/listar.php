<?php
// Vista para listar presentaciones en el panel de administración
$presentaciones = $presentaciones ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-calendar-alt me-2"></i>Gestión de Presentaciones</h1>
    <a href="<?= APP_URL ?>/admin/presentaciones/crear" class="btn btn-info text-white">
        <i class="fas fa-plus me-1"></i> Nueva Presentación
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
                <h5 class="mb-0">Listado de Presentaciones y Eventos</h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="buscar-presentacion" class="form-control" placeholder="Buscar presentación...">
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
                        <th scope="col">Lugar</th>
                        <th scope="col">Fecha del Evento</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado</th>
                        <th scope="col" width="140">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($presentaciones)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">No hay presentaciones registradas aún</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($presentaciones as $presentacion): ?>
                            <?php 
                            // Determinar si el evento ya pasó
                            $eventoPasado = strtotime($presentacion['fecha_evento']) < time();
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($presentacion['id']) ?></td>
                                <td><?= htmlspecialchars($presentacion['lugar']) ?></td>
                                <td>
                                    <span class="<?= $eventoPasado ? 'text-muted' : 'fw-bold' ?>">
                                        <?= date('d/m/Y H:i', strtotime($presentacion['fecha_evento'])) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars(substr($presentacion['descripcion'], 0, 100)) ?><?= strlen($presentacion['descripcion']) > 100 ? '...' : '' ?></td>
                                <td>
                                    <?php if($eventoPasado): ?>
                                        <span class="badge bg-secondary">Finalizado</span>
                                    <?php else: ?>
                                        <span class="badge <?= $presentacion['activo'] ? 'bg-success' : 'bg-warning' ?>">
                                            <?= $presentacion['activo'] ? 'Programado' : 'Borrador' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= APP_URL ?>/admin/presentaciones/editar/<?= $presentacion['id'] ?>" 
                                           class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="confirmarEliminar('<?= APP_URL ?>/admin/presentaciones/eliminar/<?= $presentacion['id'] ?>', 'presentación')" 
                                           class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php if(!empty($presentacion['enlace'])): ?>
                                            <a href="<?= htmlspecialchars($presentacion['enlace']) ?>" target="_blank" 
                                            class="btn btn-outline-info" data-bs-toggle="tooltip" title="Enlace externo">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        <?php endif; ?>
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
                <p class="mb-0">Mostrando <?= count($presentaciones) ?> presentaciones</p>
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
        const buscarInput = document.getElementById('buscar-presentacion');
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
