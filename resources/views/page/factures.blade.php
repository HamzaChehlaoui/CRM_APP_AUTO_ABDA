@extends('layouts.mastere')

@section('title', 'Clients - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-gray-50">
    <style>
        [x-cloak] { display: none !important; }

    </style>
    <div class="flex h-screen w-screen overflow-hidden">

       <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Factures</h1>
            <p class="text-sm text-gray-500">Gérez votre portefeuille factures</p>
        </div>

        <!-- Search Box -->
        <div class="flex-1 max-w-md mx-8">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 text-sm"></i>
                </div>
                <input
                    type="text"
                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm placeholder-gray-500"
                    placeholder="Rechercher une facture, client, montant..."
                    autocomplete="off"
                >
            
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                <i class="fas fa-bell"></i>
                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <span class="h-6 border-l border-gray-300"></span>
            <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
            </button>
        </div>
    </div>
</header>

            <!-- Main Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">

                <!-- Filters and Actions -->
                @if(auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
                <button id="openModalBtn"
                    class="flex items-center justify-center space-x-2 rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 mb-6">
                    <i class="fas fa-plus w-4 h-4"></i>
                    <span>Nouveau Factures</span>
                </button>
                @endif

<div class="bg-white rounded-xl shadow-card overflow-hidden">

                </div>
                   @if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500 ease-in-out"
         role="alert">
        <strong class="font-bold">Erreur !</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
         class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500 ease-in-out"
         role="alert">
        <strong class="font-bold">Succès !</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
                <!-- Clients Table -->
                @livewire('factures-table')

            </div>
        </div>
    </div>

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
                                <select name="client_id" id="client_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                    <option value="">Sélectionner un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                                    @endforeach
                                </select>
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
                                                        <input type="text" name="car[brand]" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                                    </div>
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-medium text-gray-700">Modèle *</label>
                                                        <input type="text" name="car[model]" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                                    </div>
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-medium text-gray-700">IVN *</label>
                                                        <input type="text" name="car[ivn]" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                                    </div>
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-medium text-gray-700">Numéro d'immatriculation *</label>
                                                        <input type="text" name="car[registration_number]" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                                    </div>
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-medium text-gray-700">Numéro de châssis *</label>
                                                        <input type="text" name="car[chassis_number]" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
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
                                                <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Statut après-vente *</label>
                        <select name="car[post_sale_status]" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                            <option value="en_attente_livraison">En attente livraison</option>
                            <option value="livre">Livré</option>
                            <option value="sav_1ere_visite">SAV 1ère visite</option>
                            <option value="relance">Relance</option>
                        </select>
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
                                    <input type="text" name="invoice[invoice_number]" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Date de facture *</label>
                                    <input type="date" name="invoice[sale_date]" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white" >
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Montant TTC *</label>
                                    <div class="relative">
                                        <input type="number" name="invoice[total_amount]" step="0.01" min="0" required
                                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                                        <span class="absolute right-3 top-3 text-gray-500 text-sm">MAD</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Accord / Contrat *</label>
                                    <input type="text" name="invoice[accord_reference]" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Bon de commande *</label>
                                    <input type="text" name="invoice[purchase_order_number]" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Bon de livraison *</label>
                                    <input type="text" name="invoice[delivery_note_number]" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Ordre de réparation*</label>
                                    <input type="text" name="invoice[payment_order_reference]" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Statut Facture *</label>
                                        <select name="invoice[statut_facture]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                            <option value="creation" selected>Creation</option>
                                            <option value="facturé">Facturé</option>
                                            <option value="envoyée_pour_paiement">Envoyée pour paiement</option>
                                            <option value="paiement">Paiement</option>
                                        </select>
                                </div>

@php
    $types = [
        'invoice' => 'Image de la facture',
        'bl' => 'Image Bon livraison',
        'or' => 'Image Ordre de réparation',
        'bc' => 'Image Bon commande',
    ];
@endphp

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
        <div
            class="flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition-colors duration-200 bg-white border-gray-300 hover:border-green-400"
            id="upload-area-{{ $type }}"
        >
            <div class="space-y-2 text-center" id="placeholder-{{ $type }}">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                </div>
                <div class="flex text-sm text-gray-600">
                    <label
                        for="{{ $type }}-image"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500"
                    >
                        <span>Télécharger un fichier</span>
                        <input
                            id="{{ $type }}-image"
                            name="image_{{ $type }}"
                            type="file"
                            accept="image/*,application/pdf"
                            class="sr-only"
                            required
                        >
                    </label>
                    <p class="pl-1">ou glisser-déposer</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, JPEG, PDF jusqu'à 10MB</p>
            </div>

            <div class="hidden" id="preview-{{ $type }}">
                <div class="flex items-center space-x-4">
                    <!-- image -->
                    <img
                        id="preview-image-{{ $type }}"
                        class="h-20 w-20 object-cover rounded-lg border border-gray-200"
                        src=""
                        alt="Preview"
                    >
                    <!-- PDF -->
                    <div class="preview-pdf-link-container"></div>

                    <div class="flex-1">
                        <p id="file-name-{{ $type }}" class="text-sm font-medium text-gray-900"></p>
                        <p id="file-size-{{ $type }}" class="text-xs text-gray-500"></p>
                        <button
                            type="button"
                            id="remove-image-{{ $type }}"
                            class="mt-1 text-xs text-red-600 hover:text-red-500"
                        >
                            <i class="fas fa-trash mr-1"></i>Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


                            </div>
                        </div>
                    </div>
                </form>
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
                            <button type="submit" form="clientForm"
                                class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="js/client.js"></script>
</body>
@endsection
