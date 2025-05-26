@extends('layouts.mastere')

@section('title', 'Reclamation - Tableau de Bord')

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
                        <h1 class="text-2xl font-bold text-gray-800">Réclamations</h1>
                        <p class="text-sm text-gray-500">Gérez les réclamations clients</p>
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
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-xl text-red-600"></i>
                            </div>
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">↑ 4%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Total Réclamations</h3>
                        <p class="text-3xl font-bold text-red-600">32</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-xl text-blue-600"></i>
                            </div>
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">↑ 2%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Nouvelles</h3>
                        <p class="text-3xl font-bold text-blue-600">4</p>
                        <p class="text-sm text-gray-500 mt-1">À traiter</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-spinner text-xl text-yellow-600"></i>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">↑ 8%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">En cours</h3>
                        <p class="text-3xl font-bold text-yellow-600">12</p>
                        <p class="text-sm text-gray-500 mt-1">En traitement</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check-circle text-xl text-green-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 15%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Résolues</h3>
                        <p class="text-3xl font-bold text-green-600">16</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>
                </div>

                <!-- Filters and Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 space-y-4 md:space-y-0">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="relative w-full sm:w-64">
                            <input type="text" placeholder="Rechercher une réclamation..."
                                   class="w-full rounded-md border border-gray-200 py-2 pl-10 pr-4 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <button class="flex items-center space-x-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-filter text-gray-400"></i>
                                    <span>Filtres</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>
                                <!-- Dropdown menu would go here -->
                            </div>
                            <div class="relative">
                                <button class="flex items-center space-x-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-sort text-gray-400"></i>
                                    <span>Trier par</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>
                                <!-- Dropdown menu would go here -->
                            </div>
                        </div>
                    </div>
                    <button class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <i class="fas fa-plus"></i>
                        <span>Nouvelle Réclamation</span>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600">
                            Toutes
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Nouvelles
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            En cours
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Résolues
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Fermées
                        </a>
                    </nav>
                </div>

                <!-- Complaints Table -->
                <div class="bg-white rounded-xl shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Référence
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sujet
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Priorité
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#REC-2025-001</div>
                                        <div class="text-xs text-gray-500">Créé le 15/05/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">TP</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Thomas Petit</div>
                                                <div class="text-sm text-gray-500">Audi A3 - 2023</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Problème de climatisation</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">La climatisation ne fonctionne plus correctement depuis la dernière révision.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full complaint-priority-high">
                                            Haute
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        20 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full complaint-status-new">
                                            Nouvelle
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-reply"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#REC-2025-002</div>
                                        <div class="text-xs text-gray-500">Créé le 14/05/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">SD</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Sophie Dubois</div>
                                                <div class="text-sm text-gray-500">Peugeot 3008 - 2022</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Retard de livraison</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">La pièce commandée n'est toujours pas arrivée après 3 semaines d'attente.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full complaint-priority-medium">
                                            Moyenne
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        14 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full complaint-status-in-progress">
                                            En cours
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-reply"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#REC-2025-003</div>
                                        <div class="text-xs text-gray-500">Créé le 10/05/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">JD</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Jean Dupont</div>
                                                <div class="text-sm text-gray-500">Audi Q5 - 2023</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Bruit moteur anormal</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">Bruit anormal au démarrage du véhicule depuis la dernière révision.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full complaint-priority-high">
                                            Haute
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        10 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full complaint-status-resolved">
                                            Résolue
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#REC-2025-004</div>
                                        <div class="text-xs text-gray-500">Créé le 05/05/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">ML</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Martin Leclerc</div>
                                                <div class="text-sm text-gray-500">Renault Clio - 2024</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">Facture incorrecte</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">Erreur sur la facture de la dernière révision, montant trop élevé.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full complaint-priority-low">
                                            Basse
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        05 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full complaint-status-closed">
                                            Fermée
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-redo"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Précédent
                            </a>
                            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">4</span> sur <span class="font-medium">32</span> résultats
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Précédent</span>
                                        <i class="fas fa-chevron-left h-5 w-5"></i>
                                    </a>
                                    <a href="#" aria-current="page" class="z-10 bg-primary-50 border-primary-500 text-primary-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        1
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        2
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        3
                                    </a>
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        7
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        8
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Suivant</span>
                                        <i class="fas fa-chevron-right h-5 w-5"></i>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
</html>
