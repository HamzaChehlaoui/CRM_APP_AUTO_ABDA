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

        // Current month
        $totalClientsCurrent = $clientsQuery->count();
        $suivisEnCoursCurrent = (clone $suivisQuery)->where('status', 'en_cours')->count();
        $activeClientsCurrent = (clone $clientsQuery)->whereHas('invoices')->count();
        $salesThisMonthCurrent = (clone $invoicesQuery)->whereMonth('sale_date', $now->month)
                                                      ->whereYear('sale_date', $now->year)
                                                      ->count();

        // Last month
        $totalClientsLast = (clone $clientsQuery)->whereMonth('created_at', $lastMonth->month)
                                                 ->whereYear('created_at', $lastMonth->year)
                                                 ->count();

        $suivisEnCoursLast = (clone $suivisQuery)->where('status', 'en_cours')
                                                 ->whereMonth('created_at', $lastMonth->month)
                                                 ->whereYear('created_at', $lastMonth->year)
                                                 ->count();

        $activeClientsLast = (clone $clientsQuery)->whereHas('invoices', function ($q) use ($lastMonth) {
            $q->whereMonth('sale_date', $lastMonth->month)
              ->whereYear('sale_date', $lastMonth->year);
        })->count();

        $salesThisMonthLast = (clone $invoicesQuery)->whereMonth('sale_date', $lastMonth->month)
                                                    ->whereYear('sale_date', $lastMonth->year)
                                                    ->count();

        return [
            'totalClientsCurrent' => $totalClientsCurrent,
            'suivisEnCoursCurrent' => $suivisEnCoursCurrent,
            'activeClientsCurrent' => $activeClientsCurrent,
            'salesThisMonthCurrent' => $salesThisMonthCurrent,
            'percentageClients' => $this->calculatePercentageChange($totalClientsCurrent, $totalClientsLast),
            'percentageSuivis' => $this->calculatePercentageChange($suivisEnCoursCurrent, $suivisEnCoursLast),
            'percentageActive' => $this->calculatePercentageChange($activeClientsCurrent, $activeClientsLast),
            'percentageSales' => $this->calculatePercentageChange($salesThisMonthCurrent, $salesThisMonthLast),
        ];
    }

    public function getClientsVendus($invoicesQuery, string $period): array
    {
        $clientsVendus = [];
        $labels = [];

        if ($period === 'week') {
            foreach (range(0, 6) as $i) {
                $day = Carbon::now()->startOfWeek()->addDays($i);
                $count = (clone $invoicesQuery)
                    ->whereDate('sale_date', $day)
                    ->distinct('client_id')->count('client_id');
                $clientsVendus[] = $count;
            }
            $labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

        } elseif ($period === 'month') {
            foreach (range(1, Carbon::now()->daysInMonth) as $i) {
                $date = Carbon::now()->startOfMonth()->addDays($i - 1);
                $count = (clone $invoicesQuery)
                    ->whereDate('sale_date', $date)
                    ->distinct('client_id')->count('client_id');
                $clientsVendus[] = $count;
                $labels[] = $date->day;
            }

        } elseif ($period === 'year') {
            foreach (range(1, 12) as $i) {
                $start = Carbon::now()->startOfYear()->addMonths($i - 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();

                $count = (clone $invoicesQuery)
                    ->whereBetween('sale_date', [$start, $end])
                    ->distinct('client_id')->count('client_id');
                $clientsVendus[] = $count;
                $labels[] = $start->shortMonthName;
            }
        }

        return [$clientsVendus, $labels];
    }
   public function getPostSaleStats($user, $selectedBranch = 'all'): array
{
    $branchInfo = $this->resolveBranchInfo($user, $selectedBranch);

    /** @var \Illuminate\Database\Eloquent\Builder $clientsQuery */
    $clientsQuery = $branchInfo['clientsQuery'];

    return [
        'en_attente_livraison' => (clone $clientsQuery)->where('post_sale_status', 'en_attente_livraison')->count(),
        'livre' => (clone $clientsQuery)->where('post_sale_status', 'livre')->count(),
        'sav_1ere_visite' => (clone $clientsQuery)->where('post_sale_status', 'sav_1ere_visite')->count(),
        'relance' => (clone $clientsQuery)->where('post_sale_status', 'relance')->count(),
    ];
}
public function getFilteredInvoices($user, $selectedBranch)
{
    $branchInfo = $this->resolveBranchInfo($user, $selectedBranch);

    /** @var \Illuminate\Database\Eloquent\Builder $invoicesQuery */
    $invoicesQuery = $branchInfo['invoicesQuery'];

    return $invoicesQuery->with(['client', 'car']);
}

}
