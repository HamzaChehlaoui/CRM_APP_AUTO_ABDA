
        document.addEventListener('DOMContentLoaded', function () {
            const openBtn = document.getElementById('openModalBtn');
            const modal = document.getElementById('clientModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const form = modal.querySelector('form');

            // Open modal
            if (openBtn) {
                openBtn.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close modal functions
            function closeModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                form.reset();
            }

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close on backdrop click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Form submission handling
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement...';

                // Re-enable after a delay in case of errors
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            });

            // Add form ID for submit button
            form.id = 'clientForm';






document.querySelectorAll('[data-type]').forEach((section) => {
    const type = section.dataset.type;
    const fileInput = document.getElementById(`${type}-image`);
    const placeholder = document.getElementById(`placeholder-${type}`);
    const preview = document.getElementById(`preview-${type}`);
    const previewImage = document.getElementById(`preview-image-${type}`);
    const fileName = document.getElementById(`file-name-${type}`);
    const fileSize = document.getElementById(`file-size-${type}`);
    const removeBtn = document.getElementById(`remove-image-${type}`);
    const uploadArea = document.getElementById(`upload-area-${type}`);

    fileInput.addEventListener('change', () => handleFile(fileInput.files[0]));

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-green-500', 'bg-green-50');
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-green-500', 'bg-green-50');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-green-500', 'bg-green-50');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            fileInput.files = e.dataTransfer.files;
            handleFile(file);
        }
    });

    removeBtn.addEventListener('click', () => {
        fileInput.value = '';
        placeholder.classList.remove('hidden');
        preview.classList.add('hidden');
        uploadArea.classList.remove('border-green-500', 'bg-green-50');
        uploadArea.classList.add('border-gray-300');
    });

    function handleFile(file) {
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner une image valide.');
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
            previewImage.src = e.target.result;
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
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});


});
