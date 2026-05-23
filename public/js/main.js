// ===== MAIN JAVASCRIPT =====

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - Website ready!');

    // Initialize
    initNavigation();
    initForms();
    initAlerts();
});

// ===== NAVIGATION =====
function initNavigation() {
    const navLinks = document.querySelectorAll('nav a');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all
            navLinks.forEach(l => l.parentElement.classList.remove('active'));
            // Add active to current
            this.parentElement.classList.add('active');
        });
    });
}

// ===== FORMS =====
function initForms() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Optionally add validation here
            console.log('Form submitted:', this);
        });
    });

    // Real-time validation for inputs
    const inputs = document.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.toggle('is-invalid', !this.value.trim());
        });
    });
}

// ===== ALERTS =====
function initAlerts() {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        // Auto-close alerts after 5 seconds
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

// ===== UTILITY FUNCTIONS =====

// Show alert message
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    const mainContent = document.querySelector('main') || document.body;
    mainContent.insertBefore(alertDiv, mainContent.firstChild);

    initAlerts(); // Reinit to set timeout
}

// API Call with error handling
async function apiCall(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...options.headers
            },
            ...options
        });

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        showAlert('An error occurred. Please try again.', 'danger');
        throw error;
    }
}

// Format date
function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===== TABLE FUNCTIONS =====

// Search in table
function searchTable(tableId, inputId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    const rows = table.querySelectorAll('tbody tr');

    input.addEventListener('keyup', debounce(function() {
        const searchTerm = this.value.toLowerCase();

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    }, 300));
}

// Sort table
function sortTable(tableId, columnIndex) {
    const table = document.getElementById(tableId);
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();

        return isNaN(aText) ?
            aText.localeCompare(bText) :
            parseFloat(aText) - parseFloat(bText);
    });

    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
}

// ===== EXPORT FUNCTIONS =====
window.showAlert = showAlert;
window.apiCall = apiCall;
window.formatDate = formatDate;
window.searchTable = searchTable;
window.sortTable = sortTable;
