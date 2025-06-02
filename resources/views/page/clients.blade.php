@extends('layouts.mastere')

@section('title', 'Clients - Tableau de Bord')

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
                        <h1 class="text-2xl font-bold text-gray-800">Clients</h1>
                        <p class="text-sm text-gray-500">Gérez votre portefeuille clients</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors">
                            <i class="fas fa-question-circle"></i>
                        </button>
                        <span class="h-6 border-l border-gray-300"></span>
                        <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                            <span class="font-medium text-sm">Aujourd'hui</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
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
                            <input type="text" placeholder="Rechercher un client..."
                                    class="w-full rounded-md border border-gray-200 py-2 pl-10 pr-4 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <button class="flex items-center space-x-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-filter text-gray-400"></i>
                                    <span>Filtres</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>
                                <!-- Dropdown menu would go here -->
                            </div>
                            <div class="relative">
                                <button class="flex items-center space-x-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-sort text-gray-400"></i>
                                    <span>Trier par</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>
                                <!-- Dropdown menu would go here -->
                            </div>
                        </div>
                    </div>
                    <button class="flex items-center justify-center space-x-2 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <i class="fas fa-plus"></i>
                        <span>Nouveau Client</span>
                    </button>
                </div>

                <!-- Clients Table -->
                <div class="bg-white rounded-xl shadow-card overflow-hidden">
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
            </div>
        </div>
    </div>
</body>
@endsection
</html>
