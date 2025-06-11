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

    dataTypeSelect.addEventListener('change', updateExportFormats);

    updateExportFormats();

        // Show/Hide field sections based on data type
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

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]:checked');
            selectedCountSpan.textContent = checkedBoxes.length;
        }

        function selectAllFields(select = true) {
            const visibleCheckboxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]');
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = select;
            });
            updateSelectedCount();
        }

        function validateDateRange() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                alert('La date de début ne peut pas être postérieure à la date de fin.');
                return false;
            }

            return true;
        }

        function handleExport() {
            const selectedFields = [];
            const checkedBoxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]:checked');

            if (checkedBoxes.length === 0) {
                alert('Veuillez sélectionner au moins un champ à exporter.');
                return;
            }

            if (!validateDateRange()) {
                return;
            }

            checkedBoxes.forEach(checkbox => {
                selectedFields.push(checkbox.getAttribute('name'));
            });

            // Set form values
            document.getElementById('formDataType').value = dataTypeSelect.value;
            document.getElementById('formExportFormat').value = exportFormatSelector.value;
            document.getElementById('formStartDate').value = startDateInput.value;
            document.getElementById('formEndDate').value = endDateInput.value;
            document.getElementById('formSelectedFields').value = JSON.stringify(selectedFields);
            const branchSelect = document.getElementById('branch_id');
            if (branchSelect) {
            document.getElementById('formBranchId').value = branchSelect.value;
            }
            // Show progress and submit

            exportForm.submit();
        }



        // Event listeners
        dataTypeSelect.addEventListener('change', updateFieldSections);
        selectAllBtn.addEventListener('click', () => selectAllFields(true));
        deselectAllBtn.addEventListener('click', () => selectAllFields(false));
        startExportBtn.addEventListener('click', handleExport);

        startDateInput.addEventListener('change', validateDateRange);
        endDateInput.addEventListener('change', validateDateRange);

        document.querySelectorAll('.export-fields input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        // Initialize
        updateFieldSections();
    });
