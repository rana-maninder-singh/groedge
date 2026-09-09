// contact-script.js - Additional contact form functionality

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
        var digits = val.replace(/\D/g, '');
        if (f.label && !val) {
            errEl.textContent = f.label + ' is required.';
            isValid = false;
        } else if (f.id === 'phone' && digits.length < 10) {
            errEl.textContent = 'Phone number must include at least 10 digits.';
            isValid = false;
        } else if (f.minLen && f.id !== 'phone' && val.length < f.minLen) {
            errEl.textContent = f.label + ' must be at least ' + f.minLen + ' characters.';
            isValid = false;
        } else if (f.pattern && !f.pattern.test(val)) {
            errEl.textContent = 'Please enter a valid ' + f.label.toLowerCase() + '.';
            isValid = false;
        }
    });
    return isValid;
}

function readSavedForm() {
    try {
        var raw = localStorage.getItem('groedgeContactForm');
        if (!raw) return {};
        var data = JSON.parse(raw);
        return data && typeof data === 'object' ? data : {};
    } catch (e) {
        try { localStorage.removeItem('groedgeContactForm'); } catch (ignore) {}
        return {};
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('contactForm');
    if (!form) return;

    // Prefer server-rendered values / error state over local draft
    var hasServerErrors = Array.prototype.some.call(document.querySelectorAll('.error-message'), function(el) {
        return (el.textContent || '').trim().length > 0;
    });
    var nameField = form.elements.name;
    var hasServerValues = !!(nameField && nameField.value);
    if (!hasServerErrors && !hasServerValues) {
        var savedData = readSavedForm();
        Object.keys(savedData).forEach(function(key) {
            var field = form.elements[key];
            if (field) field.value = savedData[key];
        });
    }

    form.addEventListener('input', function(e) {
        if (!e.target.name) return;
        var formData = readSavedForm();
        formData[e.target.name] = e.target.value;
        try {
            localStorage.setItem('groedgeContactForm', JSON.stringify(formData));
        } catch (ignore) {}
    });

    form.addEventListener('submit', function() {
        setTimeout(function() {
            try { localStorage.removeItem('groedgeContactForm'); } catch (ignore) {}
        }, 1000);
    });
});
