    </div> <!-- Cierre de .container (contenido principal) -->
</main> <!-- Cierre de .main-content -->

<footer>
    <div class="container">
        <p>
            <!-- Aquí podrías poner iconos de redes sociales -->
            <a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">Twitter</a>
        </p>
        <p>
            <!-- Enlaces rápidos o información de contacto -->
            <a href="<?= BASE_URL ?>/politica-privacidad">Política de Privacidad</a> | 
            <a href="<?= BASE_URL ?>/terminos-uso">Términos de Uso</a>
        </p>
        <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. Diseñado y desarrollado con ❤️.</p>
        <!-- Puedes añadir el nombre del escritor o editorial aquí -->
    </div>
</footer>

<!-- Scripts JavaScript -->
<!-- Es preferible cargarlos al final del body para mejorar el rendimiento de carga -->
<!-- <script src="<?= BASE_URL ?>/assets/js/main.js"></script> -->
<!-- <script src="<?= BASE_URL ?>/assets/js/navbar.js"></script> -->

</body>
</html>
