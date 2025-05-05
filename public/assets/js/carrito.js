// Carrito básico (se implementará completamente luego)
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar contador del carrito
    function actualizarCarrito() {
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        const contador = document.querySelector('.navbar .badge');
        if (contador) {
            contador.textContent = carrito.length;
        }
    }
    
    // Actualizar al cargar
    actualizarCarrito();
    
    // Escuchar eventos de actualización (se implementará completamente en la tienda)
    window.addEventListener('carrito-actualizado', actualizarCarrito);
});
