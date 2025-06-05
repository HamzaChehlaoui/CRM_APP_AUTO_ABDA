@extends('layouts.mastere')

@section('title', 'Statistique - Tableau de Bord')

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
                        <h1 class="text-2xl font-bold text-gray-800">Statistiques</h1>
                        <p class="text-sm text-gray-500">Analysez les performances de votre concession</p>
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
                        <div class="flex items-center space-x-2">
                            <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                                <span class="font-medium text-sm">Mai 2025</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Date Range and Export -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 sm:gap-0">
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text" value="01/05/2025" class="w-32 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <span class="text-gray-500">à</span>
                        <div class="relative">
                            <input type="text" value="31/05/2025" class="w-32 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Actualiser
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-file-export mr-2"></i>
                            Exporter
                        </button>
                    </div>
                </div>





                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Chart -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Évolution des Prospects et Ventes</h3>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm bg-primary-50 text-primary-600 rounded-md hover:bg-primary-600 hover:text-white transition-colors">Mois</button>
                                <button class="px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-gray-100 transition-colors">Trimestre</button>
                                <button class="px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-gray-100 transition-colors">Année</button>
                            </div>
                        </div>
                        <div class="h-80 relative">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <!-- Conversion Rate -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Taux de Conversion</h3>
                        <div class="h-80 relative">
                            <canvas id="conversionChart"></canvas>
                        </div>
                    </div>

                    <!-- Sales by Model -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Ventes par Modèle</h3>
                            <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">Voir tout</button>
                        </div>
                        <div class="h-80 relative">
                            <canvas id="salesByModelChart"></canvas>
                        </div>
                    </div>

                    <!-- Customer Satisfaction -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Satisfaction Client</h3>
                        <div class="h-80 relative">
                            <canvas id="satisfactionChart"></canvas>
                        </div>
                    </div>

                    <!-- Top Performers -->
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
                                        <th class="pb-3">Prospects</th>
                                        <th class="pb-3">Ventes</th>
                                        <th class="pb-3">Taux de conversion</th>
                                        <th class="pb-3">Satisfaction</th>
                                        <th class="pb-3 text-right">Performance</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">JD</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Julie Dubois</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">32</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">18</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">56%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full bg-green-500 rounded-full" style="width: 95%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">95%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Excellente
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">TM</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Thomas Martin</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">28</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">14</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">50%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full bg-green-500 rounded-full" style="width: 90%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">90%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Excellente
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-medium">SL</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Sophie Leroy</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">24</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">10</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">42%</p>
                                        </td>
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                <div class="w-24 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-full bg-yellow-500 rounded-full" style="width: 85%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-gray-800">85%</span>
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Bonne
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Main Chart - Prospects and Sales Evolution
        const mainCtx = document.getElementById('mainChart').getContext('2d');
        const mainChart = new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [
                    {
                        label: 'Prospects',
                        data: [42, 38, 45, 50, 53, 48, 40, 42, 45, 48, 52, 55],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0ea5e9',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Ventes',
                        data: [28, 25, 30, 35, 42, 38, 32, 30, 35, 40, 45, 48],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.05)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#8b5cf6',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
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
                        boxPadding: 5,
                        usePointStyle: true
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

        // Conversion Rate Chart
        const conversionCtx = document.getElementById('conversionChart').getContext('2d');
        const conversionChart = new Chart(conversionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Convertis', 'En cours', 'Non convertis'],
                datasets: [{
                    data: [42, 28, 30],
                    backgroundColor: [
                        '#22c55e',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
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
                        boxPadding: 5,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.formattedValue || '';
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                }
            }
        });

        // Sales by Model Chart
        const salesByModelCtx = document.getElementById('salesByModelChart').getContext('2d');
        const salesByModelChart = new Chart(salesByModelCtx, {
            type: 'bar',
            data: {
                labels: ['Renault Clio', 'Peugeot 3008', 'Citroën C4', 'Renault Captur', 'Peugeot 208', 'Dacia Sandero'],
                datasets: [{
                    label: 'Ventes',
                    data: [12, 9, 8, 7, 6, 5],
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

        // Customer Satisfaction Chart
        const satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        const satisfactionChart = new Chart(satisfactionCtx, {
            type: 'radar',
            data: {
                labels: ['Accueil', 'Conseil', 'Prix', 'Service', 'Suivi'],
                datasets: [{
                    label: 'Satisfaction',
                    data: [95, 90, 85, 92, 88],
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
</body>
@endsection
</html>
