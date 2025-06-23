<!-- Professional Modal -->
        <div id="clientModal"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden relative">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold">Nouveau factures</h2>
                            <p class="text-primary-100 mt-1">Ajoutez un client, sa voiture et sa facture</p>
                        </div>
                        <button id="closeModalBtn"
                            class="text-white hover:text-primary-100 transition-colors duration-200 p-2 hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="overflow-y-auto max-h-[calc(90vh-140px)]">
                    <form action="{{ route('invoice.storeAll') }}" method="POST" enctype="multipart/form-data" class="p-8">
    @csrf

    <!-- Progress Indicator -->
    <div class="flex items-center justify-center mb-8">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                    <i class="fas fa-user text-sm"></i>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900">Client</span>
            </div>
            <div class="w-16 h-0.5 bg-gray-300"></div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                    <i class="fas fa-car text-sm"></i>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900">Voiture</span>
            </div>
            <div class="w-16 h-0.5 bg-gray-300"></div>
            <div class="flex items-center">
                <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                    <i class="fas fa-file-invoice text-sm"></i>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-900">Facture</span>
            </div>
        </div>
    </div>

    <!-- Client Information -->
    <div class="mb-8">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-user text-blue-600"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Sélection Client</h3>
        </div>
        <div class="bg-blue-50 rounded-lg p-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Client *</label>
                <select name="client_id" id="client_id"
                    class="select-client w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                    <option value="">Sélectionner un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->full_name }} , {{ $client->cin }}</option>
                    @endforeach
                </select>
                @error('client_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <!-- Car Information -->
    <div class="mb-8">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-car text-blue-600"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Informations Voiture</h3>
        </div>
        <div class="bg-blue-50 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Marque *</label>
                    <input type="text" name="car[brand]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('car.brand') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Modèle *</label>
                    <input type="text" name="car[model]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('car.model') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">IVN *</label>
                    <input type="text" name="car[ivn]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('car.ivn') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Numéro d'immatriculation *</label>
                    <input type="text" name="car[registration_number]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('car.registration_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Numéro de châssis *</label>
                    <input type="text" name="car[chassis_number]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('car.chassis_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Couleur</label>
                    <input type="text" name="car[color]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Année de fabrication</label>
                    <input type="number" name="car[year]" min="1900" max="2099" step="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Information -->
    <div class="mb-8">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-file-invoice text-green-600"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Informations Facture</h3>
        </div>
        <div class="bg-green-50 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Numéro de facture *</label>
                    <input type="text" name="invoice[invoice_number]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('invoice.invoice_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Date de facture *</label>
                    <input type="date" name="invoice[sale_date]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('invoice.sale_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Montant TTC *</label>
                    <div class="relative">
                        <input type="number" name="invoice[total_amount]" step="0.01" min="0"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                        <span class="absolute right-3 top-3 text-gray-500 text-sm">MAD</span>
                    </div>
                    @error('invoice.total_amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Bon de commande *</label>
                    <input type="text" name="invoice[purchase_order_number]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('invoice.purchase_order_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Bon de livraison *</label>
                    <input type="text" name="invoice[delivery_note_number]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('invoice.delivery_note_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Ordre de réparation *</label>
                    <input type="text" name="invoice[payment_order_reference]"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                    @error('invoice.payment_order_reference') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                @php
                    $types = [
                        'invoice' => 'Image de la facture',
                        'bl' => 'Image Bon livraison',
                        'or' => 'Image Ordre de réparation',
                        'bc' => 'Image Bon commande',
                    ];
                @endphp

                @foreach ($types as $type => $label)
                    <div class="space-y-2 md:col-span-2" data-type="{{ $type }}">
                        <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                        <div class="mt-2">
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition-colors duration-200 bg-white border-gray-300 hover:border-green-400"
                                id="upload-area-{{ $type }}">
                                <div class="space-y-2 text-center" id="placeholder-{{ $type }}">
                                    <div class="mx-auto h-12 w-12 text-gray-400">
                                        <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                    </div>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="{{ $type }}-image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                                            <span>Télécharger un fichier</span>
                                            <input id="{{ $type }}-image" name="image_{{ $type }}" type="file"
                                                accept="image/*,application/pdf" class="sr-only">
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG, PDF jusqu'à 10MB</p>
                                </div>
                                <div class="hidden" id="preview-{{ $type }}">
                                    <div class="flex items-center space-x-4">
                                        <img id="preview-image-{{ $type }}"
                                            class="h-20 w-20 object-cover rounded-lg border border-gray-200 hidden"
                                            src="" alt="Preview">
                                        <div class="preview-pdf-link-container-{{ $type }} hidden"></div>
                                        <div class="flex-1">
                                            <p id="file-name-{{ $type }}" class="text-sm font-medium text-gray-900"></p>
                                            <p id="file-size-{{ $type }}" class="text-xs text-gray-500"></p>
                                            <button type="button" id="remove-image-{{ $type }}"
                                                class="mt-1 text-xs text-red-600 hover:text-red-500">
                                                <i class="fas fa-trash mr-1"></i>Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error("image_{{ $type }}") <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex justify-end space-x-4 mt-6">
    <button type="submit" id="saveBtn"
        class="px-6 py-3 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition">
        <i class="fas fa-save mr-2"></i> Brouillon
    </button>

    <button type="submit" id="facturerBtn"
        class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
        <i class="fas fa-check mr-2"></i> Facturer (FACTURÉ)
    </button>
</div>

<input type="hidden" name="action" id="action-field">

</form>

<div id="facturer-error-message" class="hidden mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 flex items-center space-x-2">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z" /></svg>
    <span>Veuillez remplir tous les champs obligatoires pour facturer.</span>
</div>

<!-- JavaScript for File Preview -->
<script>
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
                    pdfLinkContainer.innerHTML = `<a href="${URL.createObjectURL(file)}" target="_blank" class="text-blue-600">Voir le PDF</a>`;
                }
            }
        });

        document.getElementById(`remove-image-${input.id.replace('-image', '')}`).addEventListener('click', function() {
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
                errorDiv.querySelector('span').textContent = 'Veuillez remplir tous les champs obligatoires et télécharger toutes les images requises pour facturer.';
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
</script>
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Les champs marqués d'un * sont obligatoires
                            </p>
                            <div class="flex space-x-4">
                                <button type="button" id="cancelModalBtn"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                    Annuler
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
