
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

            // Image upload functionality
            const fileInput = document.getElementById('invoice-image');
            const uploadArea = document.getElementById('invoice-upload-area');
            const uploadPlaceholder = document.getElementById('upload-placeholder');
            const uploadPreview = document.getElementById('upload-preview');
            const previewImage = document.getElementById('preview-image');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const removeBtn = document.getElementById('remove-image');

            // File input change handler
            fileInput.addEventListener('change', handleFileSelect);

            // Drag and drop handlers
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

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        fileInput.files = files;
                        handleFileSelect();
                    }
                }
            });

            // Remove image handler
            removeBtn.addEventListener('click', () => {
                fileInput.value = '';
                uploadPlaceholder.classList.remove('hidden');
                uploadPreview.classList.add('hidden');
                uploadArea.classList.remove('border-green-500');
                uploadArea.classList.add('border-gray-300');
            });

            function handleFileSelect() {
                const file = fileInput.files[0];
                if (file) {
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Veuillez sélectionner un fichier image valide.');
                        fileInput.value = '';
                        return;
                    }

                    // Validate file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Le fichier est trop volumineux. Taille maximale: 10MB.');
                        fileInput.value = '';
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImage.src = e.target.result;
                        fileName.textContent = file.name;
                        fileSize.textContent = formatFileSize(file.size);

                        uploadPlaceholder.classList.add('hidden');
                        uploadPreview.classList.remove('hidden');
                        uploadArea.classList.remove('border-gray-300');
                        uploadArea.classList.add('border-green-500');
                    };
                    reader.readAsDataURL(file);
                }
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });

