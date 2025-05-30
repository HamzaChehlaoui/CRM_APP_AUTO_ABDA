<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;

class SalesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $sales = Invoice::with(['client', 'car'])->latest()->paginate(5);
        return view('livewire.sales-table', ['sales' => $sales]);
    }
}
