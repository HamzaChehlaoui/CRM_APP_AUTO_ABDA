<!DOCTYPE html>
<html lang="fr" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivis - AutoCRM</title>

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
                        <i class="fas fa-users mr-2  text-gray-500"></i>
                        Prospects
                    </a>
                    <a href="/suivisDirector" class="flex items-center py-2 px-3 rounded-md bg-nucleus-light text-nucleus-primary font-medium ">
                        <i class="fas fa-calendar-alt mr-2  text-nucleus-primary"></i>
                        Suivis
                    </a>
                    <a href="/notificationsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-bell mr-2 text-gray-500"></i>
                        Notifications
                        <span class="ml-auto bg-red-100 text-red-500 text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
                    </a>
                    <a href="/clientsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-car mr-2 text-gray-500"></i>
                        Clients
                    </a>
                    <a href="/entretiensDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-wrench mr-2 text-gray-500"></i>
                        Entretiens
                        <span class="ml-auto bg-yellow-100 text-yellow-500 text-xs font-semibold px-2 py-0.5 rounded-full">8</span>
                    </a>
                    <a href="/reclamationsDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle mr-2 text-gray-500"></i>
                        Réclamations
                        <span class="ml-auto bg-orange-100 text-orange-500 text-xs font-semibold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/statistiquesDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2 text-gray-500"></i>
                        Statistiques
                    </a>
                    <a href="/exporterDirector" class="flex items-center py-2 px-3 rounded-md hover:bg-nucleus-light hover:text-nucleus-primary font-medium transition-colors duration-200">
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
                        <h1 class="text-2xl font-bold text-gray-800">Suivis</h1>
                        <p class="text-sm text-gray-500">Gérez les suivis de vos prospects</p>
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
                <!-- Calendar Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h2 class="text-xl font-semibold">21 Mai 2025</h2>
                        <button class="p-2 rounded-md border border-gray-200 bg-white text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <button class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <i class="fas fa-plus"></i>
                            <span>Nouveau Suivi</span>
                        </button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600">
                            Tous
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Appels
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Emails
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Rendez-vous
                        </a>
                        <a href="#" class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Essais
                        </a>
                    </nav>
                </div>

                <!-- Follow-ups List -->
                <div class="space-y-4">
                    <!-- Follow-up Card 1 -->
                    <div class="bg-white rounded-xl shadow-card p-4">
                        <div class="flex">
                            <div class="mr-4">
                                <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Appel avec Sophie Dubois</h3>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <span>10:30</span>
                                            <span class="mx-2">•</span>
                                            <span class="px-2 py-0.5 rounded-full follow-type-call text-xs">Appel</span>
                                            <span class="mx-2">•</span>
                                            <span class="px-2 py-0.5 rounded-full status-interested text-xs">Intéressé</span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-3 bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-600">Appeler pour discuter des options disponibles pour la Peugeot 3008. Client intéressé par la finition GT.</p>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium mr-2">SD</div>
                                        <div>
                                            <p class="text-sm font-medium">Sophie Dubois</p>
                                            <p class="text-xs text-gray-500">06 23 45 67 89</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-phone mr-1.5"></i>
                                            Appeler
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-envelope mr-1.5"></i>
                                            Email
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-check mr-1.5"></i>
                                            Terminé
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Follow-up Card 2 -->
                    <div class="bg-white rounded-xl shadow-card p-4">
                        <div class="flex">
                            <div class="mr-4">
                                <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fas fa-car"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Essai routier avec Nicolas Bernard</h3>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <span>14:00</span>
                                            <span class="mx-2">•</span>
                                            <span class="px-2 py-0.5 rounded-full follow-type-test text-xs">Essai</span>
                                            <span class="mx-2">•</span>
                                            <span class="px-2 py-0.5 rounded-full status-interested text-xs">Intéressé</span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-3 bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-600">Essai du Renault Captur Hybride. Client intéressé par les performances et la consommation.</p>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium mr-2">NB</div>
                                        <div>
                                            <p class="text-sm font-medium">Nicolas Bernard</p>
                                            <p class="text-xs text-gray-500">06 78 90 12 34</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-phone mr-1.5"></i>
                                            Appeler
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-envelope mr-1.5"></i>
                                            Email
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-check mr-1.5"></i>
                                            Terminé
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Follow-up Card 3 -->
                    <div class="bg-white rounded-xl shadow-card p-4">
                        <div class="flex">
                            <div class="mr-4">
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-handshake"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Finalisation contrat Famille Richard</h3>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <span>16:30</span>
                                            <span class="mx-2">•</span>
                                            <span class="px-2 py-0.5 rounded-full follow-type-meeting text-xs">Rendez-vous</span>
                                            <span class="mx-2">•</span>
                                            <span class="px-2 py-0.5 rounded-full status-interested text-xs">Intéressé</span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-3 bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-600">Rendez-vous pour finaliser le contrat d'achat du Peugeot 5008. Préparer les documents de financement et d'assurance.</p>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium mr-2">ER</div>
                                        <div>
                                            <p class="text-sm font-medium">Émilie Richard</p>
                                            <p class="text-xs text-gray-500">06 89 01 23 45</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-phone mr-1.5"></i>
                                            Appeler
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-envelope mr-1.5"></i>
                                            Email
                                        </button>
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-check mr-1.5"></i>
                                            Terminé
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
