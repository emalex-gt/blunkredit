<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Expense;

class ExpenseShowComponent extends Component
{
    public $open=false;
    public $expense;

    public function mount(Expense $expense){
        $this->expense=$expense;
    }
    public function render()
    {
        return view('livewire.expense-show-component');
    }
}
