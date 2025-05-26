@extends('layouts.mastere')

@section('title', 'Suivis - Tableau de Bord')

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
@endsection
</html>
