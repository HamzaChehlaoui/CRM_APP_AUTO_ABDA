// Modal Functions - External JavaScript File
let currentSuiviId = null;

// Delete Modal Functions
function showDeleteModal(suiviId, clientName) {
    currentSuiviId = suiviId;
    document.getElementById('clientNameSpan').textContent = clientName;
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('modalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    // Animation
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function hideDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('modalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentSuiviId = null;
    }, 200);
}

function confirmDelete() {
    if (currentSuiviId && typeof Livewire !== 'undefined') {
        // Using Livewire component reference - you may need to adjust this
        // depending on how your Livewire component is structured
        Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
            .call('deleteSuivi', currentSuiviId);
        hideDeleteModal();
    }
}

// Edit Modal Functions
function showEditModal() {
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    // Animation
    setTimeout(() => {
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function hideEditModal() {
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
}

// Event Listeners
function initializeModalEvents() {
    // Livewire event listeners for edit modal
    if (typeof Livewire !== 'undefined') {
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-edit-modal', () => {
                showEditModal();
            });
            Livewire.on('hide-edit-modal', () => {
                hideEditModal();
            });
        });
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const deleteModal = document.getElementById('deleteModal');
        const editModal = document.getElementById('editModal');

        if (event.target === deleteModal) {
            hideDeleteModal();
        }

        if (event.target === editModal && typeof Livewire !== 'undefined') {
            // You may need to adjust this Livewire component reference
            Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
                .call('cancelEdit');
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideDeleteModal();
            if (typeof Livewire !== 'undefined') {
                // You may need to adjust this Livewire component reference
                Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
                    .call('cancelEdit');
            }
        }
    });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeModalEvents);
} else {
    initializeModalEvents();
}
