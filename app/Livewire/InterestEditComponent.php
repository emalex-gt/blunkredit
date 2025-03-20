<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Interest;

class InterestEditComponent extends Component
{
    public $open=false;
    public $interest;

    protected $rules = [
        'interest.name' => 'required|max:100|min:1'
    ];

    public function mount(Interest $interest){
        $this->interest=$interest;
    }

    public function render()
    {
        return view('livewire.interest-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->interest->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
