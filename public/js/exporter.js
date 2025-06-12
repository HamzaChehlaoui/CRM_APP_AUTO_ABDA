document.addEventListener('DOMContentLoaded', function() {
    const dataTypeSelect = document.getElementById('dataType');
    const fieldSections = document.querySelectorAll('.export-fields');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const selectedCountSpan = document.getElementById('selectedCount');
    const startExportBtn = document.getElementById('startExportBtn');
    const exportForm = document.getElementById('exportForm');
    const exportProgress = document.getElementById('exportProgress');
    const progressBar = document.getElementById('progressBar');
    const exportFormatSelector = document.getElementById('exportFormatSelector');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const errorBox = document.getElementById('errorBox');

    // Mettre à jour les formats d'exportation en fonction du type de données
    function updateExportFormats() {
        const selectedType = dataTypeSelect.value;
        const csvOption = exportFormatSelector.querySelector('option[value="csv"]');
        const pdfOption = exportFormatSelector.querySelector('option[value="pdf"]');

        if (selectedType === 'all') {
            exportFormatSelector.value = 'xlsx';
            csvOption.disabled = true;
            pdfOption.disabled = true;
            csvOption.style.color = '#9ca3af';
            pdfOption.style.color = '#9ca3af';
        } else {
            csvOption.disabled = false;
            pdfOption.disabled = false;
            csvOption.style.color = '';
            pdfOption.style.color = '';
        }
    }

    // Afficher/masquer les sections de champs en fonction du type de données
    function updateFieldSections() {
        const selectedType = dataTypeSelect.value;
        fieldSections.forEach(section => {
            const sectionType = section.id.replace('fields-', '');
            if (sectionType === selectedType || selectedType === 'all') {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        });
        updateSelectedCount();
    }

    // Mettre à jour le compteur de champs sélectionnés
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]:checked');
        selectedCountSpan.textContent = checkedBoxes.length;
    }

    // Sélectionner/désélectionner tous les champs
    function selectAllFields(select = true) {
        const visibleCheckboxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]');
        visibleCheckboxes.forEach(checkbox => {
            checkbox.checked = select;
        });
        updateSelectedCount();
    }

    // Vérifier la plage de dates
    function validateDateRange() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        const errorBox = document.getElementById('errorBox');

        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            if (errorBox) {
                errorBox.classList.remove('hidden'); // Afficher le message d'erreur
                setTimeout(() => {
                    errorBox.classList.add('hidden'); // Cacher après 4 secondes
                }, 4000);
            }
            return false; // Date invalide
        } else {
            if (errorBox) {
                errorBox.classList.add('hidden'); // Cacher si les dates sont valides
            }
        }
        return true; // Date valide
    }

    // Gérer l'exportation
    function handleExport() {
        const selectedFields = [];
        const checkedBoxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]:checked');

        if (checkedBoxes.length === 0) {
            const notificationBox = document.getElementById('notificationBox');
            const notificationMessage = document.getElementById('notificationMessage');
            if (notificationBox && notificationMessage) {
                notificationMessage.textContent = 'Veuillez sélectionner au moins un champ à exporter.';
                notificationBox.classList.remove('hidden');
                notificationBox.classList.add('text-red-800', 'bg-red-100');
                setTimeout(() => {
                    notificationBox.classList.add('hidden');
                    notificationBox.classList.remove('text-red-800', 'bg-red-100');
                }, 4000);
            }
            return;
        }

        if (!validateDateRange()) {
            return;
        }

        checkedBoxes.forEach(checkbox => {
            selectedFields.push(checkbox.getAttribute('name'));
        });

        // Remplir les valeurs du formulaire
        document.getElementById('formDataType').value = dataTypeSelect.value;
        document.getElementById('formExportFormat').value = exportFormatSelector.value;
        document.getElementById('formStartDate').value = startDateInput.value;
        document.getElementById('formEndDate').value = endDateInput.value;
        document.getElementById('formSelectedFields').value = JSON.stringify(selectedFields);

        const branchSelect = document.getElementById('branch_id');
        if (branchSelect) {
            document.getElementById('formBranchId').value = branchSelect.value;
        }

        // Afficher la progression et soumettre le formulaire
        exportForm.submit();
    }

    // Ajouter les écouteurs d'événements
    dataTypeSelect.addEventListener('change', updateExportFormats);
    dataTypeSelect.addEventListener('change', updateFieldSections);
    selectAllBtn.addEventListener('click', () => selectAllFields(true));
    deselectAllBtn.addEventListener('click', () => selectAllFields(false));
    startExportBtn.addEventListener('click', handleExport);
    startDateInput.addEventListener('change', validateDateRange);
    endDateInput.addEventListener('change', validateDateRange);

    document.querySelectorAll('.export-fields input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });

    // Initialiser
    updateExportFormats();
    updateFieldSections();
});
