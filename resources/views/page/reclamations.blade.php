@extends('layouts.mastere')

@section('title', 'Reclamation - Tableau de Bord')

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
                            <h1 class="text-2xl font-bold text-gray-800">Réclamations</h1>
                            <p class="text-sm text-gray-500">Gérez les réclamations clients</p>
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
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 space-y-4 md:space-y-0">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="relative w-full sm:w-64">
                                <input type="text" placeholder="Rechercher une réclamation..."
                                    class="w-full rounded-md border border-gray-200 py-2 pl-10 pr-4 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>

                            </div>
                            <div class="flex space-x-2">
                                <div class="relative">
                                    <button
                                        class="flex items-center space-x-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-filter text-gray-400"></i>
                                        <span>Filtres</span>
                                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                    </button>
                                    <!-- Dropdown menu would go here -->
                                </div>

                            </div>
                        </div>
                        <button id="openComplaintModalBtn"
                            class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <i class="fas fa-plus"></i>
                            <span>Nouvelle Réclamation</span>
                        </button>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="#"
                                class="whitespace-nowrap py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600">
                                Toutes
                            </a>
                            <a href="#"
                                class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Nouvelles
                            </a>
                            <a href="#"
                                class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                En cours
                            </a>
                            <a href="#"
                                class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Résolues
                            </a>
                            <a href="#"
                                class="whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Fermées
                            </a>
                        </nav>
                    </div>

                    <!-- Complaints Table -->
                    <div class="bg-white rounded-xl shadow-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Référence
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Client
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sujet
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Priorité
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($reclamations as $reclamation)
                                        <tr class="hover:bg-gray-50">

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reclamation->reference ?? '#' . $reclamation->id }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Créé le {{ $reclamation->created_at->format('d/m/Y') }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($reclamation->client)
                                                    <div class="flex items-center">

                                                        <div class="ml-3">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $reclamation->client->full_name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-500">Client non défini</span>
                                                @endif
                                            </td>


                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $reclamation->sujet }}</div>
                                                <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $reclamation->description }}">
                                                    {{ $reclamation->description }}
                                                </div>
                                            </td>


                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $priorityClass = '';
                                                    if ($reclamation->priorite == 'Haute') $priorityClass = 'complaint-priority-high';
                                                    elseif ($reclamation->priorite == 'Moyenne') $priorityClass = 'complaint-priority-medium';
                                                    else $priorityClass = 'complaint-priority-low';
                                                @endphp
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityClass }}">
                                                    {{ $reclamation->Priorite }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $reclamation->updated_at->format('d M Y') }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = '';
                                                    if ($reclamation->status == 'Nouvelle') $statusClass = 'complaint-status-new';
                                                    elseif ($reclamation->status == 'En cours') $statusClass = 'complaint-status-progress';
                                                    elseif ($reclamation->status == 'Résolue') $statusClass = 'complaint-status-resolved';
                                                    else $statusClass = 'complaint-status-closed';
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ $reclamation->status }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                                <a href="{{ route('reclamations.edit', $reclamation->id) }}" class="text-primary-600 hover:text-primary-900 mr-2" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>


                                                <form action="{{ route('reclamations.destroy', $reclamation->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réclamation ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    

                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                                Aucune réclamation trouvée.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
</table>
</div>

<div class="mt-4 flex justify-center">
    {{ $reclamations->links('vendor.pagination.tailwind') }}
</div>
</div>
                </div>
            </div>
        </div>

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
            <div class="mb-6">
                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Client <span class="text-red-500">*</span>
                </label>
                <select id="client_id" name="client_id" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                    <option value="">Sélectionner un client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option>
                    @endforeach
                </select>
                <div id="client_id_error" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description du problème <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required
                          placeholder="Décrivez le problème en détail..."
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

            <!-- Assigned User (Optional) -->
            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Assigner à
                </label>
                <select id="user_id" name="user_id"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                    <option value="">Non assigné</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
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
    // --- 1. تعريف العناصر الأساسية ---
    const modal = document.getElementById('complaintModal');
    const openModalBtn = document.getElementById('openComplaintModalBtn'); // استهداف الزر مباشرة عبر الـ ID الجديد
    const closeModalBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('complaintForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoader = document.getElementById('submitLoader');

    // --- 2. وظائف فتح وإغلاق النافذة ---

    // وظيفة فتح النافذة
    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // منع تمرير الصفحة في الخلفية
    }

    // وظيفة إغلاق النافذة وإعادة تعيين الحقول
    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // السماح بالتمرير مرة أخرى
        form.reset(); // مسح بيانات النموذج
        clearErrors(); // إزالة رسائل الأخطاء
    }

    // --- 3. ربط الأحداث بالأزرار ---

    // فتح النافذة عند الضغط على زر "Nouvelle Réclamation"
    if (openModalBtn) {
        openModalBtn.addEventListener('click', function(e) {
            e.preventDefault(); // منع السلوك الافتراضي للزر
            openModal();
        });
    }

    // إغلاق النافذة عند الضغط على زر الإغلاق (X) أو زر الإلغاء
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // إغلاق النافذة عند الضغط خارجها
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // إغلاق النافذة عند الضغط على مفتاح "Escape"
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // --- 4. معالجة إرسال النموذج (Form Submission) ---
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // منع الإرسال التقليدي للصفحة

        // عرض مؤشر التحميل
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoader.classList.remove('hidden');

        clearErrors();

        const formData = new FormData(form);

        // إرسال البيانات باستخدام Fetch API
        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '' // مهم في Laravel
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Réclamation créée avec succès!', 'success');
                    closeModal();
                    // تحديث الصفحة لإظهار السجل الجديد
                    setTimeout(() => window.location.reload(), 1500);
                } else if (data.errors) {
                    showValidationErrors(data.errors);
                    showNotification('Veuillez corriger les erreurs dans le formulaire.', 'error');
                } else {
                    showNotification(data.message || 'Une erreur est survenue.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Une erreur de communication est survenue.', 'error');
            })
            .finally(() => {
                // إعادة الزر إلى حالته الطبيعية
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                submitLoader.classList.add('hidden');
            });
    });

    // --- 5. وظائف مساعدة (Helper Functions) ---

    // وظيفة لمسح رسائل الأخطاء من الحقول
    function clearErrors() {
        document.querySelectorAll('[id$="_error"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }

    // وظيفة لإظهار أخطاء التحقق من الصحة
    function showValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(field + '_error');
            const inputElement = document.getElementById(field) || form.querySelector(`[name="${field}"]`);

            if (inputElement) {
                inputElement.classList.add('border-red-500');
            }
            if (errorElement) {
                errorElement.textContent = errors[field][0];
                errorElement.classList.remove('hidden');
            }
        });
    }

    // وظيفة لإظهار إشعار منبثق
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        let bgColor = 'bg-blue-500';
        if (type === 'success') bgColor = 'bg-green-500';
        if (type === 'error') bgColor = 'bg-red-500';

        notification.className = `fixed top-5 right-5 px-6 py-4 rounded-md shadow-lg text-white z-50 transition-transform transform translate-x-full ${bgColor}`;
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
</script>
                @include('page.button-loading')
    </body>
@endsection

</html>
