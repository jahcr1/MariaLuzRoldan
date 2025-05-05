document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ver-mas-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const card = this.closest('.noticia-card');
            const resumen = card.querySelector('.noticia-resumen');
            const isCollapsed = resumen.dataset.collapsed === 'true';
            
            resumen.dataset.collapsed = !isCollapsed;
            this.setAttribute('aria-expanded', isCollapsed);
            this.textContent = isCollapsed ? 'Ver menos' : 'Ver más';
        });
    });
});
