@extends('layouts.mastere')

@section('title', 'Exporter - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-gray-50">

    <div class="flex h-screen w-screen overflow-hidden">

        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Exporter</h1>
                        <p class="text-sm text-gray-500">Exportez vos données dans différents formats</p>
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

            <!-- Main Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Export options section -->
                <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Options d'exportation</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Data type selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de données</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                <option value="clients">Clients</option>
                                <option value="suivis">Suivis</option>
                                <option value="entretiens">Entretiens</option>
                                <option value="reclamations">Réclamations</option>
                                <option value="ventes">Ventes</option>
                                <option value="vehicules">Véhicules</option>
                            </select>
                        </div>

                        <!-- Format selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                            <div class="flex space-x-4">
                               
                                <label class="inline-flex items-center">
                                    <input type="radio" name="format" value="excel" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                    <span class="ml-2 text-gray-700">Excel</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="format" value="pdf" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                    <span class="ml-2 text-gray-700">PDF</span>
                                </label>
                            </div>
                        </div>

                        <!-- Date range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Du</label>
                                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Au</label>
                                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Predefined date ranges -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <button class="px-3 py-1 bg-primary-50 text-primary-600 rounded-md text-sm hover:bg-primary-100">Aujourd'hui</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">Cette semaine</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">Ce mois</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">Ce trimestre</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">Cette année</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">Tout</button>
                    </div>
                </div>

                <!-- Field selection section -->
                <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Champs à exporter</h2>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-primary-50 text-primary-600 rounded-md text-sm hover:bg-primary-100">Tout sélectionner</button>
                            <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm hover:bg-gray-200">Tout désélectionner</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        <!-- Prospect fields -->
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">ID</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Nom</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Prénom</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Email</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Téléphone</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Adresse</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Ville</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Code postal</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Date de création</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Statut</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Source</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                <span class="ml-2">Intérêt</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <span class="ml-2">Modèle intéressé</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <span class="ml-2">Budget</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <span class="ml-2">Notes</span>
                            </label>
                        </div>
                        <div class="border border-gray-200 rounded-md p-3">
                            <label class="inline-flex items-center font-medium text-gray-700 mb-2">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <span class="ml-2">Conseiller assigné</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Preview section -->
                <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Aperçu des données</h2>
                        <div>
                            <span class="text-sm text-gray-500">100 enregistrements trouvés</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#PRO-2025-001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Martin</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sophie</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">sophie.martin@email.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">06 12 34 56 78</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/05/2025</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#PRO-2025-002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dubois</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pierre</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">pierre.dubois@email.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07 23 45 67 89</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20/05/2025</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#PRO-2025-003</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Leroy</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Marie</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">marie.leroy@email.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">06 98 76 54 32</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-100 text-primary-800">
                                            Contacté
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">22/05/2025</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#PRO-2025-004</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Moreau</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Thomas</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">thomas.moreau@email.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07 65 43 21 09</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Inactif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25/05/2025</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#PRO-2025-005</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Petit</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Julie</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">julie.petit@email.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">06 54 32 10 98</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Rendez-vous
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28/05/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-sm text-gray-500">
                        <p>Aperçu limité aux 5 premiers enregistrements. L'exportation complète contiendra tous les enregistrements correspondant aux critères.</p>
                    </div>
                </div>

                <!-- Export history section -->
                <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Historique des exportations</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enregistrements</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28/05/2025 14:32</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Prospects</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Excel</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">David Girard</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">245</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary-600 hover:text-primary-900 mr-3">Télécharger</a>
                                        <a href="#" class="text-primary-600 hover:text-primary-900">Répéter</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">25/05/2025 09:15</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Clients</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CSV</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">David Girard</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">178</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary-600 hover:text-primary-900 mr-3">Télécharger</a>
                                        <a href="#" class="text-primary-600 hover:text-primary-900">Répéter</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20/05/2025 16:45</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ventes</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">PDF</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">David Girard</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">56</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary-600 hover:text-primary-900 mr-3">Télécharger</a>
                                        <a href="#" class="text-primary-600 hover:text-primary-900">Répéter</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/05/2025 11:20</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Entretiens</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Excel</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">David Girard</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">124</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary-600 hover:text-primary-900 mr-3">Télécharger</a>
                                        <a href="#" class="text-primary-600 hover:text-primary-900">Répéter</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Annuler
                    </button>
                    <button type="button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Exporter
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
</html>
