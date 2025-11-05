// Auto-hide alerts after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    // Find all alert messages
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 3000);
    });
});

// Confirm deletes
function confirmDelete(event) {
    if (!confirm('Are you sure you want to delete this item?')) {
        event.preventDefault();
        return false;
    }
    return true;
}
