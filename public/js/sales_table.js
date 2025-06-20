let currentSuiviId = null;

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
Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
.call('deleteSuivi', currentSuiviId);
hideDeleteModal();
}
}

function showEditModal() {
const modal = document.getElementById('editModal');
const content = document.getElementById('editModalContent');
modal.classList.remove('hidden');
modal.classList.add('flex');
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

function initializeModalEvents() {
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

document.addEventListener('click', function(event) {
const deleteModal = document.getElementById('deleteModal');
const editModal = document.getElementById('editModal');

if (event.target === deleteModal) {
hideDeleteModal();
}

if (event.target === editModal && typeof Livewire !== 'undefined') {
Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
.call('cancelEdit');
}
});

document.addEventListener('keydown', function(event) {
if (event.key === 'Escape') {
hideDeleteModal();
if (typeof Livewire !== 'undefined') {
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
