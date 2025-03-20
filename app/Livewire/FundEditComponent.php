<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fund;

class FundEditComponent extends Component
{
    public $open=false;
    public $fund;

    protected $rules = [
        'fund.name' => 'required|max:100|min:1'
    ];

    public function mount(Fund $fund){
        $this->fund=$fund;
    }

    public function render()
    {
        return view('livewire.fund-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->fund->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
