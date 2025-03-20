<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Policy;

class PolicyComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $policies = Policy::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.policy-component',compact('policies'));
    }
    public function delete($policyId)
    {
        $policy=Policy::find($policyId);
        $policy->status=0;
        $policy->save();
        $this->dispatch('redirect');
    }
}
