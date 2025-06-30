function showLogoutModal() {
const modal = document.getElementById('logoutModal');
const modalContent = modal.querySelector('div > div');

modal.classList.remove('opacity-0', 'invisible');
modal.classList.add('opacity-100', 'visible');

setTimeout(() => {
modalContent.classList.remove('scale-95');
modalContent.classList.add('scale-100');
}, 10);

document.body.style.overflow = 'hidden';
}

function hideLogoutModal() {
const modal = document.getElementById('logoutModal');
const modalContent = modal.querySelector('div > div');

modalContent.classList.remove('scale-100');
modalContent.classList.add('scale-95');

setTimeout(() => {
modal.classList.remove('opacity-100', 'visible');
modal.classList.add('opacity-0', 'invisible');
}, 200);

document.body.style.overflow = 'auto';
}

function confirmLogout() {
const confirmBtn = event.target;
const originalText = confirmBtn.innerHTML;

confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging out...';
confirmBtn.disabled = true;

setTimeout(() => {
document.getElementById('logout-form').submit();
}, 800);
}

document.getElementById('logoutModal').addEventListener('click', function(e) {
if (e.target === this) {
hideLogoutModal();
}
});

document.addEventListener('keydown', function(e) {
if (e.key === 'Escape') {
hideLogoutModal();
}
});
