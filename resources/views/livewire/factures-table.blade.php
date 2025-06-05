<div class="bg-white rounded-xl shadow-card overflow-hidden">
    <!-- Branch Filter -->
    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-card p-4">
                <label for="branch_filter" class="text-sm font-medium text-gray-700">Filtrer par succursale:</label>
                <select wire:model.live="selectedBranch" class="border rounded p-2">
                    <option value="all">Tous</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($invoices as $invoice)
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                {{-- Card Header --}}
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($client->full_name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $client->full_name }}</h3>
                                <p class="text-sm text-gray-500">CIN: {{ $client->cin }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $colorClass }}">
                            {{ $status }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border bg-blue-100 text-blue-800 border-blue-300">
                            {{ $invoice->statut_facture }}
                        </span>
                    </div>

                </div>

                {{-- Client Info --}}
                <div class="px-6 pb-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-4 mr-2"></i>
                            <span class="truncate">{{ $client->phone }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-4 mr-2"></i>
                            <span class="truncate">{{ $client->email ?? '—' }}</span>
                        </div>
                    </div>
                    @if($client->address)
                        <div class="mt-2 flex items-start text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt w-4 mr-2 mt-0.5"></i>
                            <span class="line-clamp-2">{{ $client->address }}</span>
                        </div>
                    @endif
                </div>

                {{-- Car Info --}}
                @if($car)
                    <div class="px-6 py-4 bg-blue-50 border-t border-blue-100">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-car text-blue-600 mr-2"></i>
                            <h4 class="font-medium text-gray-900">Véhicule</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
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
                        <div class="mt-3 pt-3 border-t border-blue-200">
                            <div class="grid grid-cols-1 gap-2 text-xs">
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
                <div class="px-6 py-4 bg-green-50 border-t border-green-100">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-file-invoice text-green-600 mr-2"></i>
                        <h4 class="font-medium text-gray-900">Facture</h4>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">N° Facture:</span>
                            <p class="font-medium text-gray-900">{{ $invoice->invoice_number }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Date vente:</span>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($invoice->sale_date)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-600">Montant TTC:</span>
                            <p class="font-bold text-lg text-green-600">{{ number_format($invoice->total_amount, 2, ',', ' ') }} DH</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-green-200">
                        <div class="grid grid-cols-2 gap-2 text-xs">
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
                                <span class="text-gray-600">Ordre règlement:</span>
                                <span class="text-gray-900 ml-1">{{ $invoice->payment_order_reference }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            Dernière visite:
                        </div>
                        <div class="flex space-x-2">
                            <div x-data="{ openInvoiceImage: false }">
                                <button @click="openInvoiceImage = true" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <div x-show="openInvoiceImage" x-transition x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    <div @click.away="openInvoiceImage = false"
                                        class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
                                        <button @click="openInvoiceImage = false"
                                            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <h2 class="text-lg font-semibold mb-4">Image de la Facture</h2>

                                        @php
                                            $imagePath = $invoice->image_path;
                                            $fullPath = null;

                                            if (file_exists(storage_path('app/public/' . $imagePath))) {
                                                $fullPath = asset('storage/' . $imagePath);
                                            }
                                            elseif (file_exists(public_path($imagePath))) {
                                                $fullPath = asset($imagePath);
                                            }
                                            elseif (file_exists(public_path('storage/' . $imagePath))) {
                                                $fullPath = asset('storage/' . $imagePath);
                                            }
                                        @endphp

                                        @if($fullPath)
                                            <img src="{{ $fullPath }}" alt="Facture {{ $invoice->invoice_number }}"
                                                class="w-full rounded border shadow-sm max-h-96 object-contain"
                                                onerror="this.parentElement.innerHTML='<p class=\'text-red-500 text-sm\'>Erreur lors du chargement de l\'image</p>'">
                                        @else
                                            <div class="text-center py-8">
                                                <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-3"></i>
                                                <p class="text-sm text-gray-600">Image introuvable</p>
                                                <p class="text-xs text-gray-400 mt-1">Chemin: {{ $imagePath }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="p-2 text-purple-600 hover:bg-purple-100 rounded-lg transition-colors" title="Factures">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>

</div>
