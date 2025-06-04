
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
    @foreach($clients as $client)
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
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border border-gray-300">
                        {{ $client->post_sale_status }}
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
            @if($client->cars->isNotEmpty())
                @php $car = $client->cars->first(); @endphp
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
            @if($client->invoices->isNotEmpty())
                @php $invoice = $client->invoices->first(); @endphp
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
            @endif

            {{-- Card Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-calendar mr-1"></i>
                        Dernière visite:
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Voir détails">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors" title="Véhicules">
                            <i class="fas fa-car"></i>
                        </button>
                        <button class="p-2 text-purple-600 hover:bg-purple-100 rounded-lg transition-colors" title="Factures">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>
</div>

                </div>
