<div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 shadow-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adresse
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CIN</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($clients as $client)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($client->full_name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $client->full_name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $client->email ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $client->phone ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">
                            {{ $client->address ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $client->cin ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                          <!-- Replace wire:click buttons with data attributes -->
<button data-action="show-invoices"
        data-client-id="{{ $client->id }}"
        class="text-blue-600 hover:text-blue-900"
        title="Voir les factures">
    <i class="fas fa-file-invoice text-base"></i>
</button>
@if (auth()->user()->role_id != 1)
<button data-action="edit-client"
        data-client-id="{{ $client->id }}"
        class="text-yellow-600 hover:text-yellow-900"
        title="Modifier le client">
    <i class="fas fa-edit text-base"></i>
</button>

<button data-delete-client
        data-client-id="{{ $client->id }}"
        data-client-name="{{ $client->full_name }}"
        class="text-red-600 hover:text-red-900">
    <i class="fas fa-trash"></i>
</button>

                                <!-- Professional Confirmation Modal -->
                                <div id="deleteModal"
                                    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 p-4">
                                    <div class="bg-white rounded-lg shadow-2xl w-full max-w-md mx-auto transform transition-all duration-300 scale-95 opacity-0"
                                        id="modalContent">

                                        <!-- Modal Header -->
                                        <div
                                            class="flex flex-col sm:flex-row items-center p-6 border-b border-gray-200 text-center sm:text-left">
                                            <div
                                                class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">Confirm Deletion</h3>
                                                <p class="text-sm text-gray-500">This action cannot be undone</p>
                                            </div>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="p-6">
                                            <p class="text-gray-700 mb-3">Are you sure you want to delete this client?
                                            </p>

                                            <div class="bg-gray-50 rounded-md p-3 mb-4">
                                                <p class="text-sm text-gray-600">
                                                    <span class="font-medium">Client:</span>
                                                    <span id="clientNameDisplay" class="text-gray-900"></span>
                                                </p>
                                            </div>

                                            <div class="bg-red-50 border-l-4 border-red-400 p-3">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-red-400" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-sm text-red-700 font-medium text-wrap">
                                                        Warning: This will permanently delete all client data and cannot
                                                        be recovered.
                                                    </p>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Footer -->
                                        <div
                                            class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex flex-col sm:flex-row justify-end gap-3">
                                           <button data-close-modal
        class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
    Cancel
</button>
                                            <!-- Confirm button -->
<button data-confirm-delete
        class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition">
    Delete Client
</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 bg-white text-center text-gray-500" colspan="6">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                    stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5V4H2v16h5m5 0v-6h2v6m-6 0v-4h2v4m6 0v-2h2v2" />
                                </svg>
                                <h2 class="text-xl font-semibold text-gray-700">Aucun client trouvé</h2>
                                <p class="text-sm text-gray-400">Ajoutez un nouveau client pour commencer à
                                    remplir la base de données.</p>

                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $clients->links() }}
    </div>

</div>
