<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reclamation;
use App\Models\Client;
use App\Models\User;

class ReclamationIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $statusFilter = '';

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Reclamation::with(['client', 'user', 'createdBy'])
            ->when($this->statusFilter, function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.reclamation-index', [
            'reclamations' => $query->paginate(10),
            'clients' => Client::orderBy('full_name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }
}
