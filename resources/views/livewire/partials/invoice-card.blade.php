{{-- cart facture--}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 mb-6">
    {{-- Card Header --}}
    <div class="p-4 pb-3">
        <div class="flex items-start justify-between">
            <div class="flex items-center">
                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-base">
                    {{ strtoupper(substr(optional($client)->full_name ?? '?', 0, 1)) }}
                </div>
                <div class="ml-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ optional($client)->full_name ?? '—' }}</h3>
                    <p class="text-xs text-gray-500">CIN: {{ optional($client)->cin ?? '—' }}</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $colorClass ?? 'border-gray-300' }}">
                {{ $status ?? '—' }}
            </span>
        </div>
    </div>

    {{-- Client Info --}}
    <div class="px-4 pb-3">
        <div class="grid grid-cols-2 gap-3 text-xs">
            <div class="flex items-center text-gray-600">
                <i class="fas fa-phone w-3 mr-2"></i>
                <span class="truncate">{{ optional($client)->phone ?? '—' }}</span>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-envelope w-3 mr-2"></i>
                <span class="truncate">{{ optional($client)->email ?? '—' }}</span>
            </div>
        </div>

            <div class="mt-2 flex items-start text-xs text-gray-600">
                <i class="fas fa-map-marker-alt w-3 mr-2 mt-0.5"></i>
                <span class="line-clamp-2">{{ $client->address ?? '—'}}</span>
            </div>
    </div>

    {{-- Car Info --}}
        <div class="px-4 py-3 bg-blue-50 border-t border-blue-100">
            <div class="flex items-center mb-2">
                <i class="fas fa-car text-blue-600 mr-2"></i>
                <h4 class="font-medium text-gray-900 text-sm">Véhicule</h4>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-gray-600">Marque/Modèle:</span>
                    <p class="font-medium text-gray-900">{{ $car->brand ?? '—' }} {{ $car->model ?? '' }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Année:</span>
                    <p class="font-medium text-gray-900">{{ $car->year ?? '—' }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Couleur:</span>
                    <p class="font-medium text-gray-900">{{ $car->color ?? '—' }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Immatriculation:</span>
                    <p class="font-medium text-gray-900">{{ $car->registration_number ?? '—' }}</p>
                </div>
            </div>
            <div class="mt-2 pt-2 border-t border-blue-200">
                <div class="grid grid-cols-1 gap-1 text-xs">
                    <div>
                        <span class="text-gray-600">IVN:</span>
                        <span class="font-mono text-gray-900 ml-2">{{ $car->ivn ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Châssis:</span>
                        <span class="font-mono text-gray-900 ml-2">{{ $car->chassis_number ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

    {{-- Invoice Info --}}
        <div class="px-4 py-3 bg-green-50 border-t border-green-100">
            <div class="flex items-center mb-2">
                <i class="fas fa-file-invoice text-green-600 mr-2"></i>
                <h4 class="font-medium text-gray-900 text-sm">Facture</h4>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-gray-600">N° Facture:</span>
                    <p class="font-medium text-gray-900">{{ $invoice->invoice_number ?? '—' }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Date Facture:</span>
                    <p class="font-medium text-gray-900">
                        {{ $invoice->sale_date ? \Carbon\Carbon::parse($invoice->sale_date)->format('d/m/Y') : '—' }}
                    </p>
                </div>
                <div class="col-span-2">
                    <span class="text-gray-600">Montant TTC:</span>
                    <p class="font-bold text-base text-green-600">
                        {{ $invoice->total_amount !== null ? number_format($invoice->total_amount, 2, ',', ' ') . ' DH' : '—' }}
                    </p>
                </div>
            </div>
            <div class="mt-2 pt-2 border-t border-green-200">
                <div class="grid grid-cols-2 gap-1 text-xs">
                    <div>
                        <span class="text-gray-600">Accord:</span>
                        <span class="text-gray-900 ml-1">{{ $invoice->accord_reference ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Bon commande:</span>
                        <span class="text-gray-900 ml-1">{{ $invoice->purchase_order_number ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Bon livraison:</span>
                        <span class="text-gray-900 ml-1">{{ $invoice->delivery_note_number ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Ordre de réparation:</span>
                        <span class="text-gray-900 ml-1">{{ $invoice->payment_order_reference ?? '—' }}</span>
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
                                            <h3 class="text-sm font-medium text-gray-700">{{ $img['label'] }}</h3>

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
                                                $extension = strtolower(pathinfo($img['path'], PATHINFO_EXTENSION));
                                            @endphp

                                            @if ($extension === 'pdf')
                                                <a href="{{ $img['url'] }}" target="_blank"
                                                    class="text-blue-600 underline flex items-center space-x-2">
                                                    <i class="fas fa-file-pdf text-red-600"></i>
                                                    <span>Voir le fichier PDF</span>
                                                </a>
                                            @else
                                                <img src="{{ $img['url'] }}" alt="{{ $img['label'] }}"
                                                    class="w-full h-64 object-contain rounded border"
                                                    onerror="this.parentElement.innerHTML='<p class=\'text-red-500 text-sm\'>Erreur lors du chargement de l\'image</p>'">
                                            @endif
                                        @else
                                            <div class="text-center py-8">
                                                <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-3"></i>
                                                <p class="text-sm text-gray-600">Image introuvable</p>
                                                <p class="text-xs text-gray-400 mt-1">Chemin: {{ $img['path'] }}</p>
                                            </div>
                                        @endif
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                @if($invoice->statut_facture === 'paiement')
    @php
        $paiementPath = $invoice->paiement_file_path;
        $paiementUrl = null;

        if ($paiementPath && file_exists(storage_path('app/public/' . $paiementPath))) {
            $paiementUrl = asset('storage/' . $paiementPath);
        } elseif ($paiementPath && file_exists(public_path($paiementPath))) {
            $paiementUrl = asset($paiementPath);
        } elseif ($paiementPath && file_exists(public_path('storage/' . $paiementPath))) {
            $paiementUrl = asset('storage/' . $paiementPath);
        }
    @endphp

    <div class="ml-2">
        <button
            x-data="{ openPaiementImage: false }"
            @click="openPaiementImage = true"
            class="p-1.5 text-green-600 hover:bg-green-100 rounded-lg transition-colors"
            title="Voir l'image du paiement"
        >
            <i class="fas fa-file-invoice-dollar text-sm"></i>
        </button>

        <div x-show="openPaiementImage" x-transition x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openPaiementImage = false"
                class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6 relative max-h-[80vh] overflow-auto">
                <button @click="openPaiementImage = false"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-lg font-semibold mb-4">Image du Paiement</h2>

                @if ($paiementUrl)
                    @php
                        $ext = strtolower(pathinfo($paiementPath, PATHINFO_EXTENSION));
                    @endphp

                    @if ($ext === 'pdf')
                        <a href="{{ $paiementUrl }}" target="_blank"
                            class="text-blue-600 underline flex items-center space-x-2">
                            <i class="fas fa-file-pdf text-red-600"></i>
                            <span>Voir le fichier PDF</span>
                        </a>
                    @else
                        <img src="{{ $paiementUrl }}" alt="Image du Paiement"
                            class="w-full h-64 object-contain rounded border"
                            onerror="this.parentElement.innerHTML='<p class=\'text-red-500 text-sm\'>Erreur lors du chargement de l\'image</p>'">
                    @endif
                @else     
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-3"></i>
                        <p class="text-sm text-gray-600">Image du paiement introuvable</p>
                        <p class="text-xs text-gray-400 mt-1">Chemin: {{ $paiementPath }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
                @if($invoice->statut_facture != 'paiement')
            @if(auth()->user()->role_id!=1 && auth()->user()->role_id!=2 )
                <a href="{{ route('invoices.edit', $invoice->id) }}"
                    class="inline-flex items-center justify-center w-10 h-10  text-yellow-600 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
