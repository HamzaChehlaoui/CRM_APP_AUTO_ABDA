<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entretiens - AutoCRM</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

      <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        nucleus: {
                            primary: '#3A5CDB',
                            hover: '#2D4EC0',
                            light: '#F2F6FF',
                            dark: '#0F1A42',
                            gray: '#F5F7FA',
                        },
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        success: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            700: '#15803d',
                        },
                        warning: {
                            50: '#fffbeb',
                            500: '#f59e0b',
                            700: '#b45309',
                        },
                        danger: {
                            50: '#fef2f2',
                            500: '#ef4444',
                            700: '#b91c1c',
                        },
                        neutral: {
                            50: '#fafafa',
                            100: '#f5f5f5',
                            200: '#e5e5e5',
                            300: '#d4d4d4',
                            400: '#a3a3a3',
                            500: '#737373',
                            600: '#525252',
                            700: '#404040',
                            800: '#262626',
                            900: '#171717',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'input': '0 2px 4px rgba(0, 0, 0, 0.05)',
                        'card': '0 10px 25px rgba(58, 92, 219, 0.07)',
                    }
                },
            },
        };
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .status-new {
            background-color: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #0284c7;
        }
        .status-interested {
            background-color: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #b45309;
        }
        .status-sold {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #15803d;
        }
        .status-not-interested {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #b91c1c;
        }

        /* Animation transitions */
        .card-hover {
            transition: all 0.3s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-4px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
</style>
</head>
<body class="h-full w-full font-sans bg-gray-50">

    <div class="flex h-screen w-screen overflow-hidden">

       <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex flex-col z-10">
            <div class="bg-gradient-to-r from-nucleus-primary to-nucleus-hover text-white px-6 py-5 flex items-center space-x-3 relative overflow-hidden shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 -translate-x-6"></div>
                <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/5 rounded-full translate-y-8 -translate-x-8"></div>
                <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-inner relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 86" class="w-6 h-auto">
                        <path fill="white" d="m52.3 43-23 43H23L0 43 22.9 0h6.5L6.5 43l19.6 36.9L45.7 43 34.3 21.5l3.3-6.1L52.3 43zM42.5 0h-6.6L13.1 43l14.7 27.6 3.2-6.1L19.6 43 39.2 6l19.6 37-22.9 43h6.6l22.8-43L42.5 0z"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <span class="font-bold text-xl tracking-tight">FollowUp</span>
                    <span class="font-light text-xl tracking-tight">CRM</span>
                    <div class="text-xs font-light text-white/80 mt-0.5">Solution de gestion automobile</div>
                </div>
            </div>

            <div class="p-4">
                <div class="relative mb-4">
                    <input type="text" placeholder="Rechercher..."
                           class="w-full rounded-md border border-gray-200 py-2 pl-10 pr-4 text-sm focus:border-nucleus-primary focus:outline-none focus:ring-1 focus:ring-nucleus-primary">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>

                <h2 class="text-xs uppercase text-gray-500 font-semibold mb-3">Navigation</h2>
                <nav class="space-y-1">
                    <a href="/dashboardAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                        Tableau de Bord
                    </a>
                    <a href="/prospectsAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-users mr-2 text-gray-500"></i>
                        Prospects
                    </a>
                    <a href="/suivisAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        Suivis
                    </a>
                    <a href="/notificationsAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-bell mr-2 text-gray-500"></i>
                        Notifications
                        <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    <a href="/clientsAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-car mr-2   text-gray-500"></i>
                        Clients
                    </a>
                    <a href="/entretiensAdmin" class="flex items-center py-2 px-3 rounded-md bg-nucleus-light text-nucleus-primary font-medium">
                        <i class="fas fa-wrench mr-2 text-nucleus-primary"></i>
                        Entretiens
                        <span class="ml-auto bg-yellow-100 text-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">8</span>
                    </a>
                    <a href="#" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle mr-2 text-gray-500"></i>
                        Réclamations
                        <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="#" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2 text-gray-500"></i>
                        Statistiques
                    </a>
                    <a href="#" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-file-export mr-2 text-gray-500"></i>
                        Exporter
                    </a>
                </nav>
            </div>

            <div class="mt-auto p-4 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-nucleus-primary text-white flex items-center justify-center font-semibold">DG</div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Accès complet</p>
                    </div>
                    <div class="ml-auto flex space-x-2">
                        <a href="{{route('profile.edit')}}">
                        <button class="text-gray-500 hover:text-nucleus-primary transition-colors">
                            <i class="fas fa-cog"></i>
                        </button>
                        </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-gray-500 hover:text-nucleus-primary transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Entretiens</h1>
                        <p class="text-sm text-gray-500">Gérez les entretiens et réparations des véhicules</p>
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
                            <div class="w-12 h-12 rounded-lg bg-primary-100 flex items-center justify-center">
                                <i class="fas fa-tools text-xl text-primary-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 5%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Total Entretiens</h3>
                        <p class="text-3xl font-bold text-primary-600">248</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-clock text-xl text-yellow-600"></i>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">↑ 12%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">En attente</h3>
                        <p class="text-3xl font-bold text-yellow-600">8</p>
                        <p class="text-sm text-gray-500 mt-1">À traiter</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check-circle text-xl text-green-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 8%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Terminés</h3>
                        <p class="text-3xl font-bold text-green-600">42</p>
                        <p class="text-sm text-gray-500 mt-1">Cette semaine</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-calendar-check text-xl text-purple-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 3%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Planifiés</h3>
                        <p class="text-3xl font-bold text-purple-600">15</p>
                        <p class="text-sm text-gray-500 mt-1">Prochains jours</p>
                    </div>
                </div>

                <!-- Filters and Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 space-y-4 md:space-y-0">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="relative w-full sm:w-64">
                            <input type="text" placeholder="Rechercher un entretien..."
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
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span>Période</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>
                                <!-- Dropdown menu would go here -->
                            </div>
                        </div>
                    </div>
                    <button class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <i class="fas fa-plus"></i>
                        <span>Nouvel Entretien</span>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600">
                            Tous
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Planifiés
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            En cours
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Terminés
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Annulés
                        </a>
                    </nav>
                </div>

                <!-- Maintenance Table -->
                <div class="bg-white rounded-xl shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Référence
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client & Véhicule
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
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
                                        <div class="text-sm font-medium text-gray-900">#ENT-2025-001</div>
                                        <div class="text-xs text-gray-500">Créé le 15/05/2025</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-type-revision">
                                            Révision
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        21 mai 2025 - 10:30
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-status-scheduled">
                                            Planifié
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
                                        <div class="text-sm font-medium text-gray-900">#ENT-2025-002</div>
                                        <div class="text-xs text-gray-500">Créé le 14/05/2025</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-type-repair">
                                            Réparation
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        20 mai 2025 - 14:00
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-status-in-progress">
                                            En cours
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
                                        <div class="text-sm font-medium text-gray-900">#ENT-2025-003</div>
                                        <div class="text-xs text-gray-500">Créé le 12/05/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">PT</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Pierre Thomas</div>
                                                <div class="text-sm text-gray-500">Citroën C4 - 2023</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-type-diagnostic">
                                            Diagnostic
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        18 mai 2025 - 09:15
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-status-completed">
                                            Terminé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-file-pdf"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#ENT-2025-004</div>
                                        <div class="text-xs text-gray-500">Créé le 10/05/2025</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">LM</div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">Lucie Martin</div>
                                                <div class="text-sm text-gray-500">BMW Série 3 - 2021</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-type-other">
                                            Pneus
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        15 mai 2025 - 11:00
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-status-cancelled">
                                            Annulé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-redo"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#ENT-2025-005</div>
                                        <div class="text-xs text-gray-500">Créé le 16/05/2025</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-type-revision">
                                            Révision
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        22 mai 2025 - 15:30
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full maintenance-status-scheduled">
                                            Planifié
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary-600 hover:text-primary-900"><i class="fas fa-check"></i></button>
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
                                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">5</span> sur <span class="font-medium">248</span> résultats
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
                                        49
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        50
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
</html>
