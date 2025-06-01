<div class="space-y-4">
    <!-- Branch Filter -->
    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-card p-4">
                <select wire:model.live="selectedBranch" class="border rounded p-2">
                    <option value="all">Tous</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
<p class="text-xs text-gray-500">Selected Branch : {{ $selectedBranch }}</p>

    <!-- Follow-up Cards -->
    <div class="bg-white rounded-xl shadow-card p-4">
        <div class="flex flex-col space-y-4">
            @foreach($suivis as $suivi)
                <div class="flex p-4 border rounded-md bg-white shadow-sm">
                    <div class="mr-4">
                        <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium mr-2">
                            {{ strtoupper(substr($suivi->client->full_name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $suivi->client->full_name }}</h3>
                                <div class="flex items-center mt-1 text-sm text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>{{ $suivi->date_suivi }}</span>
                                    <span class="px-2 py-0.5 rounded-full status-interested text-xs ml-2">{{ $suivi->status }}</span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-1 rounded-md text-gray-400 hover:text-gray-500 edit-suivi-btn" data-suivi-id="{{ $suivi->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-1 rounded-md text-gray-400 hover:text-gray-500 delete-suivi-btn" data-suivi-id="{{ $suivi->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 bg-gray-50 p-3 rounded-md">
                            <p class="text-sm text-gray-600">{{ $suivi->note }}</p>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex gap-2">
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-1.5"></i>
                                    <div class="m-1">
                                        <p class="text-xs text-gray-500">{{ $suivi->client->phone }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope mr-1.5"></i>
                                    <div class="m-1">
                                        <p class="text-xs text-gray-500">{{ $suivi->client->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <p><strong>Branche:</strong> {{ $suivi->client->branch->name ?? 'indéfini' }}</p>
                            <div class="flex space-x-2">
                                <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="window.open('tel:{{ $suivi->client->phone }}')">
                                    <i class="fas fa-phone mr-1.5"></i> Appeler
                                </button>
                                <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="window.open('mailto:{{ $suivi->client->email }}')">
                                    <i class="fas fa-envelope mr-1.5"></i> Email
                                </button>
                                <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 complete-suivi-btn" data-suivi-id="{{ $suivi->id }}">
                                    <i class="fas fa-check mr-1.5"></i> Terminé
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $suivis->links() }}
            </div>
        </div>
    </div>
</div>
