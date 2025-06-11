@extends('layouts.mastere')

@section('title', 'Exporter - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-gradient-to-br from-gray-50 to-gray-100">

    <div class="flex h-screen w-screen overflow-hidden">

        <x-sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200 py-6 px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Exporter</h1>
                            <p class="text-sm text-gray-500 mt-1">Exportez vos données dans différents formats avec précision</p>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 p-8 overflow-y-auto">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
                    <div class="flex items-center space-x-3 mb-6">
                         <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                             <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                         </div>
                         <h2 class="text-xl font-semibold text-gray-800">Configuration d'exportation</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label for="dataType" class="block text-sm font-semibold text-gray-700">Type de données</label>
                            <select id="dataType" name="data_type" class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                <option value="clients">📊 Clients</option>
                                <option value="cars">🚗 Voitures</option>
                                <option value="invoices">📄 Factures</option>
                                {{-- <option value="all">🔄 Tous les types</option> --}}
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label for="exportFormatSelector" class="block text-sm font-semibold text-gray-700">Format d'exportation</label>
                            <select id="exportFormatSelector" class="w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                <option value="xlsx">📗 Excel (.xlsx)</option>
                                <option value="csv">📘 CSV (.csv)</option>
                                <option value="pdf">📕 PDF (.pdf)</option>
                            </select>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">Plage de dates (Optionnel)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="startDate" class="block text-xs text-gray-500 mb-1">Date de début</label>
                                    <input type="date" id="startDate" class="w-full px-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-sm">
                                </div>
                                <div>
                                    <label for="endDate" class="block text-xs text-gray-500 mb-1">Date de fin</label>
                                    <input type="date" id="endDate" class="w-full px-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
                    <div class="flex justify-between items-center mb-8">
                         <div class="flex items-center space-x-3">
                             <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                 <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             </div>
                             <h2 class="text-xl font-semibold text-gray-800">Champs à exporter</h2>
                         </div>
                         <div class="flex space-x-3">
                             <button id="selectAllBtn" type="button" class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-sm font-medium hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">Tout sélectionner</button>
                             <button id="deselectAllBtn" type="button" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 hover:border-gray-300 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">Tout désélectionner</button>
                         </div>
                    </div>

                    {{-- Dynamic Checkbox Sections --}}
                    <div id="fields-clients" class="export-fields space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">📊 Clients</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($clientFields as $field => $label)
                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                    <input type="checkbox" name="clients.{{ $field }}" class="h-5 w-5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-800">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div id="fields-cars" class="export-fields space-y-4 mt-6 hidden">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">🚗 Voitures</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($carFields as $field => $label)
                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                    <input type="checkbox" name="cars.{{ $field }}" class="h-5 w-5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-800">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div id="fields-invoices" class="export-fields space-y-4 mt-6 hidden">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">📄 Factures</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($invoiceFields as $field => $label)
                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                                    <input type="checkbox" name="invoices.{{ $field }}" class="h-5 w-5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-800">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
               </div>

                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                             <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                 <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                             </div>
                             <h2 class="text-xl font-semibold text-gray-800">Lancer l'exportation</h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            <span id="selectedCount">0</span> champs sélectionnés
                        </div>
                    </div>

                    <button type="button" id="startExportBtn" class="w-full group relative overflow-hidden bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                            <span class="font-semibold">Exporter les données sélectionnées</span>
                        </div>
                    </button>

                    <div id="exportProgress" class="hidden mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-center space-x-3">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                            <span class="text-sm font-medium text-blue-800">Exportation en cours...</span>
                        </div>
                        <div class="mt-3 w-full bg-blue-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="exportForm" action="{{ route('export.handle') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="data_type" id="formDataType">
        <input type="hidden" name="export_format" id="formExportFormat">
        <input type="hidden" name="selected_fields" id="formSelectedFields">
        <input type="hidden" name="start_date" id="formStartDate">
        <input type="hidden" name="end_date" id="formEndDate">
    </form>

    <script>
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

            // Show progress and submit
            showExportProgress();
            exportForm.submit();
        }

        function showExportProgress() {
            exportProgress.classList.remove('hidden');
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 20;
                if (progress >= 100) {
                    progress = 95; // Fake progress stops at 95%, real download will start
                    clearInterval(interval);
                }
                progressBar.style.width = `${progress}%`;
            }, 200);
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
    </script>
</body>
@endsection
