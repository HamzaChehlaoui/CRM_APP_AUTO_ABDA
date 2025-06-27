document.addEventListener('DOMContentLoaded', function () {
const factureBtn = document.getElementById('facture-btn');

if (factureBtn) {
factureBtn.addEventListener('click', function (e) {
e.preventDefault();

clearErrors();

const requiredFields = document.querySelectorAll('[data-required="true"]');
const missingFields = [];
// vérifivation select client
 const clientSelect = document.getElementById('client_id');
const clientError = document.getElementById('clientError');

if (!clientSelect.value || clientSelect.value === '') {
    missingFields.push({
        element: clientSelect,
        label: clientSelect.closest('div').querySelector('label').textContent.trim()
    });
    highlightError(clientSelect);
    if (clientError) clientError.classList.remove('hidden'); // إظهار رسالة الخطأ
} else {
    if (clientError) clientError.classList.add('hidden'); // إخفاء الرسالة إذا تم الاختيار
}

// Vérification champs texte/num/date
requiredFields.forEach(field => {
const value = field.value.trim();
if (!value || value === '' || (field.type === 'number' && (value === '0' || value === '0.00'))) {
missingFields.push({
element: field,
label: field.getAttribute('data-label')
});
highlightError(field);
}
});

// Vérification des images obligatoires
const requiredImages = ['image_path', 'image_bc', 'image_bl', 'image_or'];
requiredImages.forEach(imageName => {
const input = document.querySelector(`input[name="${imageName}"]`);
const container = input.closest('.bg-white');
const hasExisting = container.querySelector('img, a');

if (!input.files.length && !hasExisting) {
missingFields.push({
element: container,
label: container.querySelector('label').textContent.trim()
});
highlightError(container);
}
});

if (missingFields.length > 0) {
showErrorMessage(missingFields);
missingFields[0].element.scrollIntoView({ behavior: 'smooth', block: 'center' });
const focusable = missingFields[0].element.querySelector('input') || missingFields[0].element;
focusable.focus();
} else {
document.getElementById('form-action').value = 'facture';
document.querySelector('form').submit();
}
});
}

// Gestion suppression inline des erreurs
document.addEventListener('input', function (e) {
if (e.target.hasAttribute('data-required')) {
if (e.target.value.trim() !== '') {
e.target.classList.remove('border-red-500', 'bg-red-50');
e.target.classList.add('border-gray-300');

const remainingErrors = document.querySelectorAll('.border-red-500');
if (remainingErrors.length === 0) {
document.getElementById('error-message').classList.add('hidden');
}
}
}
});

// Prévisualisation et suppression dynamique des images
const imageFields = ['image_path', 'image_bc', 'image_bl', 'image_or'];
imageFields.forEach(key => {
const input = document.querySelector(`input[name="${key}"]`);
if (!input) return;
const container = input.closest('.bg-white');

input.addEventListener('change', function (e) {
const file = e.target.files[0];
const previewZone = container.querySelector('.preview-zone');
const oldPreview = container.querySelector('img, a');

if (previewZone) previewZone.remove();
if (oldPreview) oldPreview.style.display = 'none';

if (file) {
const fileType = file.type;
const newPreview = document.createElement('div');
newPreview.classList.add('preview-zone', 'mt-3');

if (fileType === 'application/pdf') {
newPreview.innerHTML = `
<div class="flex items-center p-3 bg-red-50 rounded-lg border border-red-200 justify-between">
    <div class="flex items-center">
        <svg class="w-6 h-6 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-red-700 font-medium">${file.name}</span>
    </div>
    <button type="button" class="remove-preview text-sm text-red-600 hover:underline">Supprimer</button>
</div>
`;
} else if (fileType.startsWith('image/')) {
const reader = new FileReader();
reader.onload = function (e) {
newPreview.innerHTML = `
<div class="relative w-full group">
    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
    <button type="button"
        class="absolute top-1 right-1 bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 remove-preview">✕</button>
</div>
`;
container.appendChild(newPreview);
};
reader.readAsDataURL(file);
return;
} else {
newPreview.innerHTML = `<p class="text-sm text-gray-600">Fichier non supporté</p>`;
}

container.appendChild(newPreview);
}
});
});

document.addEventListener('click', function (e) {
if (e.target.classList.contains('remove-preview')) {
const preview = e.target.closest('.preview-zone');
const input = preview.parentElement.querySelector('input[type="file"]');
preview.remove();
input.value = '';
}
});

function clearErrors() {
const errorFields = document.querySelectorAll('.border-red-500');
errorFields.forEach(field => {
field.classList.remove('border-red-500', 'bg-red-50');
if (field.tagName === 'INPUT') {
field.classList.add('border-gray-300');
}
});

document.querySelectorAll('.bg-white.border-red-500').forEach(el => {
el.classList.remove('border-red-500', 'bg-red-50');
});

document.getElementById('error-message').classList.add('hidden');
}

function highlightError(field) {
if (field instanceof HTMLElement && field.classList.contains('bg-white')) {
field.classList.add('border-red-500', 'bg-red-50');
} else {
field.classList.remove('border-gray-300');
field.classList.add('border-red-500', 'bg-red-50');
}
}

function showErrorMessage(missingFields) {
const errorMessage = document.getElementById('error-message');
const errorText = document.getElementById('error-text');

if (missingFields.length === 1) {
errorText.textContent = `Veuillez remplir ou téléverser : ${missingFields[0].label}`;
} else {
const fieldNames = missingFields.map(field => field.label).join(', ');
errorText.textContent = `Veuillez remplir ou téléverser les champs suivants : ${fieldNames}`;
}

errorMessage.classList.remove('hidden');
errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
}
  new TomSelect('#client_id', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Rechercher un client...",
        });

// ✅ Suppression automatique de l'erreur client_id au changement
const clientSelect = document.getElementById('client_id');
if (clientSelect) {
    clientSelect.addEventListener('change', function () {
        if (clientSelect.value !== '') {
            clientSelect.classList.remove('border-red-500', 'bg-red-50');
            clientSelect.classList.add('border-gray-300');
            const clientError = document.getElementById('clientError');
            if (clientError) clientError.classList.add('hidden');

            const remainingErrors = document.querySelectorAll('.border-red-500');
            if (remainingErrors.length === 0) {
                document.getElementById('error-message').classList.add('hidden');
            }
        }
    });
}

});
