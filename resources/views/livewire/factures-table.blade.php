<div>




    @include('livewire.partials.filters')

    <div class="bg-white rounded-xl shadow-card overflow-hidden">

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($invoices as $invoice)
                @php
                    $client = $invoice->client;
                    $car = $invoice->car; // Assuming invoice has a direct relationship to a car
                    $status = $invoice->statut_facture ;
                    $colors = [
                        'envoyée_pour_paiement' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'paiement' => 'bg-green-100 text-green-800 border-green-300',
                        'facturé' => 'bg-blue-100 text-blue-800 border-blue-300',
                        'creation' => 'bg-red-100 text-red-800 border-red-300',
                    ];
                    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                @endphp
                @include('livewire.partials.invoice-card', ['invoice' => $invoice])

            @empty
                @include('livewire.partials.no-results')
            @endforelse

        </div>
        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    </div>

</div>
