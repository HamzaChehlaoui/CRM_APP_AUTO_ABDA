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

    public function render()
    {
        return view('livewire.reclamation-index', [
            'reclamations' => Reclamation::with(['client', 'user', 'createdBy'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(10),
            'clients' => Client::orderBy('full_name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }
}
