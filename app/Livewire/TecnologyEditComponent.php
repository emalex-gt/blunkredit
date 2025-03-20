<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tecnology;

class TecnologyEditComponent extends Component
{
    public $open=false;
    public $tecnology;

    protected $rules = [
        'tecnology.name' => 'required|max:100|min:1'
    ];

    public function mount(Tecnology $tecnology){
        $this->tecnology=$tecnology;
    }

    public function render()
    {
        return view('livewire.tecnology-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->tecnology->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
