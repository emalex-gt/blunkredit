<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExpenseType;

class ExpenseTypeComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $expense_types = ExpenseType::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.expense-type-component',compact('expense_types'));
    }
    public function delete($expensetypeId)
    {
        $expense_type=ExpenseType::find($expensetypeId);
        $expense_type->status=0;
        $expense_type->save();
        $this->dispatch('redirect');
    }
}
