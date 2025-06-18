<!-- Modal Overlay -->
<div id="complaintModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Nouvelle Réclamation</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="complaintForm" action="{{ route('reclamations.store') }}" method="POST" class="mt-6">
            @csrf
            <!-- Client Selection -->
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

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description du problème <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required placeholder="Décrivez le problème en détail..."
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 resize-vertical"></textarea>
                <div id="description_error" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            <!-- Priority -->
            <div class="mb-6">
                <label for="priorite" class="block text-sm font-medium text-gray-700 mb-2">
                    Priorité <span class="text-red-500">*</span>
                </label>
                <select id="priorite" name="Priorite" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                    <option value="Basse">Basse</option>
                    <option value="Moyenne" selected>Moyenne</option>
                    <option value="Haute">Haute</option>
                </select>
                <div id="priorite_error" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            <!-- Assigned User (Only current user) -->
            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Assigner à
                </label>
                <select id="user_id" name="user_id"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                    <option value="{{ auth()->id() }}" selected>{{ auth()->user()->name }}</option>
                </select>
            </div>


            <!-- Modal Footer -->
            <div class="flex items-center justify-end pt-4 border-t border-gray-200 space-x-4">
                <button type="button" id="cancelBtn"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                    Annuler
                </button>
                <button type="submit" id="submitBtn"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                    <span id="submitText">Créer la réclamation</span>
                    <span id="submitLoader" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Création...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('complaintModal');
        const openModalBtn = document.getElementById('openComplaintModalBtn');
        const closeModalBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.getElementById('complaintForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitLoader = document.getElementById('submitLoader');


        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            form.reset();
            clearErrors();
        }


        if (openModalBtn) {
            openModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        }

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoader.classList.remove('hidden');

            clearErrors();

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document
                            .querySelector('meta[name="csrf-token"]').getAttribute('content') :
                            '' // مهم في Laravel
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Réclamation créée avec succès!', 'success');
                        closeModal();
                        setTimeout(() => window.location.reload(), 1500);
                    } else if (data.errors) {
                        showValidationErrors(data.errors);
                        showNotification('Veuillez corriger les erreurs dans le formulaire.',
                            'error');
                    } else {
                        showNotification(data.message || 'Une erreur est survenue.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Une erreur de communication est survenue.', 'error');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoader.classList.add('hidden');
                });
        });


        function clearErrors() {
            document.querySelectorAll('[id$="_error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            form.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
        }

        function showValidationErrors(errors) {
            Object.keys(errors).forEach(field => {
                const errorElement = document.getElementById(field + '_error');
                const inputElement = document.getElementById(field) || form.querySelector(
                    `[name="${field}"]`);

                if (inputElement) {
                    inputElement.classList.add('border-red-500');
                }
                if (errorElement) {
                    errorElement.textContent = errors[field][0];
                    errorElement.classList.remove('hidden');
                }
            });
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            let bgColor = 'bg-blue-500';
            if (type === 'success') bgColor = 'bg-green-500';
            if (type === 'error') bgColor = 'bg-red-500';

            notification.className =
                `fixed top-5 right-5 px-6 py-4 rounded-md shadow-lg text-white z-50 transition-transform transform translate-x-full ${bgColor}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Animate out and remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }
         });
         new TomSelect('.select-client', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Rechercher un client..."
            });

</script>
