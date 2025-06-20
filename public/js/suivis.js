function openNouveauSuiviModal() {
console.log('Opening modal...');
const modal = document.getElementById('nouveauSuiviModal');
if (modal) {
modal.classList.remove('hidden');
document.body.style.overflow = 'hidden';

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

document.addEventListener('DOMContentLoaded', function() {
console.log('DOM Content Loaded - suivis.js');

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

const cancelBtn = document.getElementById('cancelModalBtn');
if (cancelBtn) {
cancelBtn.addEventListener('click', function(e) {
e.preventDefault();
closeNouveauSuiviModal();
});
}

const modal = document.getElementById('nouveauSuiviModal');
if (modal) {
modal.addEventListener('click', function(e) {
if (e.target === modal) {
closeNouveauSuiviModal();
}
});
}

document.addEventListener('keydown', function(e) {
if (e.key === 'Escape') {
const modal = document.getElementById('nouveauSuiviModal');
if (modal && !modal.classList.contains('hidden')) {
closeNouveauSuiviModal();
}
}
});

const form = document.getElementById('nouveauSuiviForm');
if (form) {
form.addEventListener('submit', function(e) {
console.log('Form submission attempted');

if (!validateForm()) {
e.preventDefault();
return false;
}

console.log('Form validated, submitting...');
});
}

const editButtons = document.querySelectorAll('.edit-suivi-btn');
editButtons.forEach(button => {
button.addEventListener('click', function(e) {
e.preventDefault();
const suiviId = this.getAttribute('data-suivi-id');
console.log('Edit suivi:', suiviId);

});
});

const deleteButtons = document.querySelectorAll('.delete-suivi-btn');


const completeButtons = document.querySelectorAll('.complete-suivi-btn');

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
const notification = document.createElement('div');
notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
}`;
notification.textContent = message;

document.body.appendChild(notification);

setTimeout(() => {
notification.remove();
}, 3000);
}

if (typeof module !== 'undefined' && module.exports) {
module.exports = {
openNouveauSuiviModal,
closeNouveauSuiviModal,
validateForm,
showNotification
};
}
