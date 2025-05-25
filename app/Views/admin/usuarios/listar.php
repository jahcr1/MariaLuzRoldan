<?php
// Vista para listar usuarios en el panel de administración
// Solo accesible para usuarios con rol 'admin'
$usuarios = $usuarios ?? [];

// Verificar si el usuario actual tiene rol de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ' . APP_URL . '/admin');
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-users me-2"></i>Gestión de Usuarios</h1>
    <a href="<?= APP_URL ?>/admin/usuarios/crear" class="btn btn-secondary">
        <i class="fas fa-user-plus me-1"></i> Nuevo Usuario
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
                <h5 class="mb-0">Listado de Usuarios del Panel</h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="buscar-usuario" class="form-control" placeholder="Buscar usuario...">
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Último Acceso</th>
                        <th scope="col">Estado</th>
                        <th scope="col" width="140">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($usuarios)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay usuarios registrados aún</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['id']) ?></td>
                                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td>
                                    <span class="badge <?= $usuario['rol'] === 'admin' ? 'bg-danger' : 'bg-info' ?>">
                                        <?= $usuario['rol'] === 'admin' ? 'Administrador' : 'Editor' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $usuario['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca' ?>
                                </td>
                                <td>
                                    <span class="badge <?= $usuario['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= APP_URL ?>/admin/usuarios/editar/<?= $usuario['id'] ?>" 
                                           class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if($_SESSION['usuario']['id'] != $usuario['id']): // No permitir eliminarse a sí mismo ?>
                                            <a href="#" onclick="confirmarEliminar('<?= APP_URL ?>/admin/usuarios/eliminar/<?= $usuario['id'] ?>', 'usuario')" 
                                            class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-outline-secondary" disabled data-bs-toggle="tooltip" title="No puedes eliminar tu propio usuario">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                <p class="mb-0">Mostrando <?= count($usuarios) ?> usuarios</p>
            </div>
            <div class="col-md-6">
                <!-- Aquí se implementaría la paginación si fuera necesario -->
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-shield-alt me-2 text-danger"></i> Importante
        </h5>
    </div>
    <div class="card-body">
        <div class="alert alert-warning">
            <strong>Precaución:</strong> La gestión de usuarios es una tarea administrativa sensible. Recuerda:
            <ul class="mb-0 mt-2">
                <li>Mantener siempre al menos un usuario con rol de administrador</li>
                <li>No compartir las credenciales de acceso</li>
                <li>Asignar roles adecuados según las responsabilidades de cada persona</li>
                <li>Desactivar usuarios que ya no deban tener acceso al sistema</li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Script para filtrar la tabla
    document.addEventListener('DOMContentLoaded', function() {
        const buscarInput = document.getElementById('buscar-usuario');
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
