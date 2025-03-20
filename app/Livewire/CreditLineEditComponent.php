<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CreditLine;

class CreditLineEditComponent extends Component
{
    public $open=false;
    public $creditline;

    protected $rules = [
        'creditline.name' => 'required|max:100|min:1'
    ];

    public function mount(CreditLine $creditline){
        $this->creditline=$creditline;
    }

    public function render()
    {
        return view('livewire.credit-line-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->creditline->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
