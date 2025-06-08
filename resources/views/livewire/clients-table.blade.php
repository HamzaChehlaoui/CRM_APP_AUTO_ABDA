<div class="bg-white rounded-xl shadow-card overflow-hidden">
     @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
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
                            </div>
                        </td>
                        <!-- Email -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $client->email ?? '—' }}</div>
                        </td>
                        <!-- Phone -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $client->phone }}</div>
                        </td>
                        <!-- Address -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">{{ $client->address }}</div>
                        </td>
                        <!-- CIN -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $client->cin }}</div>
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-900" title="Voir"><i class="fas fa-file-invoice mr-2"></i></a>
                            <a href="" wire:click.prevent="editClient({{ $client->id }})" class="text-yellow-600 hover:text-yellow-900" title="Modifier"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $clients->links() }}
        </div>
    </div>

    <!-- Edit Client Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Client</h2>
                <form wire:submit.prevent="updateClient">
                    <div class="space-y-4">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" wire:model="clientData.full_name" id="full_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('clientData.full_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="clientData.email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('clientData.email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" wire:model="clientData.phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('clientData.phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" wire:model="clientData.address" id="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('clientData.address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="cin" class="block text-sm font-medium text-gray-700">CIN</label>
                            <input type="text" wire:model="clientData.cin" id="cin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('clientData.cin') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="cancelEdit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
