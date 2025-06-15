<div class="bg-white rounded-xl shadow-card overflow-hidden">
    @if (session()->has('message'))
        <div x-data x-init="setTimeout(() => {
            $el.remove();
            location.reload();
        }, 4000);" class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif


    <!-- Branch Filter -->
    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-card p-4">
                <label for="branch_filter" class="text-sm font-medium text-gray-700">Filtrer par succursale:</label>
                <select wire:model.live="selectedBranch" class="border rounded p-2">
                    <option value="all">Tous</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <div>

        @if ($selectedClient)

            <div>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-6 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="flex-1">
        <h2 class="text-3xl font-semibold text-gray-900 leading-tight">
            Factures de : <span class="text-blue-700 font-medium">{{ $selectedClient->full_name }}</span>
        </h2>
        <div class="mt-2 h-1 w-16 bg-blue-600 rounded-full"></div>
    </div>

    <button wire:click="showClientsList"
        class="flex items-center justify-center px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
        <i class="fas fa-arrow-left mr-2 text-gray-600"></i>
        Retour à la liste des clients
    </button>
</div>

                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($invoices as $invoice)
                        @php
                            $client = $invoice->client;
                            $car = $invoice->car; // Assuming invoice has a direct relationship to a car
                            $status = $car->post_sale_status;
                            $colors = [
                                'en_attente_livraison' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                'livre' => 'bg-green-100 text-green-800 border-green-300',
                                'sav_1ere_visite' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'relance' => 'bg-red-100 text-red-800 border-red-300',
                            ];
                            $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                        @endphp
                        @include('livewire.partials.invoice-card', ['invoice' => $invoice])


                    @empty
                        <div
                            class="col-span-1 lg:col-span-2 xl:col-span-3 text-center py-16 bg-white rounded-lg shadow-sm border">
                            <i class="fas fa-file-invoice text-5xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700">Aucune facture trouvée</h3>
                            <p class="text-gray-500 mt-2">Ce client n'a pas encore de facture enregistrée.</p>
                        </div>
                    @endforelse
                </div>

            </div>
            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        @else
            @include('livewire.partials.client-card', ['clients' => $clients])

        @endif

        @include('livewire.partials.modals.edit-client', ['clients' => $clients])

    </div>


</div>
<script src="js/delete-facture.js"></script>

