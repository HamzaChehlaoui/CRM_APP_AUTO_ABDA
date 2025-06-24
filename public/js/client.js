document.addEventListener('DOMContentLoaded', function () {
    // Modal functionality
    const openBtn = document.getElementById('openModalBtn');
    const modal = document.getElementById('clientModal');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const form = modal ? modal.querySelector('form') : null;

    if (openBtn && modal) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }

    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            if (form) {
                form.reset();
            }
        }
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement...';

                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            }
        });

        form.id = 'clientForm';
    }

    // File upload functionality with null checks
    const types = ['invoice', 'bl', 'or', 'bc'];

    function initializeFileUpload() {
        types.forEach(type => {
            const fileInput = document.getElementById(`${type}-image`);
            const preview = document.getElementById(`preview-${type}`);
            const previewImage = document.getElementById(`preview-image-${type}`);
            const placeholder = document.getElementById(`placeholder-${type}`);
            const uploadArea = document.getElementById(`upload-area-${type}`);
            const fileName = document.getElementById(`file-name-${type}`);
            const fileSize = document.getElementById(`file-size-${type}`);
            const removeBtn = document.getElementById(`remove-image-${type}`);

            // Check if all required elements exist
            if (!fileInput || !preview || !previewImage || !placeholder || !uploadArea || !fileName || !fileSize || !removeBtn) {
                return; // Skip this type if elements don't exist
            }

            const pdfLinkContainer = preview.querySelector('.preview-pdf-link-container');

            // Remove existing event listeners to prevent duplicates
            const newFileInput = fileInput.cloneNode(true);
            fileInput.parentNode.replaceChild(newFileInput, fileInput);

            const newRemoveBtn = removeBtn.cloneNode(true);
            removeBtn.parentNode.replaceChild(newRemoveBtn, removeBtn);

            // Add event listeners to new elements
            newFileInput.addEventListener('change', () => {
                const file = newFileInput.files[0];
                handleFile(file, {
                    previewImage,
                    preview,
                    placeholder,
                    uploadArea,
                    fileName,
                    fileSize,
                    fileInput: newFileInput,
                    pdfLinkContainer,
                });
            });

            newRemoveBtn.addEventListener('click', () => {
                newFileInput.value = '';
                fileName.textContent = '';
                fileSize.textContent = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
                uploadArea.classList.remove('border-green-500');
                uploadArea.classList.add('border-gray-300');

                if (pdfLinkContainer) {
                    pdfLinkContainer.innerHTML = '';
                }

                previewImage.classList.remove('hidden');
                previewImage.src = '';
            });
        });
    }

    // Initialize file upload on page load
    initializeFileUpload();

    // Re-initialize file upload after Livewire updates
    document.addEventListener('livewire:navigated', initializeFileUpload);

    // Listen for Livewire updates (for older Livewire versions)
    if (window.Livewire) {
        window.Livewire.hook('message.processed', (message, component) => {
            setTimeout(initializeFileUpload, 100);
        });
    }

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
            if (pdfLinkContainer) {
                pdfLinkContainer.innerHTML = '';
            }

            if (isImage) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
            } else {
                previewImage.classList.add('hidden');

                if (pdfLinkContainer) {
                    const pdfLink = document.createElement('a');
                    pdfLink.href = e.target.result;
                    pdfLink.target = "_blank";
                    pdfLink.className = "text-sm text-blue-600 underline flex items-center space-x-1";
                    pdfLink.innerHTML = `<i class="fas fa-file-pdf text-red-600"></i><span>Voir le fichier PDF</span>`;

                    pdfLinkContainer.appendChild(pdfLink);
                }
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

    // Event delegation for Livewire buttons (edit, view invoices, delete)
    document.addEventListener('click', function(e) {
        // Handle edit and view invoices buttons
        const button = e.target.closest('[data-action]');
        if (button) {
            const action = button.getAttribute('data-action');
            const clientId = button.getAttribute('data-client-id');

            if (window.Livewire && window.Livewire.find) {
                const component = window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
                if (component) {
                    switch(action) {
                        case 'edit-client':
                            component.call('editClient', clientId);
                            break;
                        case 'show-invoices':
                            component.call('showInvoices', clientId);
                            break;
                    }
                }
            }
        }

        // Handle delete confirmation
        if (e.target.closest('[data-delete-client]')) {
            const deleteButton = e.target.closest('[data-delete-client]');
            const clientId = deleteButton.getAttribute('data-client-id');
            const clientName = deleteButton.getAttribute('data-client-name');
            showDeleteConfirmation(clientId, clientName);
        }

        // Handle modal close buttons
        if (e.target.matches('[data-close-modal]')) {
            hideDeleteConfirmation();
        }

        // Handle confirm delete
        if (e.target.matches('[data-confirm-delete]')) {
            confirmDelete();
        }

        // Handle modal backdrop clicks
        if (e.target.id === 'deleteModal') {
            hideDeleteConfirmation();
        }
    });

    // Delete confirmation modal functions
    let clientToDelete = null;

    window.showDeleteConfirmation = function(clientId, clientName) {
        clientToDelete = clientId;
        const clientNameDisplay = document.getElementById('clientNameDisplay');
        if (clientNameDisplay) {
            clientNameDisplay.textContent = clientName;
        }

        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');

        if (modal && modalContent) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    };

    window.hideDeleteConfirmation = function() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('modalContent');

        if (modal && modalContent) {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                clientToDelete = null;
            }, 300);
        }
    };

    window.confirmDelete = function() {
        if (clientToDelete && window.Livewire) {
            const component = window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
            if (component) {
                component.call('deleteClient', clientToDelete);
                hideDeleteConfirmation();
            }
        }
    };

    // Handle escape key for delete modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal && !deleteModal.classList.contains('hidden')) {
                hideDeleteConfirmation();
            }
        }
    });
});
