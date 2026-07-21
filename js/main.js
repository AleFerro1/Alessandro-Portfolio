// ========== MAIN INIT ==========
(function() {
    // Avvio navigazione
    const finalIndex = window.getIndexFromHash();
    window.goToSection(finalIndex);

    // Forza l'animazione sulla sezione iniziale
    const initialSection = document.querySelector(`section[id="${window.location.hash.replace('#','') || 'home'}"]`);
    if (initialSection) {
        window.animateSectionContent(initialSection);
    }

    // Inizializza costellazione se la sezione skills è già visibile
    if (document.getElementById('skills').getBoundingClientRect().top < window.innerHeight) {
        setTimeout(window.initConstellation, 100);
    }

    // Rimuove SVG pesante su mobile
    if (window.matchMedia('(max-width: 768px)').matches) {
        const svgContainer = document.getElementById('contactSvgContainer');
        if (svgContainer) svgContainer.remove();
    }
})();