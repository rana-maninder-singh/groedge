// services-script.js - Additional services page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Service card interaction tracking
    const serviceCards = document.querySelectorAll('.service');
    
    serviceCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Only track if not clicking on read-more button
            if (!e.target.classList.contains('read-more-btn')) {
                const serviceTitle = this.querySelector('h2');
                if (serviceTitle) {
                    // Optional: use for analytics or expand card
                }
            }
        });
    });
});