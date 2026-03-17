/*
    Script: relance l'effet "machine à écrire" pour les éléments
    .typewriter chaque fois qu'ils deviennent visibles dans la fenêtre
    grâce à IntersectionObserver (compatible avec Swiper).
    */
document.addEventListener('DOMContentLoaded', () => {
    const elems = document.querySelectorAll('.typewriter');
    const speed = 28; // ms per character

    function clearTyping(el) {
        if (el._typingTimer) {
            clearTimeout(el._typingTimer);
            el._typingTimer = null;
        }
    }

    function typeText(el) {
        clearTyping(el);
        const text = el.getAttribute('data-text') || el.textContent.trim();
        el.textContent = '';
        const chars = Array.from(text);
        let i = 0;
        function step() {
            if (i < chars.length) {
                el.textContent += chars[i++];
                el._typingTimer = setTimeout(step, speed);
            } else {
                el._typingTimer = null;
            }
        }
        // slight delay to improve UX when slide becomes visible
        el._typingTimer = setTimeout(step, 180);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const el = entry.target;
            if (entry.isIntersecting && entry.intersectionRatio > 0.4) {
                typeText(el);
            } else {
                clearTyping(el);
            }
        });
    }, { threshold: [0, 0.4, 0.6, 1] });

    elems.forEach(el => {
        // ensure initial empty state
        el.textContent = '';
        observer.observe(el);
    });
});

/*
    Script: anime `h2`, premier `p` et `img` dans `.pro` à leur apparition.
    Utilise IntersectionObserver pour relancer l'effet à chaque entrée dans la vue.
    */
document.addEventListener('DOMContentLoaded', () => {
    const proObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const pro = entry.target;
            if (entry.isIntersecting && entry.intersectionRatio > 0.25) {
                pro.classList.add('in-view');
            } else {
                pro.classList.remove('in-view');
            }
        });
    }, { threshold: [0, 0.25, 0.5] });

    const pros = document.querySelectorAll('.pro');
    pros.forEach((pro, idx) => {
        const h2 = pro.querySelector('h2');
        const firstP = pro.querySelector('p');
        const img = pro.querySelector('img');
        const priceSpan = pro.querySelector('span');

        // allow explicit variant via data-variant ("2" or "variant-2"), otherwise assign by index
        const forced = (pro.getAttribute('data-variant') || '').trim();
        let variant;
        if (forced) {
            variant = forced.startsWith('variant-') ? forced : ('variant-' + forced.replace(/[^0-9]/g, '') );
        } else {
            variant = 'variant-' + ((idx % 3) + 1);
        }
        pro.classList.add(variant);

        // Assign distinct effect combos per variant so each .pro looks different
        if (variant === 'variant-1') {
            if (h2) { h2.classList.add('anim-left'); h2.style.transitionDelay = '0.24s'; }
            if (firstP) { firstP.classList.add('anim-right'); firstP.style.transitionDelay = '0.5s'; }
            if (img) { img.classList.add('anim-up'); img.style.transitionDelay = '0.8s'; }
            if (priceSpan) { priceSpan.classList.add('price-blink', 'price-variant-1'); priceSpan.style.animationDuration = '1.2s'; }
        } else if (variant === 'variant-2') {
            if (h2) { h2.classList.add('anim-rotate'); h2.style.transitionDelay = '0.18s'; }
            if (firstP) { firstP.classList.add('anim-fade-scale'); firstP.style.transitionDelay = '0.44s'; }
            if (img) { img.classList.add('anim-left'); img.style.transitionDelay = '0.72s'; }
            if (priceSpan) { priceSpan.classList.add('price-blink', 'price-variant-2'); priceSpan.style.animationDuration = '1.6s'; }
        } else { // variant-3
            if (h2) { h2.classList.add('anim-zoom'); h2.style.transitionDelay = '0.2s'; }
            if (firstP) { firstP.classList.add('anim-tilt'); firstP.style.transitionDelay = '0.46s'; }
            if (img) { img.classList.add('anim-bounce'); img.style.transitionDelay = '0.78s'; }
            if (priceSpan) { priceSpan.classList.add('price-blink', 'price-variant-3'); priceSpan.style.animationDuration = '1s'; }
        }

            proObserver.observe(pro);
    });
});

// Ajoute temporairement la classe 'highlight' + 'pulse' quand .pro entre en vue
(function(){
    const highlightObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const pro = entry.target;
            if (entry.isIntersecting && entry.intersectionRatio > 0.25) {
                pro.classList.add('highlight');
                // restart pulse
                pro.classList.remove('pulse');
                // force reflow
                void pro.offsetWidth;
                pro.classList.add('pulse');
                // remove pulse after animation so it can replay next time
                setTimeout(() => pro.classList.remove('pulse'), 1800);
            } else {
                pro.classList.remove('highlight');
                pro.classList.remove('pulse');
            }
        });
    }, { threshold: [0, 0.25, 0.5] });

    document.querySelectorAll('.pro').forEach(p => highlightObserver.observe(p));
})();