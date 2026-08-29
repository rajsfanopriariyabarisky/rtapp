import './bootstrap';
import "tailwindcss";
import './index.js'

// Auto-save form data to localStorage
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const formId = form.id || 'form-' + Math.random().toString(36).substr(2, 9);
        form.id = formId;
        
        // Load saved data when page loads
        loadFormData(form);
        
        // Save data on input change
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                saveFormData(form);
            });
            
            input.addEventListener('change', () => {
                saveFormData(form);
            });
        });
        
        // Clear saved data on successful submit
        form.addEventListener('submit', () => {
            setTimeout(() => {
                clearFormData(form);
            }, 1000);
        });
    });
});

function saveFormData(form) {
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    localStorage.setItem('form_' + form.id, JSON.stringify(data));
}

function loadFormData(form) {
    const savedData = localStorage.getItem('form_' + form.id);
    
    if (savedData) {
        const data = JSON.parse(savedData);
        
        Object.keys(data).forEach(key => {
            const input = form.querySelector(`[name="${key}"]`);
            if (input && !input.value) { // Only fill if input is empty
                if (input.type === 'checkbox') {
                    input.checked = data[key] === 'on';
                } else if (input.type === 'radio') {
                    const radio = form.querySelector(`[name="${key}"][value="${data[key]}"]`);
                    if (radio) radio.checked = true;
                } else if (input.tagName === 'SELECT') {
                    input.value = data[key];
                } else {
                    input.value = data[key];
                }
            }
        });
    }
}

function clearFormData(form) {
    localStorage.removeItem('form_' + form.id);
}

// Add visual feedback for form validation
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.remove('border-red-500');
            }
        });
    });
});