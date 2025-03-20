<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeLimit;

class TimeLimitCreateComponent extends Component
{
    public $open=false;
    public $name;

    protected $rules = [
        'name' => 'required|max:100|min:1'
    ];

    public function render()
    {
        return view('livewire.time-limit-create-component');
    }
    
    public function save(){

        $this->validate();
        TimeLimit::create([
            'name' => $this->name,
            'status' => 1
        ]);
        $this->reset('name','open');
        $this->dispatch('ok');
        $this->dispatch('redirect');

    }
}
