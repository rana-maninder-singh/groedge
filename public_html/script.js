// script.js - Basic functionality for GroEdge website
document.addEventListener('DOMContentLoaded', function() {
    
    // Navigation active state
    highlightActiveNav();
    
    // Read more functionality for services
    initReadMoreButtons();
    
    // Back to top button
    addBackToTopButton();

    // Scroll reveal for content bands
    initRevealOnScroll();
});

function initRevealOnScroll() {
    const items = document.querySelectorAll('.reveal');
    if (!items.length || !('IntersectionObserver' in window)) {
        items.forEach(function(el) { el.classList.add('is-visible'); });
        return;
    }

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    items.forEach(function(el) { observer.observe(el); });
}

// Highlight active navigation link
function highlightActiveNav() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage || 
            (currentPage === '' && linkPage === 'index.html')) {
            link.classList.add('active');
        }
    });
}

// Initialize read more buttons
function initReadMoreButtons() {
    const readMoreBtns = document.querySelectorAll('.read-more-btn');
    
    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const details = this.previousElementSibling;
            const isVisible = details.style.display === 'block';
            
            if (isVisible) {
                details.style.display = 'none';
                this.innerHTML = '▼ View Detailed Methodology';
            } else {
                details.style.display = 'block';
                this.innerHTML = '▲ Hide Details';
            }
        });
    });
}

// Add back to top button
function addBackToTopButton() {
    const button = document.createElement('button');
    button.id = 'backToTop';
    button.innerHTML = '↑';
    button.title = 'Back to top';
    
    // Style the button
    Object.assign(button.style, {
        position: 'fixed',
        bottom: '30px',
        right: '30px',
        width: '45px',
        height: '45px',
        backgroundColor: '#2c5282',
        color: 'white',
        border: 'none',
        borderRadius: '50%',
        fontSize: '1.2rem',
        cursor: 'pointer',
        display: 'none',
        zIndex: '1000',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
    });
    
    document.body.appendChild(button);
    
    // Show/hide button
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            button.style.display = 'block';
        } else {
            button.style.display = 'none';
        }
    });
    
    // Scroll to top
    button.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}