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
                    {{-- Header buttons --}}
                </div>
            </header>

            <div class="flex-1 p-8 overflow-y-auto">
                <!-- Configuration Section -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Configuration d'exportation</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <label for="dataType" class="block text-sm font-semibold text-gray-700">Type de données</label>
                            <div class="flex items-center space-x-3">
                                <select id="dataType" name="data_type" class="flex-grow px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                    <option value="clients">📊 Clients</option>
                                    <option value="cars">🚗 Voitures</option>
                                    <option value="invoices">📄 Factures</option>
                                    <option value="all">🔄 Tous les types</option>
                                </select>
                                <button id="showAllBtn" type="button" class="px-4 py-3 border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all duration-200" title="Afficher tous les types de champs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        {{-- Format and Date Range sections --}}
                    </div>
                </div>

                <!-- Fields Selection Section -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800">Champs à exporter</h2>
                        </div>
                        <div class="flex space-x-3">
                            <button id="selectAllBtn" type="button" class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-sm font-medium hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Tout sélectionner
                            </button>
                            <button id="deselectAllBtn" type="button" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 hover:border-gray-300 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tout désélectionner
                            </button>
                        </div>
                    </div>

                    <!-- Clients Fields -->
                    <div id="fields-clients" class="export-fields space-y-6 mb-8">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Champs des Clients</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">ID</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Nom complet</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Téléphone</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">CIN</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Adresse</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Email</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Agence / Succursale</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Date de création</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Cars Fields -->
                    <div id="fields-cars" class="export-fields space-y-6 mb-8 hidden">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Champs des Voitures</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">ID</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Marque</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Modèle</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">IVN</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">N° d'immatriculation</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">N° de châssis (VIN)</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Couleur</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Année</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Nom du Client</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Agence</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Statut après-vente</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-green-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Date de création</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Invoices Fields -->
                    <div id="fields-invoices" class="export-fields space-y-6 hidden">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                            <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700">Champs des Factures</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">ID</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">N° de facture</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Date de la facture</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Montant TTC</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Chemin de l'image</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Accord / Contrat</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
<input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Accord / Contrat</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Nom du Client</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Marque voiture</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Modèle voiture</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Agence</span>
                                </label>
                            </div>
                            <div class="group border border-gray-200 rounded-xl p-4 hover:border-purple-300 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                                <label class="inline-flex items-center w-full cursor-pointer">
                                    <input type="checkbox" class="h-4 w-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">Date de création</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Actions -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800">Actions d'exportation</h2>
                        </div>
                        <div class="text-sm text-gray-500">
                            <span id="selectedCount">0</span> champs sélectionnés
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <button type="button" id="exportExcel" class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-center space-x-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">Excel (.xlsx)</span>
                            </div>
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </button>

                        <button type="button" id="exportCSV" class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6 hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-center space-x-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="font-semibold">CSV (.csv)</span>
                            </div>
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </button>

                        <button type="button" id="exportPDF" class="group relative overflow-hidden bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6 hover:from-red-600 hover:to-red-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-center space-x-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">PDF (.pdf)</span>
                            </div>
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </button>


                    </div>

                    <!-- Export Progress -->
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

    <!-- Export Configuration Form (Hidden) -->
    <form id="exportForm" action="" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="data_type" id="formDataType">
        <input type="hidden" name="export_format" id="formExportFormat">
        <input type="hidden" name="selected_fields" id="formSelectedFields">
        <input type="hidden" name="date_range" id="formDateRange">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataTypeSelect = document.getElementById('dataType');
            const fieldSections = document.querySelectorAll('.export-fields');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deselectAllBtn = document.getElementById('deselectAllBtn');
            const showAllBtn = document.getElementById('showAllBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const exportButtons = document.querySelectorAll('[id^="export"]');
            const exportForm = document.getElementById('exportForm');
            const exportProgress = document.getElementById('exportProgress');
            const progressBar = document.getElementById('progressBar');

            // Show/Hide field sections based on data type
            function updateFieldSections() {
                const selectedType = dataTypeSelect.value;

                fieldSections.forEach(section => {
                    section.classList.add('hidden');
                });

                if (selectedType === 'all') {
                    fieldSections.forEach(section => {
                        section.classList.remove('hidden');
                    });
                } else {
                    const targetSection = document.getElementById(`fields-${selectedType}`);
                    if (targetSection) {
                        targetSection.classList.remove('hidden');
                    }
                }
                updateSelectedCount();
            }

            // Update selected fields count
            function updateSelectedCount() {
                const visibleCheckboxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]');
                const checkedBoxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]:checked');
                selectedCountSpan.textContent = checkedBoxes.length;
            }

            // Select/Deselect all visible checkboxes
            function selectAllFields(select = true) {
                const visibleCheckboxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]');
                visibleCheckboxes.forEach(checkbox => {
                    checkbox.checked = select;
                });
                updateSelectedCount();
            }

            // Event listeners
            dataTypeSelect.addEventListener('change', updateFieldSections);

            selectAllBtn.addEventListener('click', () => selectAllFields(true));
            deselectAllBtn.addEventListener('click', () => selectAllFields(false));

            showAllBtn.addEventListener('click', function() {
                dataTypeSelect.value = 'all';
                updateFieldSections();
            });

            // Update count when checkboxes change
            document.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox' && e.target.closest('.export-fields')) {
                    updateSelectedCount();
                }
            });

            // Export button handlers
            exportButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const format = this.id.replace('export', '').toLowerCase();
                    handleExport(format);
                });
            });

            function handleExport(format) {
                const selectedFields = [];
                const checkedBoxes = document.querySelectorAll('.export-fields:not(.hidden) input[type="checkbox"]:checked');

                if (checkedBoxes.length === 0) {
                    alert('Veuillez sélectionner au moins un champ à exporter.');
                    return;
                }

                checkedBoxes.forEach(checkbox => {
                    const fieldName = checkbox.nextElementSibling.textContent.trim();
                    selectedFields.push(fieldName);
                });

                // Set form values
                document.getElementById('formDataType').value = dataTypeSelect.value;
                document.getElementById('formExportFormat').value = format;
                document.getElementById('formSelectedFields').value = JSON.stringify(selectedFields);

                // Show progress
                showExportProgress();

                // Submit form
                exportForm.submit();
            }

            function showExportProgress() {
                exportProgress.classList.remove('hidden');
                let progress = 0;
                const interval = setInterval(() => {
                    progress += Math.random() * 20;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(interval);
                        setTimeout(() => {
                            exportProgress.classList.add('hidden');
                            progressBar.style.width = '0%';
                        }, 1000);
                    }
                    progressBar.style.width = `${progress}%`;
                }, 200);
            }

            // Initialize
            updateFieldSections();
        });
    </script>

</body>
@endsection
