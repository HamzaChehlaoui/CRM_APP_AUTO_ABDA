
<div class="bg-white rounded-xl shadow-card overflow-hidden">
    
    <!-- Branch Filter -->
        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="mb-6">
                <div class="bg-white rounded-xl shadow-card p-4">
                    <label for="branch_filter" class="text-sm font-medium text-gray-700">Filtrer par succursale:</label>
                    <select wire:model.live="selectedBranch" class="border rounded p-2">
                        <option value="all">Tous</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
                    <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 shadow-sm rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Véhicule</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dernière visite</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($clients as $client)
                                <tr class="hover:bg-gray-50">
                                    <!-- Client -->
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($client->full_name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $client->full_name }}</div>
                                            <div class="text-sm text-gray-500">CIN: {{ $client->cin }}</div>
                                        </div>
                                    </td>

                                    <!-- Contact -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $client->email ?? '—' }}</div>
                                        <div class="text-sm text-gray-500">{{ $client->phone }}</div>
                                    </td>

                                    <!-- Véhicule -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($client->cars->isNotEmpty())
                                            @php $car = $client->cars->first(); @endphp
                                            <div class="text-sm text-gray-900">{{ $car->brand }} {{ $car->model }}</div>
                                            <div class="text-sm text-gray-500">{{ $car->year }} - {{ ucfirst($car->energy_type) }}</div>
                                        @else
                                            <div class="text-sm text-gray-500">—</div>
                                        @endif
                                    </td>

                                    <!-- Dernière visite -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $client->updated_at->format('d M Y') }}
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'en_attente_livraison' => 'bg-yellow-100 text-yellow-800',
                                                'livre' => 'bg-green-100 text-green-800',
                                                'sav_1ere_visite' => 'bg-blue-100 text-blue-800',
                                                'relance' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$client->post_sale_status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $client->post_sale_status)) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="#" class="text-blue-600 hover:text-blue-900" title="Voir"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="text-yellow-600 hover:text-yellow-900" title="Modifier"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900" title="Véhicules"><i class="fas fa-car"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $clients->links() }}
                    </div>

                    </div>

                </div>
