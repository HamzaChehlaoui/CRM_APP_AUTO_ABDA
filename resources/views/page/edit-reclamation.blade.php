<!-- Fixed Edit Complaint Modal -->
<div id="editComplaintModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Modifier la Réclamation</h3>
                <button id="closeEditModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="editComplaintForm" class="mt-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="editComplaintId" name="complaint_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Reference -->
                    <div>
                        <label for="editReference" class="block text-sm font-medium text-gray-700 mb-2">
                            Référence
                        </label>
                        <input type="text" id="editReference" name="reference"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500"
                            readonly>
                    </div>

                    <!-- Client -->
                    <div>
                        <label for="editClient" class="block text-sm font-medium text-gray-700 mb-2">
                            Client
                        </label>
                        <select id="editClient" name="client_id"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <option value="">Sélectionner un client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="editDescription" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea id="editDescription" name="description" rows="4" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500"
                            placeholder="Décrivez la réclamation en détail..."></textarea>
                    </div>

                    <!-- Priorité -->
                    <div>
                        <label for="editPriorite" class="block text-sm font-medium text-gray-700 mb-2">
                            Priorité <span class="text-red-500">*</span>
                        </label>
                        <select id="editPriorite" name="Priorite" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">

                            <option value="">Sélectionner une priorité</option>
                            <option value="Basse" @selected(old('Priorite', $reclamation->Priorite ?? '') == 'Basse')>Basse</option>
                            <option value="Moyenne" @selected(old('Priorite', $reclamation->Priorite ?? '') == 'Moyenne')>Moyenne</option>
                            <option value="Haute" @selected(old('Priorite', $reclamation->Priorite ?? '') == 'Haute')>Haute</option>
                        </select>
                    </div>


                    <!-- Status -->
                    <div>
                        <label for="editStatus" class="block text-sm font-medium text-gray-700 mb-2">
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <select id="editStatus" name="status" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <option value="">Sélectionner un statut</option>
                            <option value="nouvelle">Nouvelle</option>
                            <option value="en_cours">En cours</option>
                            <option value="résolue">Résolue</option>
                        </select>
                    </div>


                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200 mt-6 space-x-3">
                    <button type="button" id="cancelEditBtn"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" id="saveEditBtn"
                        class="px-6 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editComplaintModal');
        const editForm = document.getElementById('editComplaintForm');
        const closeEditModal = document.getElementById('closeEditModal');
        const cancelEditBtn = document.getElementById('cancelEditBtn');

        // Open modal when edit button is clicked
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-complaint-btn')) {
                e.preventDefault();

                const button = e.target.closest('.edit-complaint-btn');

                // Get data from button attributes
                const complaintId = button.getAttribute('data-complaint-id');
                const reference = button.getAttribute('data-reference');
                const clientId = button.getAttribute('data-client-id');
                const clientName = button.getAttribute('data-client-name');
                const description = button.getAttribute('data-description');
                const priorite = button.getAttribute('data-priorite');
                const status = button.getAttribute('data-status');


                // Fill the form
                document.getElementById('editComplaintId').value = complaintId;
                document.getElementById('editReference').value = reference;
                document.getElementById('editClient').value = clientId;
                document.getElementById('editDescription').value = description;
                document.getElementById('editPriorite').value = priorite;
                document.getElementById('editStatus').value = status;


                // Show modal
                editModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });

        // Close modal functions
        function closeModal() {
            editModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            editForm.reset();
        }

        closeEditModal.addEventListener('click', closeModal);
        cancelEditBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) {
                closeModal();
            }
        });

        // Handle form submission
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(editForm);
            const complaintId = document.getElementById('editComplaintId').value;

            // Show loading state
            const saveBtn = document.getElementById('saveEditBtn');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement...';
            saveBtn.disabled = true;

            // Send AJAX request
            fetch(`/reclamations/${complaintId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showNotification('Réclamation mise à jour avec succès!', 'success');

                        // Close modal
                        closeModal();

                        // Refresh the page to show updated data
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        throw new Error(data.message || 'Erreur lors de la mise à jour');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Erreur lors de la mise à jour de la réclamation', 'error');
                })
                .finally(() => {
                    // Reset button
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
        });

        // Notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-md shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    });
</script>
