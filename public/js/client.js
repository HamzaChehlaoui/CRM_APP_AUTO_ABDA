document.addEventListener('DOMContentLoaded', function () {
const openBtn = document.getElementById('openModalBtn');
const modal = document.getElementById('clientModal');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelModalBtn');
const form = modal.querySelector('form');

if (openBtn) {
openBtn.addEventListener('click', () => {
modal.classList.remove('hidden');
document.body.style.overflow = 'hidden';
});
}

function closeModal() {
modal.classList.add('hidden');
document.body.style.overflow = 'auto';
form.reset();
}

closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);

modal.addEventListener('click', (e) => {
if (e.target === modal) {
closeModal();
}
});

document.addEventListener('keydown', (e) => {
if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
closeModal();
}
});

form.addEventListener('submit', function(e) {
const submitBtn = form.querySelector('button[type="submit"]');
const originalText = submitBtn.innerHTML;

submitBtn.disabled = true;
submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement...';

setTimeout(() => {
submitBtn.disabled = false;
submitBtn.innerHTML = originalText;
}, 5000);
});

form.id = 'clientForm';


const types = ['invoice', 'bl', 'or', 'bc'];

types.forEach(type => {
const fileInput = document.getElementById(`${type}-image`);
const preview = document.getElementById(`preview-${type}`);
const previewImage = document.getElementById(`preview-image-${type}`);
const placeholder = document.getElementById(`placeholder-${type}`);
const uploadArea = document.getElementById(`upload-area-${type}`);
const fileName = document.getElementById(`file-name-${type}`);
const fileSize = document.getElementById(`file-size-${type}`);
const removeBtn = document.getElementById(`remove-image-${type}`);
const pdfLinkContainer = preview.querySelector('.preview-pdf-link-container');

fileInput.addEventListener('change', () => {
const file = fileInput.files[0];
handleFile(file, {
previewImage,
preview,
placeholder,
uploadArea,
fileName,
fileSize,
fileInput,
pdfLinkContainer,
});
});

removeBtn.addEventListener('click', () => {
fileInput.value = '';
fileName.textContent = '';
fileSize.textContent = '';
preview.classList.add('hidden');
placeholder.classList.remove('hidden');
uploadArea.classList.remove('border-green-500');
uploadArea.classList.add('border-gray-300');

pdfLinkContainer.innerHTML = '';

previewImage.classList.remove('hidden');
previewImage.src = '';
});
});
});

function handleFile(file, elements) {
const {
previewImage,
preview,
placeholder,
uploadArea,
fileName,
fileSize,
fileInput,
pdfLinkContainer,
} = elements;

if (!file) return;

const isImage = file.type.startsWith('image/');
const isPDF = file.type === 'application/pdf';

if (!isImage && !isPDF) {
alert('Veuillez sélectionner une image ou un fichier PDF valide.');
fileInput.value = '';
return;
}

if (file.size > 10 * 1024 * 1024) {
alert('Le fichier est trop volumineux. Max: 10MB.');
fileInput.value = '';
return;
}

const reader = new FileReader();
reader.onload = (e) => {
pdfLinkContainer.innerHTML = '';

if (isImage) {
previewImage.src = e.target.result;
previewImage.classList.remove('hidden');
} else {
previewImage.classList.add('hidden');

const pdfLink = document.createElement('a');
pdfLink.href = e.target.result;
pdfLink.target = "_blank";
pdfLink.className = "text-sm text-blue-600 underline flex items-center space-x-1";
pdfLink.innerHTML = `<i class="fas fa-file-pdf text-red-600"></i><span>Voir le fichier PDF</span>`;

pdfLinkContainer.appendChild(pdfLink);
}

fileName.textContent = file.name;
fileSize.textContent = formatFileSize(file.size);
placeholder.classList.add('hidden');
preview.classList.remove('hidden');
uploadArea.classList.add('border-green-500');
uploadArea.classList.remove('border-gray-300');
};

reader.readAsDataURL(file);
}

function formatFileSize(bytes) {
const sizes = ['Bytes', 'KB', 'MB', 'GB'];
if (bytes === 0) return '0 Byte';
const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
