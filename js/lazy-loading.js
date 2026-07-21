// ========== LAZY LOADING ==========
document.addEventListener('DOMContentLoaded', () => {
    const bgElements = document.querySelectorAll('[data-bg]');
    const bgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bg = entry.target.dataset.bg;
                if (bg) entry.target.style.backgroundImage = `url('${bg}')`;
                bgObserver.unobserve(entry.target);
            }
        });
    }, { rootMargin: '200px 0px' });
    bgElements.forEach(el => bgObserver.observe(el));

    const lazyImages = document.querySelectorAll('.lazy-img');
    const imgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.dataset.src;
                if (src) {
                    img.src = src;
                    img.addEventListener('load', () => img.classList.add('fade-in'));
                }
                imgObserver.unobserve(img);
            }
        });
    }, { rootMargin: '100px 0px' });
    lazyImages.forEach(img => imgObserver.observe(img));
});