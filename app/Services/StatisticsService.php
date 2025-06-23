<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StatisticsService
{
    public function getGeneralStatistics(string $startDate, string $endDate, Builder $clientsQuery, Builder $invoicesQuery, Builder $suivisQuery): array
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return [
            'totalClients' => (clone $clientsQuery)
                ->whereBetween('created_at', [$start, $end])
                ->count(),

            'totalSales' => (clone $invoicesQuery)
                ->whereRaw("COALESCE(sale_date, updated_at) BETWEEN ? AND ?", [$start, $end])
                ->count(),

            'totalRevenue' => (clone $invoicesQuery)
                ->whereRaw("COALESCE(sale_date, updated_at) BETWEEN ? AND ?", [$start, $end])
        ->where('statut_facture', 'paiement')
        ->sum('total_amount'),

            'facture_paye' => DB::table('invoices')
                ->whereRaw("COALESCE(sale_date, updated_at) BETWEEN ? AND ?", [$start, $end])
                ->selectRaw("SUM(CASE WHEN statut_facture = 'paiement' THEN 1 ELSE 0 END) as count_paiement")
                ->value('count_paiement'),
        ];
    }

    public function getInvoiceStats(string $startDate, string $endDate, Builder $invoicesQuery)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $data = $invoicesQuery
            ->whereRaw("COALESCE(sale_date, updated_at) BETWEEN ? AND ?", [$start, $end])
            ->select(
                DB::raw('COUNT(id) as total_invoices'),
                DB::raw('SUM(total_amount) as total_amount'),
                DB::raw("SUM(CASE WHEN statut_facture = 'creation' THEN 1 ELSE 0 END) as count_creation"),
                DB::raw("SUM(CASE WHEN statut_facture = 'facturé' THEN 1 ELSE 0 END) as count_facturé"),
                DB::raw("SUM(CASE WHEN statut_facture = 'envoyée_pour_paiement' THEN 1 ELSE 0 END) as count_envoyée"),
                DB::raw("SUM(CASE WHEN statut_facture = 'paiement' THEN 1 ELSE 0 END) as count_paiement")
            )
            ->first();

        return [
            'total_invoices' => (int) $data->total_invoices,
            'total_amount' => (float) $data->total_amount,
            'statut_breakdown' => [
                'creation' => (int) $data->count_creation,
                'facturé' => (int) $data->count_facturé,
                'envoyée_pour_paiement' => (int) $data->count_envoyée,
                'paiement' => (int) $data->count_paiement,
            ],
        ];
    }

public function getClientsWithPaymentsByStatus(string $startDate, string $endDate, int|string $branchId, string $status = 'paiement'): array
{
    $start = Carbon::parse($startDate)->startOfDay();
    $end = Carbon::parse($endDate)->endOfDay();

    $clientsWithPayments = DB::table('clients')
        ->leftJoin('invoices', function($join) use ($status, $start, $end) {
            $join->on('clients.id', '=', 'invoices.client_id')
                ->where('invoices.statut_facture', '=', $status)
                ->whereRaw("COALESCE(invoices.sale_date, invoices.updated_at) BETWEEN ? AND ?", [$start, $end]);
        })
        ->when($branchId !== 'all', function ($query) use ($branchId) {
            $query->where('clients.branch_id', '=', $branchId);
        })
        ->select(
            'clients.id',
            'clients.full_name',
            DB::raw('COALESCE(SUM(invoices.total_amount), 0) as total_paid')
        )
        ->groupBy('clients.id', 'clients.full_name')
        ->orderByDesc('total_paid')
        ->get()
        ->toArray();

    return $clientsWithPayments;
}



    public function getClientsWithPaymentsByStatusQuery(string $startDate, string $endDate, int|string $branchId = 'all', string $status = 'paiement')
{
    $start = Carbon::parse($startDate)->startOfDay();
    $end = Carbon::parse($endDate)->endOfDay();

    return DB::table('clients')
        ->leftJoin('invoices', function($join) use ($status, $start, $end) {
            $join->on('clients.id', '=', 'invoices.client_id')
                ->where('invoices.statut_facture', '=', $status)
                ->whereRaw("COALESCE(invoices.sale_date, invoices.updated_at) BETWEEN ? AND ?", [$start, $end]);
        })
        ->when($branchId !== 'all', function($query) use ($branchId) {
            $query->where('clients.branch_id', '=', $branchId);
        })
        ->select(
            'clients.id',
            'clients.full_name',
            DB::raw('COALESCE(SUM(invoices.total_amount), 0) as total_paid')
        )
        ->groupBy('clients.id', 'clients.full_name')
        ->orderByDesc('total_paid');
}


    public function getTopPerformers(string $startDate, string $endDate, Builder $usersQuery)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        $users = $usersQuery
            ->withCount([
                'clients as prospects_count',
                'invoices as sales_count' => function ($query) use ($start, $end) {
                    $query->whereRaw("COALESCE(sale_date, updated_at) BETWEEN ? AND ?", [$start, $end]);
                },
                'suivis as total_suivis_count' => function ($query) use ($start, $end) {
                    $query->whereBetween('date_suivi', [$start, $end]);
                },
                'suivis as completed_suivis_count' => function ($query) use ($start, $end) {
                    $query->where('status', 'termine')->whereBetween('date_suivi', [$start, $end]);
                }
            ])
            ->whereHas('invoices', function ($query) use ($start, $end) {
                $query->whereRaw("COALESCE(sale_date, updated_at) BETWEEN ? AND ?", [$start, $end]);
            })
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        return $users->map(function ($user) {
            $conversionRate = $user->prospects_count > 0
                ? round(($user->sales_count / $user->prospects_count) * 100, 1)
                : 0;

            $satisfactionRate = $user->total_suivis_count > 0
                ? round(($user->completed_suivis_count / $user->total_suivis_count) * 100, 1)
                : 0;

            return [
                'name' => $user->name,
                'initials' => $this->getInitials($user->name),
                'prospects' => $user->prospects_count,
                'sales' => $user->sales_count,
                'conversion_rate' => $conversionRate,
                'satisfaction_rate' => $satisfactionRate,
                'performance_label' => $this->getPerformanceLabel($conversionRate, $satisfactionRate)
            ];
        });
    }

    private function getInitials(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }

    private function getPerformanceLabel(float $conversionRate, float $satisfactionRate): string
    {
        $averageScore = ($conversionRate + $satisfactionRate) / 2;

        if ($averageScore >= 80) return 'Excellente';
        if ($averageScore >= 65) return 'Très bonne';
        if ($averageScore >= 50) return 'Bonne';
        if ($averageScore >= 35) return 'Moyenne';
        return 'À améliorer';
    }
}
