<div class="rounded-lg border border-gray-200 overflow-x-auto">
    @if(auth()->user()->role_id==1||auth()->user()->role_id==2)
    <div class="mb-4 flex flex-wrap gap-2">
    <button
        wire:click="$set('selectedBranch', 'all')"
        class="px-4 py-2 rounded-lg text-white
               {{ $selectedBranch === 'all' ? 'bg-blue-600' : 'bg-gray-400' }}">
            Toutes
    </button>

    @foreach($branches as $branch)
        <button
            wire:click="$set('selectedBranch', '{{ $branch->id }}')"
            class="px-4 py-2 rounded-lg text-white
                   {{ $selectedBranch == $branch->id ? 'bg-blue-600' : 'bg-gray-400' }}">
            {{ $branch->name }}
        </button>
    @endforeach
</div>
@endif

                    <table class="w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr class="text-left text-sm font-semibold text-gray-700">
                                        <th class="px-6 py-4 border-b border-gray-200">Client</th>
                                        <th class="px-6 py-4 border-b border-gray-200">Véhicule</th>
                                        <th class="px-6 py-4 border-b border-gray-200">Date de vente</th>
                                        <th class="px-6 py-4 border-b border-gray-200">Statut du paiement</th>
                                        <th class="px-6 py-4 border-b border-gray-200">Durée de la garantie</th>
                                        <th class="px-6 py-4 border-b border-gray-200">Dernier entretien</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach ($sales as $sale)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center">
                                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <span class="text-blue-700 font-bold text-sm">
                                                                {{ strtoupper(substr($sale->client->full_name, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                        <div class="ml-4">
                                                            <p class="text-sm font-semibold text-gray-900">{{ $sale->client->full_name }}</p>
                                                            <p class="text-sm text-gray-500">{{ $sale->client->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-5">
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">{{ $sale->car->brand }} {{ $sale->car->model }}</p>
                                                        <p class="text-sm text-gray-500">{{ $sale->car->year }} • {{ $sale->car->color }}</p>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-5">
                                                    <p class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($sale->sale_date)->translatedFormat('d F Y') }}</p>
                                                </td>

                                                <td class="px-6 py-5">
                                                    @if ($sale->total_amount > 0)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Paiement complet
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            En attente
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-6 py-5">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-700">2 ans</p>
                                                        <p class="text-xs text-gray-500">Jusqu’au
                                                        {{ \Carbon\Carbon::parse($sale->sale_date)->addYears(2)->translatedFormat('d F Y') }}
                                                        </p>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-5">
                                                    <p class="text-sm font-medium text-gray-700">
                                                    {{ \Carbon\Carbon::parse($sale->sale_date)->addMonths(10)->translatedFormat('d F Y') }}
                                                    </p>
                                                </td>

                                                <td class="px-6 py-5">
                                                    <div class="flex justify-center space-x-2">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>

                            </table>
                            <div class="mt-4">
                                {{ $sales->links() }}
                            </div>
                        </div>
