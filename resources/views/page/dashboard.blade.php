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
                                Tableau de Bord - Employé de Safi
                            @elseif(Auth::user()->role_id == 4)
                                Tableau de Bord - Employé de Essaouira
                            @elseif(Auth::user()->role_id == 5)
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

            <!-- Main Dashboard Content Area -->
            <div class="flex-1 p-6 overflow-y-auto">
                <!-- Summary Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user-plus text-xl text-nucleus-primary"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 12%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Total des clients</h3>
                        <p class="text-3xl font-bold text-nucleus-primary">530</p>
                        <p class="text-sm text-gray-500 mt-1">Cette semaine</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                                <i class="fas fa-phone-alt text-xl text-yellow-600"></i>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">↑ 5%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Suivis en Cours</h3>
                        <p class="text-3xl font-bold text-yellow-600">18</p>
                        <p class="text-sm text-gray-500 mt-1">Nécessitent une action</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-users text-xl text-green-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 8%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Clients Actifs</h3>
                        <p class="text-3xl font-bold text-green-600">125</p>
                        <p class="text-sm text-gray-500 mt-1">Total des clients</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-car text-xl text-purple-600"></i>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">↑ 15%</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Ventes</h3>
                        <p class="text-3xl font-bold text-purple-600">42</p>
                        <p class="text-sm text-gray-500 mt-1">Ce mois-ci</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Charts / Graphs -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Suivi des Clients</h3>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 text-sm bg-nucleus-light text-nucleus-primary rounded-md hover:bg-nucleus-primary hover:text-white transition-colors">Semaine</button>
                                <button class="px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-gray-100 transition-colors">Mois</button>
                                <button class="px-3 py-1 text-sm bg-white text-gray-500 rounded-md hover:bg-gray-100 transition-colors">Année</button>
                            </div>
                        </div>
                        <div class="h-64 relative">
                            <canvas id="prospectsChart"></canvas>
                        </div>
                    </div>

                    <!-- Summary by Status -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Statut des Clients</h3>
                        <div class="h-64 relative">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Leads -->
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Prospects Récents</h3>
                            <button class="text-nucleus-primary hover:text-nucleus-hover text-sm font-medium">Voir tout</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-200">
                                        <th class="pb-3 pl-1">Client</th>
                                        <th class="pb-3">Véhicule</th>
                                        <th class="pb-3">Date</th>
                                        <th class="pb-3">Statut</th>
                                        <th class="pb-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-nucleus-primary/10 flex items-center justify-center text-nucleus-primary font-medium">ML</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Martin Leclerc</p>
                                                    <p class="text-xs text-gray-500">martin.l@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">Renault Clio</p>
                                            <p class="text-xs text-gray-500">Essence, Automatique</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm text-gray-600">15 mai 2025</p>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-xs px-2 py-1 rounded-full status-new">Nouveau</span>
                                        </td>
                                        <td class="py-3 text-right">
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-phone"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-envelope"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-ellipsis-v"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-nucleus-primary/10 flex items-center justify-center text-nucleus-primary font-medium">SD</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Sophie Dubois</p>
                                                    <p class="text-xs text-gray-500">sophie.d@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">Peugeot 3008</p>
                                            <p class="text-xs text-gray-500">Diesel, Manuelle</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm text-gray-600">14 mai 2025</p>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-xs px-2 py-1 rounded-full status-interested">Intéressé</span>
                                        </td>
                                        <td class="py-3 text-right">
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-phone"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-envelope"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-ellipsis-v"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-nucleus-primary/10 flex items-center justify-center text-nucleus-primary font-medium">PT</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Pierre Thomas</p>
                                                    <p class="text-xs text-gray-500">pierre.t@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">Citroën C4</p>
                                            <p class="text-xs text-gray-500">Hybride, Automatique</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm text-gray-600">12 mai 2025</p>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-xs px-2 py-1 rounded-full status-sold">Vendu</span>
                                        </td>
                                        <td class="py-3 text-right">
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-phone"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-envelope"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-ellipsis-v"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 pl-1">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-nucleus-primary/10 flex items-center justify-center text-nucleus-primary font-medium">LM</div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-800">Lucie Martin</p>
                                                    <p class="text-xs text-gray-500">lucie.m@example.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm font-medium text-gray-800">BMW Série 3</p>
                                            <p class="text-xs text-gray-500">Essence, Automatique</p>
                                        </td>
                                        <td class="py-3">
                                            <p class="text-sm text-gray-600">10 mai 2025</p>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-xs px-2 py-1 rounded-full status-not-interested">Non intéressé</span>
                                        </td>
                                        <td class="py-3 text-right">
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-phone"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-envelope"></i></button>
                                            <button class="text-gray-500 hover:text-nucleus-primary p-1"><i class="fas fa-ellipsis-v"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Calendar / Tasks -->
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">À Faire Aujourd'hui</h3>
                            <button class="text-nucleus-primary hover:text-nucleus-hover text-sm font-medium">+ Ajouter</button>
                        </div>

                        <ul class="space-y-3">
                            <li class="flex items-center p-3 bg-nucleus-light rounded-lg">
                                <div class="h-8 w-8 rounded-full bg-nucleus-primary/20 flex items-center justify-center text-nucleus-primary mr-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-gray-800">Appeler Mme. Dubois</p>
                                    <p class="text-xs text-gray-500">10:30 - Citroën C3</p>
                                </div>
                                <button class="text-gray-400 hover:text-nucleus-primary">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </li>
                            <li class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-3">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-gray-800">Essai routier M. Bernard</p>
                                    <p class="text-xs text-gray-500">14:00 - Renault Captur</p>
                                </div>
                                <button class="text-gray-400 hover:text-nucleus-primary">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </li>
                            <li class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                                    <i class="fas fa-file-signature"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-gray-800">Finaliser contrat Famille Richard</p>
                                    <p class="text-xs text-gray-500">16:30 - Peugeot 5008</p>
                                </div>
                                <button class="text-gray-400 hover:text-nucleus-primary">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </li>
                            <li class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-3">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-sm text-gray-800">Réclamation client à traiter</p>
                                    <p class="text-xs text-gray-500">Urgent - M. Petit</p>
                                </div>
                                <button class="text-gray-400 hover:text-nucleus-primary">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Line chart for Prospects
        const prospectsCtx = document.getElementById('prospectsChart').getContext('2d');
        const prospectsChart = new Chart(prospectsCtx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [
                    {
                        label: 'Nouveaux Prospects',
                        data: [8, 12, 5, 9, 14, 3, 2],
                        borderColor: '#3A5CDB',
                        backgroundColor: 'rgba(58, 92, 219, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3A5CDB',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Suivis Effectués',
                        data: [4, 6, 3, 8, 5, 2, 1],
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.05)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#22c55e',
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
                        usePointStyle: true,
                        callbacks: {
                            labelPointStyle: function(context) {
                                return {
                                    pointStyle: 'circle',
                                    rotation: 0
                                };
                            }
                        }
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

        // Doughnut chart for Status
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Nouveau', 'Intéressé', 'Vendu', 'Non intéressé'],
                datasets: [{
                    data: [35, 28, 15, 22],
                    backgroundColor: [
                        '#38bdf8',
                        '#f59e0b',
                        '#22c55e',
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

        // Animation for card hover
        document.querySelectorAll('.card-hover').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.boxShadow = '0 15px 30px rgba(58, 92, 219, 0.1)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '';
            });
        });
    </script>
@endsection
