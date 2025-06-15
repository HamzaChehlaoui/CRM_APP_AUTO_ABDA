
@if ($dateErrorMessage)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
        {{ $dateErrorMessage }}
    </div>
@endif
<!-- Branch Filter -->
        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="w-full lg:w-1/3 m-4">

                <label for="branch_filter" class="block text-sm font-semibold text-slate-700 mb-2">Filtrer par
                    succursale:</label>
                <div class="relative">
                    <select wire:model.live="selectedBranch"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                        <option value="all">Tous</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
    <div class="flex flex-col lg:flex-row gap-6 p-4 ">
        <!-- Search Input -->
        <div class="w-full lg:max-w-sm">
            <label for="search" class="block text-sm font-semibold text-slate-700 mb-2">
                Rechercher
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 text-sm" wire:loading.remove wire:target="search"></i>
                    <i class="fas fa-spinner text-gray-400 text-sm animate-spin" wire:loading wire:target="search"></i>
                </div>
                <input type="text" id="search" wire:model.live.debounce.500ms="search"
                    placeholder="Rechercher une facture, client, montant..."
                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm placeholder-gray-500 shadow-sm">
            </div>

        </div>

        <!-- Invoice Status Filter -->
        <div class="w-full lg:w-1/3">
            <label for="status_facture_filter" class="block text-sm font-semibold text-slate-700 mb-2">
                Statut Facture ( Totale : {{ $filteredInvoiceCount }} )
            </label>
            <div class="relative">
                <select wire:model.live="statusFacture" id="status_facture_filter"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    <option value="all">Tous les statuts</option>
                    <option value="paiement">Paiement</option>
                    <option value="envoyée_pour_paiement">Envoyée pour paiement</option>
                    <option value="facturé">Facturé</option>
                    <option value="creation">Création</option>
                </select>

            </div>
        </div>

        <!-- After Sale Status Filter -->
        <div class="w-full lg:w-1/3">
            <label for="status_apres_vente_filter" class="block text-sm font-semibold text-slate-700 mb-2">
                Statut Après-Vente ( Totale : {{ $filteredInvoiceCount }} )
            </label>
            <div class="relative">
                <select wire:model.live="statusApresVente" id="status_apres_vente_filter"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    <option value="all">Tous les statuts</option>
                    <option value="en_attente_livraison">En attente de livraison</option>
                    <option value="livre">Livré</option>
                    <option value="sav_1ere_visite">SAV 1ère visite</option>
                    <option value="relance">Relance</option>
                </select>

            </div>
        </div>

            <div class="flex flex-col sm:flex-row gap-4 mb-4">
    <div class="flex flex-col">
        <label for="dateFrom" class="block text-sm font-semibold text-slate-700 mb-2">De :</label>
        <input type="date" wire:model.live="dateFrom" id="dateFrom" class="border px-3 py-2 rounded-md" />
    </div>

    <div class="flex flex-col">
        <label for="dateTo" class="block text-sm font-semibold text-slate-700 mb-2">À :</label>
        <input type="date" wire:model.live="dateTo" id="dateTo" class="border px-3 py-2 rounded-md" />
    </div>
</div>


    </div>
