// Modal Functions
function openNouveauSuiviModal() {
    console.log('Opening modal...');
    const modal = document.getElementById('nouveauSuiviModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Set default date to current date
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        const dateInput = document.getElementById('date');
        if (dateInput) {
            dateInput.value = formattedDate;
        }
    }
}

function closeNouveauSuiviModal() {
    console.log('Closing modal...');
    const modal = document.getElementById('nouveauSuiviModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';

        const form = document.getElementById('nouveauSuiviForm');
        if (form) {
            form.reset();
        }
    }
}

// Validation function
function validateForm() {
    const clientId = document.getElementById('client_id').value;
    const date = document.getElementById('date').value;
    const note = document.getElementById('note').value;

    if (!clientId) {
        alert('Please select a client');
        return false;
    }

    if (!date) {
        alert('Please select a date');
        return false;
    }

    if (!note.trim()) {
        alert('Please add notes');
        return false;
    }

    return true;
}

// Event Listeners Setup
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - suivis.js');

    // Nouveau Suivi Button
    const nouveauSuiviButton = document.getElementById('nouveauSuiviBtn');
    if (nouveauSuiviButton) {
        console.log('Nouveau Suivi button found');
        nouveauSuiviButton.addEventListener('click', function(e) {
            console.log('Nouveau Suivi button clicked');
            e.preventDefault();
            openNouveauSuiviModal();
        });
    } else {
        console.log('Nouveau Suivi button not found');

        // Fallback: try to find button by text content
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            if (button.textContent.includes('Nouveau Suivi')) {
                console.log('Found button by text content');
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    openNouveauSuiviModal();
                });
            }
        });
    }

    // Cancel Modal Button
    const cancelBtn = document.getElementById('cancelModalBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeNouveauSuiviModal();
        });
    }

    // Close modal when clicking outside
    const modal = document.getElementById('nouveauSuiviModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeNouveauSuiviModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('nouveauSuiviModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeNouveauSuiviModal();
            }
        }
    });

    // Form submission handling
    const form = document.getElementById('nouveauSuiviForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission attempted');

            if (!validateForm()) {
                e.preventDefault();
                return false;
            }

            console.log('Form validated, submitting...');
            // Form will submit normally if validation passes
        });
    }

    // Edit buttons
    const editButtons = document.querySelectorAll('.edit-suivi-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const suiviId = this.getAttribute('data-suivi-id');
            console.log('Edit suivi:', suiviId);

            // You can implement edit functionality here
            // For example, populate the modal with existing data
            // openEditSuiviModal(suiviId);
        });
    });

    // Delete buttons
    const deleteButtons = document.querySelectorAll('.delete-suivi-btn');
    // deleteButtons.forEach(button => {
    //     button.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         const suiviId = this.getAttribute('data-suivi-id');

    //         if (confirm('Êtes-vous sûr de vouloir supprimer ce suivi?')) {
    //             console.log('Delete suivi:', suiviId);

    //             // Send delete request
    //             fetch(`/suivis/${suiviId}`, {
    //                 method: 'DELETE',
    //                 headers: {
    //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //                     'Content-Type': 'application/json',
    //                 }
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 if (data.success) {
    //                     location.reload(); // Reload page to reflect changes
    //                 } else {
    //                     alert('Erreur lors de la suppression');
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Error:', error);
    //                 alert('Erreur lors de la suppression');
    //             });
    //         }
    //     });
    // });

    // Complete buttons
    const completeButtons = document.querySelectorAll('.complete-suivi-btn');
    // completeButtons.forEach(button => {
    //     button.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         const suiviId = this.getAttribute('data-suivi-id');

    //         if (confirm('Marquer ce suivi comme terminé?')) {
    //             console.log('Complete suivi:', suiviId);

    //             // Send update request
    //             fetch(`/suivis/${suiviId}/complete`, {
    //                 method: 'PATCH',
    //                 headers: {
    //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //                     'Content-Type': 'application/json',
    //                 }
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 if (data.success) {
    //                     location.reload(); // Reload page to reflect changes
    //                 } else {
    //                     alert('Erreur lors de la mise à jour');
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Error:', error);
    //                 alert('Erreur lors de la mise à jour');
    //             });
    //         }
    //     });
    // });

    // Branch filter functionality (if exists)
    const branchFilter = document.getElementById('branch_filter');
    if (branchFilter) {
        branchFilter.addEventListener('change', function() {
            const loadingIndicator = document.getElementById('loading-indicator');
            if (loadingIndicator) {
                loadingIndicator.classList.remove('hidden');
            }
        });
    }
});

// Additional utility functions
function showNotification(message, type = 'success') {
    // Create a simple notification
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Export functions if using modules (optional)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        openNouveauSuiviModal,
        closeNouveauSuiviModal,
        validateForm,
        showNotification
    };
}
