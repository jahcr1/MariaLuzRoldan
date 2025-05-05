    <?php // Plantilla de pie de página: incluye cierre de etiquetas HTML, scripts JS globales y/o información de copyright. ?>

</div> <!-- Cierre de .container (contenido principal) -->
</main> <!-- Cierre de .main-content -->

<footer class="bg-dark text-light mt-5 py-4">
    <div class="container text-center">
        <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. Todos los derechos reservados.</p>
        <!-- Podríamos añadir enlaces a redes sociales aquí -->
        <div>
            <a href="#" class="text-light me-2"><i class="fab fa-facebook-f"></i></a> <!-- Necesitarías FontAwesome u otros iconos -->
            <a href="#" class="text-light me-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle (Incluye Popper) (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- AOS JS (CDN) -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Inicialización de AOS -->
<script>
  AOS.init({
    duration: 1000, // Duración de la animación en ms
    once: true // Si la animación debe ocurrir solo una vez
  });
</script>

<!-- Scripts para embeds -->
<script async defer src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v12.0"></script>
<script async defer src="//www.instagram.com/embed.js"></script>
<script src="<?= APP_URL ?>/assets/js/embeds.js"></script>

<!-- Scripts personalizados (si los creamos más adelante) -->
<!-- <script src="<?= BASE_URL ?>/assets/js/main.js"></script> -->
<!-- <script src="<?= BASE_URL ?>/assets/js/navbar.js"></script> -->

</body>
</html>
