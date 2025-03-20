<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeLimit;

class TimeLimitComponent extends Component
{
    public $search='';
    protected $listeners=['render','delete'];

    public function render()
    {
        $timelimits = TimeLimit::where('status',1)
                                ->where('name','like','%'.$this->search.'%')
                                ->orderBy('id','desc')
                                ->paginate(30);
        return view('livewire.time-limit-component',compact('timelimits'));
    }
    public function delete($timelimitId)
    {
        $timelimit=TimeLimit::find($timelimitId);
        $timelimit->status=0;
        $timelimit->save();
        $this->dispatch('redirect');
    }
}
