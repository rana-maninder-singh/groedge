// script.js - GroEdge website functionality
document.addEventListener('DOMContentLoaded', function() {
    highlightActiveNav();
    initReadMoreButtons();
    addBackToTopButton();
    initRevealOnScroll();
    initTestimonialCarousel();
    initMegaMenu();
    initMobileMenu();
});

function initRevealOnScroll() {
    var items = document.querySelectorAll('.reveal');
    if (!items.length || !('IntersectionObserver' in window)) {
        items.forEach(function(el) { el.classList.add('is-visible'); });
        return;
    }
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    items.forEach(function(el) { observer.observe(el); });
}

function highlightActiveNav() {
    var currentPage = window.location.pathname.split('/').pop();
    var navLinks = document.querySelectorAll('.main-nav > a, .main-nav > .nav-dropdown > .nav-dropdown-toggle');
    navLinks.forEach(function(link) {
        var href = link.getAttribute('href');
        if (!href) return;
        var linkPage = href.split('/').pop();
        if (linkPage === currentPage ||
            (currentPage === '' && (linkPage === 'index.html' || linkPage === 'index.php')) ||
            (currentPage === 'index.php' && linkPage === 'index.php')) {
            link.classList.add('active');
        }
    });
}

function initReadMoreButtons() {
    var readMoreBtns = document.querySelectorAll('.read-more-btn');
    readMoreBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var details = this.previousElementSibling;
            var isVisible = details.style.display === 'block';
            if (isVisible) {
                details.style.display = 'none';
                this.innerHTML = '&#9660; View Detailed Methodology';
            } else {
                details.style.display = 'block';
                this.innerHTML = '&#9650; Hide Details';
            }
        });
    });
}

function addBackToTopButton() {
    var button = document.createElement('button');
    button.id = 'backToTop';
    button.innerHTML = '&#8593;';
    button.title = 'Back to top';
    Object.assign(button.style, {
        position: 'fixed',
        bottom: '90px',
        right: '24px',
        width: '45px',
        height: '45px',
        backgroundColor: '#0b1320',
        color: 'white',
        border: 'none',
        borderRadius: '50%',
        fontSize: '1.2rem',
        cursor: 'pointer',
        display: 'none',
        zIndex: '997',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
    });
    document.body.appendChild(button);
    window.addEventListener('scroll', function() {
        button.style.display = window.scrollY > 300 ? 'block' : 'none';
    });
    button.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

function initTestimonialCarousel() {
    var carousel = document.getElementById('testimonialCarousel');
    if (!carousel) return;
    var track = carousel.querySelector('.testimonial-track');
    var cards = carousel.querySelectorAll('.testimonial-card');
    var prevBtn = carousel.querySelector('.carousel-prev');
    var nextBtn = carousel.querySelector('.carousel-next');
    var dotsContainer = carousel.querySelector('.carousel-dots');
    if (!cards.length || !track) return;
    var currentIndex = 0;
    var autoplayTimer = null;

    cards.forEach(function(_, i) {
        var dot = document.createElement('button');
        dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Go to testimonial ' + (i + 1));
        dot.addEventListener('click', function() { goTo(i); });
        dotsContainer.appendChild(dot);
    });

    function goTo(index) {
        if (index < 0) index = cards.length - 1;
        if (index >= cards.length) index = 0;
        currentIndex = index;
        track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
        carousel.querySelectorAll('.carousel-dot').forEach(function(d, i) {
            d.classList.toggle('active', i === currentIndex);
        });
        resetAutoplay();
    }

    function resetAutoplay() {
        if (autoplayTimer) clearInterval(autoplayTimer);
        autoplayTimer = setInterval(function() { goTo(currentIndex + 1); }, 5000);
    }

    if (prevBtn) prevBtn.addEventListener('click', function() { goTo(currentIndex - 1); });
    if (nextBtn) nextBtn.addEventListener('click', function() { goTo(currentIndex + 1); });
    carousel.addEventListener('mouseenter', function() { if (autoplayTimer) clearInterval(autoplayTimer); });
    carousel.addEventListener('mouseleave', resetAutoplay);
    resetAutoplay();
}

function initMegaMenu() {
    var dropdowns = document.querySelectorAll('.nav-dropdown');
    dropdowns.forEach(function(dropdown) {
        var toggle = dropdown.querySelector('.nav-dropdown-toggle');
        if (!toggle) return;

        // Desktop: hover
        dropdown.addEventListener('mouseenter', function() {
            if (window.innerWidth > 768) {
                dropdown.classList.add('open');
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
        dropdown.addEventListener('mouseleave', function() {
            if (window.innerWidth > 768) {
                dropdown.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Mobile: click toggle
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            var isOpen = dropdown.classList.contains('open');
            // Close other dropdowns
            dropdowns.forEach(function(d) { d.classList.remove('open'); d.querySelector('.nav-dropdown-toggle').setAttribute('aria-expanded', 'false'); });
            if (!isOpen) {
                dropdown.classList.add('open');
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-dropdown')) {
            dropdowns.forEach(function(d) {
                d.classList.remove('open');
                d.querySelector('.nav-dropdown-toggle').setAttribute('aria-expanded', 'false');
            });
        }
    });
}

function initMobileMenu() {
    var toggle = document.querySelector('.mobile-menu-toggle');
    var nav = document.querySelector('.main-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', function() {
        var isOpen = nav.classList.contains('open');
        nav.classList.toggle('open');
        toggle.classList.toggle('open');
        toggle.setAttribute('aria-expanded', !isOpen);
    });
}
