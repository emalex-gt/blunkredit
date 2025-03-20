<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExpenseType;

class ExpenseTypeEditComponent extends Component
{
    public $open=false;
    public $expense_type;

    protected $rules = [
        'expense_type.name' => 'required|max:100|min:1'
    ];

    public function mount(ExpenseType $expense_type){
        $this->expense_type=$expense_type;
    }

    public function render()
    {
        return view('livewire.expense-type-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->expense_type->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
    
}
