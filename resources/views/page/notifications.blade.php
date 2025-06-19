@extends('layouts.mastere')

@section('title', 'Notification - Tableau de Bord')

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
                            <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                            <p class="text-sm text-gray-500">Restez informé des activités importantes</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                                <i class="fas fa-bell"></i>
                                <span
                                    class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>

                            <span class="h-6 border-l border-gray-300"></span>
                            <button
                                class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                                <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                                <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
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
                            <button
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-check-circle mr-2"></i>
                                Tout marquer comme lu
                            </button>
                            <button
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-filter mr-2"></i>
                                Filtrer
                            </button>
                        </div>
                    </div>

                    <!-- Filter options -->
                    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200">
                        <div class="flex flex-wrap gap-3">
                            <button
                                class="inline-flex items-center px-3 py-1.5 bg-primary-50 text-primary-600 text-sm font-medium rounded-md">
                                <i class="fas fa-check-circle mr-1.5"></i>
                                Tous
                            </button>
                        
                            <button
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-clock mr-1.5 text-purple-500"></i>
                                Rappels
                            </button>
                            <button
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-exclamation-circle mr-1.5 text-red-500"></i>
                                Alertes
                            </button>
                            <button
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-calendar-check mr-1.5 text-yellow-500"></i>
                                Événements
                            </button>
                            <button
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
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
                                        <div
                                            class="h-12 w-12 rounded-full notification-prospect flex items-center justify-center">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                            <h4 class="font-medium text-gray-900">Nouveau client</h4>
                                            <span class="text-xs text-gray-500 mt-1 sm:mt-0">Il y a 1 heure</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">description</p>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                <i class="fas fa-eye mr-1.5"></i>
                                                Voir le détail
                                            </button>
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                                                Marquer comme lu
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
                @include('page.button-loading')

    </body>
@endsection

</html>
