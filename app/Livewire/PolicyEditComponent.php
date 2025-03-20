<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Policy;

class PolicyEditComponent extends Component
{
    public $open=false;
    public $policy;

    protected $rules = [
        'policy.name' => 'required|max:100|min:1'
    ];

    public function mount(Policy $policy){
        $this->policy=$policy;
    }

    public function render()
    {
        return view('livewire.policy-edit-component');
    }
    public function save()
    {
        $this->validate();
        $this->policy->save();
        $this->dispatch('render');
        $this->dispatch('ok');
    }
}
