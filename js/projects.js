// ========== PROJECTS DECK ==========
(function() {
    window.cardIndex = 0;
    window.maxCards = document.querySelectorAll('.project-card').length - 1;
    const cardDeck = document.getElementById('cardDeck');

    window.updateDeckDots = function(index) {
        const dots = document.querySelectorAll('.deck-dot');
        dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
    };

    window.updateCardDeck = function(index) {
        const cards = cardDeck.querySelectorAll('.project-card');
        cards.forEach((card, i) => {
            if (i < index) {
                card.style.opacity = '0';
                card.style.transform = 'translateX(-120%) rotate(-15deg) scale(0.7)';
                card.style.zIndex = '0';
                card.style.pointerEvents = 'none';
            } else if (i === index) {
                card.style.opacity = '1';
                card.style.transform = 'translateX(0) rotate(0deg) scale(1)';
                card.style.zIndex = '10';
                card.style.pointerEvents = 'auto';
            } else {
                const stackOffset = (i - index) * 20;
                card.style.opacity = '1';
                card.style.transform = `translateX(0) rotate(0deg) scale(${1 - (i - index) * 0.05}) translateY(-${stackOffset}px)`;
                card.style.zIndex = '5';
                card.style.pointerEvents = 'none';
            }
        });
        window.updateDeckDots(index);
    };

    setTimeout(() => window.updateCardDeck(0), 100);
})();