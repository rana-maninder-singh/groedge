// contact-script.js - Additional contact form functionality

// Global validation function (called from form onsubmit)
function validateForm() {
    var isValid = true;
    var fields = [
        { id: 'name', errorId: 'name-error', minLen: 2, label: 'Full name' },
        { id: 'email', errorId: 'email-error', pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, label: 'Email' },
        { id: 'phone', errorId: 'phone-error', minLen: 10, label: 'Phone number' },
        { id: 'company', errorId: 'company-error', minLen: 2, label: 'Company name' },
        { id: 'industry', errorId: 'industry-error', label: 'Industry' },
        { id: 'challenge', errorId: 'challenge-error', minLen: 10, label: 'Biggest operational challenge' }
    ];
    fields.forEach(function(f) {
        var el = document.getElementById(f.id);
        var errEl = document.getElementById(f.errorId);
        if (!errEl) return;
        errEl.textContent = '';
        if (!el) return;
        var val = (el.value || '').trim();
        if (f.label && !val) {
            errEl.textContent = f.label + ' is required.';
            isValid = false;
        } else if (f.minLen && val.length < f.minLen) {
            errEl.textContent = f.label + ' must be at least ' + f.minLen + ' characters.';
            isValid = false;
        } else if (f.pattern && !f.pattern.test(val)) {
            errEl.textContent = 'Please enter a valid ' + f.label.toLowerCase() + '.';
            isValid = false;
        }
    });
    return isValid;
}

document.addEventListener('DOMContentLoaded', function() {
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                value = '+' + value;
                if (value.length > 4) {
                    value = value.slice(0, 4) + ' ' + value.slice(4);
                }
                if (value.length > 9) {
                    value = value.slice(0, 9) + ' ' + value.slice(9);
                }
                if (value.length > 14) {
                    value = value.slice(0, 14);
                }
            }
            
            e.target.value = value;
        });
    }
    
    // Form field auto-save to localStorage
    const form = document.getElementById('contactForm');
    if (form) {
        // Load saved form data
        const savedData = JSON.parse(localStorage.getItem('groedgeContactForm')) || {};
        Object.keys(savedData).forEach(key => {
            const field = form.elements[key];
            if (field) {
                field.value = savedData[key];
            }
        });
        
        // Save form data on input
        form.addEventListener('input', function(e) {
            if (e.target.name) {
                const formData = JSON.parse(localStorage.getItem('groedgeContactForm')) || {};
                formData[e.target.name] = e.target.value;
                localStorage.setItem('groedgeContactForm', JSON.stringify(formData));
            }
        });
        
        // Clear saved data on successful submission
        form.addEventListener('submit', function() {
            setTimeout(() => {
                localStorage.removeItem('groedgeContactForm');
            }, 1000);
        });
    }
    
    // Add map interaction (placeholder)
    const mapPlaceholder = document.querySelector('.map-placeholder');
    if (mapPlaceholder) {
        mapPlaceholder.addEventListener('click', function() {
            this.innerHTML = '<p>📍 Map integration coming soon!</p><p>For now, please use our contact information above.</p>';
            this.style.backgroundColor = '#d4edda';
            this.style.color = '#155724';
            this.style.cursor = 'default';
        });
    }
});