<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Suivi;
use App\Models\Invoice;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardService
{
public function resolveBranchInfo($user, $selectedBranch): array
    {
        if ($user->role_id == 1 || $user->role_id == 2) {
            $clientsQuery = Client::query();
            $suivisQuery = Suivi::query();
            $invoicesQuery = Invoice::query();

            if ($selectedBranch !== 'all') {
                $clientsQuery->where('branch_id', $selectedBranch);

                $suivisQuery->whereHas('client', function ($query) use ($selectedBranch) {
                    $query->where('branch_id', $selectedBranch);
                });

                $invoicesQuery->whereHas('client', function ($query) use ($selectedBranch) {
                    $query->where('branch_id', $selectedBranch);
                });
            }

            return [
                'clientsQuery' => $clientsQuery,
                'suivisQuery' => $suivisQuery,
                'invoicesQuery' => $invoicesQuery,
                'branches' => Branch::all()
            ];
        }

        $branchId = $user->branch_id;

        return [
            'clientsQuery' => Client::where('branch_id', $branchId),

            'suivisQuery' => Suivi::whereHas('client', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            }),

            'invoicesQuery' => Invoice::whereHas('client', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            }),

            'branches' => collect()
        ];
    }

public function calculatePercentageChange($current, $previous): string
    {
        if ($previous == 0) return '0%';
        $change = (($current - $previous) / $previous) * 100;
        $sign = $change >= 0 ? '+' : '';
        return $sign . round($change) . '%';
    }

public function getDashboardStats($clientsQuery, $suivisQuery, $invoicesQuery): array
{
    $now = Carbon::now();
    $lastMonth = $now->copy()->subMonth();

    $statuts = ['creation', 'facturé', 'envoyée_pour_paiement', 'paiement'];

    $facturesCurrent = [];
    $facturesLast = [];
    $facturesPercentageChange = [];

    foreach ($statuts as $statut) {

        $facturesCurrent[$statut] = (clone $invoicesQuery)
            ->where('statut_facture', $statut)
            ->whereMonth('sale_date', $now->month)
            ->whereYear('sale_date', $now->year)
            ->count();

        $facturesLast[$statut] = (clone $invoicesQuery)
            ->where('statut_facture', $statut)
            ->whereMonth('sale_date', $lastMonth->month)
            ->whereYear('sale_date', $lastMonth->year)
            ->count();

        $facturesPercentageChange[$statut] = $this->calculatePercentageChange(
            $facturesCurrent[$statut],
            $facturesLast[$statut]
        );
    }

    return [
        'factures_current' => $facturesCurrent,
        'factures_last' => $facturesLast,
        'factures_percentage_change' => $facturesPercentageChange,
    ];
}

/**
 * Calculates the total number of sales over a given period for chart display.
 *
 * @param Builder $invoicesQuery The base, pre-filtered invoice query.
 * @param string  $period        The time period ('week', 'month', or 'year').
 * @return array                An array containing sales counts and corresponding labels.
 */
public function getTopPayingClients($invoicesQuery, $period): array
{
    $topClients = (clone $invoicesQuery)
        ->where('statut_facture', 'paiement') 
        ->selectRaw('client_id, SUM(total_amount) as total_paid')
        ->with('client:id,full_name')
        ->groupBy('client_id')
        ->orderByDesc('total_paid')
        ->take(5)
        ->get();

    $labels = $topClients->map(fn($item) => optional($item->client)->full_name ?? '—')->toArray();
    $clientsVendus = $topClients->map(fn($item) => round($item->total_paid, 2))->toArray();

    return [$clientsVendus, $labels];
}





public function getPostSaleStats($user, $selectedBranch = 'all'): array
{
    $query = DB::table('clients')
        ->join('invoices', function ($join) {
            $join->on('clients.id', '=', 'invoices.client_id')
                ->where('invoices.statut_facture', 'paiement');
        })
        ->select(
            'clients.id',
            'clients.full_name',
            DB::raw('SUM(invoices.total_amount) as total_amount')
        )
        ->groupBy('clients.id', 'clients.full_name')
        ->havingRaw('SUM(invoices.total_amount) > 0');

    if ($user->role_id == 1 || $user->role_id == 2) {
        if ($selectedBranch !== 'all') {
            $query->where('clients.branch_id', $selectedBranch);
        }
    } else {
        $query->where('clients.branch_id', $user->branch_id);
    }

    return $query->get()->toArray();
}




public function getFilteredInvoices($user, $selectedBranch)
    {
        $branchInfo = $this->resolveBranchInfo($user, $selectedBranch);

        /** @var \Illuminate\Database\Eloquent\Builder $invoicesQuery */
        $invoicesQuery = $branchInfo['invoicesQuery'];

        return $invoicesQuery->with(['client', 'car']);
    }

}
