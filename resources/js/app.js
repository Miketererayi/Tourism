/**
 * Tourism App — UI Interactions
 * - IntersectionObserver for scroll animations
 * - Scroll-to-top button
 */

// Scroll Animations via IntersectionObserver
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('[data-animate]');

    if (animatedElements.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        animatedElements.forEach(el => observer.observe(el));
    } else {
        // Fallback: show everything immediately
        animatedElements.forEach(el => el.classList.add('is-visible'));
    }

    // Stagger children
    const staggerContainers = document.querySelectorAll('.stagger-children');
    if (staggerContainers.length && 'IntersectionObserver' in window) {
        const staggerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    staggerObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.05,
            rootMargin: '0px 0px -20px 0px'
        });

        staggerContainers.forEach(el => staggerObserver.observe(el));
    } else {
        staggerContainers.forEach(el => el.classList.add('is-visible'));
    }
});

// Scroll-to-Top Button
(function() {
    const btn = document.getElementById('scroll-top-btn');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();
