            </div> <!-- Cierre del container-fluid -->
        </div> <!-- Cierre del #content -->
    </div> <!-- Cierre del .wrapper -->

    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (requerido para algunas funcionalidades) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Script para el toggle del sidebar -->
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        
        // Inicialización de tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Confirmación para eliminar elementos
        function confirmarEliminar(url, elemento) {
            if (confirm('¿Estás seguro de que deseas eliminar este ' + elemento + '? Esta acción no se puede deshacer.')) {
                window.location.href = url;
            }
            return false;
        }
    </script>
    
    <!-- Scripts adicionales específicos de cada página se pueden incluir aquí -->
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= APP_URL . '/assets/js/' . $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
</body>
</html>
