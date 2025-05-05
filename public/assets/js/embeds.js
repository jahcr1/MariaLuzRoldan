document.addEventListener('DOMContentLoaded', function() {
    // Carga embeds para evitar bloqueos de renderizado
    const embeds = document.querySelectorAll('[data-platform]');
    
    embeds.forEach(embed => {
        const platform = embed.dataset.platform;
        const url = embed.dataset.url;
        
        switch(platform) {
            case 'facebook':
                embed.innerHTML = 
                    `<div class="fb-post" 
                      data-href="${url}"
                      data-width="100%"></div>`;
                break;
            case 'instagram':
                embed.innerHTML = 
                    `<blockquote class="instagram-media" 
                      data-instgrm-permalink="${url}"
                      data-instgrm-version="13"></blockquote>`;
                break;
        }
    });
});
