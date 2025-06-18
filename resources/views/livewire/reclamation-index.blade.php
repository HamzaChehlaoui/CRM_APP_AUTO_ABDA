<div class="flex-1 p-6 overflow-y-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 space-y-4 md:space-y-0">
        <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
            <div class="w-full sm:w-64">
                <label for="rechercher" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search text-gray-400 mr-1"></i>
                    Rechercher
                </label>

                <div class="relative">
                    <input type="text" id="rechercher" placeholder="Rechercher une réclamation..."
                        wire:model.live.debounce.300ms="searchTerm"
                        class="w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <!-- icons serch-->
                        <i class="fas fa-search text-gray-400" wire:loading.remove wire:target="searchTerm"></i>

                        <!-- icons loading-->
                        <i class="fas fa-spinner fa-spin text-gray-400" wire:loading wire:target="searchTerm"></i>
                    </div>
                </div>
            </div>





            @php
                $canFilterByBranch = auth()->user()->role_id == 1 || auth()->user()->role_id == 2;
            @endphp

            @if ($canFilterByBranch)
                <div class="mb-4 w-full sm:w-72">
                    <label for="branchFilter" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-code-branch text-gray-400 mr-1"></i>
                        Filtrer par branche
                    </label>
                    <div class="relative">
                        <select wire:model.live="branchFilter" id="branchFilter"
                            class="block w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-2 pr-10 text-sm text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="all">Toutes les branches</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            @endif


        </div>
        @if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
            <button id="openComplaintModalBtn"
                class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <i class="fas fa-plus"></i>
                <span>Nouvelle Réclamation</span>
            </button>
        @endif
    </div>

    <div class="flex items-center flex-wrap gap-3 mb-6">
        @php
            $filters = [
                '' => ['label' => 'Tout', 'color' => 'gray', 'icon' => 'fa-list'],
                'nouvelle' => ['label' => 'Nouvelle', 'color' => 'blue', 'icon' => 'fa-star'],
                'en_cours' => ['label' => 'En cours', 'color' => 'yellow', 'icon' => 'fa-spinner'],
                'résolue' => ['label' => 'Résolue', 'color' => 'green', 'icon' => 'fa-check-circle'],
            ];
        @endphp

        @foreach ($filters as $key => $filter)
            @php
                $isActive = $statusFilter === $key;

                $baseClass =
                    'inline-flex items-center px-4 py-2 rounded-full text-sm font-medium shadow-sm transition-all duration-150 border';
                $bgClass = $isActive
                    ? "bg-{$filter['color']}-600 text-white border-transparent"
                    : "bg-white text-{$filter['color']}-600 border border-{$filter['color']}-300 hover:bg-{$filter['color']}-50";

                $iconClass = "fas {$filter['icon']} mr-2";
                if ($key === 'en_cours') {
                    $iconClass .= ' animate-spin-slow';
                }
            @endphp

            <button wire:click="$set('statusFilter', '{{ $key }}')"
                class="{{ $baseClass }} {{ $bgClass }}">
                <i class="{{ $iconClass }}"></i>
                {{ $filter['label'] }}
            </button>
        @endforeach
    </div>





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
                    @if(auth()->user()->role_id != 1)

                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
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
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500">Client non défini</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $reclamation->sujet }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs"
                                    title="{{ $reclamation->description }}">
                                    {{ $reclamation->description }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $priorityClass = '';
                                    if ($reclamation->priorite == 'Haute') {
                                        $priorityClass = 'complaint-priority-high';
                                    } elseif ($reclamation->priorite == 'Moyenne') {
                                        $priorityClass = 'complaint-priority-medium';
                                    } else {
                                        $priorityClass = 'complaint-priority-low';
                                    }
                                @endphp
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityClass }}">
                                    {{ $reclamation->Priorite }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $reclamation->updated_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = '';
                                    if ($reclamation->status == 'Nouvelle') {
                                        $statusClass = 'complaint-status-new';
                                    } elseif ($reclamation->status == 'En cours') {
                                        $statusClass = 'complaint-status-progress';
                                    } elseif ($reclamation->status == 'Résolue') {
                                        $statusClass = 'complaint-status-resolved';
                                    } else {
                                        $statusClass = 'complaint-status-closed';
                                    }
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $reclamation->status }}
                                </span>
                            </td>
                            @if(auth()->user()->role_id != 1)
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#"
                                    class="text-primary-600 hover:text-primary-900 mr-2 edit-complaint-btn"
                                    title="Modifier" data-complaint-id="{{ $reclamation->id }}"
                                    data-reference="{{ $reclamation->reference ?? '#' . $reclamation->id }}"
                                    data-client-id="{{ $reclamation->client->id ?? '' }}"
                                    data-description="{{ $reclamation->description }}"
                                    data-priorite="{{ $reclamation->Priorite }}"
                                    data-status="{{ $reclamation->status }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="delete-form-{{ $reclamation->id }}"
                                    action="{{ route('reclamations.destroy', $reclamation->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="showDeleteModal({{ $reclamation->id }}, '{{ addslashes($reclamation->client->full_name ?? 'Client inconnu') }}')"
                                        class="text-red-600 hover:text-red-800" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center space-y-2">
                                    <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                    <p class="text-lg font-semibold">Aucune réclamation trouvée</p>
                                    <p class="text-sm text-gray-400">Essayez de changer le filtre ou ajoutez une
                                        nouvelle réclamation.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-center">
            {{ $reclamations->links() }}
        </div>
        @include('page.edit-reclamation', ['reclamation' => $reclamations->first() ?? null])


    </div>

    <div id="deleteModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden items-center justify-center transition-opacity duration-300"
        style="z-index: 9999;">
        <div id="modalContent"
            class="relative mx-auto p-5 border w-11/12 md:w-1/3 shadow-lg rounded-md bg-white transform transition-transform duration-300 scale-95">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 fa-lg"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Supprimer la réclamation</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir supprimer la réclamation du client <strong id="clientNameSpan"
                            class="font-bold"></strong> ? Cette action est irréversible.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDeleteBtn" onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Confirmer la suppression
                    </button>
                    <button id="cancelDeleteBtn" onclick="hideDeleteModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-auto ml-2 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentReclamationId = null;

        function showDeleteModal(reclamationID, clientName) {
            currentReclamationId = reclamationID;
            document.getElementById('clientNameSpan').textContent = clientName;
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function hideDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                currentReclamationId = null;
            }, 200);
        }

        function confirmDelete() {
            if (currentReclamationId) {
                const form = document.getElementById('delete-form-' + currentReclamationId);
                if (form) {
                    form.submit();
                } else {
                    console.error('Le formulaire de suppression est introuvable pour l\'ID:', currentReclamationId);
                }
                hideDeleteModal();
            }
        }
    </script>
</div>
