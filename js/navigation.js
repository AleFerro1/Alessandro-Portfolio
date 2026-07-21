// ========== NAVIGAZIONE ==========
(function() {
    const wrapper = document.getElementById("pageWrapper");
    const sections = document.querySelectorAll("section[id]");
    const navItems = document.querySelectorAll("#sideList li");
    const sideList = document.getElementById('sideList');

    window.currentIndex = 0;
    window.isAnimating = false;
    window.TRANSITION_MS = 1000;

    history.scrollRestoration = 'manual';

    // 👇 Altezza fissa delle sezioni in pixel
    function updateSectionHeight() {
        window.sectionHeight = window.innerHeight;
        sections.forEach(section => {
            section.style.height = window.sectionHeight + 'px';
        });
    }
    updateSectionHeight(); // imposta subito

    window.getIndexFromHash = function() {
        const hash = window.location.hash.replace('#', '');
        if (!hash) return 0;
        const target = document.getElementById(hash);
        if (!target) return 0;
        return Array.from(sections).indexOf(target);
    };

    const originalHash = window.location.hash;
    if (originalHash) {
        history.replaceState(null, '', window.location.pathname + window.location.search);
    }

    wrapper.addEventListener('transitionstart', () => { wrapper.style.willChange = 'transform'; });
    wrapper.addEventListener('transitionend', () => { wrapper.style.willChange = 'auto'; });

    window.animateSectionContent = function(section) {
        const containers = section.querySelectorAll('.about-inner, .skills-inner, .projects-container, .contact-inner');
        containers.forEach(el => {
            el.classList.add('in-view');
            if (el.classList.contains('skills-inner')) {
                if (typeof window.initConstellation === 'function') window.initConstellation();
            }
        });
        const accentLines = section.querySelectorAll('.accent-line');
        accentLines.forEach(line => {
            line.classList.remove('animate-line');
            void line.offsetWidth;
            line.classList.add('animate-line');
        });
    };

    let onWrapperTransitionEnd = null;
    let wrapperTransitionTimer = null;

    window.goToSection = function(index) {
        const clamped = Math.max(0, Math.min(sections.length - 1, index));
        if (clamped === window.currentIndex) return;

        document.querySelectorAll('.about-inner, .skills-inner, .projects-container, .contact-inner')
            .forEach(el => el.classList.remove('in-view'));

        window.currentIndex = clamped;
        window.isAnimating = true;

        // Usa l'altezza fissa delle sezioni (non window.innerHeight, che potrebbe variare)
        const offsetPx = clamped * window.sectionHeight;
        wrapper.style.transform = `translateY(-${offsetPx}px)`;

        navItems.forEach(li => li.classList.remove("active"));
        const activeLi = document.querySelector(`#sideList li[data-target="${sections[clamped].id}"]`);
        if (activeLi) activeLi.classList.add("active");

        const newHash = `#${sections[clamped].id}`;
        if (window.location.hash !== newHash) history.pushState(null, '', newHash);

        if (onWrapperTransitionEnd) wrapper.removeEventListener('transitionend', onWrapperTransitionEnd);
        onWrapperTransitionEnd = () => {
            wrapper.removeEventListener('transitionend', onWrapperTransitionEnd);
            onWrapperTransitionEnd = null;
            window.animateSectionContent(sections[clamped]);
            window.isAnimating = false;
        };
        wrapper.addEventListener('transitionend', onWrapperTransitionEnd);

        clearTimeout(wrapperTransitionTimer);
        wrapperTransitionTimer = setTimeout(() => {
            if (onWrapperTransitionEnd) {
                wrapper.removeEventListener('transitionend', onWrapperTransitionEnd);
                onWrapperTransitionEnd = null;
                window.animateSectionContent(sections[clamped]);
            }
            window.isAnimating = false;
        }, window.TRANSITION_MS + 100);
    };

    // Al resize ricalcola l'altezza e riposiziona il wrapper senza animazione
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            const oldHeight = window.sectionHeight;
            updateSectionHeight(); // ricalcola altezza sezioni
            if (window.sectionHeight !== oldHeight) {
                wrapper.style.transition = 'none';
                const offsetPx = window.currentIndex * window.sectionHeight;
                wrapper.style.transform = `translateY(-${offsetPx}px)`;
                wrapper.offsetHeight; // reflow
                wrapper.style.transition = 'transform 1s cubic-bezier(0.76, 0, 0.24, 1)';
            }
        }, 150);
    });

    // ----- Resto della logica (invariata) -----
    function sectionCanScroll(el) { return el.scrollHeight > el.clientHeight + 1; }
    function sectionAtTop(el) { return el.scrollTop <= 0; }
    function sectionAtBottom(el) { return el.scrollTop + el.clientHeight >= el.scrollHeight - 1; }

    window.addEventListener("wheel", (e) => {
        if (window.isAnimating) return;
        const sectionEl = sections[window.currentIndex];
        const sectionId = sectionEl.id;

        if (sectionId === 'projects') {
            e.preventDefault();
            if (e.deltaY > 0) {
                if (window.cardIndex < window.maxCards) { window.cardIndex++; window.updateCardDeck(window.cardIndex); }
                else { window.goToSection(window.currentIndex + 1); }
            } else if (e.deltaY < 0) {
                if (window.cardIndex > 0) { window.cardIndex--; window.updateCardDeck(window.cardIndex); }
                else { window.goToSection(window.currentIndex - 1); }
            }
            return;
        }

        if (sectionCanScroll(sectionEl)) {
            if (e.deltaY < 0 && !sectionAtTop(sectionEl)) return;
            if (e.deltaY > 0 && !sectionAtBottom(sectionEl)) return;
        }
        e.preventDefault();
        window.goToSection(window.currentIndex + (e.deltaY > 0 ? 1 : -1));
    }, { passive: false });

    let touchStartY = 0;
    window.addEventListener("touchstart", (e) => { touchStartY = e.touches[0].clientY; }, { passive: true });
    window.addEventListener("touchmove", (e) => {
        if (window.isAnimating) return;
        const sectionEl = sections[window.currentIndex];
        if (sectionEl.id === 'projects') { e.preventDefault(); return; }
        if (sectionCanScroll(sectionEl)) {
            const currentY = e.touches[0].clientY;
            const delta = touchStartY - currentY;
            if (delta < 0 && !sectionAtTop(sectionEl)) return;
            if (delta > 0 && !sectionAtBottom(sectionEl)) return;
        }
        e.preventDefault();
    }, { passive: false });

    window.addEventListener("touchend", (e) => {
        if (window.isAnimating) return;
        const delta = touchStartY - e.changedTouches[0].clientY;
        if (Math.abs(delta) < 50) return;
        const sectionEl = sections[window.currentIndex];
        const sectionId = sectionEl.id;

        if (sectionId !== 'projects' && sectionCanScroll(sectionEl)) {
            if (delta < 0 && !sectionAtTop(sectionEl)) return;
            if (delta > 0 && !sectionAtBottom(sectionEl)) return;
        }

        if (sectionId === 'projects') {
            if (delta > 0) {
                if (window.cardIndex < window.maxCards) { window.cardIndex++; window.updateCardDeck(window.cardIndex); }
                else { window.goToSection(window.currentIndex + 1); }
            } else if (delta < 0) {
                if (window.cardIndex > 0) { window.cardIndex--; window.updateCardDeck(window.cardIndex); }
                else { window.goToSection(window.currentIndex - 1); }
            }
        } else {
            window.goToSection(window.currentIndex + (delta > 0 ? 1 : -1));
        }
    });

    window.addEventListener("keydown", (e) => {
        if (window.isAnimating) return;
        const sectionId = sections[window.currentIndex].id;
        let direction = 0;
        if (["ArrowDown", "PageDown"].includes(e.key)) direction = 1;
        else if (["ArrowUp", "PageUp"].includes(e.key)) direction = -1;
        if (direction !== 0) {
            e.preventDefault();
            if (sectionId === 'projects') {
                if (direction === 1) {
                    if (window.cardIndex < window.maxCards) { window.cardIndex++; window.updateCardDeck(window.cardIndex); }
                    else { window.goToSection(window.currentIndex + 1); }
                } else {
                    if (window.cardIndex > 0) { window.cardIndex--; window.updateCardDeck(window.cardIndex); }
                    else { window.goToSection(window.currentIndex - 1); }
                }
            } else {
                window.goToSection(window.currentIndex + direction);
            }
        }
    });

    sideList.addEventListener('click', (e) => {
        const li = e.target.closest('li');
        if (!li) return;
        if (window.isAnimating) return;
        const target = document.getElementById(li.dataset.target);
        const index = Array.from(sections).indexOf(target);
        if (target.id === 'projects') {
            window.cardIndex = 0;
            setTimeout(() => window.updateCardDeck(0), 300);
        }
        window.goToSection(index);
    });

    window.addEventListener("hashchange", () => {
        if (window.isAnimating) return;
        const newIndex = window.getIndexFromHash();
        if (sections[newIndex] && sections[newIndex].id === 'projects') {
            window.cardIndex = 0;
            setTimeout(() => window.updateCardDeck(0), 300);
        }
        window.goToSection(newIndex);
    });

    // Scroll cue
    document.querySelectorAll('.scroll-cue-wrapper').forEach(el => {
        el.addEventListener('click', (e) => {
            e.stopPropagation();
            if (window.isAnimating) return;
            const direction = el.dataset.direction === 'up' ? -1 : 1;
            const parentSection = el.closest('section');
            const idx = Array.from(sections).indexOf(parentSection);

            if (parentSection.id === 'projects') {
                if (direction === 1) {
                    if (window.cardIndex < window.maxCards) { window.cardIndex++; window.updateCardDeck(window.cardIndex); }
                    else { window.goToSection(idx + 1); }
                } else {
                    if (window.cardIndex > 0) { window.cardIndex--; window.updateCardDeck(window.cardIndex); }
                    else { window.goToSection(idx - 1); }
                }
                return;
            }
            window.goToSection(idx + direction);
        });
    });
})();