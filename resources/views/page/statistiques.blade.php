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
                                <span
                                    class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                            <span class="h-6 border-l border-gray-300"></span>
                            <button
                                class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                                <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                                <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </header>

                <div class="flex-1 p-6 overflow-y-auto">
                    <form method="GET" action="{{ route('statistics.index') }}"
                        class="bg-white rounded-xl shadow-card p-6 mb-6">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
                            <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4 flex-1">
                                <div class="flex items-end space-x-2">
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                        <input type="date" name="start_date" value="{{ $startDate }}"
                                            class="w-40 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                    </div>
                                    <span class="text-gray-500 pb-2">à</span>
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                        <input type="date" name="end_date" value="{{ $endDate }}"
                                            class="w-40 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                    </div>
                                </div>

                                @if (in_array(auth()->user()->role_id, [1, 2]))
                                    <div class="flex flex-col">
                                        <label class="text-sm font-medium text-gray-700 mb-1">Succursale</label>
                                        <select name="branch"
                                            class="w-48 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                            <option value="all" {{ $selectedBranch == 'all' ? 'selected' : '' }}>
                                                Toutes les succursales
                                            </option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ $selectedBranch == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                    Actualiser
                                </button>
                            </div>

                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                <div class="flex space-x-2 border-l border-gray-200 pl-3">
                                    <button type="button" onclick="window.print()"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-print mr-2"></i>
                                        Imprimer
                                    </button>


                                </div>
                            </div>
                        </div>

                        @if (request()->has('start_date') || request()->has('branch'))
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <i class="fas fa-filter text-primary-500"></i>
                                        <span>Filtres actifs:</span>

                                        @if ($selectedBranch != 'all' && $branches->isNotEmpty())
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                                <i class="fas fa-building mr-1"></i>
                                                {{-- FIX: Added 'id' as the key for firstWhere --}}
                                                {{ $branches->firstWhere('id', $selectedBranch)->name ?? 'Succursale' }}
                                            </span>
                                        @endif

                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                                        </span>
                                    </div>

                                    <a href="{{ route('statistics.index') }}"
                                        class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                                        <i class="fas fa-times mr-1"></i>
                                        Réinitialiser les filtres
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow-card p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center"><i
                                            class="fas fa-users text-blue-600"></i></div>
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
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"><i
                                            class="fas fa-file-invoice text-green-600"></i></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Factures Totales</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalSales }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-card p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center"><i
                                            class="fas fa-euro-sign text-yellow-600"></i></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Chiffre d'Affaires</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ number_format($totalRevenue, 2, ',', ' ') }} dh</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-card p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center"><i
                                            class="fas fa-tasks text-purple-600"></i></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Suivis Actifs</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $activeSuivis }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Statistiques des Factures</h3>
                            <div class="h-80 relative">
                                @if ($invoiceStats['total_invoices'] > 0)
                                    <canvas id="invoiceStatsChart"></canvas>
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-500">
                                        <div class="text-center">
                                            <i class="fas fa-chart-bar text-4xl mb-4 text-gray-300"></i>
                                            <p>Aucune donnée disponible pour cette période</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-card p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Satisfaction Client</h3>
                            <div class="h-80 relative">
                                {{-- FIX: Check if data exists before rendering the chart --}}
                                @if ($satisfactionData)
                                    <canvas id="satisfactionChart"></canvas>
                                @else
                                    {{-- Display a message if no data is available --}}
                                    <div class="flex items-center justify-center h-full text-gray-500">
                                        <div class="text-center">
                                            <i class="fas fa-smile-beam text-4xl mb-4 text-gray-300"></i>
                                            <p>Aucune donnée de satisfaction disponible</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-card p-6 col-span-1 lg:col-span-3">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Meilleures Performances</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-200">
                                            <th class="pb-3 pl-1">Conseiller</th>
                                            <th class="pb-3">Factures</th>
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
                                                        <div
                                                            class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">
                                                            {{ $performer['initials'] }}
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium text-gray-800">
                                                                {{ $performer['name'] }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <p class="text-sm font-medium text-gray-800">{{ $performer['sales'] }}
                                                    </p>
                                                </td>
                                                <td class="py-3">
                                                    <p class="text-sm font-medium text-gray-800">
                                                        {{ $performer['conversion_rate'] }}%</p>
                                                </td>
                                                <td class="py-3">
                                                    <div class="flex items-center">
                                                        <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                            <div class="h-full {{ $performer['satisfaction_rate'] >= 80 ? 'bg-green-500' : ($performer['satisfaction_rate'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full"
                                                                style="width: {{ $performer['satisfaction_rate'] }}%">
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="text-sm font-medium text-gray-800">{{ $performer['satisfaction_rate'] }}%</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-right">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $performer['performance_label'] == 'Excellente' ? 'bg-green-100 text-green-800' : ($performer['performance_label'] == 'Très bonne' ? 'bg-blue-100 text-blue-800' : ($performer['performance_label'] == 'Bonne' ? 'bg-yellow-100 text-yellow-800' : ($performer['performance_label'] == 'Moyenne' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                                        {{ $performer['performance_label'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="py-6 text-center text-gray-500">
                                                    Aucune donnée de performance disponible pour cette période
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

        {{-- Ensure Chart.js is loaded if any chart data is present --}}
        @if ($satisfactionData || $invoiceStats['total_invoices'] > 0)
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            @php
                $statutData = [
                    $invoiceStats['statut_breakdown']['creation'] ?? 0,
                    $invoiceStats['statut_breakdown']['facturé'] ?? 0,
                    $invoiceStats['statut_breakdown']['envoyée_pour_paiement'] ?? 0,
                    $invoiceStats['statut_breakdown']['paiement'] ?? 0,
                ];

                $satisfactionChartData = [];
                if ($satisfactionData) {
                    $satisfactionChartData = [
                        $satisfactionData['accueil'] ?? 0,
                        $satisfactionData['conseil'] ?? 0,
                        $satisfactionData['prix'] ?? 0,
                        $satisfactionData['service'] ?? 0,
                        $satisfactionData['suivi'] ?? 0,
                    ];
                }
            @endphp

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    @if ($invoiceStats['total_invoices'] > 0)
                        const invoiceStatsCtx = document.getElementById('invoiceStatsChart');
                        if (invoiceStatsCtx) {
                            const ctx = invoiceStatsCtx.getContext('2d');

                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['Création', 'Facturé', 'Envoyée pour Paiement', 'Payé'],
                                    datasets: [{
                                        label: 'Nombre de Factures',
                                        data: @json($statutData),
                                        backgroundColor: [
                                            '#2563EB', // Professional blue
                                            '#7C3AED', // Professional purple
                                            '#DC2626', // Professional red
                                            '#059669' // Professional green
                                        ],
                                        borderWidth: 0,
                                        barThickness: 40
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    layout: {
                                        padding: {
                                            top: 10,
                                            right: 10,
                                            bottom: 10,
                                            left: 10
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                color: '#374151',
                                                font: {
                                                    family: 'Arial, sans-serif',
                                                    size: 12
                                                }
                                            },
                                            border: {
                                                color: '#D1D5DB'
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            grid: {
                                                color: '#E5E7EB',
                                                lineWidth: 1
                                            },
                                            ticks: {
                                                precision: 0,
                                                color: '#374151',
                                                font: {
                                                    family: 'Arial, sans-serif',
                                                    size: 11
                                                },
                                                callback: function(value) {
                                                    return value;
                                                }
                                            },
                                            border: {
                                                color: '#D1D5DB'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            backgroundColor: '#FFFFFF',
                                            titleColor: '#111827',
                                            bodyColor: '#374151',
                                            borderColor: '#D1D5DB',
                                            borderWidth: 1,
                                            cornerRadius: 4,
                                            padding: 8,
                                            titleFont: {
                                                family: 'Arial, sans-serif',
                                                size: 12,
                                                weight: 'bold'
                                            },
                                            bodyFont: {
                                                family: 'Arial, sans-serif',
                                                size: 11
                                            },
                                            displayColors: false,
                                            callbacks: {
                                                label: function(context) {
                                                    return context.parsed.y + ' factures';
                                                }
                                            }
                                        }
                                    },
                                    animation: {
                                        duration: 0
                                    },
                                    interaction: {
                                        intersect: true,
                                        mode: 'nearest'
                                    }
                                }
                            });
                        }
                    @endif

                    @if ($satisfactionData)
                        const satisfactionCtx = document.getElementById('satisfactionChart');
                        if (satisfactionCtx) {
                            const ctx = satisfactionCtx.getContext('2d');
                            new Chart(ctx, {
                                type: 'radar',
                                data: {
                                    labels: ['Accueil', 'Conseil', 'Prix', 'Service', 'Suivi'],
                                    datasets: [{
                                        label: 'Satisfaction',
                                        data: @json($satisfactionChartData),
                                        backgroundColor: 'rgba(14, 165, 233, 0.2)',
                                        borderColor: '#0ea5e9',
                                        pointBackgroundColor: '#0ea5e9',
                                        pointBorderColor: '#fff',
                                        pointHoverBackgroundColor: '#fff',
                                        pointHoverBorderColor: '#0ea5e9',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        r: {
                                            beginAtZero: true,
                                            suggestedMax: 10,
                                            ticks: {
                                                stepSize: 1,
                                                showLabelBackdrop: false
                                            },
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)'
                                            },
                                            angleLines: {
                                                color: 'rgba(0, 0, 0, 0.1)'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        }
                                    }
                                }
                            });
                        }
                    @endif
                });
            </script>
        @endif
        <script>
            // Auto-submit form when branch selection changes
            const branchSelect = document.querySelector('select[name="branch"]');
            if (branchSelect) {
                branchSelect.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            }
        </script>
    </body>
@endsection
@include('page.button-loading')
