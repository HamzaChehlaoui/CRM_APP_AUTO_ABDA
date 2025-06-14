<!-- resources/views/dashboard.blade.php -->
@extends('layouts.mastere')

@section('title', 'Dashboard - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-nucleus-gray">

    <div class="flex h-screen w-screen overflow-hidden">

        <!-- Sidebar -->
    <x-sidebar />
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            @if(Auth::user()->role_id == 1)
                                Tableau de Bord - Directeur Général
                            @elseif(Auth::user()->role_id ==2)
                                Tableau de Bord - Assistant Directeur
                            @elseif(Auth::user()->role_id == 3)
                                Tableau de Bord - Employé de Magasin Safi
                            @elseif(Auth::user()->role_id==4)
                                Tableau de Bord - Employé de Carrosserie Safi
                            @elseif(Auth::user()->role_id==5)
                                Tableau de Bord - Employé de Atelier Safi
                            @elseif(Auth::user()->role_id == 6)
                                Tableau de Bord - Employé de Essaouira
                            @elseif(Auth::user()->role_id == 7)
                                Tableau de Bord - Employé de Sidi Bennour
                            @else
                                Tableau de Bord
                            @endif
                        </h1>
                        <p class="text-sm text-gray-500">
                            Vue d'ensemble de votre CRM automobile
                        </p>
                </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <span class="h-6 border-l border-gray-300"></span>
                        <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                            <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                            <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
                        </button>


                    </div>
                </div>
            </header>


            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Summary Stats -->
                <!-- Branch Filter (Only for Admin and Assistant) -->
@if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
<div class="mb-6">
    <div class="bg-white rounded-xl shadow-card p-4">
        <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-4">
            <label for="branch_filter" class="text-sm font-medium text-gray-700">Filtrer par succursale:</label>
            <select name="branch_filter" id="branch_filter"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-nucleus-primary focus:border-transparent bg-white min-w-[200px]"
                    onchange="this.form.submit()">
                <option value="all" {{ $selectedBranch == 'all' ? 'selected' : '' }}>
                    Toutes les succursales
                </option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $selectedBranch == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>

            <!-- Loading indicator -->
            <div id="loading-indicator" class="hidden">
                <svg class="animate-spin h-5 w-5 text-nucleus-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('branch_filter').addEventListener('change', function() {
    document.getElementById('loading-indicator').classList.remove('hidden');
});
</script>
@endif

<!-- Summary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-user-plus text-xl text-nucleus-primary"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageClients, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageClients }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Total des clients</h3>
        <p class="text-3xl font-bold text-nucleus-primary">{{ $totalClientsCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Cette semaine</p>
    </div>

    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-phone-alt text-xl text-yellow-600"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageSuivis, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageSuivis }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Suivis en Cours</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $suivisEnCoursCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Nécessitent une action</p>
    </div>

    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <i class="fas fa-users text-xl text-green-600"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageActive, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageActive }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Clients Actifs</h3>
        <p class="text-3xl font-bold text-green-600">{{ $activeClientsCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Total des clients</p>
    </div>

    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <i class="fas fa-car text-xl text-purple-600"></i>
            </div>
            @php
                $isPositive = str_starts_with($percentageSales, '+');
                $colorBg = $isPositive ? 'bg-green-100' : 'bg-red-100';
                $colorText = $isPositive ? 'text-green-700' : 'text-red-700';
            @endphp
            <span class="{{ $colorBg }} {{ $colorText }} text-xs px-2 py-1 rounded-full font-medium">{{ $percentageSales }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Ventes</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $salesThisMonthCurrent }}</p>
        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
    </div>
</div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Charts / Graphs -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Suivi des Clients</h3>
                            <div class="flex space-x-2">
                                <div class="flex space-x-2">
                                    <button onclick="changePeriod('week')" class="period-btn px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Semaine</button>
                                    <button onclick="changePeriod('month')" class="period-btn px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Mois</button>
                                    <button onclick="changePeriod('year')" class="period-btn px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Année</button>
                                </div>
                            </div>
                        </div>
                        <div class="h-64 relative">
                            <canvas id="prospectsChart"></canvas>
                        </div>
                    </div>

                    <!-- Summary by Post-Sale Status -->
                    <div class="bg-white rounded-xl shadow-card p-6">

                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Phase Post-Vente</h3>

                        <div class="h-64 relative" wire:init="initChart">
                            <canvas  id="statusChart"></canvas>
                        
                        </div>
                    </div>


                        <!-- Clients -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-3">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">Clients</h3>
                                {{-- <p class="text-sm text-gray-600">Gestion et suivi de la clientèle</p> --}}
                            </div>
                            <a href="/clients" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                Voir tout
                            </a>
                        </div>



            <div class="bg-white rounded-xl shadow-card overflow-hidden">

                    <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 shadow-sm rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cin</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($clients as $client)
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

                                    <!-- Contact -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $client->email ?? '—' }}</div>
                                    </td>

                                    <!-- Véhicule -->
                                    <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-500">{{$client->phone}}</div>

                                    </td>

                                    <!-- Dernière visite -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="text-sm text-gray-500">{{$client->address}}</div>
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{$client->cin}}</div>
                                    </td>


                                </tr>
                                @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-16 bg-white text-center text-gray-500" colspan="6">
                                                <div class="flex flex-col items-center justify-center space-y-3">
                                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m5 0v-6h2v6m-6 0v-4h2v4m6 0v-2h2v2" />
                                                    </svg>
                                                    <h2 class="text-xl font-semibold text-gray-700">Aucun client trouvé</h2>
                                                    <p class="text-sm text-gray-400">Ajoutez un nouveau client pour commencer à remplir la base de données.</p>

                                                </div>
                                            </td>
                                        </tr>
                            @endforelse
                        </tbody>
                    </table>



                    </div>

                </div>



                    </div>


                </div>
            </div>
        </div>
    </div>

 <script>
    window.chartData = {
        selectedBranch: "{{ $selectedBranch ?? (auth()->user()->branch_id ?? 'all') }}",
        labels: @json($labels),
        clientsVendus: @json($clientsVendus)
    };

</script>

<script src="js/dashboard.js"></script>
@endsection
