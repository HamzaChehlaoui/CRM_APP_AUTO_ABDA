@extends('layouts.mastere')

@section('title', 'Prospects - Tableau de Bord')

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
                        <h1 class="text-2xl font-bold text-gray-800">Prospects</h1>
                        <p class="text-sm text-gray-500">Gérez vos prospects et leurs informations</p>
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
                <!-- Filters and Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 space-y-4 md:space-y-0">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="relative w-full sm:w-64">
                            <input type="text" placeholder="Rechercher un prospect..."
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
                        <span>Nouveau Prospect</span>
                    </button>
                </div>

                <!-- Prospects Table -->
                <div class="bg-white rounded-xl shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Véhicule
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
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">ML</div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Martin Leclerc</div>
                                                <div class="text-sm text-gray-500">ID: #PRO-2025-001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">martin.l@example.com</div>
                                        <div class="text-sm text-gray-500">06 12 34 56 78</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Renault Clio</div>
                                        <div class="text-sm text-gray-500">Essence, Automatique</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        15 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-new">
                                            Nouveau
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">SD</div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Sophie Dubois</div>
                                                <div class="text-sm text-gray-500">ID: #PRO-2025-002</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">sophie.d@example.com</div>
                                        <div class="text-sm text-gray-500">06 23 45 67 89</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Peugeot 3008</div>
                                        <div class="text-sm text-gray-500">Diesel, Manuelle</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        14 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-interested">
                                            Intéressé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">PT</div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Pierre Thomas</div>
                                                <div class="text-sm text-gray-500">ID: #PRO-2025-003</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">pierre.t@example.com</div>
                                        <div class="text-sm text-gray-500">06 34 56 78 90</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Citroën C4</div>
                                        <div class="text-sm text-gray-500">Hybride, Automatique</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        12 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-sold">
                                            Vendu
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">LM</div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Lucie Martin</div>
                                                <div class="text-sm text-gray-500">ID: #PRO-2025-004</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">lucie.m@example.com</div>
                                        <div class="text-sm text-gray-500">06 45 67 89 01</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">BMW Série 3</div>
                                        <div class="text-sm text-gray-500">Essence, Automatique</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        10 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-not-interested">
                                            Non intéressé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">TP</div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Thomas Petit</div>
                                                <div class="text-sm text-gray-500">ID: #PRO-2025-005</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">thomas.p@example.com</div>
                                        <div class="text-sm text-gray-500">06 56 78 90 12</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Audi A3</div>
                                        <div class="text-sm text-gray-500">Essence, Automatique</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        9 mai 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-interested">
                                            Intéressé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
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
                                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">5</span> sur <span class="font-medium">42</span> résultats
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
                                        8
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        9
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
