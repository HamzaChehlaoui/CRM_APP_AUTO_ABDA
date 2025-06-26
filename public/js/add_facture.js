document.querySelectorAll('input[type="file"]').forEach(input => {
input.addEventListener('change', function(e) {
const type = this.id.replace('-image', '');
const file = e.target.files[0];
const previewDiv = document.getElementById(`preview-${type}`);
const placeholderDiv = document.getElementById(`placeholder-${type}`);
const previewImage = document.getElementById(`preview-image-${type}`);
const fileName = document.getElementById(`file-name-${type}`);
const fileSize = document.getElementById(`file-size-${type}`);
const pdfLinkContainer = document.querySelector(`.preview-pdf-link-container-${type}`);

if (file) {
placeholderDiv.classList.add('hidden');
previewDiv.classList.remove('hidden');

fileName.textContent = file.name;
fileSize.textContent = `${(file.size / 1024).toFixed(2)} KB`;

if (file.type.startsWith('image/')) {
const reader = new FileReader();
reader.onload = function(e) {
previewImage.src = e.target.result;
previewImage.classList.remove('hidden');
pdfLinkContainer.classList.add('hidden');
pdfLinkContainer.innerHTML = '';
};
reader.readAsDataURL(file);
} else if (file.type === 'application/pdf') {
previewImage.classList.add('hidden');
pdfLinkContainer.classList.remove('hidden');
pdfLinkContainer.innerHTML =
`<a href="${URL.createObjectURL(file)}" target="_blank" class="text-blue-600">Voir le PDF</a>`;
}
}
});

document.getElementById(`remove-image-${input.id.replace('-image', '')}`).addEventListener('click',
function() {
const type = this.id.replace('remove-image-', '');
const input = document.getElementById(`${type}-image`);
const previewDiv = document.getElementById(`preview-${type}`);
const placeholderDiv = document.getElementById(`placeholder-${type}`);
const previewImage = document.getElementById(`preview-image-${type}`);
const pdfLinkContainer = document.querySelector(`.preview-pdf-link-container-${type}`);

input.value = '';
previewDiv.classList.add('hidden');
placeholderDiv.classList.remove('hidden');
previewImage.src = '';
pdfLinkContainer.innerHTML = '';
});
});

// Add client-side required attribute for all fields when clicking Facturer
const facturerBtn = document.getElementById('facturerBtn');

if (facturerBtn) {
facturerBtn.addEventListener('click', function(e) {
document.getElementById('action-field').value = 'facturer';
const requiredFields = [
'client_id',
'car[brand]',
'car[model]',
'car[ivn]',
'car[registration_number]',
'car[chassis_number]',
'invoice[invoice_number]',
'invoice[sale_date]',
'invoice[total_amount]',
'invoice[purchase_order_number]',
'invoice[delivery_note_number]',
'invoice[payment_order_reference]'
];
// Add required image fields
const requiredImages = [
'image_invoice',
'image_bl',
'image_or',
'image_bc'
];
let valid = true;
requiredFields.forEach(function(name) {
const el = document.querySelector(`[name='${name}']`);
if (el && !el.value) {
el.classList.add('border-red-500');
valid = false;
} else if (el) {
el.classList.remove('border-red-500');
}
});
requiredImages.forEach(function(name) {
const el = document.querySelector(`[name='${name}']`);
if (el && !el.files.length) {
const uploadArea = el.closest('.border-dashed');
if (uploadArea) uploadArea.classList.add('border-red-500');
valid = false;
} else if (el) {
const uploadArea = el.closest('.border-dashed');
if (uploadArea) uploadArea.classList.remove('border-red-500');
}
});
const errorDiv = document.getElementById('facturer-error-message');
if (!valid) {
e.preventDefault();
if (errorDiv) {
errorDiv.classList.remove('hidden');
errorDiv.querySelector('span').textContent =
'Veuillez remplir tous les champs obligatoires et télécharger toutes les images requises pourfacturer.';
}
} else {
if (errorDiv) {
errorDiv.classList.add('hidden');
}
}
});
}

// Remove all error highlights and do not validate fields or images when clicking Enregistrer (CREATION)
const saveBtn = document.getElementById('saveBtn');
if (saveBtn) {
saveBtn.addEventListener('click', function(e) {
document.getElementById('action-field').value = 'save';
// Remove all error highlights and hide error message for save
const allInputs = document.querySelectorAll('input, select');
allInputs.forEach(function(el) {
el.classList.remove('border-red-500');
});
document.querySelectorAll('.border-dashed').forEach(function(el) {
el.classList.remove('border-red-500');
});
const errorDiv = document.getElementById('facturer-error-message');
if (errorDiv) {
errorDiv.classList.add('hidden');
}
});
}
