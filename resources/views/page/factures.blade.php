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
                            <h1 class="text-2xl font-bold text-gray-800">Factures</h1>
                            <p class="text-sm text-gray-500">Gérez votre portefeuille factures</p>
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

                    <!-- Filters and Actions -->
                    @if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
                        <button id="openModalBtn"
                            class="flex items-center justify-center space-x-2 rounded-lg bg-primary-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 mb-6">
                            <i class="fas fa-plus w-4 h-4"></i>
                            <span>Nouveau Factures</span>
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
                    
                    @livewire('factures-table')

                </div>
            </div>
        </div>

            @include('page.add-facture')

        <script src="js/client.js"></script>
        <script>
            new TomSelect('.select-client', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Rechercher un client..."
            });
        </script>
        @include('page.button-loading')

    </body>
@endsection
