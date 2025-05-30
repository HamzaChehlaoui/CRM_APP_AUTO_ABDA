<?php
namespace App\Livewire;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class SalesTable extends Component
{
    use WithPagination;

    public $selectedBranch = 'all';

    protected $paginationTheme = 'tailwind';

    protected DashboardService $branchInfoService;

    // Constructor Injection
    public function boot(DashboardService $branchInfoService)
    {
        $this->branchInfoService = $branchInfoService;
    }

    public function render()
    {
        $user = Auth::user();

        $branchInfo = $this->branchInfoService->resolveBranchInfo($user, $this->selectedBranch);

        $sales = $branchInfo['invoicesQuery']->paginate(5);

        return view('livewire.sales-table', [
            'sales' => $sales,
            'branches' => $branchInfo['branches'],
        ]);
    }
}

