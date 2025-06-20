let currentInvoiceId = null;

function showNotification(message, type = 'error') {
const notification = document.getElementById('notification');
const content = document.getElementById('notificationContent');
const icon = document.getElementById('notificationIcon');
const messageEl = document.getElementById('notificationMessage');

icon.className = 'fas text-lg';
if (type === 'success') {
content.className = 'flex items-center justify-between px-6 py-4 min-w-96 rounded-lg shadow-lg border backdrop-blur-smbg-green-50 border-green-200 text-green-800';
icon.classList.add('fa-check-circle', 'text-green-600');
} else {
content.className = 'flex items-center justify-between px-6 py-4 min-w-96 rounded-lg shadow-lg border backdrop-blur-smbg-red-50 border-red-200 text-red-800';
icon.classList.add('fa-exclamation-circle', 'text-red-600');
}

messageEl.textContent = message;
notification.classList.remove('hidden');

// Smooth animation
setTimeout(() => {
notification.classList.remove('-translate-y-full');
}, 10);

setTimeout(() => closeNotification(), 5000);
}

function closeNotification() {
const notification = document.getElementById('notification');
notification.classList.add('-translate-y-full');
setTimeout(() => {
notification.classList.add('hidden');
}, 300);
}

function deleteInvoice(invoiceId) {
currentInvoiceId = invoiceId;
const modal = document.getElementById('deleteModal');
const passwordInput = document.getElementById('confirmPassword');
const passwordError = document.getElementById('passwordError');

modal.classList.remove('hidden');
passwordInput.value = '';
passwordInput.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
passwordError.classList.add('hidden');

setTimeout(() => passwordInput.focus(), 100);
}

function closeModal() {
document.getElementById('deleteModal').classList.add('hidden');
currentInvoiceId = null;
}

function confirmDelete() {
const password = document.getElementById('confirmPassword').value;
const passwordInput = document.getElementById('confirmPassword');
const passwordError = document.getElementById('passwordError');

passwordInput.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
passwordError.classList.add('hidden');

if (!password) {
passwordInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
passwordError.classList.remove('hidden');
passwordInput.focus();
return;
}

const deleteBtn = event.target;
const originalText = deleteBtn.innerHTML;
deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Suppression...';
deleteBtn.disabled = true;

fetch('/invoices/delete', {
method: 'POST',
headers: {
'Content-Type': 'application/json',
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
'Accept': 'application/json'
},
body: JSON.stringify({
invoice_id: currentInvoiceId,
password: password
})
})
.then(response => {
if (!response.ok) return response.json().then(data => Promise.reject(data));
return response.json();
})
.then(data => {
closeModal();
showNotification(data.message || 'Supprimé avec succès', 'success');
setTimeout(() => location.reload(), 1500);
})
.catch(error => {
deleteBtn.innerHTML = originalText;
deleteBtn.disabled = false;

closeModal();
showNotification(error.message || 'Erreur lors de la suppression', 'error');
});
}

window.addEventListener('click', function (e) {
if (e.target.id === 'deleteModal') closeModal();
});

window.addEventListener('keydown', function (e) {
if (e.key === 'Escape') closeModal();
});

document.addEventListener('DOMContentLoaded', function() {
const passwordInput = document.getElementById('confirmPassword');
passwordInput.addEventListener('keydown', function(e) {
if (e.key === 'Enter') {
confirmDelete();
}
});
});
