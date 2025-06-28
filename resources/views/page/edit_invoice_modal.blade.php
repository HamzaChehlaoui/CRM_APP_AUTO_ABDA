<div class="bg-gray-300">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- CSS JS Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    @if ($invoice->statut_facture == 'creation')
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" enctype="multipart/form-data"
            class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            @csrf
            @method('PUT')
            <!-- Header du formulaire -->
            <div
                class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 flex items-center justify-between shadow-lg">
                <h1 class="text-2xl font-semibold text-white flex items-center">
                    <svg class="w-7 h-7 mr-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                            clip-rule="evenodd"/>
                    </svg>
                    Modifier la Facture N° {{ $invoice->invoice_number }}
                </h1>
                <a href="/factures"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 rounded-md transition-colors duration-200 shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retourner à la page de facturation
                </a>
            </div>
            <div class="p-8 space-y-8">
                <!-- Section Client -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        Informations Client
                    </h2>
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner un
                            client</label>
                        <select id="client_id" name="client_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white">
                            <option value="">-- Choisir un client --</option>
                            @foreach ($clients as $c)
                                <option value="{{ $c->id }}"
                                    {{ $c->id == $invoice->client_id ? 'selected' : '' }}>
                                    {{ $c->full_name }} - CIN: {{ $c->cin }}
                                </option>
                            @endforeach
                        </select>
                        <p id="clientError" class="text-red-500 text-sm mt-1 hidden">Veuillez sélectionner un client.</p>
                    </div>

                </div>

                <!-- Section Véhicule -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                        Informations sur le véhicule
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Marque</label>
                            <input type="text" name="car[brand]" data-required="true" data-label="Marque du véhicule"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.brand', $invoice->car->brand ?? '') }}" placeholder="Ex: Toyota">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Modèle</label>
                            <input type="text" name="car[model]" data-required="true" data-label="Modèle du véhicule"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.model', $invoice->car->model ?? '') }}" placeholder="Ex: Camry">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Année</label>
                            <input type="number" name="car[year]" data-required="true" data-label="Année du véhicule"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.year', $invoice->car->year ?? '') }}" placeholder="Ex: 2022">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Couleur
                                <span class="text-gray-500 text-xs font-normal">(optionnel)</span>
                            </label>
                            <input type="text" name="car[color]"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.color', $invoice->car->color ?? '') }}" placeholder="Ex: Blanc">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Immatriculation</label>
                            <input type="text" name="car[registration_number]" data-required="true"
                                data-label="Immatriculation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.registration_number', $invoice->car->registration_number ?? '') }}"
                                placeholder="Ex: 12345-A-67">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">IVN</label>
                            <input type="text" name="car[ivn]" data-required="true" data-label="IVN"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.ivn', $invoice->car->ivn ?? '') }}" placeholder="Numéro IVN">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">N° Châssis</label>
                            <input type="text" name="car[chassis_number]" data-required="true"
                                data-label="Numéro de châssis"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('car.chassis_number', $invoice->car->chassis_number ?? '') }}"
                                placeholder="Numéro de châssis">
                        </div>
                    </div>
                </div>

                <!-- Section Facture -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                clip-rule="evenodd" />
                        </svg>
                        Détails de la facture
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">N° Facture</label>
                            <input type="text" name="invoice[invoice_number]" data-required="true"
                                data-label="Numéro de facture"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('invoice.invoice_number', $invoice->invoice_number) }}"
                                placeholder="Ex: FAC-2024-001">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de la vente</label>
                            <input type="date" name="invoice[sale_date]" data-required="true"
                                data-label="Date de la vente"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('invoice.sale_date', optional($invoice->sale_date)->format('Y-m-d')) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Montant TTC</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="invoice[total_amount]"
                                    data-required="true" data-label="Montant TTC"
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    value="{{ old('invoice.total_amount', $invoice->total_amount) }}"
                                    placeholder="0.00">
                                <span class="absolute right-3 top-3 text-gray-500 font-medium">MAD</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Référence Accord</label>
                            <input type="text" name="invoice[accord_reference]" data-required="true"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('invoice.accord_reference', $invoice->accord_reference) }}"
                                placeholder="Référence accord">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bon de Commande</label>
                            <input type="text" name="invoice[purchase_order_number]" data-required="true"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('invoice.purchase_order_number', $invoice->purchase_order_number) }}"
                                placeholder="N° bon de commande">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bon de Livraison</label>
                            <input type="text" name="invoice[delivery_note_number]" data-required="true"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('invoice.delivery_note_number', $invoice->delivery_note_number) }}"
                                placeholder="N° bon de livraison">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ordre de Réparation</label>
                            <input type="text" name="invoice[payment_order_reference]" data-required="true"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('invoice.payment_order_reference', $invoice->payment_order_reference) }}"
                                placeholder="Référence ordre de réparation">
                        </div>
                    </div>
                </div>

                <!-- Section Images -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                        Images associées
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $images = [
                                'image_path' => 'Image de la Facture',
                                'image_bc' => 'Bon de Commande',
                                'image_bl' => 'Bon de Livraison',
                                'image_or' => 'Ordre de Réparation',
                            ];
                        @endphp

                        @foreach ($images as $key => $label)
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-3">{{ $label }}</label>
                                @if ($invoice->$key)
                                    <div class="mb-4">
                                        @php
                                            $imgPath = $invoice->$key;
                                            $url = asset('storage/' . $imgPath);
                                        @endphp
                                        @if (Str::endsWith($imgPath, '.pdf'))
                                            <div
                                                class="flex items-center p-3 bg-red-50 rounded-lg border border-red-200">
                                                <svg class="w-8 h-8 text-red-600 mr-3" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <a href="{{ $url }}" target="_blank"
                                                    class="text-red-700 font-medium hover:text-red-800 transition-colors">
                                                    Voir le PDF
                                                </a>
                                            </div>
                                        @else
                                            <div class="relative group">
                                                <img src="{{ $url }}"
                                                    class="w-full h-32 object-cover rounded-lg border border-gray-200 group-hover:opacity-75 transition-opacity cursor-pointer">
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-8 h-8 text-white bg-black bg-opacity-50 rounded-full p-1"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd"
                                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="relative">
                                    <input type="file" name="{{ $key }}"
                                        accept="image/*,application/pdf"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        id="file-{{ $key }}">
                                    <label for="file-{{ $key }}"
                                        class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm5 5a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm0 3a1 1 0 011-1h3a1 1 0 110 2h-3a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm text-gray-600">Choisir un fichier</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Message d'erreur -->
                <div id="error-message" class="hidden mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-red-800 font-medium">Champs obligatoires manquants</h3>
                            <p id="error-text" class="text-red-700 text-sm mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div
                    class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                    <button type="submit" name="action" value="draft"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12z"
                                clip-rule="evenodd" />
                        </svg>
                        Enregistrer comme brouillon
                    </button>
                    <button type="button" id="facture-btn"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Enregistrer comme FACTURÉ
                    </button>
                </div>

                <input type="hidden" name="action" id="form-action" value="">
            </div>
        </form>
        @vite('resources/js/edit-invoice.js')
        @else
   <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" enctype="multipart/form-data"
    class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
    @csrf
    @method('PUT')

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 flex items-center justify-between shadow-lg">
        <h1 class="text-2xl font-semibold text-white flex items-center">
            <svg class="w-7 h-7 mr-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                <path fill-rule="evenodd"
                      d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                      clip-rule="evenodd" />
            </svg>
            Modifier la Facture N° {{ $invoice->invoice_number }}
        </h1>
        <a href="/factures"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 rounded-md transition-colors duration-200 shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retourner à la page de facturation
        </a>
    </div>

    <p class="text-xs text-blue-600 m-3">Statut: {{ ucfirst(str_replace('_', ' ', $invoice->statut_facture)) }}</p>

    <div class="p-8 space-y-8">
        <!-- Section Statut -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
                Statut Facture
            </h2>

            <!-- Select Statut -->
            <div>
                <label for="statut_facture" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner un statut</label>
                <select id="statut_facture" name="statut_facture"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white"
                        onchange="handleStatutChange(this)">
                    @if ($invoice->statut_facture == 'facturé')
                        <option value="creation">Création</option>
                        <option value="facturé" selected>Facturé</option>
                        <option value="envoyée_pour_paiement">Envoyée pour paiement</option>
                    @elseif ($invoice->statut_facture == 'envoyée_pour_paiement')
                        <option value="facturé">Facturé</option>
                        <option value="envoyée_pour_paiement" selected>Envoyée pour paiement</option>
                        <option value="paiement">Paiement</option>
                    @endif
                </select>
            </div>

            <!-- Upload File for "paiement" -->
            <div id="paiement_file_upload" class="mt-6 hidden">
                <label for="paiement_file" class="block text-sm font-medium text-gray-700 mb-2">
                    Joindre un reçu de paiement (PDF ou image) (accuse de reseption)
                </label>
                <input type="file" id="paiement_file" name="paiement_file"
                       accept="application/pdf,image/*"
                       onchange="previewFile()"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white">

                <!-- Preview -->
                <div id="file_preview" class="mt-4"></div>
            </div>
        </div>
            <input type="hidden" name="client_id" value="{{ old('client_id', $invoice->client_id) }}">

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                Enregistrer les modifications
            </button>
        </div>
    </div>
</form>

<!-- JS: Gestion du changement de statut et de l'aperçu -->
<script>
    function handleStatutChange(select) {
        const uploadDiv = document.getElementById('paiement_file_upload');
        const fileInput = document.getElementById('paiement_file');
        const preview = document.getElementById('file_preview');

        if (select.value === 'paiement') {
            uploadDiv.classList.remove('hidden');
            fileInput.required = true;
        } else {
            uploadDiv.classList.add('hidden');
            fileInput.required = false;
            fileInput.value = "";
            preview.innerHTML = "";
        }
    }

    function previewFile() {
        const input = document.getElementById('paiement_file');
        const preview = document.getElementById('file_preview');
        const file = input.files[0];
        preview.innerHTML = "";

        if (file) {
            const type = file.type;
            if (type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = "w-32 h-32 object-contain border rounded mb-2";
                preview.appendChild(img);
            } else if (type === "application/pdf") {
                const info = document.createElement('p');
                info.textContent = "Fichier PDF sélectionné : " + file.name;
                info.className = "text-sm text-gray-800";
                preview.appendChild(info);
            }

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.textContent = "Supprimer le fichier";
            removeBtn.className = "mt-2 px-4 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700";
            removeBtn.onclick = () => {
                input.value = "";
                preview.innerHTML = "";
            };
            preview.appendChild(removeBtn);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const current = document.getElementById('statut_facture');
        handleStatutChange(current);
    });
</script>

@endif
</div>
