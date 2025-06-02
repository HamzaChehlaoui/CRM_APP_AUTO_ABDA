<div class="relative">
    <div class="space-y-4">
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-md">{{ session('message') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-md">{{ session('error') }}</div>
        @endif

        <!-- Branch Filter -->
        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="mb-6">
                <div class="bg-white rounded-xl shadow-card p-4">
                    <select wire:model.live="selectedBranch" class="border rounded p-2">
                        <option value="all">Tous</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <!-- Follow-up Cards -->
        <div class="bg-white rounded-xl shadow-card p-4">
            <div class="flex flex-col space-y-4">
                @foreach($suivis as $suivi)
                    <div class="flex p-4 border rounded-md bg-white shadow-sm">
                        <div class="mr-4">
                            <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium mr-2">
                                {{ strtoupper(substr($suivi->client->full_name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $suivi->client->full_name }}</h3>
                                    <div class="flex items-center mt-1 text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>{{ $suivi->date_suivi }}</span>
                                        <span class="px-2 py-0.5 rounded-full status-interested text-xs ml-2">{{ $suivi->status }}</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="editSuivi({{ $suivi->id }})" class="p-1 rounded-md text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="showDeleteModal({{ $suivi->id }}, '{{ addslashes($suivi->client->full_name) }}')" class="p-1 rounded-md text-gray-400 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3 bg-gray-50 p-3 rounded-md">
                                <p class="text-sm text-gray-600">{{ $suivi->note }}</p>
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex gap-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-1.5"></i>
                                        <div class="m-1">
                                            <p class="text-xs text-gray-500">{{ $suivi->client->phone }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-1.5"></i>
                                        <div class="m-1">
                                            <p class="text-xs text-gray-500">{{ $suivi->client->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p><strong>Branche:</strong> {{ $suivi->client->branch->name ?? 'indéfini' }}</p>
                                <div class="flex space-x-2">
                                    <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="window.open('tel:{{ $suivi->client->phone }}')">
                                        <i class="fas fa-phone mr-1.5"></i> Appeler
                                    </button>
                                    <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="window.open('mailto:{{ $suivi->client->email }}')">
                                        <i class="fas fa-envelope mr-1.5"></i> Email
                                    </button>
                                    <button wire:click="completeSuivi({{ $suivi->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                                        <i class="fas fa-check mr-1.5"></i> Terminé
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $suivis->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Suivi Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="backdrop-filter: blur(4px);" wire:ignore>
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all duration-300 scale-95" id="editModalContent">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-edit text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Modifier le suivi</h3>
                        <p class="text-sm text-gray-500">{{ $editClientName }}</p>
                    </div>
                </div>
                <button wire:click="cancelEdit" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div>
                    <label for="editDateSuivi" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2"></i>Date de suivi
                    </label>
                    <input type="date" wire:model="editDateSuivi" id="editDateSuivi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    @error('editDateSuivi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="editStatus" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-flag mr-2"></i>Statut
                    </label>
                    <select wire:model="editStatus" id="editStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="en_cours">En cours</option>
                        <option value="termine">Terminé</option>
                        <option value="annule">Annule</option>
                    </select>
                    @error('editStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="editNote" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sticky-note mr-2"></i>Note
                    </label>
                    <textarea wire:model="editNote" id="editNote" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none" placeholder="Ajoutez vos notes ici..."></textarea>
                    @error('editNote') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        <p class="text-sm text-blue-700">
                            Les modifications seront sauvegardées immédiatement après confirmation.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end space-x-3 p-6 bg-gray-50 rounded-b-2xl">
                <button wire:click="cancelEdit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Annuler
                </button>
                <button wire:click="updateSuivi" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>Sauvegarder
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95" id="modalContent">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Confirmer la suppression</h3>
                        <p class="text-sm text-gray-500">Cette action est irréversible</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700 leading-relaxed">
                    Êtes-vous sûr de vouloir supprimer le suivi pour
                    <span class="font-semibold text-gray-900" id="clientNameSpan"></span> ?
                </p>
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-info-circle text-red-500 mt-0.5"></i>
                        <p class="text-sm text-red-700">
                            Toutes les informations liées à ce suivi seront définitivement perdues.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end space-x-3 p-6 bg-gray-50 rounded-b-2xl">
                <button onclick="hideDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Annuler
                </button>
                <button onclick="confirmDelete()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>Supprimer
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript and CSS moved inside the root div -->
    <script src="js/sales_table.js"></script>

    <style>
        .status-interested {
            background-color: #e0f2fe;
            color: #0277bd;
        }

        /* Custom focus styles for form elements */
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Smooth transitions for modals */
        #editModal, #deleteModal {
            transition: all 0.3s ease;
        }

        #editModalContent, #modalContent {
            transition: transform 0.3s ease;
        }

        /* Custom scrollbar for textarea */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</div>
