<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;
use App\Models\Invoice;

class FacturesTable extends Component
{
    use WithPagination;

    public $selectedBranch = 'all';
    public $branches = [];
    public $stats = [];

    protected $queryString = ['selectedBranch'];

    protected $paginationTheme = 'tailwind';

    public function mount(DashboardService $dashboardService)
    {
        $user = Auth::user();
        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $this->branches = $data['branches'];
        $this->stats = $dashboardService->getDashboardStats(
            $data['clientsQuery'],
            $data['suivisQuery'],
            $data['invoicesQuery']
        );
    }

    public function updatingSelectedBranch()
    {
        $this->resetPage();
    }

    public function render(DashboardService $dashboardService)
    {
        $user = Auth::user();
        $data = $dashboardService->resolveBranchInfo($user, $this->selectedBranch);

        $invoices = $data['invoicesQuery']
            ->with(['client', 'car'])
            ->paginate(6);

        return view('livewire.factures-table', [
            'invoices' => $invoices,
            'branches' => $this->branches,
            'selectedBranch' => $this->selectedBranch,
            'stats' => $this->stats,
        ]);
    }
}
