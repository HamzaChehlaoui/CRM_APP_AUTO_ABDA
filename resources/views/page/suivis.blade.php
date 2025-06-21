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
                        <a href="/notifications"> <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative" id="notificationBell">
                            <i class="fas fa-bell"></i>
                            @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
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
                    @if (session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                            class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md transition-opacity duration-500 ease-in-out">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Calendar Navigation -->
                    <div class="flex justify-between items-center mb-6">

                        @if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
                            <div class="flex space-x-2">
                                <button id="nouveauSuiviBtn"
                                    class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    <i class="fas fa-plus"></i>
                                    <span>Nouveau Suivi</span>
                                </button>
                            </div>
                        @endif
                    </div>


                    @livewire('sales-table')
                </div>
            </div>
        </div>

        <!-- Nouveau Suivi Modal -->
        <div id="nouveauSuiviModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Center the modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="nouveauSuiviForm" action="{{ route('suivis.store') }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                        <i class="fas fa-plus mr-2 text-primary-600"></i>
                                        Nouveau Suivi
                                    </h3>

                                    <div class="space-y-4">
                                        <!-- Client Selection -->
                                        <!-- Client Information -->
                                        <div class="mb-8">
                                            <div class="flex items-center mb-6">
                                                <div
                                                    class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-blue-600"></i>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900">Sélection Client</h3>
                                            </div>
                                            <div class="bg-blue-50 rounded-lg p-6">
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-gray-700">Client *</label>
                                                    <select name="client_id" id="client_id" required
                                                        class="select-client w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                                        <option value="">Sélectionner un client</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}">{{ $client->full_name }} ,
                                                                {{ $client->cin }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Follow-up Date -->
                                        <div>
                                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                                                Date de Suivi <span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" id="date" name="date_suivi" required
                                                min="{{ date('Y-m-d') }}"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        </div>


                                        <!-- Status -->
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                                Statut
                                            </label>
                                            <select id="status" name="status"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                <option value="en_cours" selected>En Cours</option>
                                                <option value="termine">Terminé</option>
                                                <option value="annule">Annulé</option>
                                            </select>
                                        </div>

                                        <!-- Notes -->
                                        <div>
                                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                                                Notes <span class="text-red-500">*</span>
                                            </label>
                                            <textarea id="note" name="note" rows="4" required placeholder="Ajouter des notes sur ce suivi..."
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"></textarea>
                                        </div>

                                        <!-- Hidden fields -->
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="fas fa-save mr-2"></i>
                                Créer le Suivi
                            </button>
                            <button type="button" id="cancelModalBtn"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            // Modal Functions
            function openNouveauSuiviModal() {
                console.log('Opening modal...');
                document.getElementById('nouveauSuiviModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Set default date to current date
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const formattedDate = `${year}-${month}-${day}`;
                document.getElementById('date').value = formattedDate;
            }

            function closeNouveauSuiviModal() {
                console.log('Closing modal...');
                document.getElementById('nouveauSuiviModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
                document.getElementById('nouveauSuiviForm').reset();
            }

            // Event Listeners
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM Content Loaded');

                // Nouveau Suivi Button
                const nouveauSuiviButton = document.getElementById('nouveauSuiviBtn');
                if (nouveauSuiviButton) {
                    console.log('Nouveau Suivi button found');
                    nouveauSuiviButton.addEventListener('click', function(e) {
                        console.log('Nouveau Suivi button clicked');
                        e.preventDefault();
                        openNouveauSuiviModal();
                    });
                } else {
                    console.log('Nouveau Suivi button not found');
                }

                // Cancel Modal Button
                const cancelBtn = document.getElementById('cancelModalBtn');
                if (cancelBtn) {
                    cancelBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        closeNouveauSuiviModal();
                    });
                }

                // Close modal when clicking outside
                const modal = document.getElementById('nouveauSuiviModal');
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            closeNouveauSuiviModal();
                        }
                    });
                }

                // Close modal with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        const modal = document.getElementById('nouveauSuiviModal');
                        if (modal && !modal.classList.contains('hidden')) {
                            closeNouveauSuiviModal();
                        }
                    }
                });

                // Form submission handling
                const form = document.getElementById('nouveauSuiviForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        console.log('Form submitted');
                        // Add any form validation here if needed
                    });
                }

                // Edit buttons
                const editButtons = document.querySelectorAll('.edit-suivi-btn');
                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const suiviId = this.getAttribute('data-suivi-id');
                        console.log('Edit suivi:', suiviId);
                        // Add edit functionality here
                    });
                });


            });

            // Branch filter script (if needed)
            const branchFilter = document.getElementById('branch_filter');
            if (branchFilter) {
                branchFilter.addEventListener('change', function() {
                    const loadingIndicator = document.getElementById('loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.classList.remove('hidden');
                    }
                });
            }
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
    <script src="{{ asset('js/suivis.js') }}" defer></script>
@endsection

