@extends('layouts.mastere')

@section('title', 'Clients - Tableau de Bord')

@section('content')

    <body class="h-full w-full font-sans bg-gray-50">
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        <div class="flex h-screen w-screen overflow-hidden">

            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Clients</h1>
                            <p class="text-sm text-gray-500">Gérez votre portefeuille clients</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="/notifications"> <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative" id="notificationBell">
                            <i class="fas fa-bell"></i>
                            @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 h-5 w-5 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-xs text-white font-bold">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            </span>
                            @endif
                        </button>
                        </a>

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

                    <!-- Filters and Actions -->
                    @if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
                        <button id="openModalBtn"
                            class="flex items-center justify-center space-x-2 rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 mb-6">
                            <i class="fas fa-plus w-4 h-4"></i>
                            <span>Nouveau Client</span>
                        </button>
                    @endif

                    <div class="bg-white rounded-xl shadow-card overflow-hidden">

                    </div>
                    @if (session('error'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500 ease-in-out"
                            role="alert">
                            <strong class="font-bold">Erreur !</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500 ease-in-out"
                            role="alert">
                            <strong class="font-bold">Succès !</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    <!-- Clients Table -->
                    <div class="bg-white rounded-xl shadow-card overflow-hidden">
                        @livewire('clients-table')
                    </div>

                </div>
            </div>
        </div>

        <!-- Professional Modal -->
        <div id="clientModal"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden relative">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold">Nouveau Client</h2>
                            <p class="text-primary-100 mt-1">Ajoutez un client</p>
                        </div>
                        <button id="closeModalBtn"
                            class="text-white hover:text-primary-100 transition-colors duration-200 p-2 hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="overflow-y-auto max-h-[calc(90vh-140px)]">
                    <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                        @csrf

                        <!-- Progress Indicator -->
                        <div class="flex items-center justify-center mb-8">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Client</span>
                                </div>

                            </div>
                        </div>

                        <!-- Client Information -->
                        <div class="mb-8">
                            <div class="flex items-center mb-6">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-primary-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Informations Client</h3>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Nom complet *</label>
                                        <input type="text" name="client[full_name]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Téléphone *</label>
                                        <input type="text" name="client[phone]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Carte d'identité *</label>
                                        <input type="text" name="client[cin]" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="client[email]"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                                        <input type="text" name="client[address]"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                    <input type="hidden" name="client[branch_id]" value="{{ auth()->user()->branch_id }}">
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Les champs marqués d'un * sont obligatoires
                            </p>
                            <div class="flex space-x-4">
                                <button type="button" id="cancelModalBtn"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                    Annuler
                                </button>
                                <button type="submit" form="clientForm"
                                    class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-save mr-2"></i>
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script src="js/client.js"></script>
        @include('page.button-loading')
    </body>
@endsection
