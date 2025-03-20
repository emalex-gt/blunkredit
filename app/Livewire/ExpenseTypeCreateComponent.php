<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExpenseType;

class ExpenseTypeCreateComponent extends Component
{
    public $open=false;
    public $name;

    protected $rules = [
        'name' => 'required|max:100|min:1'
    ];

    public function render()
    {
        return view('livewire.expense-type-create-component');
    }
    
    public function save(){

        $this->validate();
        ExpenseType::create([
            'name' => $this->name,
            'status' => 1
        ]);
        $this->reset('name','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
    
}
