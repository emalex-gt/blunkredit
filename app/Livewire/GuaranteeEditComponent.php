<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Guarantee;

class GuaranteeEditComponent extends Component
{
    public $open=false;
    public $guarantee;

    protected $rules = [
        'guarantee.name' => 'required|max:100|min:1'
    ];

    public function mount(Guarantee $guarantee){
        $this->guarantee=$guarantee;
    }

    public function render()
    {
        return view('livewire.guarantee-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->guarantee->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
