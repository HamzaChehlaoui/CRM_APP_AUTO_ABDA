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
    public $searchTerm = ''; 

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
{
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
        ->orderBy('created_at', 'desc');

    return view('livewire.reclamation-index', [
        'reclamations' => $query->paginate(10),
        'clients' => Client::orderBy('full_name')->get(),
        'users' => User::orderBy('name')->get(),
    ]);
}

}
