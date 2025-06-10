@extends('layouts.mastere')

@section('title', 'Statistique - Tableau de Bord')

@section('content')
<body class="h-full w-full font-sans bg-gray-50">

    <div class="flex h-screen w-screen overflow-hidden">

        <x-sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Statistiques</h1>
                        <p class="text-sm text-gray-500">Analysez les performances de votre concession</p>
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
                <!-- Date Range Filter -->
                <form method="GET" action="{{ route('statistics.index') }}" class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-40 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                        </div>
                        <span class="text-gray-500">à</span>
                        <div class="relative">
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-40 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                        </div>
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Actualiser
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </button>
                        <a href="{{ route('statistics.export') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-file-export mr-2"></i>
                            Exporter
                        </a>
                    </div>
                </form>

                <!-- Key Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Nouveaux Clients</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalClients }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-car text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Ventes Totales</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalSales }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-euro-sign text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Chiffre d'Affaires</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalRevenue, 0, ',', ' ') }} dh</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-tasks text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Suivis Actifs</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $activeSuivis }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Sales by Model Chart -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Ventes par Modèle</h3>
                            <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">Voir tout</button>
                        </div>
                        <div class="h-80 relative">
                            @if($salesByModel->count() > 0)
                                <canvas id="salesByModelChart"></canvas>
                            @else
                                <div class="flex items-center justify-center h-full text-gray-500">
                                    <div class="text-center">
                                        <i class="fas fa-chart-bar text-4xl mb-4"></i>
                                        <p>Aucune donnée de vente disponible</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Satisfaction Chart -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Satisfaction Client</h3>
                        <div class="h-80 relative">
                            <canvas id="satisfactionChart"></canvas>
                        </div>
                    </div>

                    <!-- Top Performers Table -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-1 lg:col-span-3">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Meilleures Performances</h3>
                            <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">Voir tout</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-200">
                                        <th class="pb-3 pl-1">Conseiller</th>
                                        <th class="pb-3">Ventes</th>
                                        <th class="pb-3">Taux de conversion</th>
                                        <th class="pb-3">Satisfaction</th>
                                        <th class="pb-3 text-right">Performance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($topPerformers as $performer)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">
                                                    {{ $performer['initials'] }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">{{ $performer['name'] }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">{{ $performer['sales'] }}</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">{{ $performer['conversion_rate'] }}%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full {{ $performer['satisfaction_rate'] >= 80 ? 'bg-green-500' : ($performer['satisfaction_rate'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full" style="width: {{ $performer['satisfaction_rate'] }}%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">{{ $performer['satisfaction_rate'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $performer['performance_label'] == 'Excellente' ? 'bg-green-100 text-green-800' :
                                                   ($performer['performance_label'] == 'Très bonne' ? 'bg-blue-100 text-blue-800' :
                                                   ($performer['performance_label'] == 'Bonne' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($performer['performance_label'] == 'Moyenne' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                                {{ $performer['performance_label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-gray-500">
                                            Aucune donnée disponible pour cette période
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

    @if($salesByModel->count() > 0 || !empty($satisfactionData))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if($salesByModel->count() > 0)
        // Sales by Model Chart
        const salesByModelCtx = document.getElementById('salesByModelChart').getContext('2d');
        const salesByModelChart = new Chart(salesByModelCtx, {
            type: 'bar',
            data: {
                labels: @json($salesByModel->pluck('label')),
                datasets: [{
                    label: 'Ventes',
                    data: @json($salesByModel->pluck('sales')),
                    backgroundColor: [
                        'rgba(14, 165, 233, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(20, 184, 166, 0.8)'
                    ],
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#262626',
                        bodyColor: '#525252',
                        bodyFont: {
                            size: 12
                        },
                        borderColor: '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#737373'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#737373'
                        }
                    }
                }
            }
        });
        @endif

        // Customer Satisfaction Chart
        const satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        const satisfactionChart = new Chart(satisfactionCtx, {
            type: 'radar',
            data: {
                labels: ['Accueil', 'Conseil', 'Prix', 'Service', 'Suivi'],
                datasets: [{
                    label: 'Satisfaction',
                    data: [
                        {{ $satisfactionData['accueil'] ?? 80 }},
                        {{ $satisfactionData['conseil'] ?? 80 }},
                        {{ $satisfactionData['prix'] ?? 80 }},
                        {{ $satisfactionData['service'] ?? 80 }},
                        {{ $satisfactionData['suivi'] ?? 80 }}
                    ],
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    borderColor: '#0ea5e9',
                    pointBackgroundColor: '#0ea5e9',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#0ea5e9'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        suggestedMin: 50,
                        suggestedMax: 100,
                        ticks: {
                            backdropColor: 'transparent',
                            color: '#737373',
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        pointLabels: {
                            font: {
                                size: 11
                            },
                            color: '#525252'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#262626',
                        bodyColor: '#525252',
                        bodyFont: {
                            size: 12
                        },
                        borderColor: '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 5
                    }
                }
            }
        });
    </script>
    @endif
</body>
@endsection
