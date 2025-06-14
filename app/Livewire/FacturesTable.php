<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;

class FacturesTable extends Component
{
    use WithPagination;

    public $selectedBranch = 'all';
    public $branches = [];
    public $stats = [];
    public $search = '';

    protected $queryString = ['selectedBranch'];
    protected $paginationTheme = 'tailwind';

    public function updatedSearch()
    {
        $this->resetPage();
    }

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

        $invoicesQuery = $data['invoicesQuery']->with(['client', 'car']);

        if (!empty($this->search)) {
            $invoicesQuery->where(function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('full_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('total_amount', 'like', '%' . $this->search . '%');
            });
        }

        $invoices = $invoicesQuery->paginate(6);

        return view('livewire.factures-table', [
            'invoices' => $invoices,
            'branches' => $this->branches,
            'selectedBranch' => $this->selectedBranch,
            'stats' => $this->stats,
        ]);
    }
}
