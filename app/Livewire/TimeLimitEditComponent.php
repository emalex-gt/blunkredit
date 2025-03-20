<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeLimit;

class TimeLimitEditComponent extends Component
{
    public $open=false;
    public $timelimit;

    protected $rules = [
        'timelimit.name' => 'required|max:100|min:1'
    ];

    public function mount(TimeLimit $timelimit){
        $this->timelimit=$timelimit;
    }

    public function render()
    {
        return view('livewire.time-limit-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->timelimit->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
