<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - AutoCRM</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    <a href="/managerSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                        Tableau de Bord
                    </a>
                    <a href="/prospectsSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-users mr-2 text-gray-500"></i>
                        Prospects
                    </a>
                    <a href="/suivisSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        Suivis
                    </a>
                    <a href="/notificationsSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-bell mr-2 text-gray-500"></i>
                        Notifications
                        <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    <a href="/clientsSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-car mr-2   text-gray-500"></i>
                        Clients
                    </a>
                    <a href="/entretiensSidiBennour" class="flex items-center py-2 px-3 rounded-md  hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-wrench mr-2 text-gray-500"></i>
                        Entretiens
                        <span class="ml-auto bg-yellow-100 text-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">8</span>
                    </a>
                    <a href="/reclamationsSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle mr-2  text-gray-500"></i>
                        Réclamations
                        <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/statistiquesSidiBennour" class="flex items-center py-2 px-3 rounded-md bg-nucleus-light text-nucleus-primary font-medium ">
                        <i class="fas fa-chart-bar mr-2  text-nucleus-primary"></i>
                        Statistiques
                    </a>
                    <a href="/exporterSidiBennour" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
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
                        <h1 class="text-2xl font-bold text-gray-800">Statistiques</h1>
                        <p class="text-sm text-gray-500">Analysez les performances de votre concession</p>
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
                        <div class="flex items-center space-x-2">
                            <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                                <span class="font-medium text-sm">Mai 2025</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Date Range and Export -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text" value="01/05/2025" class="w-32 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <span class="text-gray-500">à</span>
                        <div class="relative">
                            <input type="text" value="31/05/2025" class="w-32 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Actualiser
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-file-export mr-2"></i>
                            Exporter
                        </button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex -mb-px space-x-8">
                        <a href="#" class="py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600 whitespace-nowrap">
                            Vue d'ensemble
                        </a>
                        <a href="#" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            Prospects
                        </a>
                        <a href="#" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            Ventes
                        </a>
                        <a href="#" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            Entretiens
                        </a>
                        <a href="#" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            Satisfaction client
                        </a>
                    </nav>
                </div>

                <!-- Summary Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user-plus text-xl text-primary-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 12%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Nouveaux Prospects</h3>
                        <p class="text-3xl font-bold text-primary-600">53</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-car text-xl text-purple-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 15%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Ventes</h3>
                        <p class="text-3xl font-bold text-purple-600">42</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-wrench text-xl text-yellow-600"></i>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">↑ 5%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Entretiens</h3>
                        <p class="text-3xl font-bold text-yellow-600">87</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-smile text-xl text-green-600"></i>
                            </div>
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">↓ 2%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Satisfaction</h3>
                        <p class="text-3xl font-bold text-green-600">92%</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Chart -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Évolution des Prospects et Ventes</h3>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm bg-primary-50 text-primary-600 rounded-md hover:bg-primary-600 hover:text-white transition-colors">Mois</button>
                                <button class="px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-gray-100 transition-colors">Trimestre</button>
                                <button class="px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-gray-100 transition-colors">Année</button>
                            </div>
                        </div>
                        <div class="h-80 relative">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <!-- Conversion Rate -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Taux de Conversion</h3>
                        <div class="h-80 relative">
                            <canvas id="conversionChart"></canvas>
                        </div>
                    </div>

                    <!-- Sales by Model -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Ventes par Modèle</h3>
                            <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">Voir tout</button>
                        </div>
                        <div class="h-80 relative">
                            <canvas id="salesByModelChart"></canvas>
                        </div>
                    </div>

                    <!-- Customer Satisfaction -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Satisfaction Client</h3>
                        <div class="h-80 relative">
                            <canvas id="satisfactionChart"></canvas>
                        </div>
                    </div>

                    <!-- Top Performers -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-1 lg:col-span-3">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Meilleures Performances</h3>
                            <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">Voir tout</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-200">
                                        <th class="pb-3 pl-1">Conseiller</th>
                                        <th class="pb-3">Prospects</th>
                                        <th class="pb-3">Ventes</th>
                                        <th class="pb-3">Taux de conversion</th>
                                        <th class="pb-3">Satisfaction</th>
                                        <th class="pb-3 text-right">Performance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">JD</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Julie Dubois</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">32</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">18</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">56%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full bg-green-500 rounded-full" style="width: 95%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">95%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Excellente
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">TM</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Thomas Martin</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">28</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">14</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">50%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full bg-green-500 rounded-full" style="width: 90%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">90%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Excellente
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">SL</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Sophie Leroy</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">24</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">10</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">42%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full bg-yellow-500 rounded-full" style="width: 85%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">85%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Bonne
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Main Chart - Prospects and Sales Evolution
        const mainCtx = document.getElementById('mainChart').getContext('2d');
        const mainChart = new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [
                    {
                        label: 'Prospects',
                        data: [42, 38, 45, 50, 53, 48, 40, 42, 45, 48, 52, 55],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0ea5e9',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Ventes',
                        data: [28, 25, 30, 35, 42, 38, 32, 30, 35, 40, 45, 48],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.05)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#8b5cf6',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#262626',
                        bodyColor: '#525252',
                        bodyFont: {
                            size: 12
                        },
                        borderColor: '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5,
                        usePointStyle: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#737373'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#737373'
                        }
                    }
                }
            }
        });

        // Conversion Rate Chart
        const conversionCtx = document.getElementById('conversionChart').getContext('2d');
        const conversionChart = new Chart(conversionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Convertis', 'En cours', 'Non convertis'],
                datasets: [{
                    data: [42, 28, 30],
                    backgroundColor: [
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#262626',
                        bodyColor: '#525252',
                        bodyFont: {
                            size: 12
                        },
                        borderColor: '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.formattedValue || '';
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                }
            }
        });

        // Sales by Model Chart
        const salesByModelCtx = document.getElementById('salesByModelChart').getContext('2d');
        const salesByModelChart = new Chart(salesByModelCtx, {
            type: 'bar',
            data: {
                labels: ['Renault Clio', 'Peugeot 3008', 'Citroën C4', 'Renault Captur', 'Peugeot 208', 'Dacia Sandero'],
                datasets: [{
                    label: 'Ventes',
                    data: [12, 9, 8, 7, 6, 5],
                    backgroundColor: [
                        'rgba(14, 165, 233, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(20, 184, 166, 0.8)'
                    ],
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#262626',
                        bodyColor: '#525252',
                        bodyFont: {
                            size: 12
                        },
                        borderColor: '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#737373'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#737373'
                        }
                    }
                }
            }
        });

        // Customer Satisfaction Chart
        const satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        const satisfactionChart = new Chart(satisfactionCtx, {
            type: 'radar',
            data: {
                labels: ['Accueil', 'Conseil', 'Prix', 'Service', 'Suivi'],
                datasets: [{
                    label: 'Satisfaction',
                    data: [95, 90, 85, 92, 88],
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    borderColor: '#0ea5e9',
                    pointBackgroundColor: '#0ea5e9',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#0ea5e9'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        suggestedMin: 50,
                        suggestedMax: 100,
                        ticks: {
                            backdropColor: 'transparent',
                            color: '#737373',
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        pointLabels: {
                            font: {
                                size: 11
                            },
                            color: '#525252'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#262626',
                        bodyColor: '#525252',
                        bodyFont: {
                            size: 12
                        },
                        borderColor: '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5
                    }
                }
            }
        });
    </script>
</body>
</html>
