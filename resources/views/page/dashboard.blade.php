<!-- resources/views/dashboard.blade.php -->
@extends('layouts.mastere')

@section('title', 'Dashboard - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-nucleus-gray">

    <div class="flex h-screen w-screen overflow-hidden">

        <!-- Sidebar -->
    <x-sidebar />
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            @if(Auth::user()->role_id == 1)
                                Tableau de Bord - Directeur Général
                            @elseif(Auth::user()->role_id ==2)
                                Tableau de Bord - Assistant Directeur
                            @elseif(Auth::user()->role_id == 3)
                                Tableau de Bord - Employé de Magasin Safi
                            @elseif(Auth::user()->role_id==4)
                                Tableau de Bord - Employé de Carrosserie Safi
                            @elseif(Auth::user()->role_id==5)
                                Tableau de Bord - Employé de Atelier Safi
                            @elseif(Auth::user()->role_id == 6)
                                Tableau de Bord - Employé de Essaouira
                            @elseif(Auth::user()->role_id == 7)
                                Tableau de Bord - Employé de Sidi Bennour
                            @else
                                Tableau de Bord
                            @endif
                        </h1>
                        <p class="text-sm text-gray-500">
                            Vue d'ensemble de votre CRM automobile
                        </p>
                </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors">
                            <i class="fas fa-question-circle"></i>
                        </button>
                        <span class="h-6 border-l border-gray-300"></span>
                        <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                            <span class="font-medium text-sm">Aujourd'hui</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </header>


            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Summary Stats -->
                <!-- Branch Filter (Only for Admin and Assistant) -->
@if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
<div class="mb-6">
    <div class="bg-white rounded-xl shadow-card p-4">
        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-4">
            <label for="branch_filter" class="text-sm font-medium text-gray-700">Filtrer par succursale:</label>
            <select name="branch_filter" id="branch_filter"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-nucleus-primary focus:border-transparent bg-white min-w-[200px]"
                    onchange="this.form.submit()">
                <option value="all" {{ $selectedBranch == 'all' ? 'selected' : '' }}>
                    Toutes les succursales
                </option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $selectedBranch == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>

            <!-- Loading indicator -->
            <div id="loading-indicator" class="hidden">
                <svg class="animate-spin h-5 w-5 text-nucleus-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('branch_filter').addEventListener('change', function() {
    document.getElementById('loading-indicator').classList.remove('hidden');
});
</script>
@endif

<!-- Summary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-user-plus text-xl text-nucleus-primary"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageClients, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageClients }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Total des clients</h3>
        <p class="text-3xl font-bold text-nucleus-primary">{{ $totalClientsCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Cette semaine</p>
    </div>

    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-phone-alt text-xl text-yellow-600"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageSuivis, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageSuivis }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Suivis en Cours</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $suivisEnCoursCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Nécessitent une action</p>
    </div>

    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <i class="fas fa-users text-xl text-green-600"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageActive, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageActive }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Clients Actifs</h3>
        <p class="text-3xl font-bold text-green-600">{{ $activeClientsCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Total des clients</p>
    </div>

    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <i class="fas fa-car text-xl text-purple-600"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageSales, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageSales }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Ventes</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $salesThisMonthCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
    </div>
</div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Charts / Graphs -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Suivi des Clients</h3>
                            <div class="flex space-x-2">
                                <div class="flex space-x-2">
                                    <button onclick="changePeriod('week')" class="period-btn px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Semaine</button>
                                    <button onclick="changePeriod('month')" class="period-btn px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Mois</button>
                                    <button onclick="changePeriod('year')" class="period-btn px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Année</button>
                                </div>
                            </div>
                        </div>
                        <div class="h-64 relative">
                            <canvas id="prospectsChart"></canvas>
                        </div>
                    </div>

                    <!-- Summary by Post-Sale Status -->
                    <div class="bg-white rounded-xl shadow-card p-6">

                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Phase Post-Vente</h3>

                        <div class="h-64 relative" wire:init="initChart">
                            <canvas  id="statusChart"></canvas>
                        </div>
                    </div>

                        <!-- Clients -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-3">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">Clients</h3>
                                {{-- <p class="text-sm text-gray-600">Gestion et suivi de la clientèle</p> --}}
                            </div>
                            <a href="/clients" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                Voir tout
                            </a>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($clients as $client)
            @php
                $invoice = $client->invoices->first();
                $car = $client->cars->first();
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
                        @php
    $status = $client->post_sale_status;
    $colors = [
        'en_attente_livraison' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
        'livre' => 'bg-green-100 text-green-800 border-green-300',
        'sav_1ere_visite' => 'bg-blue-100 text-blue-800 border-blue-300',
        'relance' => 'bg-red-100 text-red-800 border-red-300',
    ];
    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $colorClass }}">
    {{ $status }}
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
                @if($invoice)
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

                                        @if($invoice && $invoice->image_path)
                                            @php
                                                // Try different path combinations
                                                $imagePath = $invoice->image_path;
                                                $fullPath = null;

                                                // Check if it's a storage path
                                                if (file_exists(storage_path('app/public/' . $imagePath))) {
                                                    $fullPath = asset('storage/' . $imagePath);
                                                }
                                                // Check if it's already in public
                                                elseif (file_exists(public_path($imagePath))) {
                                                    $fullPath = asset($imagePath);
                                                }
                                                // Check if it's in public/storage
                                                elseif (file_exists(public_path('storage/' . $imagePath))) {
                                                    $fullPath = asset('storage/' . $imagePath);
                                                }
                                            @endphp

                                            @if($fullPath)
                                                <img src="{{ $fullPath }}" alt="Facture"
                                                    class="w-full rounded border shadow-sm max-h-96 object-contain"
                                                    onerror="this.parentElement.innerHTML='<p class=\'text-red-500 text-sm\'>Erreur lors du chargement de l\'image</p>'">
                                            @else
                                                <div class="text-center py-8">
                                                    <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-3"></i>
                                                    <p class="text-sm text-gray-600">Image introuvable</p>
                                                    <p class="text-xs text-gray-400 mt-1">Chemin: {{ $imagePath }}</p>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-8">
                                                <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                                                <p class="text-sm text-gray-500">Aucune image disponible pour cette facture.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

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
    </div>




                    </div>


                </div>
            </div>
        </div>
    </div>

 <script>
    window.chartData = {
        selectedBranch: "{{ $selectedBranch ?? (auth()->user()->branch_id ?? 'all') }}",
        labels: @json($labels),
        clientsVendus: @json($clientsVendus)
    };

</script>

<script src="js/dashboard.js"></script>
@endsection
