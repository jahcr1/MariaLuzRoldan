// Navbar sticky mejorado
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;
    let hideTimeout;
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll <= 100) {
            navbar.style.transform = 'translateY(0)';
            navbar.style.opacity = '1';
            return;
        }
        
        if (currentScroll > lastScroll) {
            navbar.style.transform = 'translateY(0)';
            navbar.style.opacity = '1';
        }
        
        clearTimeout(hideTimeout);
        hideTimeout = setTimeout(() => {
            navbar.style.transform = 'translateY(-100%)';
            navbar.style.opacity = '0';
        }, 3000);
        
        lastScroll = currentScroll;
    });

    navbar.addEventListener('mouseenter', () => {
        clearTimeout(hideTimeout);
        navbar.style.transform = 'translateY(0)';
        navbar.style.opacity = '1';
    });
});
