<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exporter - AutoCRM</title>

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
                    <a href="/manager" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                        Tableau de Bord
                    </a>
                    <a href="/prospectsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-users mr-2 text-gray-500"></i>
                        Prospects
                    </a>
                    <a href="/suivisDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        Suivis
                    </a>
                    <a href="/notificationsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-bell mr-2 text-gray-500"></i>
                        Notifications
                        <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    <a href="/clientsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-car mr-2   text-gray-500"></i>
                        Clients
                    </a>
                    <a href="/entretiensDirector" class="flex items-center py-2 px-3 rounded-md  hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-wrench mr-2 text-gray-500"></i>
                        Entretiens
                        <span class="ml-auto bg-yellow-100 text-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">8</span>
                    </a>
                    <a href="/reclamationsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle mr-2  text-gray-500"></i>
                        Réclamations
                        <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/statistiquesDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2  text-gray-500"></i>
                        Statistiques
                    </a>
                    <a href="/exporterDirector" class="flex items-center py-2 px-3 rounded-md bg-nucleus-light text-nucleus-primary font-medium ">
                        <i class="fas fa-file-export mr-2 text-nucleus-primary"></i>
                        Exporter
                    </a>
                    <a href="/register" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium  transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2 text-gray-500"></i>
                        Register
                    </a>
                    <a href="/users" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-users mr-2  text-gray-500"></i>
                        Users
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
                                <option value="prospects">Prospects</option>
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
                                    <input type="radio" name="format" value="csv" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                                    <span class="ml-2 text-gray-700">CSV</span>
                                </label>
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
</html>
