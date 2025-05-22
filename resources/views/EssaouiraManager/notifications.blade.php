<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - AutoCRM</title>

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
                    <a href="/notificationsAdmin" class="flex items-center py-2 px-3 rounded-md bg-nucleus-light text-nucleus-primary font-medium ">
                        <i class="fas fa-bell mr-2 text-nucleus-primary"></i>
                        Notifications
                        <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    <a href="/clientsAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-car mr-2 text-gray-500"></i>
                        Clients
                    </a>
                    <a href="/entretiensAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-wrench mr-2 text-gray-500"></i>
                        Entretiens
                        <span class="ml-auto bg-yellow-100 text-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">8</span>
                    </a>
                    <a href="/reclamationsAdmin" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle mr-2 text-gray-500"></i>
                        Réclamations
                        <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/statistiquesAdim" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2 text-gray-500"></i>
                        Statistiques
                    </a>
                    <a href="/exporterAdim" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
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
                        <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                        <p class="text-sm text-gray-500">Restez informé des activités importantes</p>
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
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
                    <h2 class="text-lg font-semibold">Notifications (3 non lues)</h2>
                    <div class="flex flex-wrap gap-2">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-check-circle mr-2"></i>
                            Tout marquer comme lu
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-filter mr-2"></i>
                            Filtrer
                        </button>
                    </div>
                </div>

                <!-- Filter options -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200">
                    <div class="flex flex-wrap gap-3">
                        <button class="inline-flex items-center px-3 py-1.5 bg-primary-50 text-primary-600 text-sm font-medium rounded-md">
                            <i class="fas fa-check-circle mr-1.5"></i>
                            Tous
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-user-plus mr-1.5 text-primary-500"></i>
                            Prospects
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-clock mr-1.5 text-purple-500"></i>
                            Rappels
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-exclamation-circle mr-1.5 text-red-500"></i>
                            Alertes
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-calendar-check mr-1.5 text-yellow-500"></i>
                            Événements
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-file-signature mr-1.5 text-green-500"></i>
                            Documents
                        </button>
                    </div>
                </div>

                <!-- Unread Notifications -->
                <div class="mb-8">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Non lues</h3>
                    <div class="space-y-4">
                        <!-- Notification 1 -->
                        <div class="bg-primary-50 rounded-xl shadow-sm p-4 border border-primary-100">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-prospect flex items-center justify-center">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-900">Nouveau prospect</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Il y a 1 heure</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Martin Leclerc a demandé des informations sur la Renault Clio</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                                            Marquer comme lu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 2 -->
                        <div class="bg-primary-50 rounded-xl shadow-sm p-4 border border-primary-100">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-reminder flex items-center justify-center">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-900">Rappel de suivi</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Il y a 2 heures</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Appel à effectuer avec Sophie Dubois aujourd'hui à 10:30</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                                            Marquer comme lu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 3 -->
                        <div class="bg-primary-50 rounded-xl shadow-sm p-4 border border-primary-100">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-alert flex items-center justify-center">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-900">Réclamation client</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Hier à 16:45</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Nouvelle réclamation de M. Petit concernant son véhicule</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                                            Marquer comme lu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Read Notifications -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Lues récemment</h3>
                    <div class="space-y-4">
                        <!-- Notification 4 -->
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-event flex items-center justify-center opacity-70">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-700">Essai routier</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Aujourd'hui à 07:30</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Essai routier avec M. Bernard prévu aujourd'hui à 14:00</p>
                                    <div class="mt-3">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 5 -->
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-document flex items-center justify-center opacity-70">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-700">Document à signer</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Hier à 15:20</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Contrat de vente pour la famille Richard prêt à être signé</p>
                                    <div class="mt-3">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 6 -->
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-service flex items-center justify-center opacity-70">
                                        <i class="fas fa-wrench"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-700">Entretien programmé</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Il y a 2 jours</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Entretien des 30 000 km pour le véhicule de Mme Moreau</p>
                                    <div class="mt-3">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification 7 -->
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-3 sm:mb-0 sm:mr-4">
                                    <div class="h-12 w-12 rounded-full notification-prospect flex items-center justify-center opacity-70">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                        <h4 class="font-medium text-gray-700">Nouveau prospect</h4>
                                        <span class="text-xs text-gray-500 mt-1 sm:mt-0">Il y a 3 jours</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Jean Dupont a demandé des informations sur la Peugeot 3008</p>
                                    <div class="mt-3">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-eye mr-1.5"></i>
                                            Voir le détail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-1.5 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1.5 border border-primary-500 bg-primary-50 rounded-md text-sm text-primary-600 font-medium">1</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-50">2</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-50">3</button>
                        <span class="px-2 text-gray-500">...</span>
                        <button class="px-3 py-1.5 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-50">8</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
