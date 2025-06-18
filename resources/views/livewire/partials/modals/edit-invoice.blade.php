{{-- Edit Modal --}}
<div x-data="{ openEditModal: false }">
     @if($invoice->statut_facture != 'paiement' && auth()->user()->role_id != 1)
    <button @click="openEditModal = true" class="p-1.5 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors"
        title="Modifier">
        <i class="fas fa-edit text-sm"></i>
    </button>

    {{-- Edit Modal Popup --}}
    <div x-show="openEditModal" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="openEditModal = false"
            class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto m-4">

            {{-- Modal Header --}}
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-edit text-yellow-600 mr-2"></i>
                    Modifier la Facture #{{ $invoice->invoice_number }}
                </h2>
                <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <!-- Replace your existing form tag with this -->
                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- <form wire:submit.prevent="updateInvoice"> -->

                    <!-- Car Information Section -->
                    @if ($car)
                        <div class="mb-8">

                            <!-- ... existing car fields ... -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                                    <input type="text" name="car_brand" value="{{ old('car_brand', $car->brand) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                    <input type="text" name="car_model" value="{{ old('car_model', $car->model) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                                    <input type="number" name="car_year" value="{{ old('car_year', $car->year) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                                    <input type="text" name="car_color" value="{{ old('car_color', $car->color) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Immatriculation</label>
                                    <input type="text" name="car_registration"
                                        value="{{ old('car_registration', $car->registration_number) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut
                                        après-vente</label>
                                    <select name="post_sale_status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="en_attente_livraison"
                                            {{ old('post_sale_status', $car->post_sale_status) == 'en_attente_livraison' ? 'selected' : '' }}>
                                            En attente livraison</option>
                                        <option value="livre"
                                            {{ old('post_sale_status', $car->post_sale_status) == 'livre' ? 'selected' : '' }}>
                                            Livré</option>
                                        <option value="sav_1ere_visite"
                                            {{ old('post_sale_status', $car->post_sale_status) == 'sav_1ere_visite' ? 'selected' : '' }}>
                                            SAV 1ère visite</option>
                                        <option value="relance"
                                            {{ old('post_sale_status', $car->post_sale_status) == 'relance' ? 'selected' : '' }}>
                                            Relance</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">IVN</label>
                                    <input type="text" name="car_ivn" value="{{ old('car_ivn', $car->ivn) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent font-mono">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro
                                        châssis</label>
                                    <input type="text" name="car_chassis"
                                        value="{{ old('car_chassis', $car->chassis_number) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent font-mono">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Invoice Information Section -->
                    <div class="mb-8">
                        <!-- ... existing invoice fields ... -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">N°
                                    Facture</label>
                                <input type="text" name="invoice_number"
                                    value="{{ old('invoice_number', $invoice->invoice_number) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date
                                    de Facture</label>
                                <input type="date" name="sale_date"
                                    value="{{ old('sale_date', \Carbon\Carbon::parse($invoice->sale_date)->format('Y-m-d')) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut
                                    Facture *</label>
                                <select name="statut_facture" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                    <option value="creation"
                                        {{ old('statut_facture', $invoice->statut_facture) == 'creation' ? 'selected' : '' }}>
                                        Creation</option>
                                    <option value="facturé"
                                        {{ old('statut_facture', $invoice->statut_facture) == 'facturé' ? 'selected' : '' }}>
                                        Facturé</option>
                                    <option value="envoyée_pour_paiement"
                                        {{ old('statut_facture', $invoice->statut_facture) == 'envoyée_pour_paiement' ? 'selected' : '' }}>
                                        Envoyée pour paiement</option>
                                    <option value="paiement"
                                        {{ old('statut_facture', $invoice->statut_facture) == 'paiement' ? 'selected' : '' }}>
                                        Paiement</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Montant
                                    TTC (DH)</label>
                                <input type="number" step="0.01" name="total_amount"
                                    value="{{ old('total_amount', $invoice->total_amount) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Référence
                                    accord</label>
                                <input type="text" name="accord_reference"
                                    value="{{ old('accord_reference', $invoice->accord_reference) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">N°
                                    bon commande</label>
                                <input type="text" name="purchase_order_number"
                                    value="{{ old('purchase_order_number', $invoice->purchase_order_number) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">N°
                                    bon livraison</label>
                                <input type="text" name="delivery_note_number"
                                    value="{{ old('delivery_note_number', $invoice->delivery_note_number) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ordre
                                    de réparation</label>
                                <input type="text" name="payment_order_reference"
                                    value="{{ old('payment_order_reference', $invoice->payment_order_reference) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <button type="button" @click="openEditModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
