<div>


    <div class="flex flex-col lg:flex-row gap-6 p-4 ">
        <!-- Search Input -->
        <div class="w-full lg:max-w-sm">
            <label for="search" class="block text-sm font-semibold text-slate-700 mb-2">
                Rechercher
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 text-sm" wire:loading.remove wire:target="search"></i>
                    <i class="fas fa-spinner text-gray-400 text-sm animate-spin" wire:loading wire:target="search"></i>
                </div>
                <input type="text" id="search" wire:model.live.debounce.500ms="search"
                    placeholder="Rechercher une facture, client, montant..."
                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm placeholder-gray-500 shadow-sm">
            </div>

        </div>

        <!-- Invoice Status Filter -->
        <div class="w-full lg:w-1/3">
            <label for="status_facture_filter" class="block text-sm font-semibold text-slate-700 mb-2">
                Statut Facture ( Totale : {{ $filteredInvoiceCount }} )
            </label>
            <div class="relative">
                <select wire:model.live="statusFacture" id="status_facture_filter"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    <option value="all">Tous les statuts</option>
                    <option value="paiement">Paiement</option>
                    <option value="envoyée_pour_paiement">Envoyée pour paiement</option>
                    <option value="facturé">Facturé</option>
                    <option value="creation">Création</option>
                </select>

            </div>
        </div>

        <!-- After Sale Status Filter -->
        <div class="w-full lg:w-1/3">
            <label for="status_apres_vente_filter" class="block text-sm font-semibold text-slate-700 mb-2">
                Statut Après-Vente ( Totale : {{ $filteredInvoiceCount }} )
            </label>
            <div class="relative">
                <select wire:model.live="statusApresVente" id="status_apres_vente_filter"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    <option value="all">Tous les statuts</option>
                    <option value="en_attente_livraison">En attente de livraison</option>
                    <option value="livre">Livré</option>
                    <option value="sav_1ere_visite">SAV 1ère visite</option>
                    <option value="relance">Relance</option>
                </select>

            </div>
        </div>
        <!-- Branch Filter -->
        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="w-full lg:w-1/3">

                <label for="branch_filter" class="block text-sm font-semibold text-slate-700 mb-2">Filtrer par
                    succursale:</label>
                <div class="relative">
                    <select wire:model.live="selectedBranch"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                        <option value="all">Tous</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif


    </div>



    <div class="bg-white rounded-xl shadow-card overflow-hidden">



        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($invoices as $invoice)
                @php
                    $client = $invoice->client;
                    $car = $invoice->car; // Assuming invoice has a direct relationship to a car
                    $status = $car->post_sale_status;
                    $colors = [
                        'en_attente_livraison' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'livre' => 'bg-green-100 text-green-800 border-green-300',
                        'sav_1ere_visite' => 'bg-blue-100 text-blue-800 border-blue-300',
                        'relance' => 'bg-red-100 text-red-800 border-red-300',
                    ];
                    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                @endphp
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    {{-- Card Header --}}
                    <div class="p-4 pb-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center">
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-base">
                                    {{ strtoupper(substr($client->full_name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-semibold text-gray-900">{{ $client->full_name }}</h3>
                                    <p class="text-xs text-gray-500">CIN: {{ $client->cin }}</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $colorClass }}">
                                {{ $status }}
                            </span>
                        </div>
                    </div>

                    {{-- Client Info --}}
                    <div class="px-4 pb-3">
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-phone w-3 mr-2"></i>
                                <span class="truncate">{{ $client->phone }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-envelope w-3 mr-2"></i>
                                <span class="truncate">{{ $client->email ?? '—' }}</span>
                            </div>
                        </div>
                        @if ($client->address)
                            <div class="mt-2 flex items-start text-xs text-gray-600">
                                <i class="fas fa-map-marker-alt w-3 mr-2 mt-0.5"></i>
                                <span class="line-clamp-2">{{ $client->address }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Car Info --}}
                    @if ($car)
                        <div class="px-4 py-3 bg-blue-50 border-t border-blue-100">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-car text-blue-600 mr-2"></i>
                                <h4 class="font-medium text-gray-900 text-sm">Véhicule</h4>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <span class="text-gray-600">Marque/Modèle:</span>
                                    <p class="font-medium text-gray-900">{{ $car->brand }} {{ $car->model }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Année:</span>
                                    <p class="font-medium text-gray-900">{{ $car->year }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Couleur:</span>
                                    <p class="font-medium text-gray-900">{{ $car->color }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Immatriculation:</span>
                                    <p class="font-medium text-gray-900">{{ $car->registration_number }}</p>
                                </div>
                            </div>
                            <div class="mt-2 pt-2 border-t border-blue-200">
                                <div class="grid grid-cols-1 gap-1 text-xs">
                                    <div>
                                        <span class="text-gray-600">IVN:</span>
                                        <span class="font-mono text-gray-900 ml-2">{{ $car->ivn }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Châssis:</span>
                                        <span class="font-mono text-gray-900 ml-2">{{ $car->chassis_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Invoice Info --}}
                    <div class="px-4 py-3 bg-green-50 border-t border-green-100">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-file-invoice text-green-600 mr-2"></i>
                            <h4 class="font-medium text-gray-900 text-sm">Facture ({{ $invoice->statut_facture }})</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-gray-600">N° Facture:</span>
                                <p class="font-medium text-gray-900">{{ $invoice->invoice_number }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Date Facture:</span>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($invoice->sale_date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-600">Montant TTC:</span>
                                <p class="font-bold text-base text-green-600">
                                    {{ number_format($invoice->total_amount, 2, ',', ' ') }} DH</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-green-200">
                            <div class="grid grid-cols-2 gap-1 text-xs">
                                <div>
                                    <span class="text-gray-600">Accord:</span>
                                    <span class="text-gray-900 ml-1">{{ $invoice->accord_reference }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Bon commande:</span>
                                    <span class="text-gray-900 ml-1">{{ $invoice->purchase_order_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Bon livraison:</span>
                                    <span class="text-gray-900 ml-1">{{ $invoice->delivery_note_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Ordre de réparationt:</span>
                                    <span class="text-gray-900 ml-1">{{ $invoice->payment_order_reference }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                Dernière visite:
                            </div>
                            <div class="flex space-x-1">
                                @php
                                    $images = [
                                        'image_path' => 'Image de la Facture',
                                        'image_bc' => 'Bon de Commande',
                                        'image_bl' => 'Bon de Livraison',
                                        'image_or' => 'Ordre de Réparation',
                                    ];

                                    $imageUrls = [];

                                    foreach ($images as $key => $label) {
                                        $path = $invoice->$key;
                                        $fullPath = null;

                                        if ($path && file_exists(storage_path('app/public/' . $path))) {
                                            $fullPath = asset('storage/' . $path);
                                        } elseif ($path && file_exists(public_path($path))) {
                                            $fullPath = asset($path);
                                        } elseif ($path && file_exists(public_path('storage/' . $path))) {
                                            $fullPath = asset('storage/' . $path);
                                        }

                                        $imageUrls[$key] = [
                                            'label' => $label,
                                            'url' => $fullPath,
                                            'path' => $path,
                                        ];
                                    }
                                @endphp

                                <div x-data="{ openInvoiceImage: false }">
                                    <button @click="openInvoiceImage = true"
                                        class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                        title="Voir les images">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>

                                    <div x-show="openInvoiceImage" x-transition x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                        <div @click.away="openInvoiceImage = false"
                                            class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-6 relative max-h-[80vh] overflow-auto">
                                            <button @click="openInvoiceImage = false"
                                                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <h2 class="text-lg font-semibold mb-4">Images associées à la facture</h2>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                @foreach ($imageUrls as $img)
                                                    <div class="border rounded-lg p-3 shadow-sm bg-gray-50">
                                                        <div class="flex justify-between items-center mb-2">
                                                            <h3 class="text-sm font-medium text-gray-700">
                                                                {{ $img['label'] }}</h3>

                                                            @if ($img['url'])
                                                                <a href="{{ $img['url'] }}" download
                                                                    class="text-green-600 hover:text-green-800 text-sm flex items-center space-x-1">
                                                                    <i class="fas fa-download"></i>
                                                                    <span>Télécharger</span>
                                                                </a>
                                                            @endif
                                                        </div>

                                                        @if ($img['url'])
                                                            @php
                                                                $extension = strtolower(
                                                                    pathinfo($img['path'], PATHINFO_EXTENSION),
                                                                );
                                                            @endphp

                                                            @if ($extension === 'pdf')
                                                                <a href="{{ $img['url'] }}" target="_blank"
                                                                    class="text-blue-600 underline flex items-center space-x-2">
                                                                    <i class="fas fa-file-pdf text-red-600"></i>
                                                                    <span>Voir le fichier PDF</span>
                                                                </a>
                                                            @else
                                                                <img src="{{ $img['url'] }}"
                                                                    alt="{{ $img['label'] }}"
                                                                    class="w-full h-64 object-contain rounded border"
                                                                    onerror="this.parentElement.innerHTML='<p class=\'text-red-500 text-sm\'>Erreur lors du chargement de l\'image</p>'">
                                                            @endif
                                                        @else
                                                            <div class="text-center py-8">
                                                                <i
                                                                    class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-3"></i>
                                                                <p class="text-sm text-gray-600">Image introuvable</p>
                                                                <p class="text-xs text-gray-400 mt-1">Chemin:
                                                                    {{ $img['path'] }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                {{-- Edit Modal --}}
                                <div x-data="{ openEditModal: false }">
                                    <button @click="openEditModal = true"
                                        class="p-1.5 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors"
                                        title="Modifier">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>

                                    {{-- Edit Modal Popup --}}
                                    <div x-show="openEditModal" x-transition x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                        <div @click.away="openEditModal = false"
                                            class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto m-4">

                                            {{-- Modal Header --}}
                                            <div
                                                class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                                                <h2 class="text-xl font-semibold text-gray-900">
                                                    <i class="fas fa-edit text-yellow-600 mr-2"></i>
                                                    Modifier la Facture #{{ $invoice->invoice_number }}
                                                </h2>
                                                <button @click="openEditModal = false"
                                                    class="text-gray-400 hover:text-gray-600 transition-colors">
                                                    <i class="fas fa-times text-lg"></i>
                                                </button>
                                            </div>

                                            {{-- Modal Body --}}
                                            <div class="p-6">
                                                <!-- Replace your existing form tag with this -->
                                                <form action="{{ route('invoices.update', $invoice->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- <form wire:submit.prevent="updateInvoice"> -->

                                                    <!-- Car Information Section -->
                                                    @if ($car)
                                                        <div class="mb-8">

                                                            <!-- ... existing car fields ... -->
                                                            <div
                                                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                                                                    <input type="text" name="car_brand"
                                                                        value="{{ old('car_brand', $car->brand) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                                                    <input type="text" name="car_model"
                                                                        value="{{ old('car_model', $car->model) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                                                                    <input type="number" name="car_year"
                                                                        value="{{ old('car_year', $car->year) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                                                                    <input type="text" name="car_color"
                                                                        value="{{ old('car_color', $car->color) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Immatriculation</label>
                                                                    <input type="text" name="car_registration"
                                                                        value="{{ old('car_registration', $car->registration_number) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Statut
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
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">IVN</label>
                                                                    <input type="text" name="car_ivn"
                                                                        value="{{ old('car_ivn', $car->ivn) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent font-mono">
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label
                                                                        class="block text-sm font-medium text-gray-700 mb-1">Numéro
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
                                                        <div
                                                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">N°
                                                                    Facture</label>
                                                                <input type="text" name="invoice_number"
                                                                    value="{{ old('invoice_number', $invoice->invoice_number) }}"
                                                                    required
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Date
                                                                    de Facture</label>
                                                                <input type="date" name="sale_date"
                                                                    value="{{ old('sale_date', \Carbon\Carbon::parse($invoice->sale_date)->format('Y-m-d')) }}"
                                                                    required
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700">Statut
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
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Montant
                                                                    TTC (DH)</label>
                                                                <input type="number" step="0.01"
                                                                    name="total_amount"
                                                                    value="{{ old('total_amount', $invoice->total_amount) }}"
                                                                    required
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Référence
                                                                    accord</label>
                                                                <input type="text" name="accord_reference"
                                                                    value="{{ old('accord_reference', $invoice->accord_reference) }}"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">N°
                                                                    bon commande</label>
                                                                <input type="text" name="purchase_order_number"
                                                                    value="{{ old('purchase_order_number', $invoice->purchase_order_number) }}"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">N°
                                                                    bon livraison</label>
                                                                <input type="text" name="delivery_note_number"
                                                                    value="{{ old('delivery_note_number', $invoice->delivery_note_number) }}"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 mb-1">Ordre
                                                                    de réparation</label>
                                                                <input type="text" name="payment_order_reference"
                                                                    value="{{ old('payment_order_reference', $invoice->payment_order_reference) }}"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div
                                                        class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
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
                                </div>

                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full place-items-center">
                    <div class="px-6 py-12 text-center text-gray-500 bg-white rounded-md shadow-sm">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 13h6m-6 4h6M3 7h18M5 7v12h14V7" />
                            </svg>
                            <span class="text-lg font-semibold">Aucune facture trouvée</span>
                            <p class="text-sm text-gray-400">Essayez d’ajouter une nouvelle facture pour commencer.</p>
                        </div>
                    </div>
                </div>

            @endforelse

        </div>
        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
