<div>
    @if($invoice->statut_facture != 'paiement' && auth()->user()->role_id != 1)
    <button onclick="deleteInvoice({{ $invoice->id }})"
    class="inline-flex items-center justify-center w-9 h-9 text-red-600 hover:text-white hover:bg-red-600 transition-all duration-200 rounded-lg border border-red-200 hover:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
    <i class="fas fa-trash-alt text-sm"></i>
</button>

<!-- Notification -->
<div id="notification" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300 -translate-y-full">
    <div id="notificationContent" class="flex items-center justify-between px-6 py-4 min-w-96 rounded-lg shadow-lg border backdrop-blur-sm">
        <div class="flex items-center space-x-3">
            <i id="notificationIcon" class="fas text-lg"></i>
            <span id="notificationMessage" class="font-medium text-sm"></span>
        </div>
        <button onclick="closeNotification()" class="ml-4 p-1 hover:bg-black hover:bg-opacity-10 rounded transition-colors duration-150">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>
</div>

<!-- Modal -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-8">
            <!-- Icon and Header -->
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Confirmer la suppression</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Cette action est <span class="font-semibold text-gray-900">irréversible</span>.
                    Veuillez confirmer votre mot de passe pour continuer.
                </p>
            </div>

            <!-- Password Input -->
            <div class="mb-6">
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                    Mot de passe
                </label>
                <div class="relative">
                    <input type="password" id="confirmPassword"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        placeholder="Entrez votre mot de passe" />
                </div>
                <p id="passwordError" class="mt-2 text-sm text-red-600 hidden flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Mot de passe requis pour la suppression
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button onclick="closeModal()"
                    class="flex-1 bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-3 rounded-lg font-medium text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Annuler
                </button>
                <button onclick="confirmDelete()"
                    class="flex-1 bg-red-600 text-white hover:bg-red-700 px-4 py-3 rounded-lg font-medium text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

@endif

</div>
