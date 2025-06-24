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
                        <a href="/notifications">
                            <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors relative" id="notificationBell">
                                <i class="fas fa-bell"></i>
                                @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 h-5 w-5 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                </span>
                                @endif
                            </button>
                        </a>
                        <span class="h-6 border-l border-gray-300"></span>
                        <button class="flex items-center space-x-2 hover:bg-gray-100 rounded-md px-3 py-1.5 transition-colors">
                            <span class="font-medium text-sm">{{ date('d/m/Y') }}</span>
                            <i class="fas fa-calendar-alt text-xs text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </header>

            <div class="flex-1 p-6 overflow-y-auto">
                <form method="GET" action="{{ route('statistics.index') }}" class="bg-white rounded-xl shadow-card p-6 mb-6">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4 flex-1">
                            <div class="flex items-end space-x-2">
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-40 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                </div>
                                <span class="text-gray-500 pb-2">à</span>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-40 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                </div>
                            </div>

                            @if (in_array(auth()->user()->role_id, [1, 2]))
                            <div class="flex flex-col">
                                <label class="text-sm font-medium text-gray-700 mb-1">Succursale</label>
                                <select name="branch" class="w-48 rounded-md border border-gray-300 py-2 px-3 text-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                                    <option value="all" {{ $selectedBranch == 'all' ? 'selected' : '' }}>Toutes les succursales</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $selectedBranch == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                <i class="fas fa-sync-alt mr-2"></i> Actualiser
                            </button>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <div class="flex space-x-2 border-l border-gray-200 pl-3">
                                <button type="button" onclick="window.print()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-print mr-2"></i> Imprimer
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <i class="fas fa-building mr-1"></i>
                                    {{ $branches->firstWhere('id', $selectedBranch)->name ?? 'Succursale' }}
                                </span>
                                @endif
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                                </span>
                            </div>
                            <a href="{{ route('statistics.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fas fa-times mr-1"></i> Réinitialiser les filtres
                            </a>
                        </div>
                    </div>
                    @endif
                </form>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-users text-blue-600"></i></div>
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
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-file-invoice text-green-600"></i></div>
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
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center"><i class="fas fa-euro-sign text-yellow-600"></i></div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Chiffre d'Affaires</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalRevenue, 2, ',', ' ') }} dh</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-card p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center"><i class="fas fa-money-check-alt text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Factures payé</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $facture_paye }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-card p-6 col-span-2 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-chart-bar text-blue-500"></i>
                            Statistiques des Factures
                        </h3>
                        <div class="h-80 relative flex-1">
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
                    <div class="bg-white rounded-xl shadow-card border border-blue-100 p-0 col-span-1 flex flex-col h-[23rem] min-w-[320px] max-w-[380px]">
                        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-blue-50 bg-gradient-to-r from-blue-50 to-white rounded-t-xl">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-users text-blue-400"></i>
                                <h3 class="text-base font-semibold text-gray-800">Clients et Montants Payés</h3>
                            </div>
                            <div class="text-xs text-gray-500 font-medium" id="clients-total-count">
                                Total: {{ count($clientsWithPayments ?? []) }}
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-200 scrollbar-track-blue-50 hover:scrollbar-thumb-blue-300 px-4 py-2" id="clients-list-container">
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <span>Chargement...</span>
                            </div>
                        </div>
                        <div class="px-6 py-3 border-t border-blue-50 bg-gradient-to-r from-blue-50 to-white rounded-b-xl">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Total Général:</span>
                                <span class="text-lg font-bold text-blue-600" id="clients-total-amount">0 DH</span>
                            </div>
                            <div class="flex justify-center mt-2" id="clients-pagination"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-card p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Meilleures Performances</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-200">
                                    <th class="pb-3 pl-1">Conseiller</th>
                                    <th class="pb-3">Factures payé</th>
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
                                        <p class="text-sm font-medium text-gray-800">{{$facture_paye}}</p>
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $performer['performance_label'] == 'Excellente' ? 'bg-green-100 text-green-800' : ($performer['performance_label'] == 'Très bonne' ? 'bg-blue-100 text-blue-800' : ($performer['performance_label'] == 'Bonne' ? 'bg-yellow-100 text-yellow-800' : ($performer['performance_label'] == 'Moyenne' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
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

    @if (($clientsWithPayments ?? false) || $invoiceStats['total_invoices'] > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @php
        $statutData = [
            $invoiceStats['statut_breakdown']['creation'] ?? 0,
            $invoiceStats['statut_breakdown']['facturé'] ?? 0,
            $invoiceStats['statut_breakdown']['envoyée_pour_paiement'] ?? 0,
            $invoiceStats['statut_breakdown']['paiement'] ?? 0,
        ];
        $clients = $clientsWithPayments ?? [];
        $clientLabels = collect($clients)->pluck('full_name')->toArray();
        $clientAmounts = collect($clients)->pluck('total_paid')->map(fn($v) => round($v, 2))->toArray();
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
                                '#2563EB',
                                '#7C3AED',
                                '#DC2626',
                                '#059669'
                            ],
                            borderWidth: 0,
                            barThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: { top: 10, right: 10, bottom: 10, left: 10 }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: {
                                    color: '#374151',
                                    font: { family: 'Arial, sans-serif', size: 12 }
                                },
                                border: { color: '#D1D5DB' }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#E5E7EB', lineWidth: 1 },
                                ticks: {
                                    precision: 0,
                                    color: '#374151',
                                    font: { family: 'Arial, sans-serif', size: 11 },
                                },
                                border: { color: '#D1D5DB' }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#FFFFFF',
                                titleColor: '#111827',
                                bodyColor: '#374151',
                                borderColor: '#D1D5DB',
                                borderWidth: 1,
                                cornerRadius: 4,
                                padding: 8,
                                titleFont: { family: 'Arial, sans-serif', size: 12, weight: 'bold' },
                                bodyFont: { family: 'Arial, sans-serif', size: 11 },
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' factures';
                                    }
                                }
                            }
                        },
                        animation: { duration: 0 },
                        interaction: { intersect: true, mode: 'nearest' }
                    }
                });
            }
            @endif
        });
    </script>
    @endif

    <script>
        const branchSelect = document.querySelector('select[name="branch"]');
        if (branchSelect) {
            branchSelect.addEventListener('change', function() {
                this.closest('form').submit();
            });
        }
    </script>

    <script>
// AJAX pagination for Clients et Montants Payés
function renderClientsList(clients, page, perPage, total, totalAmount) {
    const container = document.getElementById('clients-list-container');
    if (!clients.length) {
        container.innerHTML = `<div class='flex flex-col items-center justify-center text-gray-400 h-full'>
            <div class='w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center mb-3'>
                <i class='fas fa-user-slash text-2xl'></i>
            </div>
            <p class='text-sm font-medium'>Aucune donnée disponible</p>
            <p class='text-xs text-gray-300 mt-1'>Aucun paiement trouvé</p>
        </div>`;
        document.getElementById('clients-total-amount').textContent = '0 DH';
        document.getElementById('clients-total-count').textContent = 'Total: 0';
        document.getElementById('clients-pagination').innerHTML = '';
        return;
    }
    let html = '<div class="space-y-2">';
    clients.forEach((client, idx) => {
        html += `<div class='flex items-center justify-between p-2 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all duration-200 border border-blue-100 hover:border-blue-200 shadow-sm'>
            <div class='flex items-center space-x-3'>
                <div class='flex-shrink-0'>
                    <div class='w-7 h-7 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xs shadow-sm'>${(page-1)*perPage+idx+1}</div>
                </div>
                <div class='min-w-0 flex-1'>
                    <h4 class='text-sm font-medium text-gray-900 truncate'>${client.full_name}</h4>
                </div>
            </div>
            <div class='text-right flex-shrink-0'>
                <div class='text-sm font-bold text-emerald-600'>${parseFloat(client.total_paid).toLocaleString('fr-FR', {minimumFractionDigits:2})} DH</div>
                <div class='text-xs text-gray-400'>Payé</div>
            </div>
        </div>`;
    });
    html += '</div>';
    container.innerHTML = html;
    document.getElementById('clients-total-amount').textContent = `${totalAmount.toLocaleString('fr-FR', {minimumFractionDigits:2})} DH`;
    document.getElementById('clients-total-count').textContent = `Total: ${total}`;
}
function renderClientsPagination(page, totalPages) {
    const pag = document.getElementById('clients-pagination');
    if (totalPages <= 1) { pag.innerHTML = ''; return; }
    let html = '';
    // Prev button
    html += `<button class='px-2 py-1 mx-1 rounded ${page===1?'bg-gray-200 text-gray-400 cursor-not-allowed':'bg-white text-blue-500 border border-blue-200 hover:bg-blue-100'}' data-page='${page-1}' ${page===1?'disabled':''}>Préc.</button>`;
    // Page numbers
    let start = Math.max(1, page - 2);
    let end = Math.min(totalPages, page + 2);
    if (start > 1) {
        html += `<button class='px-2 py-1 mx-1 rounded bg-white text-blue-500 border border-blue-200 hover:bg-blue-100' data-page='1'>1</button>`;
        if (start > 2) html += `<span class='px-2 text-gray-400'>...</span>`;
    }
    for (let i = start; i <= end; i++) {
        html += `<button class='px-2 py-1 mx-1 rounded ${i===page?'bg-blue-500 text-white':'bg-white text-blue-500 border border-blue-200 hover:bg-blue-100'}' data-page='${i}'>${i}</button>`;
    }
    if (end < totalPages) {
        if (end < totalPages - 1) html += `<span class='px-2 text-gray-400'>...</span>`;
        html += `<button class='px-2 py-1 mx-1 rounded bg-white text-blue-500 border border-blue-200 hover:bg-blue-100' data-page='${totalPages}'>${totalPages}</button>`;
    }
    // Next button
    html += `<button class='px-2 py-1 mx-1 rounded ${page===totalPages?'bg-gray-200 text-gray-400 cursor-not-allowed':'bg-white text-blue-500 border border-blue-200 hover:bg-blue-100'}' data-page='${page+1}' ${page===totalPages?'disabled':''}>Suiv.</button>`;
    pag.innerHTML = html;
    Array.from(pag.querySelectorAll('button')).forEach(btn => {
        if (!btn.disabled) {
            btn.onclick = function() { loadClientsWithPayments(parseInt(this.dataset.page)); };
        }
    });
}
function loadClientsWithPayments(page=1) {
    // Récupérer la valeur du filtre de succursale
    const branchSelect = document.querySelector('select[name="branch"]');
    const branch = branchSelect ? branchSelect.value : 'all';
    const params = new URLSearchParams({
        start_date: '{{ $startDate }}',
        end_date: '{{ $endDate }}',
        branch: branch, // Ajout du filtre de branche
        page: page
    });
    fetch(`{{ route('statistics.clientsWithPaymentsAjax') }}?${params}`)
        .then(r => r.json())
        .then(data => {
            renderClientsList(data.data, data.current_page, data.per_page, data.total, data.data.reduce((sum, c) => sum + parseFloat(c.total_paid), 0));
            renderClientsPagination(data.current_page, data.last_page);
        });
}
document.addEventListener('DOMContentLoaded', function() {
    loadClientsWithPayments();
});
</script>
</body>
@endsection
@include('page.button-loading')
