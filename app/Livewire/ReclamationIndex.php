<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reclamation;
use App\Models\Client;
use App\Models\User;
use App\Models\Branch;

class ReclamationIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $statusFilter = '';
    public $searchTerm = '';
    public $branchFilter = 'all';

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingBranchFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        // إذا لم يكن المستخدم إداريًا، يتم قصر العرض على فرعه فقط
        if ($user->role_id > 2) {
            $this->branchFilter = $user->branch_id;
        }

        $query = Reclamation::with(['client', 'user', 'createdBy'])
            ->when($this->statusFilter, function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->when($this->searchTerm, function ($q) {
                $search = '%' . $this->searchTerm . '%';
                $q->where(function ($query) use ($search) {
                    $query->where('Priorite', 'like', $search)
                        ->orWhere('status', 'like', $search)
                        ->orWhere('description', 'like', $search)
                        ->orWhereHas('client', function ($q) use ($search) {
                            $q->where('full_name', 'like', $search);
                        });
                });
            })
            ->when($this->branchFilter !== 'all', function ($q) {
                $q->whereHas('client', function ($query) {
                    $query->where('branch_id', $this->branchFilter);
                });
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.reclamation-index', [
            'reclamations' => $query->paginate(10),
            'clients' => Client::orderBy('full_name')->get(),
            'users' => User::orderBy('name')->get(),
            'branches' => $user->role_id <= 2 ? Branch::all() : collect(),
        ]);
    }
}
